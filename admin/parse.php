<?php

session_start();
if(!isset($_SESSION["admin"]))
{
	echo "Bitte erst <a href=\"anmeldung.html\">einloggen</a>";
	exit;
}

//user + filename noch hartcodiert müssen aus der datenbank ausgelesen werden oder vom vorherigen file mit session übertragen werden
$user ="peterle";
$filename ="intermediateTest2.csr";

$csrlocation="../users/".$user."/".$filename;


$csr = shell_exec('openssl req -noout -text -in '.$csrlocation);

//echo $csr;

//echo $csrlocation;
echo "<p>&nbsp;</p>";

$subjectpart = explode('Subject:', $csr);
$subjectstring = implode(' ', $subjectpart);
$subject= explode (', ', $subjectstring);

echo "<p>&nbsp;</p>";

$country= $subject[1];
echo "<p>&nbsp;</p>";
echo $country;
echo "<p>&nbsp;</p>";
$state=$subject['2'];
echo $state;
echo "<p>&nbsp;</p>";
$location=$subject['3'];
echo $location;
echo "<p>&nbsp;</p>";
$O=$subject['4'];
echo $O;
echo "<p>&nbsp;</p>";
$OU=explode(' ',$subject['5']);
echo $OU[0];
echo "<p>&nbsp;</p>";
$commonname= $OU[1];
echo $commonname;
echo "<p>&nbsp;</p>";
//Verschlüsselungsmethode, etc. fehlt
$Restdercsr=implode(" ", $OU);
$keyinformation=implode(" ", $OU);
$publickey= explode("Public-Key:", $keyinformation);
echo "oeffentlicher Schluessel:".$publickey[1];
echo "<p>&nbsp;</p>";
var_dump($Restdercsr);


?>