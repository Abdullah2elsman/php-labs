<?php

require_once 'config.php';

if (isset($_GET['success'])) {
    echo "<div style='color: green; padding: 10px; margin: 10px 0; border: 1px solid green;'>";
    switch ($_GET['success']) {
        case 'user_added':
            echo "Success: User added successfully!";
            break;
        case 'user_deleted':
            echo "Success: User deleted successfully!";
            break;
    }
    echo "</div>";
}

if (isset($_GET['error'])) {
    echo "<div style='color: red; padding: 10px; margin: 10px 0; border: 1px solid red;'>";
    echo "Error: " . htmlspecialchars($_GET['error']);
    echo "</div>";
}

try {
    $sql = "SELECT u.*, GROUP_CONCAT(s.name SEPARATOR ', ') as skills
            FROM users u
            LEFT JOIN user_skills us ON u.id = us.user_id
            LEFT JOIN skills s ON us.skill_id = s.id
            GROUP BY u.id
            ORDER BY u.id DESC";

    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>User Management System</h2>";
    echo "<a href='registeration.php' style='margin-bottom: 20px; display: inline-block; padding: 10px; background: #007cba; color: white; text-decoration: none;'>Add New User</a>";

    if (empty($users)) {
        echo "<p>No users found. <a href='registeration.php'>Add the first user</a></p>";
    } else {
        echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-top: 20px;'>";
        echo "<tr style='background-color: #f2f2f2;'>
        <th style='padding: 10px;'>ID</th>
        <th style='padding: 10px;'>Name</th>
        <th style='padding: 10px;'>Country</th>
        <th style='padding: 10px;'>Skills</th>
        <th style='padding: 10px;'>Department</th>
        <th style='padding: 10px;'>Actions</th>
        </tr>";

        foreach ($users as $user) {
            echo "<tr>";
            echo "<td style='padding: 8px;'>" . $user['id'] . "</td>";
            echo "<td style='padding: 8px;'>" . htmlspecialchars($user['first_name'] . " " . $user['last_name']) . "</td>";
            echo "<td style='padding: 8px;'>" . htmlspecialchars($user['country']) . "</td>";
            echo "<td style='padding: 8px;'>" . htmlspecialchars($user['skills'] ?: 'No skills') . "</td>";
            echo "<td style='padding: 8px;'>" . htmlspecialchars($user['department']) . "</td>";
            echo "<td style='padding: 8px;'>
            <a href='view.php?id=" . $user['id'] . "' style='margin-right: 10px;'>View</a> | 
            <a href='delete.php?id=" . $user['id'] . "' onclick='return confirm(\"Are you sure you want to delete this user?\")' style='color: red;'>Delete</a>
            </td>";
            echo "</tr>";
        }

        echo "</table>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
