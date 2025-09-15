<?php
include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $product['name']; ?> - Product Details</title>
</head>
<body>
<a href="logout.php">Logout</a>
    <h1><?= $product['name']; ?></h1>
    <img src="<?= $product['image']; ?>" width="300px" height="400px">
    <p>Description: <?= $product['description']; ?></p>
    <p>Price: <?= $product['price']; ?> บาท</p>
    <p>Stock: <?= $product['stock']; ?></p>
    <a href="products.php">Back to Product List</a>
</body>
</html>
