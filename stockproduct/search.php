<?php
include 'db.php';

$keyword = $_GET['keyword'];
$sql = "SELECT * FROM products WHERE name LIKE ?";
$stmt = $conn->prepare($sql);
$search_term = "%$keyword%";
$stmt->bind_param('s', $search_term);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
</head>
<body>
<a href="logout.php">Logout</a>
    <h1>Search Results</h1>

    <div>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div>
                <img src="<?= $row['image']; ?>" width="150px" height="200px">
                <h3><?= $row['name']; ?></h3>
                <p>Price: <?= $row['price']; ?> บาท</p>
                <a href="product_detail.php?id=<?= $row['id']; ?>">View Details</a>
            </div>
        <?php endwhile; ?>
    </div>
    <a href="products.php">Back to Product List</a>
</body>
</html>
