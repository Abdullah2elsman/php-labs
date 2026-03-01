<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
        $fname = $_POST['first-name'];
        $lname = $_POST['last-name'];
        $address = $_POST['address'];
        $gender = $_POST['gender'];
        $skills = $_POST['skills'];
        $dept = $_POST['department'];

        $title = ($gender == "female") ? "Miss" : "Mr.";

        echo "<h1>Thanks $title $fname $lname</h1>";
        echo "<h3>Please Review Your Information:</h3>";
        echo "<p><b>Name:</b> $fname $lname</p>";
        echo "<p><b>Address:</b> $address</p>";
        echo "<p><b>Your Skills:</b> " . implode(", ", $skills) . "</p>";
        echo "<p><b>Department:</b> $dept</p>";
}
