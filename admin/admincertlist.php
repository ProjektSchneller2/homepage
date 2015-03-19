<?php


if(!isset($_SESSION["admin"]))
{
	echo "Bitte erst <a href=\"anmeldung.html\">einloggen</a>";
	exit;
}

include '../dbconnect.php';

$abfrage = "SELECT user, csr_pfad, laufzeit, csr_timestamp, crt_pfad, crt_timestamp FROM cert WHERE status LIKE 1";
$ergebnis = mysqli_query($db, $abfrage);

if ($ergebnis){
	if (mysqli_num_rows($ergebnis)>0) {

	echo "<table class=\"table table-striped\">";
	echo "<tr>
			<td><b>CSR-Typ</b></td>
			<td><b>User</b></td>
			<td><b>Laufzeit</b></td>
			<td><b>CSR-Timestamp</b></td>
			<td><b>CSR-Pfad</b></td>
			<td><b>CRT-Timestamp</b></td>
			<td><b>CRT-Pfad</b></td>
			</tr>";
	while ($zeile = mysqli_fetch_array($ergebnis, MYSQL_ASSOC))
	{
		echo "<tr>";

		$stringpart = explode ("/", $zeile['csr_pfad']);
		$filename = $stringpart[count($stringpart)-1];
		$type = explode ("2", $filename);
			
		echo "<td>". $type[0] . "</td>";
		echo "<td>". $zeile['user'] . "  </td>";
		echo "<td>". $zeile['laufzeit']. "  </td>";
		echo "<td>". $zeile['csr_timestamp'] . "</td>";
		echo "<td>". $zeile['csr_pfad'] . "  </td>";
		echo "<td>". $zeile['crt_timestamp'] . "</td>";
		echo "<td>". $zeile['crt_pfad'] . "</td>";
		echo "</tr>";
	}
	echo "</table>";
	
	}else{
		echo "Derzeit liegt keine Anfrage vor!";
	}

}else{
	echo "Datenbank sagt nein.";
}


/*
$certs=5;

echo "<table class=\"table table-striped\">";
while ($certs >= 1){
	//in den jeweiligen tds m�ssen dann die jeweiligen pendants der datenbank eingef�gt werden
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
*/
?>