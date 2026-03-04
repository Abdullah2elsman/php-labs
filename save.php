<?php

require_once 'config.php';

try {
    $skills = isset($_POST["skills"]) ? implode(", ", $_POST["skills"]) : "";

    $sql = "INSERT INTO users (first_name, last_name, address, country, gender, skills, department, username, password) 
            VALUES (:first_name, :last_name, :address, :country, :gender, :skills, :department, :username, :password)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':first_name' => $_POST["first-name"],
        ':last_name' => $_POST["last-name"],
        ':address' => $_POST["address"],
        ':country' => $_POST["country"],
        ':gender' => $_POST["gender"],
        ':skills' => $skills,
        ':department' => $_POST["department"],
        ':username' => $_POST["username"],
        ':password' => password_hash($_POST["password"], PASSWORD_DEFAULT)
    ]);

    header("Location: list.php?success=user_added");
    exit;
} catch (PDOException $e) {
    header("Location: registeration.php?error=" . urlencode($e->getMessage()));
    exit;
}
