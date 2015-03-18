<?php
session_start();
if(!isset($_SESSION["username"]))
{
	echo "Bitte erst <a href=\"anmeldung.html\">einloggen</a>";
	exit;
}
else {
	
	
	
	$certpath=$_GET['crt_pfad'];
	$stringpart = explode("/", $certpath);
	$filename = $stringpart[count($stringpart)-1];
	
	header ("Content-Type:application/x-x509-ca-cert");
	header("Content-Disposition: attachment; filename=\"$filename\"");
	readfile($certpath);
	
	exit;
}

?>