<?php
include 'db.php';
session_start();

// ตรวจสอบการล็อกอินและสิทธิ์การเข้าถึง
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'manager') {
    header('Location: index.html');
    exit;
}

// ดึงข้อมูลสินค้าจากฐานข้อมูล
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
</head>
<body>
    <h1>Manage Products</h1>

    <a href="add_product.php">Add New Product</a><br>
    <a href="manager_dashboard.php">Back to Dashboard</a><br>
    <a href="logout.php">Logout</a>

    <table border="1">
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Image</th>
            <th>Category ID</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= $row['description'] ?></td>
                <td><?= $row['price'] ?></td>
                <td><?= $row['stock'] ?></td>
                <td>
                    <?php if (!empty($row['image'])): ?>
                        <img src="<?= $row['image'] ?>" width="150" height="200"> <!-- แสดงรูปภาพ -->
                    <?php else: ?>
                        No Image
                    <?php endif; ?>
                </td>
                <td><?= $row['category_id'] ?></td>
                <td>
                    <a href="edit_product.php?product_id=<?= $row['id'] ?>">Edit</a> |
                    <a href="delete_product.php?product_id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    
</body>
</html>
