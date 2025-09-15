<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    if ($password !== $confirm_password) {
        die('Passwords do not match!');
    }

    if (strlen($password) < 8 || !preg_match("/[0-9]/", $password) || 
        !preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password)) {
        die('Password must be at least 8 characters long, contain at least one number, one uppercase and one lowercase letter.');
    }

    $hashed_password = md5($password);

    $sql = "INSERT INTO users (username, password, first_name, last_name, email, role) VALUES (?, ?, ?, ?, ?, 'manager')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssss', $username, $hashed_password, $first_name, $last_name, $email);

    if ($stmt->execute()) {
        echo 'Manager account added successfully!';
    } else {
        echo 'Error: ' . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Manager</title>
</head>
<body>
    <h1>Add Manager</h1>
    <form action="add_manager.php" method="post">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        Confirm Password: <input type="password" name="confirm_password" required><br>
        First Name: <input type="text" name="first_name" required><br>
        Last Name: <input type="text" name="last_name" required><br>
        Email: <input type="email" name="email" required><br>
        <input type="submit" value="Add Manager">
    </form>
    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
