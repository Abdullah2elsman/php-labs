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
} catch (PDOException $e) {
  die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile - <?php echo htmlspecialchars($user['first_name']); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      padding: 40px 0;
    }

    .profile-card {
      background: white;
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
      overflow: hidden;
    }

    .profile-header {
      background: linear-gradient(45deg, #667eea, #764ba2);
      color: white;
      padding: 40px;
      text-align: center;
    }

    .profile-header i {
      font-size: 5rem;
    }

    .info-label {
      font-weight: bold;
      color: #667eea;
      width: 150px;
      display: inline-block;
    }

    .skill-badge {
      background: #f0f2ff;
      color: #764ba2;
      border: 1px solid #d1d8ff;
      padding: 5px 12px;
      border-radius: 20px;
      margin-right: 5px;
      font-size: 0.9rem;
    }
  </style>
</head>

<body>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="profile-card">
          <div class="profile-header">
            <i class="bi bi-person-circle"></i>
            <h2 class="mt-3"><?php echo htmlspecialchars($user['first_name'] . " " . $user['last_name']); ?></h2>
            <p class="opacity-75 mb-0">Member since <?php echo date('M Y', strtotime($user['created_at'])); ?></p>
          </div>

          <div class="p-5">
            <div class="row g-4">
              <div class="col-sm-6">
                <p><span class="info-label"><i class="bi bi-hash me-2"></i>User ID:</span> #<?php echo $user['id']; ?></p>
                <p><span class="info-label"><i class="bi bi-geo-alt me-2"></i>Country:</span> <?php echo htmlspecialchars($user['country']); ?></p>
                <p><span class="info-label"><i class="bi bi-building me-2"></i>Dept:</span> <?php echo htmlspecialchars($user['department']); ?></p>
              </div>
              <div class="col-sm-6">
                <p><span class="info-label"><i class="bi bi-person-badge me-2"></i>Username:</span> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><span class="info-label"><i class="bi bi-gender-ambiguous me-2"></i>Gender:</span> <?php echo ucfirst($user['gender']); ?></p>
                <p><span class="info-label"><i class="bi bi-envelope me-2"></i>Address:</span> <?php echo htmlspecialchars($user['address']); ?></p>
              </div>
            </div>

            <hr class="my-4">

            <h5 class="mb-3">Professional Skills</h5>
            <div class="mb-4">
              <?php if (empty($userSkills)): ?>
                <span class="text-muted">No skills listed</span>
              <?php else: ?>
                <?php foreach ($userSkills as $skill): ?>
                  <span class="skill-badge"><i class="bi bi-check2-circle me-1"></i><?php echo htmlspecialchars($skill); ?></span>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>

            <div class="d-flex justify-content-between mt-5">
              <a href="list.php" class="btn btn-outline-secondary px-4">
                <i class="bi bi-arrow-left me-2"></i>Back to List
              </a>
              <div>
                <a href="delete.php?id=<?php echo $user['id']; ?>"
                  class="btn btn-danger px-4"
                  onclick="return confirm('Are you sure you want to delete this user?')">
                  <i class="bi bi-trash me-2"></i>Delete Profile
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>