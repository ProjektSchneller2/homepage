<?php

//evtl muss openssl in einem bestimmten Ordner aufgerufen werden -> Pfad zum Ordner noch einfügen
$command = "openssl req -in intermediate.csr (-noout) -text";
$out = shell_exec($command);


$replace = '|';

$out_replaced1 = ereg_replace("Subject: C=", $replace, $out);
$out_replaced2 = ereg_replace("Subject Public Key Info:", $replace, $out_replaced1);
$out_replaced3 = ereg_replace("Modulus:", $replace, $out_replaced2);
$out_replaced4 = ereg_replace("Exponent:", $replace, $out_replaced3);
$out_replaced5 = ereg_replace("Signature Algorithm:", $replace, $out_replaced4);

$array = explode('|', $out_replaced5);


echo "<p>Land, Staat, Stadt, Organisation etc.:</p>";
echo "<br>";
echo "<p>C="+$array[1]+"</p>";
echo "<br>";

echo "<p>Subject Public Key Info:</p>";
echo "<br>";
echo "<p>"+$array[2]+"</p>";
echo "<br>";

echo "<p>Modulus:</p>";
echo "<br>";
echo "<p>"+$array[3]+"</p>";
echo "<br>";

echo "<p>Exponent:</p>";
echo "<br>";
echo "<p>"+$array[4]+"</p>";
echo "<br>";

echo "<p>Signature Algorithm:</p>";
echo "<br>";
echo "<p>"+$array[5]+"</p>";
echo "<br>";


//evtl Button setzen; falls die Ausgabe nicht lesbar ist 
//(z.B. der Kunde hat seine Stadt wie "Modulus:" benannt)
//sodass zumindest noch die komplette CSR ungeparst ausgegeben wird
//sollte dann schöner sein, als jedes Mal die komplette Ausgabe

echo "<br>";
echo "<br>";
echo "<br>";
echo "Hier folgt noch die komplette CSR ungeparst:";
echo "<br>";
echo $out;


?>