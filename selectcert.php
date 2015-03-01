<?php

session_start();

if(!isset($_SESSION["username"]))
{
	echo "Bitte erst <a href=\"anmeldung.html\">einloggen</a>";
	exit;
}

if (isset($_POST('submit'))){
if (isset($_POST('selectcert'))){
	if (isset($_POST('singlecert'))){
	// hier muss der zertifikatstyp in die session gespeichert werden um in der csrupload.php verarbeitet zu werden - Speicherung in den richtigen Ordner
	$_SESSION['certtype']="singlecert";
	}
	if (isset($_POST('intermediate'))){
		$_SESSION['certtype']="intermediate";
	}
	if (isset($_POST('wildcard'))){
		$_SESSION['certtype']="wildcard";
	}
	header ('Location: ./csrupload.php');
}
}
?>