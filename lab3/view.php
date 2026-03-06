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

  $skillStmt = $pdo->prepare("
        SELECT s.name 
        FROM skills s 
        JOIN user_skills us ON s.id = us.skill_id 
        WHERE us.user_id = :user_id
        ORDER BY s.name
    ");
  $skillStmt->execute([':user_id' => $id]);
  $userSkills = $skillStmt->fetchAll(PDO::FETCH_COLUMN);

  echo "<!DOCTYPE html>
    <html>
    <head>
        <title>User Details</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .container { max-width: 600px; margin: 0 auto; }
            .detail-box { border: 1px solid #ddd; padding: 20px; margin: 20px 0; }
            .detail-row { margin: 10px 0; }
            .label { font-weight: bold; display: inline-block; width: 120px; }
            .actions { text-align: center; margin: 20px 0; }
            .btn { padding: 10px 20px; margin: 0 10px; text-decoration: none; }
            .btn-primary { background: #007cba; color: white; }
            .btn-danger { background: #dc3545; color: white; }
        </style>
    </head>
    <body>";

  echo "<div class='container'>";
  echo "<h2>User Details</h2>";
  echo "<div class='detail-box'>";
  echo "<div class='detail-row'><span class='label'>ID:</span> " . htmlspecialchars($user['id']) . "</div>";
  echo "<div class='detail-row'><span class='label'>Name:</span> " . htmlspecialchars($user['first_name'] . " " . $user['last_name']) . "</div>";
  echo "<div class='detail-row'><span class='label'>Address:</span> " . htmlspecialchars($user['address']) . "</div>";
  echo "<div class='detail-row'><span class='label'>Country:</span> " . htmlspecialchars($user['country']) . "</div>";
  echo "<div class='detail-row'><span class='label'>Gender:</span> " . htmlspecialchars(ucfirst($user['gender'])) . "</div>";
  echo "<div class='detail-row'><span class='label'>Skills:</span> " . (empty($userSkills) ? 'No skills' : htmlspecialchars(implode(', ', $userSkills))) . "</div>";
  echo "<div class='detail-row'><span class='label'>Department:</span> " . htmlspecialchars($user['department']) . "</div>";
  echo "<div class='detail-row'><span class='label'>Username:</span> " . htmlspecialchars($user['username']) . "</div>";
  echo "<div class='detail-row'><span class='label'>Registered:</span> " . htmlspecialchars($user['created_at']) . "</div>";
  echo "</div>";

  echo "<div class='actions'>";
  echo "<a href='list.php' class='btn btn-primary'>Back to List</a>";
  echo "<a href='delete.php?id=" . $user['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete User</a>";
  echo "</div>";
  echo "</div>";

  echo "</body></html>";
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
