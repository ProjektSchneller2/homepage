<?php
include 'header.php';

$username = mysqli_real_escape_string ($db, $_POST["username"]);
$email = mysqli_real_escape_string ($db, $_POST["email"]);
$passwort = mysqli_real_escape_string ($db, $_POST["passwort"]);
$passwort2 = mysqli_real_escape_string ($db, $_POST["passwort2"]);

if($passwort != $passwort2 OR $username == "" OR $passwort == "" OR $email == "")
{
	echo "<p class=\"bg-danger\">Eingabefehler. Bitte alle Felder korekt ausfüllen. <a href=\"registrierung.html\">Zurück</a></p>";
	exit;
}
$passwort = hash('sha512', $username.$passwort);

$result = mysqli_query($db, "SELECT id FROM login WHERE username LIKE '$username'");
$menge = mysqli_num_rows($result);

if($menge == 0)
{
	$eintrag = "INSERT INTO login (username, passwort, email, freischaltung) VALUES ('$username', '$passwort', '$email', 0)";
	$eintragen = mysqli_query($db, $eintrag);

	if($eintragen == true)
	{
		echo "<p class=\"bg-success\">Benutzername <b>$username</b> wurde erstellt. <a href=\"anmeldung.html\">Login</a></p>";
	}
	else
	{
		echo "<p class=\"bg-danger\">Fehler beim Speichern des Benutzernames. <a href=\"registrierung.html\">Zurück</a></p>";
	}


}

else
{
echo "<p class=\"bg-danger\">Benutzername schon vorhanden. <a href=\"registrierung.html\">Zurück</a></p>";
    }
		?>
