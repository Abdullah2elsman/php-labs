<?php

$host = 'localhost';
$username = 'abdullah'; 
$password = '123456';

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS user_management");
    echo "Database 'user_management' created successfully.<br>";

    $pdo->exec("USE user_management");

    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        address TEXT NOT NULL,
        country VARCHAR(50) NOT NULL,
        gender ENUM('male', 'female') NOT NULL,
        department VARCHAR(50) NOT NULL,
        username VARCHAR(100) UNIQUE,
        password VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    $pdo->exec($sql);
    echo "Table 'users' created successfully.<br>";

    $sql = "CREATE TABLE IF NOT EXISTS skills (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL UNIQUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    $pdo->exec($sql);
    echo "Table 'skills' created successfully.<br>";

    $sql = "CREATE TABLE IF NOT EXISTS user_skills (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        skill_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (skill_id) REFERENCES skills(id) ON DELETE CASCADE,
        UNIQUE KEY unique_user_skill (user_id, skill_id)
    )";

    $pdo->exec($sql);
    echo "Table 'user_skills' created successfully.<br>";

    $defaultSkills = ['PHP', 'J2SE', 'MySQL', 'PostgreSQL', 'JavaScript', 'Python', 'Java', 'C++'];

    $stmt = $pdo->prepare("INSERT IGNORE INTO skills (name) VALUES (?)");
    foreach ($defaultSkills as $skill) {
        $stmt->execute([$skill]);
    }
    echo "Default skills inserted successfully.<br>";

    echo "<br><strong>Database setup completed!</strong><br>";
    echo "<br><a href='registeration.php'>Go to Registration</a> | <a href='list.php'>View Users</a>";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
