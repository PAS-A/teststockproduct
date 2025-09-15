-- สร้างฐานข้อมูล
CREATE DATABASE stock_management;
USE stock_management;

-- ตารางสำหรับจัดเก็บข้อมูลลูกค้าและผู้จัดการ
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    role ENUM('admin', 'manager', 'customer') NOT NULL
);

-- เพิ่มผู้จัดการล่วงหน้า 1 คนและแอดมิน 1 คน
INSERT INTO users (username, password, first_name, last_name, email, role) 
VALUES ('manage', MD5('1234'), 'John', 'Doe', 'manage@example.com', 'manager');
INSERT INTO users (username, password, first_name, last_name, email, role) 
VALUES ('admin', MD5('123456789Kk'), 'High', 'Low', 'eated@gmail.com', 'admin');

-- ตารางสำหรับหมวดหมู่สินค้า
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- ตารางสำหรับจัดเก็บข้อมูลสินค้า
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2),
    stock INT,
    image VARCHAR(255),
    category_id INT,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);
