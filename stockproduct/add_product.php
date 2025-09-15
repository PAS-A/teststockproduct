<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'manager') {
    header("Location: index.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id'];

    // การจัดการอัปโหลดรูปภาพ
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

    // ตรวจสอบไฟล์ว่ารูปภาพหรือไม่
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        die('File is not an image.');
    }

    // ตรวจสอบนามสกุลไฟล์
    if (!in_array($imageFileType, $allowed_extensions)) {
        die('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
    }

    // ย้ายไฟล์รูปภาพไปยังโฟลเดอร์ uploads
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        die('Sorry, there was an error uploading your file.');
    }

    // เพิ่มข้อมูลสินค้าในฐานข้อมูล
    $sql = "INSERT INTO products (name, description, price, stock, image, category_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssdisi', $name, $description, $price, $stock, $target_file, $category_id);

    if ($stmt->execute()) {
        echo 'Product added successfully!';
    } else {
        echo 'Error: ' . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
</head>
<body>
    <h1>Add Product</h1>
    <form action="add_product.php" method="post" enctype="multipart/form-data">
        Product Name: <input type="text" name="name" required><br>
        Description: <textarea name="description" required></textarea><br>
        Price: <input type="number" name="price" step="0.01" required><br>
        Stock: <input type="number" name="stock" required><br>
        Image: <input type="file" name="image" required><br>
        Category: 
        <select name="category_id" required>
            <?php
            $sql = "SELECT * FROM categories";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
            }
            ?>
        </select><br>
        <input type="submit" value="Add Product">
    </form>
    <a href="manage_products.php">Back to Manage Product</a><br>
    <a href="manager_dashboard.php">Back to Dashboard</a>
</body>
</html>
