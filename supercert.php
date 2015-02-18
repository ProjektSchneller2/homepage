<?php


//loginvariable, muss z. B. mit Session verbunden und mit einem weiteren if case abgefragt bzw. geändert werden - eingeloggt, ausgeloggt
$login = 1;

if ($login=1){
echo "Willkommen bei Supercert";
echo "Bitte wählen Sie aus";
//direkte html Verlinkung test
echo "<a href=\"./anmeldung.html\">Anmelden</a>";
//noch keine Verlinkung
echo "<a href=\"\">Sie sind noch nicht angemeldet? Registrieren Sie sich hier!</a>";

}
else {
	echo "Ein Fehler ist aufgetreten";
}
include ("Homepage.html");


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