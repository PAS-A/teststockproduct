<?php
session_start();
include 'db.php';
// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'manager') {
    header('Location: index.html');
    exit;
}

// ดึงข้อมูลหมวดหมู่ทั้งหมดจากฐานข้อมูล
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
</head>
<body>
    <h1>Manage Categories</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td>
                <a href="edit_category.php?category_id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete_category.php?category_id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <a href="add_category.php">Add New Category</a><br>
    <a href="manager_dashboard.php">Back to Dashboard</a><br>
    <a href="logout.php">Logout</a>
</body>
</html>
