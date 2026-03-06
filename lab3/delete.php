<?php

require_once 'config.php';

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: list.php?error=Invalid user ID");
    exit;
}

$id = (int)$_GET["id"];

try {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $result = $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() > 0) {
        header("Location: list.php?success=user_deleted");
    } else {
        header("Location: list.php?error=User not found");
    }
    exit;
} catch (PDOException $e) {
    header("Location: list.php?error=" . urlencode($e->getMessage()));
    exit;
}
