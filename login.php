<?php
//Einlogdaten + PWHash
session_start();
?>

<?php 
include 'dbconnect.php';

$username = $_POST["username"]; 
$passwort = md5($_POST["password"]); 

$abfrage = "SELECT username, passwort, freischaltung FROM login WHERE username LIKE '$username' LIMIT 1"; 
$ergebnis = mysqli_query($db, $abfrage); 
$row = mysqli_fetch_object($ergebnis); 

if($row->freischaltung == 0){
	echo "Ihr Account wurde noch nicht freigeschaltet. <a href=\"anmeldung.html\">Login</a>";
}
else {

if($row->passwort == $passwort) 
    { 
    $_SESSION["username"] = $username; 
    echo "Login erfolgreich. <br> <a href=\"supercert.php\">supercert.php</a>"; 
    } 
else 
    { 
    echo "Benutzername und/oder Passwort waren falsch. <a href=\"anmeldung.html\">Login</a>"; 
    } 
}


/* old code:
 * 
 * if (isset($_POST['username'])) {
	$username = $_POST['username'];
} else {
	$error = TRUE;
}
if (isset($_POST['password'])) {
	$pw = hash("sha512", $_POST['password']);
} else {
	$error = TRUE;
}

$account = NULL;
if ($db->get_admin($username) != NULL) {
	$account = reset($db->get_admin($username));
}

if ($account['password'] == $pw) {
	$_SESSION['accountaccept'] = TRUE;
} else {
	$_SESSION['accountaccept'] = FALSE;
}

header('Location: supercert.php');
 */

?>