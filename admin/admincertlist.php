<?php
$certs=5;

echo "<table style=\"border-radius: 15px; border-width:10px; border-color:#66CC66; border-style:ridge; padding:5px; width: 900px;\">";
while ($certs >= 1){
	//in den jeweiligen tds müssen dann die jeweiligen pendants der datenbank eingefügt werden
	echo "<tr>";
	echo "<td>";
	echo "Kunde";
	echo "</td>";
	echo "<td>";
	echo "Zertifikatsart";
	echo "</td>";
	echo "<td>";
	echo "Datum";
	echo "</td>";
		
	echo "</tr>";

	$certs=$certs-1;
}

echo "</table>";

?>