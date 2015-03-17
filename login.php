<?php
//Einlogdaten + PWHash
session_start();
require_once 'header.php';
echo "<div class=\"container\">"; //@TODO: needed?
include 'dbconnect.php';

$username = $_POST["username"]; 
$passwort = md5($_POST["password"]); //@TODO: PHP 5.5 and above: change to $passwort = password_hash($passwort, PASSWORD_DEFAULT);
									 //@TODO: set database column to length 255, delete all users, register new

//get database record for user
$stmt = $db->prepare("SELECT username, passwort, freischaltung FROM login WHERE username LIKE ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_object();

//is user unlocked
if ($row->freischaltung == 1) {
	//verify password
	if ($row->passwort == $passwort) {//@TODO: if (password_verify($passwort, $row->passwort)) { Login success } 
		$_SESSION["username"] = $username; 
		header('Location: supercert.php'); 
	} else { 
		echo "Benutzername und/oder Passwort waren falsch. <a href=\"login.html\">Login</a>"; 
	} 
} else { //freischaltung != 1 -> 0 or something different (because of error in database type etc.)
	echo "Ihr Account wurde noch nicht freigeschaltet. <a href=\"login.html\">Login</a>";
}

echo "</div>";
?>
