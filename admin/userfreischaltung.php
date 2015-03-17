<?php
include '../dbconnect.php';


$abfrage = "SELECT username, freischaltung, email FROM login WHERE freischaltung LIKE 0";
$ergebnis = mysqli_query($db, $abfrage);


echo "<table class=\"table table-striped\">";;
while ($zeile = mysqli_fetch_array($ergebnis, MYSQL_ASSOC))
	{
			echo "<tr>";
			echo '<form action="userconfirmed.php" method="POST">';
			echo "<td>". $zeile['username'] . " <input type=\"hidden\" value=". $zeile['username'] ." name=\"username\"> </td>";
			echo "<td>". $zeile['email'] . "</td>";
			echo "<td> <input type=\"submit\" value=\"bestätigen\"></td>";
			echo "</form>";
			echo "</tr>";
		}
echo "</table>";


?>