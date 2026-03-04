<?php

$skills = isset($_POST["skills"]) ? implode("__/", $_POST["skills"]) : "";

$data = [
    $_POST["first_name"],
    $_POST["last_name"],
    $_POST["address"],
    $_POST["country"],
    $_POST["gender"],
    $skills,
    $_POST["department"]
];

$line = implode(",", $data) . PHP_EOL;

$filePath = __DIR__ . "/users.txt";
$file = fopen($filePath, "a");
if ($file) {
    $result = fwrite($file, $line);
    fclose($file);
    if ($result === false) {
        die("Unable to write to file!");
    }
} else {
    die("Unable to open file! Check permissions on: " . $filePath);
}

header("Location: list.php");
exit;