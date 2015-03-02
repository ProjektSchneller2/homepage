<?php

session_start();

if(!isset($_SESSION["username"]))
{
	echo "Bitte erst <a href=\"anmeldung.html\">einloggen</a>";
	exit;
}


$selection = $_POST["selectcert"];
var_dump($_POST);

  
if ($selection == "singlecert"){
	$_SESSION['certtype']="singlecert";
	// statt in der Session muss es hier in der Datenbank gespeichert werden
}

if ($selection =="intermediate") {
	$_SESSION['certtype']="intermediate";
	
	
}
if ($selection =="wildcard"){
	
	$_SESSION['certtype']="wildcard";
}
include ("csrupload.php");

?>
