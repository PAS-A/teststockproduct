<?php
include 'db.php';
session_start();

// ตรวจสอบว่าสถานะการล็อกอินเป็น Admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
}

$user_id = $_GET['id'];

// ลบผู้ใช้
$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);

if ($stmt->execute()) {
    header('Location: admin_users.php');
} else {
    echo "Error deleting user.";
}
?>
