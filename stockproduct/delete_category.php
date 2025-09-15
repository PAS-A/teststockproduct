<?php
session_start();
include 'db.php';
// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่ และต้องมีสิทธิ์เป็นผู้จัดการ
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'manager') {
    header('Location: index.html');
    exit;
}

// ตรวจสอบว่ามีการส่งค่า category_id มาหรือไม่
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // ลบหมวดหมู่จากฐานข้อมูล
    $sql = "DELETE FROM categories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $category_id);

    if ($stmt->execute()) {
        echo "Category deleted successfully!";
        header('Location: manage_categories.php'); // กลับไปยังหน้าจัดการหมวดหมู่หลังจากลบสำเร็จ
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "No category ID specified.";
    exit;
}
?>
