<?php
require_once 'header.php';

if(!isset($_SESSION["username"]))
{
	echo "Bitte erst <a href=\"anmeldung.html\">einloggen</a>";
	exit;
}


//Variablen init
$username = $_SESSION["username"];


//DB-Abfrage
$abfrage = "SELECT csr_pfad, crt_timestamp, crt_pfad, laufzeit, status, csr_timestamp FROM cert WHERE user LIKE '$username'";
$ergebnis = mysqli_query($db, $abfrage);



if ($ergebnis){
	if (mysqli_num_rows($ergebnis)>0){

	echo "<table class=\"table table-striped\">";
	
	if (isset($zeile['status'])){
		if($zeile['status']==1){
	$renew="<td><b>Verl�ngern</b></td>";}
	else{
		$renew="<td></td>";
	}
	}
	echo "<tr><td><b>CSR-Typ</b></td><td><b>Status</b></td><td><b>Uploaddatum</b></td><td><strong>G&uuml;ltig bis</strong></td>".$renew."</tr>";
	while ($zeile = mysqli_fetch_array($ergebnis, MYSQL_ASSOC))
		{
			
			
				echo "<tr>";
				
				$stringpart = explode ("/", $zeile['csr_pfad']);	
				$filename = $stringpart[count($stringpart)-1];
				$type = explode ("2", $filename);
				$docdateunstructured=$zeile['csr_timestamp'];
				$dochour=substr($docdateunstructured, -4, 2);
				$docmin=substr($docdateunstructured, -2);
				$docyear=substr($docdateunstructured, -12, 4);
				$docday=substr($docdateunstructured, -6, 2);
				$docmonth=substr($docdateunstructured, -8, 2);
				
				
				echo "<td>". $type[0] . "</td>";
				if ($zeile['status'] == 0){
					echo "<td>Beantragt</td>";
				}else{
					echo "<form action=\"downloadcert.php\" method=\"GET\">";
					echo "<input type=\"hidden\" name=\"crt_pfad\" value=\"".$zeile['crt_pfad']."\">";
					echo "<td><input type=\"submit\" name=\"certdownload\" value=\"Download\" class=\"btn btn-success\"></td>";
					echo "</form>";
				}
				echo "<td>".$docday." / ".$docmonth." / ".$docyear." | ".$dochour.":".$docmin."</td>";
				if ($zeile['status'] == 1){
					
				echo "<td>".date('d / m / Y | H:i',strtotime(date("Y-m-d H:i:s", strtotime($zeile['crt_timestamp'])) . " + ".$zeile['laufzeit']." day"))."</td>";
				}
				else {
					echo "<td>&nbsp;</td>";
				}
				if ($zeile['status'] == 1){
					echo "<form action=\"renew.php\" method=\"POST\">";
				echo "<input type=\"hidden\" name=\"csr_pfad\" value=\"".$zeile['csr_pfad']."\">";
				//echo "<input type=\"hidden\" name=\"crt_pfad\" value=\"".$zeile['crt_pfad']."\">";
				//echo "<input type=\"hidden\" name=\"username\" value=\"".$username."\">";
				echo "<input type=\"hidden\" name=\"type\" value=\"".$type[0]."\">";
				echo "<td><input type=\"submit\" name=\"renew\" value=\"Verl�ngern\" class=\"btn btn-info\"></td>";
				echo "</form>";
				
				}
				else{
					echo"<td></td>";
				}
				echo "</tr>";
			}
	echo "</table>";
	
	}else{
		echo "Sie haben bisher kein Zertifikat erworben.";
	}

}else{
	echo "Datenbank sagt nein.";
}


/* 
 * 
 * 
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
					//echo "<input type=\"hidden\" name=\"username\" value=\"".$_SESSION['username']."\">";
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
		
		*
		*/
?>
