<?php
include '../dbconnect.php';


$abfrage = "SELECT username, freischaltung, email FROM login WHERE freischaltung LIKE 0";
$ergebnis = mysqli_query($db, $abfrage);


echo '<table border="1" style="border-radius: 15px; border-width:10px; border-color:#66CC66; border-style:ridge; padding:5px; width: 900px;">';
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