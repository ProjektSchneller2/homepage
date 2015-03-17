<?php
session_start();
if(!isset($_SESSION["username"]))
{
	echo "Bitte erst <a href=\"anmeldung.html\">einloggen</a>";
	exit;
}
else {
	$type=".crt";
	$user=$_SESSION["username"];
	$filename="peterleintermediate201503171918";
	$certpath=$user."/".$filename.$type;
	
	header ("Content-Type:application/x-x509-ca-cert");
	header("Content-Disposition: attachment; filename=\"$filename.$type\"");
	readfile($certpath);
	
	exit;
}

?>