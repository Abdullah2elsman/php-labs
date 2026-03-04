<?php

require_once 'config.php';

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: list.php?error=Invalid user ID");
    exit;
}

$id = (int)$_GET["id"];

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header("Location: list.php?error=User not found");
        exit;
    }

    echo "<h2>User Details</h2>";
    echo "<div style='max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd;'>";
    echo "<p><strong>ID:</strong> " . htmlspecialchars($user['id']) . "</p>";
    echo "<p><strong>Name:</strong> " . htmlspecialchars($user['first_name'] . " " . $user['last_name']) . "</p>";
    echo "<p><strong>Address:</strong> " . htmlspecialchars($user['address']) . "</p>";
    echo "<p><strong>Country:</strong> " . htmlspecialchars($user['country']) . "</p>";
    echo "<p><strong>Gender:</strong> " . htmlspecialchars(ucfirst($user['gender'])) . "</p>";
    echo "<p><strong>Skills:</strong> " . htmlspecialchars($user['skills']) . "</p>";
    echo "<p><strong>Department:</strong> " . htmlspecialchars($user['department']) . "</p>";
    echo "<p><strong>Username:</strong> " . htmlspecialchars($user['username']) . "</p>";
    echo "<p><strong>Registered:</strong> " . htmlspecialchars($user['created_at']) . "</p>";
    echo "</div>";

    echo "<div style='text-align: center; margin: 20px;'>";
    echo "<a href='list.php' style='margin-right: 10px;'>Back to List</a>";
    echo "<a href='delete.php?id=" . $user['id'] . "' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete User</a>";
    echo "</div>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
