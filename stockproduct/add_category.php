<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'manager') {
    header("Location: index.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $sql = "INSERT INTO categories (name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $name);

    if ($stmt->execute()) {
        echo 'Category added successfully!';
    } else {
        echo 'Error: ' . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Category</title>
</head>
<body>
    <h1>Add Category</h1>
    <form action="add_category.php" method="post">
        Category Name: <input type="text" name="name" required><br>
        <input type="submit" value="Add Category">
    </form>
    <a href="manage_categories.php">Back to Manage Categories</a><br>
    <a href="manager_dashboard.php">Back to Dashboard</a>
</body>
</html>
