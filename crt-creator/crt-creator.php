<?php
//welches Zertifikat soll es werden? Intermediate/Wildcard/Sub-Ca?
$certificat_kind= "Wildcard";

//Tage über irgendein Feld von der Webseite übertragen
$days = "365";

//Username
$username = "ABC";

//Timestamp
$timestamp = "1234";

//Name des Ordners des Users
$userbox = "";

//wo liegt das config-File?
$cnf_pfad = "";

//evtl muss openssl in einem bestimmten Ordner aufgerufen werden -> Pfad zum Ordner noch einfügen

//Name der csr-Datei muss momentan immer "ca.csr" lauten





if ($certificat_kind=="Intermediate"){
	//Intermediate:
	$command = "\usr\bin\openssl ca -config intermediate.cnf -days ";
	$command += $days;
	$command += " -in ";
	$command += $userbox;
	$command += "\ca.csr -extensions v3_ca -out ";
	$command += $userbox+"\\"+$username+"_IM_"+$timestamp+".crt";

	$output = shell_exec($command);
}

else if($certificat_kind=="Wildcard"){
	//WC:
	$command = "\usr\bin\openssl ca -config intermediate.cnf -days ";
	$command += $days;
	$command += " -in "; 
	$command += $userbox;
	$command += "\ca.csr -out ";
	$command += $userbox+"\\"+$username+"_WC_"+$timestamp+".crt";

	$output = shell_exec($command);
}

else if($certificat_kind=="Sub-Ca"){
	//WC:
	$command = "\usr\bin\openssl ca -config intermediate.cnf -days ";
	$command += $days;
	$command += " -in ";
	$command += $userbox;
	$command += "\ca.csr -out ";
	$command += $userbox+"\\"+$username+"_S-Ca_"+$timestamp+".crt";

	$output = shell_exec($command);
}

else {
	echo "Zertifikatsart nicht erkannt. Bitte fragen sie ihr hilfreiches Administratorteam.";
}

?>
