<?php
include 'db.php';
session_start();

// ตรวจสอบการล็อกอินและสิทธิ์การเข้าถึง
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'manager') {
    header('Location: index.html');
    exit;
}

// ตรวจสอบว่ามีการส่งค่า product_id มาหรือไม่
if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']); // แปลงเป็นตัวเลขเพื่อความปลอดภัย

    // ดึงข้อมูลสินค้าจากฐานข้อมูล
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "<b>Error:</b> Product not found. Please go back and try again.";
        exit;
    }

    // ดึงข้อมูลหมวดหมู่ทั้งหมดจากฐานข้อมูล
    $category_sql = "SELECT * FROM categories";
    $category_result = $conn->query($category_sql);

} else {
    echo "No product ID specified.";
    exit;
}

// ตรวจสอบว่ามีการส่งข้อมูลการแก้ไขมาแล้วหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id']; // รับค่าหมวดหมู่จากฟอร์ม

    // ตรวจสอบว่ามีการอัปโหลดรูปภาพหรือไม่
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == UPLOAD_ERR_OK) {
        $image_name = basename($_FILES['product_image']['name']);
        $image_tmp_name = $_FILES['product_image']['tmp_name'];
        $image_folder = 'uploads/'; // ตรวจสอบให้โฟลเดอร์นี้มีอยู่จริงและสามารถเขียนไฟล์ได้
        $image_path = $image_folder . $image_name;

        // ตรวจสอบประเภทไฟล์ (optional)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['product_image']['type'], $allowed_types)) {
            echo "Error: Only JPG, PNG, and GIF files are allowed.";
            exit;
        }

        // ย้ายไฟล์ที่อัปโหลดไปยังตำแหน่งที่ต้องการ
        if (move_uploaded_file($image_tmp_name, $image_path)) {
            // ถ้ามีการอัปโหลดรูปใหม่ ให้อัปเดตข้อมูลรูปภาพในฐานข้อมูล
            $sql = "UPDATE products SET name = ?, description = ?, price = ?, stock = ?, image = ?, category_id = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssiissi', $product_name, $product_description, $price, $stock, $image_path, $category_id, $product_id);
        } else {
            echo "Error: Failed to upload image.";
            exit;
        }
    } else {
        // ถ้าไม่มีการอัปโหลดรูปใหม่ ให้อัปเดตข้อมูลอื่นๆ ยกเว้นรูปภาพ
        $sql = "UPDATE products SET name = ?, description = ?, price = ?, stock = ?, category_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssiiii', $product_name, $product_description, $price, $stock, $category_id, $product_id);
    }

    if ($stmt->execute()) {
        echo "Product updated successfully!";
        header('Location: manage_products.php'); // กลับไปยังหน้าจัดการสินค้า
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product</h1>

    <?php if (isset($product['name'])) { ?>
    <form action="edit_product.php?product_id=<?= $product_id ?>" method="post" enctype="multipart/form-data">
        Product Name: <input type="text" name="product_name" value="<?= htmlspecialchars($product['name']) ?>" required><br>
        Product Description: <textarea name="product_description" required><?= htmlspecialchars($product['description']) ?></textarea><br>
        Price: <input type="number" name="price" value="<?= $product['price'] ?>" required><br>
        Stock: <input type="number" name="stock" value="<?= $product['stock'] ?>" required><br>
        
        <!-- ฟิลด์สำหรับอัปโหลดรูปภาพใหม่ -->
        Current Image: <img src="<?= htmlspecialchars($product['image']) ?>" width="150px" height="200px"><br>
        Upload New Image: <input type="file" name="product_image"><br>

        <!-- Dropdown สำหรับเลือกหมวดหมู่ -->
        Category: 
        <select name="category_id" required>
            <?php while ($category = $category_result->fetch_assoc()) { ?>
                <option value="<?= $category['id'] ?>" <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php } ?>
        </select><br>

        <input type="submit" value="Update">
    </form>
    <?php } else { ?>
        <p><b>Error:</b> Product not found. Please go back and try again.</p>
    <?php } ?>

    <a href="manage_products.php">Back to Manage Products</a>
</body>
</html>
