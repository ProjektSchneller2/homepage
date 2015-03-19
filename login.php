<?php
//Einlogdaten + PWHash
require_once 'header.php';
echo "<div class=\"container\">"; //@TODO: needed?

$username = $_POST["username"]; 
$passwort = hash('sha512', $username.$_POST["password"]); //@TODO: PHP 5.5 and above: change to $passwort = password_hash($passwort, PASSWORD_DEFAULT);
									 //@TODO: set database column to length 255, delete all users, register new

//get database record for user
$stmt = mysqli_prepare ($db, "SELECT username, passwort, freischaltung FROM login WHERE username LIKE ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute ($stmt);
$res = mysqli_stmt_get_result ($stmt);
$row = mysqli_fetch_array ($res);

//is user unlocked
if ($row["freischaltung"] == 1) {
	//verify password
	if ($row["passwort"] == $passwort) {//@TODO: if (password_verify($passwort, $row->passwort)) { Login success } 
		$_SESSION["username"] = $username; 
		header('Location: supercert.php'); 
	} else { 
		echo "Benutzername und/oder Passwort waren falsch. <a href=\"anmeldung.html\">Login</a>"; 
	} 
} else { //freischaltung != 1 -> 0 or something different (because of error in database type etc.)
	echo "Ihr Account wurde noch nicht freigeschaltet. <a href=\"anmeldung.html\">Login</a>";
}

echo "</div>";
?>
