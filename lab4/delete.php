<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php?error=unauthorized");
    exit;
}

require_once 'config.php';

if (!isset($_GET["id"]) || !filter_var($_GET["id"], FILTER_VALIDATE_INT)) {
    header("Location: list.php?error=Invalid user ID");
    exit;
}

$id = (int)$_GET["id"];

if ($id === $_SESSION['userid']) {
    header("Location: list.php?error=You cannot delete your own account!");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() > 0) {
        header("Location: list.php?success=user_deleted");
    } else {
        header("Location: list.php?error=User not found or already deleted");
    }
    exit;

} catch (PDOException $e) {
    error_log("Delete Error: " . $e->getMessage());
    header("Location: list.php?error=Database error occurred");
    exit;
}