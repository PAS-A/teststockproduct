<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    // ตรวจสอบรหัสผ่านว่าตรงกัน
    if ($password !== $confirm_password) {
        die('Passwords do not match!');
    }

    // ตรวจสอบความยาวและรูปแบบรหัสผ่าน
    if (strlen($password) < 8 || !preg_match("/[0-9]/", $password) || 
        !preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password)) {
        die('Password must be at least 8 characters long, contain at least one number, one uppercase and one lowercase letter.');
    }

    // ตรวจสอบว่าอีเมลไม่ซ้ำ
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die('Email already exists!');
    }

    // เข้ารหัสรหัสผ่าน
    $hashed_password = md5($password);

    // บันทึกข้อมูลผู้ใช้ในฐานข้อมูล
    // บรรทัด SQL คำสั่ง INSERT INTO
$sql = "INSERT INTO users (username, password, first_name, last_name, email, role) VALUES (?, ?, ?, ?, ?, 'customer')";
$stmt = $conn->prepare($sql);

// ปรับให้ bind_param ตรงกับจำนวนคอลัมน์ที่ใช้
$stmt->bind_param('sssss', $username, $hashed_password, $first_name, $last_name, $email);


    if ($stmt->execute()) {
        echo 'Customer registered successfully!';
        echo '<a href="index.html">Go to Login Page</a>';
    } else {
        echo 'Error: ' . $stmt->error;
    }
}
?>
