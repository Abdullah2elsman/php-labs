<?php

$id = $_GET["id"];
$rows = file("users.txt");

$data = explode(",", trim($rows[$id]));

echo "<h2>User Info</h2>";
echo "Name: ".$data[0]." ".$data[1]."<br>";
echo "Address: ".$data[2]."<br>";
echo "Country: ".$data[3]."<br>";
echo "Gender: ".$data[4]."<br>";
echo "Skills: ".str_replace("|", ", ", $data[5])."<br>";
