<?php
include 'db.php';
session_start();

// ตรวจสอบว่าสถานะการล็อกอินเป็น Admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
}

$user_id = $_GET['id'];

// ดึงข้อมูลผู้ใช้ที่ต้องการแก้ไข
$sql = "SELECT username, first_name, last_name, email, role FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // อัปเดตข้อมูลผู้ใช้ ยกเว้น username และ password
    $sql_update = "UPDATE users SET first_name = ?, last_name = ?, email = ?, role = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('ssssi', $first_name, $last_name, $email, $role, $user_id);

    if ($stmt_update->execute()) {
        header('Location: admin_users.php');
    } else {
        echo "Error updating user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>

    <form method="post">
        Username: <input type="text" value="<?= htmlspecialchars($user['username']); ?>" disabled><br>
        First Name: <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']); ?>" required><br>
        Last Name: <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']); ?>" required><br>
        Last Name: <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required><br>
        Role:
        <select name="role" required>
            <option value="customer" <?= $user['role'] == 'customer' ? 'selected' : ''; ?>>Customer</option>
            <option value="manager" <?= $user['role'] == 'manager' ? 'selected' : ''; ?>>Manager</option>
        </select><br>
        <button type="submit">Update User</button>
    </form>

    <br><a href="admin_users.php">Back to User Management</a>
</body>
</html>
