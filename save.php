<?php

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

$line = implode(",", $data) . PHP_EOL;

file_put_contents("users.txt", $line, FILE_APPEND);

header("Location: list.php");
exit;
