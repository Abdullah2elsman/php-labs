<?php

require_once 'config.php';

// Display messages
if (isset($_GET['success'])) {
   echo "<div style='color: green; padding: 10px; margin: 10px 0; border: 1px solid green;'>";
   echo "Success: User added successfully!";
   echo "</div>";
}

if (isset($_GET['error'])) {
   echo "<div style='color: red; padding: 10px; margin: 10px 0; border: 1px solid red;'>";
   echo "Error: " . htmlspecialchars($_GET['error']);
   echo "</div>";
}

try {
   $stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
   $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

   echo "<h2>User List</h2>";
   echo "<a href='registeration.php' style='margin-bottom: 20px; display: inline-block;'>Add New User</a>";

   echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
   echo "<tr style='background-color: #f2f2f2;'>
    <th style='padding: 10px;'>ID</th>
    <th style='padding: 10px;'>Name</th>
    <th style='padding: 10px;'>Country</th>
    <th style='padding: 10px;'>Department</th>
    <th style='padding: 10px;'>Actions</th>
    </tr>";

   foreach ($users as $user) {
      echo "<tr>";
      echo "<td style='padding: 8px;'>" . $user['id'] . "</td>";
      echo "<td style='padding: 8px;'>" . htmlspecialchars($user['first_name'] . " " . $user['last_name']) . "</td>";
      echo "<td style='padding: 8px;'>" . htmlspecialchars($user['country']) . "</td>";
      echo "<td style='padding: 8px;'>" . htmlspecialchars($user['department']) . "</td>";
      echo "<td style='padding: 8px;'>
        <a href='view.php?id=" . $user['id'] . "'>View</a> | 
        <a href='delete.php?id=" . $user['id'] . "' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
        </td>";
      echo "</tr>";
   }

   echo "</table>";
} catch (PDOException $e) {
   echo "Error: " . $e->getMessage();
}
