<?php
require_once 'header.php';

$username = $_POST["username"]; 
$passwort = $_POST["password"];

//get database record for user
$stmt = mysqli_prepare("SELECT username, passwort, freischaltung FROM login WHERE username LIKE ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_array($res);

//is user unlocked
if ($row["freischaltung"] == 1) {
	//verify password
	if (password_verify($passwort, $row["passwort"])) {
		$_SESSION["username"] = $username; 
		header('Location: supercert.php'); 
	} else { 
		echo "<p class=\"bg-danger\">Benutzername und/oder Passwort waren falsch. <a href=\"anmeldung.html\">Login</a></p>"; 
	} 
} else { //freischaltung != 1 -> 0 or something different (because of error in database type etc.)
	echo "<p class=\"bg-danger\">Ihr Account wurde noch nicht freigeschaltet. <a href=\"anmeldung.html\">Login</a></p>";
}

?>
