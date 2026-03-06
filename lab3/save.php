<?php

require_once 'config.php';

try {
    $pdo->beginTransaction();

    $sql = "INSERT INTO users (first_name, last_name, address, country, gender, department, username, password) 
            VALUES (:first_name, :last_name, :address, :country, :gender, :department, :username, :password)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':first_name' => $_POST["first-name"],
        ':last_name' => $_POST["last-name"],
        ':address' => $_POST["address"],
        ':country' => $_POST["country"],
        ':gender' => $_POST["gender"],
        ':department' => $_POST["department"],
        ':username' => $_POST["username"],
        ':password' => password_hash($_POST["password"], PASSWORD_DEFAULT)
    ]);

    $userId = $pdo->lastInsertId();

    if (isset($_POST["skills"]) && is_array($_POST["skills"])) {
        $skillStmt = $pdo->prepare("INSERT INTO user_skills (user_id, skill_id) VALUES (?, ?)");

        foreach ($_POST["skills"] as $skillId) {
            $skillStmt->execute([$userId, $skillId]);
        }
    }

    $pdo->commit();

    header("Location: list.php?success=user_added");
    exit;
} catch (PDOException $e) {
    $pdo->rollback();
    header("Location: registeration.php?error=" . urlencode($e->getMessage()));
    exit;
}
