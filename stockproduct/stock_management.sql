-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2024 at 02:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stock_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(2, 'แมวไทย'),
(3, 'แมวต่างประเทศ');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image`, `category_id`) VALUES
(10, 'โคราช/มาเลศ', 'ขนสั้น สีสวาด (silver blue)\r\nหัวเมื่อดูจากด้านหน้าจะเป็นรูปหัวใจ หน้าผากใหญ่และแบน หูตั้ง\r\nนัยน์ตาสีเขียวสดใสเป็นประกาย หรือสีเหลืองอำพัน\r\nหางยาว ปลายแหลมชี้ตรง', 8999.00, 17, 'uploads/แมวโคราช.jpg', 2),
(11, 'วิเชียรมาศ', 'ขนสั้นแน่นสีขาว หรือสีน้ำตาลอ่อน มีแต้มสีครั่ง หรือสีน้ำตาลไหม้ที่บริเวณใบหน้า หูทั้งสองข้าง เท้าทั้งสี่ หางและที่อวัยวะเพศ\r\nหัวไม่กลมหรือแหลมเกินไป หน้าผากใหญ่และแบน จมูกสั้น หูใหญ่ ตั้งสูงเด่นบนส่วนหัว\r\nตาสีฟ้า\r\nหางยาว ปลายแหลมชี้ตรง', 9630.00, 3, 'uploads/e7974085017e35d6817e8e9dfc6b0dcf.jpg', 2),
(12, 'ขาวมณี', 'ขนสั้นแน่นและอ่อนนุ่ม สีขาวไม่มีสีอื่นปน\r\nรูปร่างไม่กลม หรือแหลมเกินไป แต่คล้ายรูปหัวใจ ผน้าผากใหญ่และแบน จมูกสั้น หูตั้งใหญ่\r\nนัยน์ตาสีฟ้า หรือสีเหลืองอำพัน\r\nหางยาว ปลายหางแหลมชี้ตรง', 10090.00, 5, 'uploads/khao-manee-cat-headshot.jpg', 2),
(13, 'อเมริกันขนสั้น', 'มีอยู่หลากหลายเฉดประมาณ 34 รูปแบบทั้งลายทั้งสี\r\nเป็นแมวที่มีขนาดกลางถึงขนาดใหญ่ โครงสร้างลำตัวใหญ่โต มีกล้ามเนื้อแข็งแรงเห็นชัดเจน อกใหญ่ ขาใหญ่ ยาวขนาดปานกลาง ใบหูขนาดกลางและขอบเป็นทรงกลมมน หัวรูปไข่แต่มีคางที่ค่อนข้างใหญ่ชัดเจน ดวงตาแมวพันธุ์นี้กลมโต ขอบตาด้านนอกด้านบนจะโค้งลงมา สีของตาเป็นสีเขียว', 9444.00, 12, 'uploads/20-facts-about-american-shorthair-cats-1703638525.jpg', 3),
(14, 'เอ็กโซติกขนสั้น', 'ขนที่สั้น ลักษณะลำตัวกลม และมีขาสั้นป้อม หัวกลม หูเล็ก จมูกเล็ก', 30000.00, 4, 'uploads/OIP.jpg', 3),
(15, 'บริติชขนสั้น', 'ขนสั้นหนา อุ้งเท้ากลม ดวงตาสีเหลืองอำพัน รูปร่างสมส่วน และมีโคนหางหนา', 9999.00, 9, 'uploads/OIP (1).jpg', 3),
(16, 'อเมริกันเคิร์ล', 'ใบหูจะมีลักษณะสั้นและปลายงอไปด้านหลัง มีทั้งชนิดขนสั้นและยาว ขนนุ่มฟูและเงา มีลายมาร์เบิลชัดเจน ตัวใหญ่', 13000.00, 8, 'uploads/OIP (2).jpg', 3),
(17, 'สกอตติชโฟลด์', 'ใบหูพับลง หน้าดูกลม มีขนสั้น ขนรอบคอหนา มีช่วงคอสั้น ดวงตากลมโต', 9500.00, 6, 'uploads/ev-blog-scottishfold_header-1024x683.jpg', 3),
(18, 'มันช์กิ้น', 'ขาสั้นกุด หูสั้น ลำตัวกลมและหนา ขนยาว หางยาวเป็นพวง ดวงตากลมโตคล้ายผลวอลนัท', 12000.00, 3, 'uploads/gatitos-munchkin-jpg-140420.jpg', 3),
(19, 'เปอร์เซีย', 'ขนยาวฟู หางยาวเป็นพวง ใบหน้ากลม จมูกหักและสั้น', 11111.00, 11, 'uploads/OIP (3).jpg', 3),
(20, 'แร็กดอลล์', 'ใบหน้ามีแต้มสีขาวรูปสามเหลี่ยม ขนสีน้ำตาลครีม ขนยาวฟู มีแผงคอหนา หางยาวเป็นพวง มีดวงตากลมโต', 13200.00, 7, 'uploads/R.jpg', 3),
(21, 'สโนว์ชู', 'ขนสั้นที่มีลวดลายสีต่างๆ แทรกตามขน ดวงตากลมโต ใบหน้ามีขนสีขาวและสีเข้ม อุ้งเท้าสีขาว', 9877.00, 9, 'uploads/R (1).jpg', 3),
(22, 'ชินชิลล่า', 'ขาสั้น ขนบางและสีอ่อน ดวงตาสีฟ้ากลมโต มีเส้นขอบตาสีดำเข้ม หัวกลม คอสั้น จมูกเล็ก อุ้งเท้าเล็ก', 9699.00, 14, 'uploads/OIP (4).jpg', 3),
(23, 'สฟิงซ์', 'ขนเส้นเล็กๆละเอียดทั่วทั้งตัว ไม่มีขนตาและหนวด รูปร่างลำตัวยาว ผิวหนังย่น ขายาว หางเรียวยาว อกหนา ดวงตากลมโต หูตั้งชัน', 19000.00, 9, 'uploads/OIP (5).jpg', 3),
(24, 'รัสเซียนบลู', 'รูปร่างเพรียว ขายาว ใบหูขนาดใหญ่ตั้ง ดวงตากลมโตสีเขียวและสีฟ้าคล้ายเมล็ดอัลมอนด์ ขนนุ่ม', 32000.00, 1, 'uploads/R (2).jpg', 3),
(25, 'เบงกอล', 'สีขนมีลายหินอ่อน สีขนเข้มบริเวณรอบดวงตา หูเล็กและกลมมน ', 14000.00, 3, 'uploads/OIP (6).jpg', 3),
(26, 'เมนคูน', 'ขนาดใหญ่ รูปร่างสมส่วน ใบหน้าใหญ่ โหนกแก้มสูง หูแหลม ขนยาวสวยงาม ขoแผงคอหนา อุ้งเท้าขนาดใหญ่', 23000.00, 10, 'uploads/Maine_Coon_cat_breed.jpg', 3),
(27, 'นอร์วีเจียนฟอเรสต์', 'ขนยาวปกคลุมทั่วทั้งตัว หางยาวเป็นพวง มีลำตัวยาว ขนหนาบริเวณคอและอก', 23330.00, 2, 'uploads/R (3).jpg', 3),
(28, 'ทิฟฟานี', 'ขนฟูฟ่อง มีดวงตาสีเขียวกลมโต', 9960.00, 3, 'uploads/OIP (7).jpg', 3),
(29, 'คาราคัล', 'ลำตัวแข็งแรง ขายาว มีขนสีน้ำตาลแดง ใบหูปลายแหลมขนาดใหญ่ ต้องขอใบอนุญาตเลี้ยง', 44444.00, 1, 'uploads/OIP (8).jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','manager','customer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `email`, `role`) VALUES
(1, 'manage', '81dc9bdb52d04dc20036dbd8313ed055', 'mong', 'mang', 'manage@example.com', 'manager'),
(2, 'momo', 'e42fa8b40676a881cd4b0f62f238906b', 'moo', 'moo', 'mohmoh@gmail.com', 'customer'),
(3, 'admin', 'ab2bea3ad7c604a9a04003b7739328a4', 'High', 'Low', 'eated@gmail.com', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
