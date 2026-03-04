<?php

$rows = file("users.txt");

echo "<table border='1'>";
echo "<tr>
<th>ID</th>
<th>Name</th>
<th>Actions</th>
</tr>";

foreach($rows as $index => $row){

   $data = explode(",",$row);

   echo "<tr>";
   echo "<td>$index</td>";
   echo "<td>".$data[0]." ".$data[1]."</td>";

   echo "<td>
   <a href='view.php?id=$index'>View</a>
   <a href='delete.php?id=$index'>Delete</a>
   </td>";

   echo "</tr>";
}

echo "</table>";