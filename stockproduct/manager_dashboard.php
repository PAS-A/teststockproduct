<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'manager') {
    header("Location: index.html");
    exit();
}

echo "Welcome Manager: " . $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manager Dashboard</title>
</head>
<body>
    <h1>Manager Dashboard</h1>
    <a href="manage_categories.php">Manage Categories</a><br>
    <a href="manage_products.php">Manage Product</a><br>
    <a href="logout.php">Logout</a>
</body>
</html>
