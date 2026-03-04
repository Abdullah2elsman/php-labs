<?php

echo "<pre>";
echo "POST data received:\n";
print_r($_POST);
echo "</pre>";

$skills = isset($_POST["skills"]) ? implode("__/", $_POST["skills"]) : "";

$data = [
    $_POST["first-name"],
    $_POST["last-name"],
    $_POST["address"],
    $_POST["country"],
    $_POST["gender"],
    $skills,
    $_POST["department"]
];

echo "<pre>";
echo "Data to save:\n";
print_r($data);
echo "</pre>";

$line = implode(",", $data) . PHP_EOL;

echo "Line to write: " . $line . "<br>";

$result = file_put_contents("users.txt", $line, FILE_APPEND);

if ($result === false) {
    echo "Failed to write to file!<br>";
    echo "Current working directory: " . getcwd() . "<br>";
    echo "File exists: " . (file_exists("users.txt") ? "YES" : "NO") . "<br>";
    echo "File is writable: " . (is_writable("users.txt") ? "YES" : "NO") . "<br>";
    echo "Directory is writable: " . (is_writable(".") ? "YES" : "NO") . "<br>";
    echo "PHP user: " . get_current_user() . "<br>";
    echo "Error: " . error_get_last()['message'] . "<br>";
} else {
    echo "Successfully wrote " . $result . " bytes to file.";
    header("Location: list.php");
exit;
}
