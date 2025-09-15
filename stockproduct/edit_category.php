<?php
session_start();
include 'db.php'; // เชื่อมต่อกับฐานข้อมูล
// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'manager') {
    header('Location: index.html');
    exit;
}

// ตรวจสอบว่ามีการส่งค่า category_id มาหรือไม่
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // ดึงข้อมูลหมวดหมู่จากฐานข้อมูล
    $sql = "SELECT * FROM categories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();
} else {
    echo "No category ID specified.";
    exit;
}

// ตรวจสอบว่ามีการส่งข้อมูลการแก้ไขมาแล้วหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_category_name = $_POST['category_name'];

    // อัปเดตข้อมูลในฐานข้อมูล
    $sql = "UPDATE categories SET name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $new_category_name, $category_id);

    if ($stmt->execute()) {
        echo "Category updated successfully!";
        header('Location: manage_categories.php'); // กลับไปยังหน้าจัดการหมวดหมู่หลังจากแก้ไขสำเร็จ
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Category</title>
</head>
<body>
    <h1>Edit Category</h1>
    <form action="edit_category.php?category_id=<?= $category_id ?>" method="post">
        Category Name: <input type="text" name="category_name" value="<?= $category['name'] ?>" required><br>
        <input type="submit" value="Update">
    </form>
    <a href="manage_categories.php">Back to Manage Categories</a>
</body>
</html>
