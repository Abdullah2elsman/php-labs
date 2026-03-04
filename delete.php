<?php

$id = $_GET["id"];
$rows = file("users.txt");

unset($rows[$id]);

file_put_contents("users.txt", implode("", $rows));

header("Location: list.php");
exit;