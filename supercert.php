<?php

//Testseite für index-Startseite
//loginvariable, muss z. B. mit Session verbunden und mit einem weiteren if case abgefragt bzw. geändert werden - eingeloggt, ausgeloggt
$login = 1;
//nicht angemeldet
if ($login=1){
include ("logintemplate.html");


//direkte Einbindung
 include ("anmeldung.html");
 include ("registrierung.html");
 

}
else {
	echo "Ein Fehler ist während Ihrer Anmeldung aufgetreten";
}

//bereits angemeldet
if ($login=2){
	include ("Homepage.html");
}
else {
	
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