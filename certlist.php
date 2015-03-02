<?php


if(!isset($_SESSION["username"]))
{
	echo "Bitte erst <a href=\"anmeldung.html\">einloggen</a>";
	exit;
}

//Datenbankabfrage ob bereits Zertifikate gekauft wurden + Auflistung
//certcount soll die Anzahl der Zertifikate darstellen, im Mom. noch fest codiert
$certcount = 5;
$certstatus = FALSE;



//Prüfung ob Zertifikate gekauft werden
		if ($certcount !== Null){
			
			//Darstellung als Liste/Tabelle
			echo "<table style=\"border-radius: 15px; border-width:10px; border-color:#66CC66; border-style:ridge; padding:5px; width: 900px;\">";
			while ($certcount >= 1){
				//in den jeweiligen tds müssen dann die jeweiligen pendants der datenbank eingefügt werden
				echo "<tr>";
				echo "<td>";
				echo "$certcount";
				echo "</td>";
				echo "<td>";
				echo "Zertifikatsart";
				echo "</td>";
				echo "<td>";
				echo "Zertifikatsdownload";
				echo "</td>";
				echo "<td>";
				// vorläufige codierung ohne Datenbankzugriff - statusmeldung
				
//foreach besser, wenn die zertifikate dann als array ausgelesen werden
				if ($certstatus !== False){
					echo "<form action=\"downloadcert.php\" method=\"GET\">";
					echo "<input type=\"submit\" name=\"certdownload\" value=\"Download\">";
					echo "</form>";
				}
				else {
					echo "Beantragt!";
				}
				
				echo "</td>";
				echo "</tr>";
				
				$certcount=$certcount-1;
			}
						
			echo "</table>";
			
}	

		else {
			echo "Bislang haben Sie noch kein Zertifikat erworben";
		}
?>