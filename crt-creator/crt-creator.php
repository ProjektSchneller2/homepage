<?php
//welches Zertifikat soll es werden? Intermediate/Wildcard/Sub-Ca?

//Typ= aus Datenbank auslesen
$certificat_kind= "Wildcard";

//Tage über irgendein Feld von der Webseite übertragen
//aus Datenbank auslesen
$days = "365";

//Username
//aus Datenbank auslesen
$username = "ABC";

//Timestamp
//aus Datenbank auslesen
$timestamp = "1234";

//Pfad zur csr-Datei; mit ".csr" ?
//aus Datenbank auslesen
$userbox = "";

//wo liegt das config-File?
//$cnf_pfad = "/etc/apache2/sites-enabled/000-default.conf";


//Name der csr-Datei muss momentan immer ".csr" lauten -> aus Datenbank auslesen





if ($certificat_kind=="Intermediate"){
	//Intermediate:
	$command = "openssl ca -config /etc/apache2/sites-enabled/000-default.conf -days ";
	$command += $days;
	$command += " -in ";
	$command += $userbox;
	$command += ".csr -extensions v3_ca -out ";
	$command += $userbox+"\\"+$username+"_IM_"+$timestamp+".crt";

	$output = shell_exec($command);
}

else if($certificat_kind=="Wildcard"){
	//WC:
	$command = "openssl ca -config /etc/apache2/sites-enabled/000-default.conf -days ";
	$command += $days;
	$command += " -in "; 
	$command += $userbox;
	$command += ".csr -out ";
	$command += $userbox+"\\"+$username+"_WC_"+$timestamp+".crt";

	$output = shell_exec($command);
}

else if($certificat_kind=="Sub-Ca"){
	//WC:
	$command = "openssl ca -config /etc/apache2/sites-enabled/000-default.conf -days ";
	$command += $days;
	$command += " -in ";
	$command += $userbox;
	$command += ".csr -out ";
	$command += $userbox+"\\"+$username+"_S-Ca_"+$timestamp+".crt";

	$output = shell_exec($command);
}

else {
	echo "Zertifikatsart nicht erkannt. Bitte fragen sie ihr hilfreiches Administratorteam.";
}

?>
