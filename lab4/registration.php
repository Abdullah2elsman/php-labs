<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
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
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="form-container">
                    <!-- Header -->
                    <div class="gradient-header p-4 text-center">
                        <h2 class="mb-0">
                            <i class="bi bi-person-plus-fill me-2"></i>
                            Create Your Account
                        </h2>
                        <p class="mb-0 mt-2 opacity-75">Join our community today</p>
                    </div>

                    <div class="p-4">
                        <?php
                        require_once 'config.php';

                        if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>Error:</strong> <?php echo htmlspecialchars($_GET['error']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="save.php" method="POST" id="registrationForm" novalidate>
                            <!-- Name Fields -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="first-name" class="form-label">
                                        <i class="bi bi-person me-1"></i>First Name
                                    </label>
                                    <input type="text" class="form-control" id="first-name" name="first-name"
                                        placeholder="Enter your first name" required>
                                    <div class="invalid-feedback">
                                        Please provide your first name.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="last-name" class="form-label">
                                        <i class="bi bi-person me-1"></i>Last Name
                                    </label>
                                    <input type="text" class="form-control" id="last-name" name="last-name"
                                        placeholder="Enter your last name" required>
                                    <div class="invalid-feedback">
                                        Please provide your last name.
                                    </div>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label for="address" class="form-label">
                                    <i class="bi bi-geo-alt me-1"></i>Address
                                </label>
                                <textarea class="form-control" id="address" name="address" rows="3"
                                    placeholder="Enter your full address" required></textarea>
                                <div class="invalid-feedback">
                                    Please provide your address.
                                </div>
                            </div>

                            <!-- Country -->
                            <div class="mb-3">
                                <label for="country" class="form-label">
                                    <i class="bi bi-globe me-1"></i>Country
                                </label>
                                <select class="form-select" id="country" name="country" required>
                                    <option value="">🌍 Select your country</option>
                                    <option value="Egypt">🇪🇬 Egypt</option>
                                    <option value="Saudi Arabia">🇸🇦 Saudi Arabia</option>
                                    <option value="Tunis">🇹🇳 Tunisia</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select your country.
                                </div>
                            </div>

                            <!-- Gender -->
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-gender-ambiguous me-1"></i>Gender
                                </label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" required>
                                        <label class="form-check-label" for="male">
                                            <i class="bi bi-person-standing me-1"></i>Male
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" required>
                                        <label class="form-check-label" for="female">
                                            <i class="bi bi-person-standing-dress me-1"></i>Female
                                        </label>
                                    </div>
                                </div>
                                <div class="invalid-feedback d-block" id="gender-error" style="display: none !important;">
                                    Please select your gender.
                                </div>
                            </div>

                            <!-- Skills -->
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-code-slash me-1"></i>Skills & Technologies
                                </label>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php
                                    try {
                                        $stmt = $pdo->query("SELECT * FROM skills ORDER BY name");
                                        $skills = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        $icons = [
                                            'PHP' => 'bi-filetype-php',
                                            'J2SE' => 'bi-cup-hot',
                                            'MySQL' => 'bi-database',
                                            'PostgreSQL' => 'bi-database-gear',
                                            'JavaScript' => 'bi-filetype-js',
                                            'Python' => 'bi-snake',
                                            'Java' => 'bi-cup-hot-fill',
                                            'C++' => 'bi-code-square'
                                        ];

                                        foreach ($skills as $key => $skill) {
                                            $checked = ($key === 0) ? 'checked' : '';
                                            $icon = $icons[$skill['name']] ?? 'bi-laptop';

                                            echo "<div class='form-check skill-badge'>";
                                            echo "<input class='form-check-input' type='checkbox' id='skill_" . $skill['id'] . "' name='skills[]' value='" . $skill['id'] . "' $checked>";
                                            echo "<label class='form-check-label badge bg-light text-dark border p-2' for='skill_" . $skill['id'] . "'>";
                                            echo "<i class='$icon me-1'></i>" . htmlspecialchars($skill['name']);
                                            echo "</label>";
                                            echo "</div>";
                                        }
                                    } catch (PDOException $e) {
                                        echo "<div class='alert alert-warning'>Error loading skills: " . $e->getMessage() . "</div>";
                                    }
                                    ?>
                                </div>
                                <div class="invalid-feedback d-block" id="skills-error" style="display: none !important;">
                                    Please select at least one skill.
                                </div>
                            </div>

                            <!-- Username and Password -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="username" class="form-label">
                                        <i class="bi bi-at me-1"></i>Username
                                    </label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="Choose a username" required>
                                    <div class="invalid-feedback">
                                        Please choose a username.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">
                                        <i class="bi bi-lock me-1"></i>Password
                                    </label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Create a strong password" required>
                                    <div class="invalid-feedback">
                                        Please create a password.
                                    </div>
                                </div>
                            </div>

                            <!-- Department -->
                            <div class="mb-3">
                                <label for="department" class="form-label">
                                    <i class="bi bi-building me-1"></i>Department
                                </label>
                                <input type="text" class="form-control" id="department" name="department"
                                    value="OpenSource" readonly>
                            </div>

                            <!-- Captcha -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="bi bi-shield-check me-1"></i>Security Verification
                                </label>
                                <div class="captcha-box p-3 text-center">
                                    <div class="fs-3 fw-bold text-primary mb-2" style="letter-spacing: 3px;">Sh68Sa</div>
                                    <input type="text" class="form-control w-50 mx-auto" name="captcha"
                                        placeholder="Enter the code above" required>
                                    <div class="invalid-feedback">
                                        Please enter the security code.
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-outline-secondary me-md-2">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Reset Form
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-person-plus me-1"></i>Create Account
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

    <script>
        // Form validation and submission
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let isValid = true;

            // Check skills
            let skills = document.querySelectorAll('input[name="skills[]"]:checked');
            if (skills.length == 0) {
                document.getElementById('skills-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('skills-error').style.display = 'none';
            }

            // Check gender
            let gender = document.querySelector('input[name="gender"]:checked');
            if (!gender) {
                document.getElementById('gender-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('gender-error').style.display = 'none';
            }

            // Check captcha
            let captchaInput = document.getElementsByName('captcha')[0].value;
            let originalCode = "Sh68Sa";
            if (captchaInput !== originalCode) {
                alert("🔒 Please enter the correct security code!");
                isValid = false;
            }

            // Bootstrap validation
            if (!this.checkValidity()) {
                isValid = false;
            }

            this.classList.add('was-validated');

            if (isValid) {
                // Show loading modal
                new bootstrap.Modal(document.getElementById('loadingModal')).show();

                // Submit form after short delay
                setTimeout(() => {
                    this.submit();
                }, 1000);
            }
        });

        // Skill badge styling
        document.querySelectorAll('input[name="skills[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const label = this.nextElementSibling;
                if (this.checked) {
                    label.classList.remove('bg-light', 'text-dark');
                    label.classList.add('bg-primary', 'text-white');
                } else {
                    label.classList.remove('bg-primary', 'text-white');
                    label.classList.add('bg-light', 'text-dark');
                }
            });
        });

        // Initialize checked skills styling
        document.querySelectorAll('input[name="skills[]"]:checked').forEach(checkbox => {
            const label = checkbox.nextElementSibling;
            label.classList.remove('bg-light', 'text-dark');
            label.classList.add('bg-primary', 'text-white');
        });
    </script>
</body>

</html>