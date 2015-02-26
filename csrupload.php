<?php
session_start();
?>

<?php

if(!isset($_SESSION["username"]))
{
	echo "Bitte erst <a href=\"anmeldung.html\">einloggen</a>";
	exit;
}

foreach ($_FILES["csr"]["error"] as $key => $error) {
	if ($error == UPLOAD_ERR_OK) {
		$tmp_name = $_FILES["csr"]["tmp_name"][$key];
		$name = $_FILES["csr"]["name"][$key];
		move_uploaded_file($tmp_name, "data/$name");
	}
}
?>