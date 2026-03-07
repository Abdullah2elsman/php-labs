<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    try {
        $sql = "SELECT id, username, password, first_name FROM users WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData && password_verify($password, $userData['password'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['userid'] = $userData['id'];
            $_SESSION['first_name'] = $userData['first_name'];
            $_SESSION['username'] = $userData['username'];

            header('Location: list.php');
            exit;
        } else {
            header('Location: login.php?error=invalid');
            exit;
        }
    } catch (PDOException $e) {
        die('ERROR: ' . $e->getMessage());
    }
} else {
    header('Location: login.php');
    exit;
}