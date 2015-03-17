<?php

if(!isset($_SESSION["admin"]))
{
	echo "Bitte erst <a href=\"anmeldung.html\">einloggen</a>";
	exit;
}

include '../dbconnect.php';
		
$abfrage = "SELECT user, csr_pfad, laufzeit, csr_timestamp FROM cert WHERE status LIKE 0";
$ergebnis = mysqli_query($db, $abfrage);

if ($ergebnis){

	echo '<table border="1" style="border-radius: 15px; border-width:10px; border-color:#66CC66; border-style:ridge; padding:5px; width: 900px;">';
	echo "<tr><td><b>CSR-Typ</b></td><td><b>User</b></td><td><b>Laufzeit</b></td><td><b>Timestamp</b></td><td><b>CSR-Pfad</b></td><td><b>CSR prüfen</b></td></tr>";
	while ($zeile = mysqli_fetch_array($ergebnis, MYSQL_ASSOC))
		{
				echo "<tr>";
				
				$stringpart = explode ("/", $zeile['csr_pfad']);	
				$filename = $stringpart[count($stringpart)-1];
				$type = explode ("2", $filename);
					
				echo "<td>". $type[0] . "</td>";
				echo "<td>". $zeile['user'] . "</td>";
				echo "<td>". $zeile['laufzeit']. "</td>";				
				echo "<td>". $zeile['csr_timestamp'] . "</td>";
				echo '<form action="csrcontrol.php" method="POST">';
				echo "<td>". $zeile['csr_pfad'] . " <input type=\"hidden\" value=". $zeile['csr_pfad'] ." name=\"csr_pfad\"> </td>";
				echo "<td> <input type=\"submit\" value=\"CSR prüfen\"></td>";
				echo "</form>";
				echo "</tr>";
			}
	echo "</table>";

}else{
	echo "Derzeit liegt keine Anfrage vor!";
}


/* 
//Abfrage ob eine Request vorliegt muss noch implementiert werden
$submitrequest = 5;



if ($submitrequest !== Null){
	
		
// Darstellung der Bestätigung muss noch implementiert werden
		
		
		echo "<table style=\"border-radius: 15px; border-width:10px; border-color:#66CC66; border-style:ridge; padding:5px; width: 900px;\">";
		while ($submitrequest >= 1){
			//in den jeweiligen tds müssen dann die jeweiligen pendants der datenbank eingefügt werden
			echo "<tr>";
			echo "<td>";
			echo "CSR Anfrage";
			echo "</td>";
					echo "<td>";
							echo "Zertifikatsart";
									echo "</td>";
									echo "<td>";
									echo "<a href=\"csrcontrol.php\">CSR prüfen</a>";
									echo "</td>";
									
						echo "</tr>";
		
						$submitrequest=$submitrequest-1;
		}
		
		echo "</table>";
				
	
	
}

else {
	
	echo " Derzeit liegt keine Anfrage vor!";
}
 */

?>