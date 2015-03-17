<?php
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


?>