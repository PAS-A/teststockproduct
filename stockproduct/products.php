<?php
include 'db.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'customer') {
    header("Location: index.html");
    exit();
}
// รับค่า keyword และ category_id จาก URL
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';

// ดึงข้อมูลหมวดหมู่จากฐานข้อมูลเพื่อนำมาแสดงใน dropdown
$sql_categories = "SELECT * FROM categories";
$result_categories = $conn->query($sql_categories);

// ปรับ SQL ตามการค้นหา keyword และหมวดหมู่
$sql = "SELECT * FROM products WHERE name LIKE ?";
if ($category_id) {
    $sql .= " AND category_id = ?";
}

$stmt = $conn->prepare($sql);
$search_term = "%$keyword%";

// ตรวจสอบว่ามีการเลือกหมวดหมู่หรือไม่
if ($category_id) {
    $stmt->bind_param('si', $search_term, $category_id);  // หมวดหมู่มีค่า
} else {
    $stmt->bind_param('s', $search_term);  // ค้นหาเฉพาะคำสำคัญ
}

$stmt->execute();
$result = $stmt->get_result();

echo "Welcome Customer: " . $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
</head>
<body>
<a href="logout.php">Logout</a>
    <h1>Product List</h1>
    

    <!-- ฟอร์มค้นหา -->
    <form method="get" action="search.php">
        <input type="text" name="keyword" placeholder="Search by keyword" value="<?= htmlspecialchars($keyword); ?>">
        <select name="category_id">
            <option value="">All Categories</option>
            <?php while ($row_category = $result_categories->fetch_assoc()): ?>
                <option value="<?= $row_category['id']; ?>" <?= $row_category['id'] == $category_id ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($row_category['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Search</button>
    </form>

    <hr>

    <!-- แสดงผลการค้นหา -->
    <div>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div>
                    <img src="<?= $row['image']; ?>" width="150px" height="200px">
                    <h3><?= htmlspecialchars($row['name']); ?></h3>
                    <p>Price: <?= $row['price']; ?> บาท</p>
                    <a href="product_detail.php?id=<?= $row['id']; ?>">View Details</a>
                </div>
                <hr>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>

</body>
</html>
