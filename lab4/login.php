<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .form-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .gradient-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }

        .skill-badge {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .skill-badge:hover {
            transform: translateY(-2px);
        }

        .captcha-box {
            background: #f8f9fa;
            border: 2px dashed #667eea;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="container py    -5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="form-container">
                    <!-- Header -->
                    <div class="gradient-header p-4 text-center">
                        <h2 class="mb-0">
                            <i class="bi bi-person-fill me-2"></i>
                            Login
                        </h2>
                        <p class="mb-0 mt-2 opacity-75">Join our community today</p>
                    </div>

                    <div class="p-4">
                        <?php
                        require_once 'config.php';

                        $alertMessage = "";
                        $alertClass = "alert-danger";

                        if (isset($_GET['error'])) {
                            switch ($_GET['error']) {
                                case 'invalid':
                                    $alertMessage = "<strong>Error:</strong> Invalid username or password.";
                                    break;
                                case 'unauthorized':
                                    $alertMessage = "<strong>Access Denied:</strong> Please login first to access this page.";
                                    break;
                                default:
                                    $alertMessage = "<strong>Error:</strong> An unexpected error occurred.";
                            }
                        } elseif (isset($_GET['status']) && $_GET['status'] == 'logged_out') {
                            $alertClass = "alert-info"; // لون أزرق للخروج
                            $alertMessage = "<i class='bi bi-info-circle-fill me-2'></i> <strong>Success:</strong> You have been logged out safely.";
                        }
                        ?>

                        <?php if ($alertMessage): ?>
                            <div class="alert <?php echo $alertClass; ?> alert-dismissible fade show" role="alert">
                                <?php if ($alertClass === "alert-danger"): ?>
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <?php endif; ?>

                                <?php echo $alertMessage; ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="signIn.php" method="POST" id="loginForm" novalidate>

                            <!-- Username and Password -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="username" class="form-label">
                                        <i class="bi bi-at me-1"></i>username
                                    </label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="Username" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">
                                        <i class="bi bi-lock me-1"></i>Password
                                    </label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="password" required>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-person me-1"></i>Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-4">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h5>Creating your account...</h5>
                    <p class="text-muted mb-0">Please wait while we process your information.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>