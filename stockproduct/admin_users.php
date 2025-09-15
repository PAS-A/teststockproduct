<?php
include 'db.php';
session_start();

// ตรวจสอบว่าสถานะการล็อกอินเป็น Admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
}

// ดึงข้อมูลลูกค้าและผู้จัดการทั้งหมดจากฐานข้อมูล
$sql = "SELECT id, username, first_name, last_name, email, role FROM users WHERE role != 'admin' ORDER BY role, id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
</head>
<body>
    <h1>User Management</h1>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['username']); ?></td>
                <td><?= htmlspecialchars($row['first_name']); ?></td>
                <td><?= htmlspecialchars($row['last_name']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= $row['role'] == 'admin' ? 'Admin' : ($row['role'] == 'manager' ? 'Manager' : 'Customer'); ?></td>
                <td>
                    <a href="edit_user.php?id=<?= $row['id']; ?>">Edit</a>
                    <a href="delete_user.php?id=<?= $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a href="add_user.php">Add New User</a>
    <br><br>
    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
