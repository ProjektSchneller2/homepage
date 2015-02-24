
<?php

//Testseite für index-Startseite
//loginvariable, muss z. B. mit Session verbunden und mit einem weiteren if case abgefragt bzw. geändert werden - eingeloggt, ausgeloggt
//öffnet eine Session um den Status der Anmeldung zu speichern/abzufragen

session_start();
//Beispielcode für Anmeldeüberprüfung
//if (!isset($_SESSION['username']))
//	{
//		echo "Bitte erst <a href=\"supercert.php\">einloggen</a>";
//		exit;
//	}

$login = 1;
//nicht angemeldet

if ($login == 1){
include ("logintemplate.html");

//direkte Einbindung
 include ("anmeldung.html");
 include ("registrierung.html");
 }
 
else {
	

//bereits angemeldet
if ($login == 2){
	//statt $login==2 Sessionwerte abfragen ob der Kunde von csrupload.php kommt - dann csr weiterverarbeitung
	
	//include ("xy");
	if ($login == 2){
		//Liste der bereits erworbenen Zertifikate
	include ("certlist.php");
	//Auswahl der kaufbaren Zertifikate
	include ("selectcert.html");
}
else {
	echo "Ein Fehler ist während Ihrer Anmeldung aufgetreten";
	exit;
	
}
}



}


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
?>