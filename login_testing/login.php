<?php
session_start();
?>

<?php 
$verbindung = mysqli_connect("localhost", "root" , "", "dhbw_ca") 
or die("Verbindung zur Datenbank konnte nicht hergestellt werden"); 

$username = $_POST["username"]; 
$passwort = md5($_POST["password"]); 

$abfrage = "SELECT username, passwort FROM login WHERE username LIKE '$username' LIMIT 1"; 
$ergebnis = mysqli_query($verbindung, $abfrage); 
$row = mysqli_fetch_object($ergebnis); 

if($row->passwort == $passwort) 
    { 
    $_SESSION["username"] = $username; 
    echo "Login erfolgreich. <br> <a href=\"geheim.php\">Geschützer Bereich</a>"; 
    } 
else 
    { 
    echo "Benutzername und/oder Passwort waren falsch. <a href=\"login.html\">Login</a>"; 
    } 

?>