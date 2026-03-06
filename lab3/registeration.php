<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>

<body>
    <?php
    require_once 'config.php';

    if (isset($_GET['error'])): ?>
        <div style="color: red; padding: 10px; margin: 10px 0; border: 1px solid red;">
            Error: <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <h2>User Registration</h2>
    <form action="save.php" method="POST">
        <input type="text" name="first-name" placeholder="First Name" required><br><br>
        <input type="text" name="last-name" placeholder="Last Name" required><br><br>
        <textarea name="address" placeholder="Address" required></textarea><br><br>
        <select name="country" required>
            <option value="">Select Country</option>
            <option value="Egypt">Egypt</option>
            <option value="Saudi Arabia">Saudi Arabia</option>
            <option value="Tunis">Tunis</option>
        </select><br><br>
        <label>Gender</label>
        <input type="radio" name="gender" value="male" required> Male
        <input type="radio" name="gender" value="female" required> Female
        <br><br>
        <label>Skills</label><br>
        <?php
        try {
            $stmt = $pdo->query("SELECT * FROM skills ORDER BY name");
            $skills = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($skills as $key => $skill) {
                $checked = ($key === 0) ? 'checked' : '';

                echo "<input type='checkbox' name='skills[]' value='" . $skill['id'] . "' $checked> " . htmlspecialchars($skill['name']) . " ";
            }
        } catch (PDOException $e) {
            echo "Error loading skills: " . $e->getMessage();
        }
        ?>
        <br><br>
        <label>Username</label>
        <input type="text" name="username" required>
        <br><br>
        <label>Password</label>
        <input type="password" name="password" required>
        <br><br>
        <label>Department</label>
        <input type="text" name="department" value="OpenSource" readonly>
        <br><br>
        <p>Sh68Sa</p>
        <input type="text" name="captcha" placeholder="Insert the code above" required>
        <br><br>

        <button type="submit">Submit</button>
        <button type="reset">Reset</button>
        <br><br>
    </form>

    <script>
        document.querySelector('form').onsubmit = function(e) {
            let skills = document.querySelectorAll('input[name="skills[]"]:checked');
            if (skills.length == 0) {
                alert("Please choose one skill at least");
                e.preventDefault();
                return false;
            }

            let gender = document.querySelector('input[name="gender"]:checked');
            if (!gender) {
                alert("Please select your gender");
                e.preventDefault();
                return false;
            }

            let country = document.querySelector('select[name="country"]').value;
            if (!country) {
                alert("Please select your country");
                e.preventDefault();
                return false;
            }

            let captchaInput = document.getElementsByName('captcha')[0].value;
            let originalCode = "Sh68Sa";
            if (captchaInput !== originalCode) {
                alert("Please Enter the correct code");
                e.preventDefault();
                return false;
            }

            return true;
        }
    </script>
</body>

</html>