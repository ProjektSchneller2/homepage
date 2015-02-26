<?php

if(!isset($_SESSION["username"]))
{
	echo "Bitte erst <a href=\"anmeldung.html\">einloggen</a>";
	exit;
}

if (isset($_POST('submit'))){
if (isset($_POST('selectcert'))){
	if (isset($_POST('intermediate'))){
		header ('Location: ./supercert.php');
	}
	if (isset($_POST('wildcard'))){
		header ('Location: ./supercert.php');
	}
}
}
?>