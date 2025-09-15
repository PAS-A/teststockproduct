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
    $product_id = $_GET['product_id'];

    // ลบสินค้าจากฐานข้อมูล
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $product_id);

    if ($stmt->execute()) {
        echo "Product deleted successfully!";
        header('Location: manage_products.php');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "No product ID specified.";
    exit;
}
?>
