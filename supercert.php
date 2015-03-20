<?php
require_once 'header.php';
echo "<div class=\"container\">";
if (isset($_SESSION['username'])){
$username=$_SESSION['username'];

}
else{
	$username="";
}

echo "<h2>Herzlich willkommen bei Supercert ".$username."!</h2>";
if(!isset($_SESSION["username"]))
{
	echo "Bitte erst <a href=\"anmeldung.html\">einloggen</a>";
	exit;
}


//Testseite für index-Startseite
//loginvariable, muss z. B. mit Session verbunden und mit einem weiteren if case abgefragt bzw. geändert werden - eingeloggt, ausgeloggt
//öffnet eine Session um den Status der Anmeldung zu speichern/abzufragen


/*
$login = 2;
//nicht angemeldet

if ($login == 1){
include ("logintemplate.html");

//direkte Einbindung
 include ("anmeldung.html");
 include ("registrierung.html");
 }
 
else {
	
*/

//bereits angemeldet
//if ($login == 2){
	//statt $login==2 Sessionwerte abfragen ob der Kunde von csrupload.php kommt - dann csr weiterverarbeitung
	
	//include ("xy");
	//if ($login == 2){
	//Begrüßung und Farbe
	echo "<h3>Sie befinden sich auf Ihrem Kundenprofil:</h3>";

		//Liste der bereits erworbenen Zertifikate
	include ("certlist.php");
	//Auswahl der kaufbaren Zertifikate
	include ("selectcert.html");
	
	include 'price.php';
	include 'kontodaten.php';
	include 'logout.html';
/*
	}
else {
	echo "Ein Fehler ist während Ihrer Anmeldung aufgetreten";
	exit;
	
}

}



}

*/
	
	
//wird evtl. später gebraucht um Seite von dieser Seite aufzubauen
/*
$homepage = get_homepage_parts('./homepage.html');
//Template Tags ersetzen
foreach ($template as &$part) {
	switch ($part) {
		case 'title';
		$part = title();
		break;
		
	}
}


echo implode($homepage)*/
	echo "</div >";
	include 'footer.php';
	if (isset($_POST['impressum'])){
		echo "Kurs WI 2012 - IT Sicherheit/Gruppe 04<br>";
		echo "Marienstra�e 20<br>";
		echo "89518 Heidenheim<br>";
		echo "info(at)dhbw-heidenheim.de<br>";
	}
	else{echo"&nbsp;";}
?>
