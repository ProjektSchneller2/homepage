<?php

session_start();
if(!isset($_SESSION["admin"]))
{
	echo "Bitte erst <a href=\"anmeldung.html\">einloggen</a>";
	exit;
}
$user ="peterle";
echo "Daten der CSR von Nutzer \"".$user."\":";
//user + filename noch hartcodiert müssen aus der datenbank ausgelesen werden oder vom vorherigen file mit session übertragen werden

$filename ="wildcard6.csr";

$csrlocation="../users/".$user."/".$filename;


$csr = shell_exec('openssl req -noout -text -in '.$csrlocation);

//echo $csr;

//echo $csrlocation;

$subjectpart = explode('Subject:', $csr);
$subject=$subjectpart[1];
//$subjectstring = implode('', $subjectpart[1]);
$parts= explode (', ', $subject);

echo "<p>&nbsp;</p>";
echo "<table style=\" border-radius: 15px; border-width:10px; border-color:#66CC66; border-style:ridge; padding:5px; width: 900px;\">";
$country= $parts[0];
//echo "<p>&nbsp;</p>";
echo "<tr><td>Land:</td><td> ".$country."</td></tr>";
//echo "<p>&nbsp;</p>";

$state=$parts['1'];
echo "<tr><td>Bundesland:</td><td> ".$state."</td></tr>";
//echo "<p>&nbsp;</p>";

$location=$parts['2'];
echo "<tr><td>Ort:</td><td>".$location."</td></tr>";
//echo "<p>&nbsp;</p>";

$O=$parts['3'];
echo "<tr><td>Name des Unternehmens:</td><td> ".$O."</td></tr>";
//echo "<p>&nbsp;</p>";

$OU=$parts['4'];
echo "<tr><td>Organisationseinheit:</td><td> ".$OU."</td></tr>";
//echo "<p>&nbsp;</p>";

$commonnameextend= $parts['5'];
$commonnamepart=explode(" ",$commonnameextend);
$commonname=$commonnamepart[0];
echo "<tr><td>Commonname</td><td> ".$commonname."</td></tr>";


echo "</table>";
//Sonderaufteilung wegen Commonname & Verschlüsselung
$keyinformation=implode(" ",$commonnamepart);
$modulusextract= explode("Modulus:", $keyinformation);
$publickeypart=$modulusextract[1];
$publickeyextend=explode(" Exponent", $publickeypart);
$publickey=str_replace(" Exponent","", $publickeyextend[0]);
$bitpart =$modulusextract[0];
$bitencrypt=explode("Public-Key:",$bitpart);

echo "<p>&ouml;ffentlicher Schl&uuml;essel:</p><p><table style=\"border-radius: 15px; border-width:10px; border-color:#66CC66; border-style:ridge; padding:5px; width: 900px;\"><tr><td>"."Verschlüsselt mit ".$bitencrypt[1].":"."</td><td>".$publickey."</td></tr></table></p>";


/*var_dump($modulusextract);
echo "<p>&nbsp;</p>";
var_dump($publickey);
echo "<p>&nbsp;</p>";
var_dump($csr);*/


?>