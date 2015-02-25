<?php
include ("dbconnect.php");
$sql = "SELECT * FROM users";

$db_return = mysqli_query ($db, $sql);
if (! $db_return){
	exit ('Ungültige Abfrage: ' . mysqli_error());
}

echo '<table border="1">';
while ($zeile = mysqli_fetch_array($db_return, MYSQL_ASSOC))
{
	echo "<tr>";
	echo "<td>". $zeile['user'] . "</td>";
	echo "</tr>";
}
echo "</table>";

mysqli_free_result($db_return);

?>