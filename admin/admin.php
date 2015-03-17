<?php



//Testseite für index-Startseite
//loginvariable, muss z. B. mit Session verbunden und mit einem weiteren if case abgefragt bzw. geändert werden - eingeloggt, ausgeloggt
//öffnet eine Session um den Status der Anmeldung zu speichern/abzufragen

session_start();
require_once '../header.php';
echo "<div class=\"container\">";
$_SESSION['backend']=True;
if(!isset($_SESSION["admin"]))
{
	echo "Bitte erst <a href=\"anmeldung.html\">einloggen</a>";
	exit;
}
			include ("admintemp.html");
			//Konsolenbestätigung der CSR-Dateien
			include ("console.php");
			echo "<p>&nbsp;</p>";
			include ("admincertlist.php");
			echo "<p>&nbsp;</p>";
			include ("userfreischaltung.php");
			echo "<p>&nbsp;</p>";
			include '../logout.html';
			
			
		



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
			echo "</div>"
?>
