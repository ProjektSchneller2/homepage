<?php

	$user = "peterle";
	$csr = "wildcard1.csr";
	$cert = "wildcard1_cert.pem";
	$pfad = "/var/www/html/users/$user/";
	$pfadcsr = "/var/www/html/users/$user/$csr";
	$pfadcert = "/var/www/html/users/$user/$cert";
	
	$subca = "/etc/ssl/serverca/serverca.pem";
	$privkey = "/etc/ssl/serverca/servercakey.pem";
	
	//Shell-Befehl zum signieren eines Zertifikates
	//serverca für normale zertifikate und userca für subca
 	
	//Wildcard Zertifikat
	//shell_exec('openssl ca -name serverca -in ' .$pfadcsr. ' -days 365 -out ' .$pfadcert);
	//chmod($pfadcert, 0775);
	
	$descriptors = array(
		0 => array("pipe", "r"),
		1 => array("pipe", "w")
	);

	$process = proc_open('openssl ca -name serverca -in ' .$pfadcsr. ' -days 365 -out ' .$pfadcert, $descriptors, $pipes);

	if(is_resource($process)) {
		list ($out, $in) = $pipes;
		
		fwrite($out, "y\n");
		fwrite($out, "y\n");
		
		//echo stream_get_contents($in);
	}

	//$userscert = openssl_csr_sign($pfadcsr, $subca, $privkey, 365);
	
	//openssl_x509_export($usercert, $certout);
	//echo $certout;
	
	//Intermediate Zertifikat
	//shell_exec('openssl ca -name userca -in ' .$pfadcsr. ' -days 365 -out ' .$pfadcert);
	
	//SAN Zertifikat
	//shell_exec('openssl ca -name serverca -in /var/www/html/users/peterle/san.csr -days 365 -out /var/www/html/users/peterle/test_san.pem');
	//shell_exec('openssl ca -name serverca -in ' .$pfadcsr. ' -days 365 -out ' .$pfadcert);
	
	echo "Das Zertifikat von User $user wurde signiert."
	
	
/*	
	//Shell-Befehl der den Request anzeigt
	shell_exec('openssl req -text -noout -in "Pfad"/"Request-Datei".pem')	
*/		
?>

<form action="admin.php" method="post"> <input type="submit" value="Back"> </form>
