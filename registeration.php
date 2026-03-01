<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="done.php" method="POST">
        <input type="text" name="first-name" placeholder="First Name" required><br><br>
        <input type="text" name="last-name" placeholder="Last Name" required><br><br>
        <textarea name="address" id="" placeholder="Address" required></textarea><br><br>
        <select name="" id="">
            <option value="Egypt">Egypt</option>
            <option value="Saudi Arabia">Saudi Arabia</option>
            <option value="Tunis">Tunis</option>
        </select><br><br>
        <label>Gender</label>
        <input type="radio" name="gender" value="male"> Male
        <input type="radio" name="gender" value="female"> Female
        <br><br>
        <label>Skills</label>
        <input type="checkbox" name="skills[]" value="PHP"> PHP
        <input type="checkbox" name="skills[]" value="J2SE"> J2SE <br><br>
        <label></label> <input type="checkbox" name="skills[]" value="MySQL" checked> MySQL
        <input type="checkbox" name="skills[]" value="PostgreSQL"> PostgreSQL
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
        <input type="text" name="captcha" placeholder="Insert the code above">
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
                return;
            }

            let captchaInput = document.getElementsByName('captcha')[0].value;
            let originalCode = "Sh68Sa"; 
            if (captchaInput !== originalCode) {
                alert("Please Enter the correct code");
                e.preventDefault();
                return;
            }
        }
    </script>
</body>

</html>