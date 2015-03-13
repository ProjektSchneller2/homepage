<?php
include 'dbconnect.php';

$timestamp = time ();
$datum = date ( "dmY", $timestamp );
$uhrzeit = date ( "Hi", $timestamp );

//welche stati gibts?
$status = "check";

//Daten aus DB auslesen
$abfrage = "SELECT id, user, csr_pfad, crt_pfad, laufzeit, status FROM cert WHERE status LIKE '$status'";
$ergebnis = mysqli_query($db, $abfrage);
$row = mysqli_fetch_object($ergebnis);

//und in Variablen speichern
$id = $row->id;
$username = $row->user;
$days= $row->laufzeit;

// !!!!   HART REINCODIERT     !!!!!!	
$certificat_kind= "Wildcard";
	echo "!!! Hart-Reincodiert: !!! ";
	echo ($certificat_kind);
	echo "<br>";


//Pfad zur csr-Datei; mit ".csr" ?
$csr_pfad = $row->csr_pfad;



/*
if ($certificat_kind=="Intermediate"){
	//Intermediate:
	//den zukünftigen crt-Pfad generieren
	$crt_pfad = $csr_pfad+"\\"+$username+"_IM_"+$timestamp+".crt";
		echo "crt_pfad:";
		echo $crt_pfad;
	
	$command = "C:\Vera\Programme\Openssl\openssl ca -config C:\Vera\Programme\Openssl\ca.conf -days ";
	$command += $days;
	$command += " -in ";
	$command += $csr_pfad;
	$command += ".csr -extensions v3_ca -out ";
	$command += $crt_pfad;

	$output = shell_exec($command);
}
*/
//else 
if($certificat_kind=="Wildcard"){
	//WC:
		//$crt_pfad = $csr_pfad+"\\"+$username+"_WC_"+$timestamp+".crt";
		//echo "crt_pfad:";
		//echo $crt_pfad;
//$_SESSION ['username'] . '/' . $_SESSION ['certtype'] . '/' . $datum . '/' . $uhrzeit . '/' . $_FILES ['csruploadfile'] ['name'] );
	
	//in Ordner openssl gehen und openssl aufrufen
	$openssl = "cd C:\Vera\Programme\Openssl\openssl";
	$file = shell_exec($openssl);
	
	$activate_openssl = "openssl";
	$openssl_active= shell_exec($activate_openssl);
		echo "<br>";
		echo "openssl: ";
		echo $activate_openssl;
		echo "<br>";
	
	$command = "ca -config ca.cnf -days 365 -in C:\Vera\Programme\Openssl\openssl\intermediateTest2.csr -out C:\Vera\Programme\Openssl\openssl\intermediateTest2.crt";
		//echo "command1:";
		//echo "<br>";
		//echo $command;
		//echo "<br>";
	//$command += $days;
		//echo "command2:";
		//echo "<br>";
		//echo $command;
		//echo "<br>";
	//$command += " -in "; 
		//$command += $csr_pfad;
		//$command += "C:\Vera\Programme\Openssl\openssl\intermediateTest2.csr";
	//$command += " -out ";
		//$command += $crt_pfad;
	//$command += "C:\Vera\Programme\Openssl\openssl\php_certs\intermediateTest2.crt";
		//echo "<br>";
		echo "<br>";
		echo "command:";
		echo "<br>";
		echo $command;
		echo "<br>";
	$output = shell_exec($command);
	
	$really = "y";
	echo "<br>";
	echo "really:";
	echo $really;
	echo "<br>";
	$sign = shell_exec($really);
}
/*
else if($certificat_kind=="Sub-Ca"){
	//SA:
	$crt_pfad = $csr_pfad+"\\"+$username+"_S-Ca_"+$timestamp+".crt";
	echo "crt_pfad:";
	echo $crt_pfad;
	
	$command = "openssl ca -config /etc/apache2/sites-enabled/000-default.conf -days ";
	$command += $days;
	$command += " -in ";
	$command += $csr_pfad;
	$command += ".csr -out ";
	$command += $crt_pfad;

	$output = shell_exec($command);
	
}
*/
else {
	echo "Zertifikatsart nicht erkannt. Bitte fragen sie ihr hilfreiches Administratorteam.";
}




//DB anpassen
$update= "UPDATE cert SET crt_pfad = '$crt_pfad', crt_timestamp='$datum.$uhrzeit' WHERE id = '$id'";
$db_aendern= mysqli_query($db, $update);


?>
