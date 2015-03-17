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
	$validatefile="";
	$filename="peterleintermediate201503171918";
	$certpath=$user."/".$filename.$type;
	/*
function certdownload($file, $dir, $type) {

	header("Content-Type: $type");

	header("Content-Disposition: attachment; filename=\"$file\"");

	readfile($dir.$file);

}


$dir = 'users/'.$_SESSION['username']."/".'intermediateTest2.csr';

$type = 'application/zip';

if(!empty($_GET['file']) && !preg_match('=/=', $_GET['file'])) {
	if(file_exists ($dir.$_GET['file']))     {
		makeDownload($_GET['file'], $dir, $type);
	}

}*/
header ('Location: supercert.php');
}

?>