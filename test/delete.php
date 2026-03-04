<?php

echo "Delete operation started<br>";
echo "ID received: " . $_GET["id"] . "<br>";

$id = $_GET["id"];
$rows = file("users.txt");

echo "Total rows before delete: " . count($rows) . "<br>";
echo "Row to delete: " . (isset($rows[$id]) ? $rows[$id] : "NOT FOUND") . "<br>";

unset($rows[$id]);

echo "Total rows after delete: " . count($rows) . "<br>";

$result = file_put_contents("users.txt", implode("", $rows));

if ($result === false) {
    echo "Failed to write file!<br>";
} else {
    echo "Successfully wrote file (" . $result . " bytes)<br>";
}

echo "<a href='list.php'>Go to list</a>";

// Temporarily comment out redirect for debugging
// header("Location: list.php");
// exit;
