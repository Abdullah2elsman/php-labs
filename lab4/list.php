<?php

require_once 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['userid'])) {
    header("Location: login.php?error=unauthorized");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .main-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            margin-top: 50px;
            margin-bottom: 50px;
            overflow: hidden;
        }

        .gradient-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
        }

        .table thead {
            background-color: #f8f9fa;
        }

        .btn-add {
            background: #667eea;
            color: white;
            border: none;
        }

        .btn-add:hover {
            background: #764ba2;
            color: white;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="main-container">

                    <div class="gradient-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0"><i class="bi bi-people-fill me-2"></i> User Management</h3>
                        <div>
                            <span class="me-3">Welcome, <strong><?php echo htmlspecialchars($_SESSION['first_name']); ?></strong></span>
                            <a href="registration.php" class="btn btn-light btn-sm">
                                <i class="bi bi-person-plus-fill me-1"></i> Add New User
                            </a>
                            <a href="logout.php" class="btn btn-outline-light btn-sm ms-2">Logout</a>
                        </div>
                    </div>

                    <div class="p-4">
                        <?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <?php
                                echo ($_GET['success'] == 'user_added') ? "User added successfully!" : "User deleted successfully!";
                                ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php
                        try {
                            $sql = "SELECT u.*, GROUP_CONCAT(s.name SEPARATOR ', ') as skills
                                FROM users u
                                LEFT JOIN user_skills us ON u.id = us.user_id
                                LEFT JOIN skills s ON us.skill_id = s.id
                                GROUP BY u.id
                                ORDER BY u.id DESC";

                            $stmt = $pdo->query($sql);
                            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if (empty($users)): ?>
                                <div class="text-center py-5">
                                    <i class="bi bi-person-x" style="font-size: 3rem; color: #ccc;"></i>
                                    <p class="mt-3 text-muted">No users found. <a href="registration.php">Add the first user</a></p>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Full Name</th>
                                                <th>Country</th>
                                                <th>Skills</th>
                                                <th>Department</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $user): ?>
                                                <tr>
                                                    <td><span class="badge bg-secondary">#<?php echo $user['id']; ?></span></td>
                                                    <td><strong><?php echo htmlspecialchars($user['first_name'] . " " . $user['last_name']); ?></strong></td>
                                                    <td><i class="bi bi-geo-alt me-1 text-primary"></i><?php echo htmlspecialchars($user['country']); ?></td>
                                                    <td>
                                                        <?php
                                                        $skills = $user['skills'] ? explode(', ', $user['skills']) : [];
                                                        foreach ($skills as $skill): ?>
                                                            <span class="badge rounded-pill bg-info text-dark" style="font-size: 0.75rem;"><?php echo htmlspecialchars($skill); ?></span>
                                                        <?php endforeach;
                                                        if (empty($skills)) echo '<span class="text-muted small">None</span>'; ?>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($user['department']); ?></td>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            <a href="view.php?id=<?php echo $user['id']; ?>" class="btn btn-outline-primary btn-sm">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            <a href="delete.php?id=<?php echo $user['id']; ?>"
                                                                onclick="return confirm('Are you sure you want to delete this user?')"
                                                                class="btn btn-outline-danger btn-sm">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                        <?php endif;
                        } catch (PDOException $e) {
                            echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>