<?php
require_once 'header.php';
if (! isset($_SESSION)){
	session_start();
}
echo "<div class=\"container\">";
if(!isset($_SESSION["username"]))
{
	echo "Bitte erst <a href=\"anmeldung.html\">einloggen</a>";
	exit;
}
if (isset($_POST['certrenew'])){
	$laufzeit=$_POST['dauer'];
	$laufzeit= mysqli_real_escape_string ($db, $laufzeit);
	$csr_pfad=$_POST['csr_pfad'];
	
	include 'dbconnect.php';
	$eintrag="UPDATE cert SET crt_pfad='', crt_timestamp='', laufzeit='$laufzeit', status=0 WHERE csr_pfad='$csr_pfad'";
	$renewstatus = mysqli_query($db, $eintrag);
	
	// Mail Notification für Admin
	$empfaenger = "projektca@gmx.de";
	$absendername = "CSR Anfrage Formular";
	$absendermail = "projektca@gmx.de";
	$betreff = "Eine neue Zertifikatsanfrage ist eingetroffen";
	// Auf Nennung des Users wird aus Sicherheitsgründen verzichtet, da die Information direkt im Adminpanel bereitsteht
	$text = "Bitte CSR verlängern";
	mail ( $empfaenger, $betreff, $text, "From: $absendername <$absendermail>" );
	
	echo "<p>Vielen Dank! Sie haben soeben den Antrag zur Verl&auml;ngerung Ihres Zertifikates eingereicht!";
	echo "<p>Als nächstes werden wir Ihre Anfrage prüfen. Bei einer positiven Überprüfung werden wir Ihr signiertes Zertifikat erstellen.</p>";
	echo "<p>Dieses, sowie den aktuellen Bearbeitungsstand können Sie Ihrem Kundenprofil entnehmen.<br>Zu diesem <a href=\"supercert.php\">gelangen Sie hier.</a></p>";
}
else{
if (isset($_POST['renew'])){
	if(isset($_POST['csr_pfad'])){
		$csr_pfad=$_POST['csr_pfad'];
	}

	$type=$_POST['type'];
	

echo "<p>&nbsp;</p>";
echo "<table class=\"table table-striped\">";
echo "<form action=\"renew.php\" method=\"POST\">";
echo "<tr><td><b>CRT-Typ</b></td><td><b>Verl&auml;ngern um</b></td></tr>";
echo "<tr>";
echo "<td>".$type."</td>";
echo "<td><input name=\"dauer\" type=\"number\" min=\"1\" max=\"1825\" step=\"1\" value=\"1\">Tag(e)</td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan=\"3\"><input type=\"submit\" name=\"certrenew\" value=\"Verlängern\" class=\"btn btn-info\"></td>";		
echo "</tr>";
echo "<input type=\"hidden\" name=\"csr_pfad\" value=\"".$csr_pfad."\">";
echo "</form>";
echo "</table>";
echo "<form action=\"supercert.php\" method=\"POST\">";
echo "<input type=\"submit\" value=\"Abbrechen\" class=\"btn btn-info\">";
echo "</form>";

		}
		else{
			header("Location:supercert.php");
		}
}
echo "</div>";
?>