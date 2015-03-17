<?php
$certs=5;

echo "<table class=\"table table-striped\">";
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