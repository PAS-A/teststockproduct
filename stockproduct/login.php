<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && md5($password) === $user['password']) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'manager') {
            header("Location: manager_dashboard.php");
        } else if ($user['role'] === 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: products.php");
        }
        exit();
    } else {
        echo 'Invalid login credentials!';
    }
}
?>
