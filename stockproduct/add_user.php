<?php
include 'db.php';
session_start();

// ตรวจสอบว่าสถานะการล็อกอินเป็น Admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // ตรวจสอบว่ามีการกรอกข้อมูลครบหรือไม่
    if (empty($username) || empty($password) || empty($first_name) || empty($last_name) || empty($email) || empty($role)) {
        echo "Please fill in all fields.";
    } else {
        // ตรวจสอบว่า username ซ้ำหรือไม่
        $sql_check = "SELECT * FROM users WHERE username = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param('s', $username);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        // ตรวจสอบว่าอีเมลไม่ซ้ำ
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die('Email already exists!');
    }

        if ($result_check->num_rows > 0) {
            echo "Username already exists.";
        } else {
            // เพิ่มผู้ใช้ใหม่
            $sql = "INSERT INTO users (username, password, first_name, last_name, email, role) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssss', $username, $password, $first_name, $last_name, $email, $role);

            if ($stmt->execute()) {
                header('Location: admin_users.php');
            } else {
                echo "Error adding user.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
</head>
<body>
    <h1>Add New User</h1>

    <form method="post">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        First Name: <input type="text" name="first_name" required><br>
        Last Name: <input type="text" name="last_name" required><br>
        Email: <input type="email" name="email" required><br>
        Role:
        <select name="role" required>
            <option value="customer">Customer</option>
            <option value="manager">Manager</option>
        </select><br>
        <button type="submit">Add User</button>
    </form>

    <br><a href="admin_users.php">Back to User Management</a>
</body>
</html>
