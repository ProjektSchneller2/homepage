<?php
include 'header.php';

$username = $_POST["username"];
$email = $_POST["email"];
$passwort = $_POST["passwort"];
$passwort2 = $_POST["passwort2"];

if ($passwort != $passwort2 OR $username == "" OR $passwort == "" OR $email == "") {
	echo "<p class=\"bg-danger\">Eingabefehler. Bitte alle Felder korekt ausfüllen. <a href=\"registrierung.html\">Zurück</a></p>";
	exit;
}
$passwort = password_hash($passwort, PASSWORD_DEFAULT); //bcrypt with automatic salting, algorithm cost of 10

//Prepared Statement: Check if username already exists
$stmt = mysqli_prepare("SELECT username, passwort, freischaltung FROM login WHERE username LIKE ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result();
$menge = mysqli_stmt_num_rows;

if ($menge == 0) {
	//Prepared Statement: Save user
	$stmt = mysqli_prepare("INSERT INTO login (username, passwort, email, freischaltung) VALUES (?, ?, ?, 0)");
	mysqli_stmt_bind_param($stmt, "sss", $username, $passwort, $email);
	mysqli_stmt_execute($stmt);
	$eintragen = mysqli_stmt_affected_rows($stmt);
	
	if ($eintragen >= 0) {
		echo "<p class=\"bg-success\">Benutzername <b>$username</b> wurde erstellt. <a href=\"anmeldung.html\">Login</a></p>";
	} else {
		echo "<p class=\"bg-danger\">Fehler beim Speichern des Benutzernames. <a href=\"registrierung.html\">Zurück</a>"</p>;
	}
} else {
echo "<p class=\"bg-danger\">Benutzername schon vorhanden. <a href=\"registrierung.html\">Zurück</a></p>";
}
?>
