<?php

$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Connect to MySQL server
    $pdo = new PDO("mysql:host=$host;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS user_management");
    echo "Database 'user_management' created successfully.<br>";

    // Use the database
    $pdo->exec("USE user_management");

    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        address TEXT NOT NULL,
        country VARCHAR(50) NOT NULL,
        gender ENUM('male', 'female') NOT NULL,
        skills TEXT,
        department VARCHAR(50) NOT NULL,
        username VARCHAR(100),
        password VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    $pdo->exec($sql);
    echo "Table 'users' created successfully.<br>";

    echo "<br><a href='registeration.php'>Go to Registration</a> | <a href='list.php'>View Users</a>";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
