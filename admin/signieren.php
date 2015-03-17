<?php
	
	
	$type = $_POST["type"];
	$user = $_POST["user"];
	$laufzeit = $_POST["laufzeit"];
	$csrlocation = substr($_POST["csrlocation"], 3);
		
	$timestamp = time ();
	$datum = date ( "Ymd", $timestamp );
	$uhrzeit = date ( "Hi", $timestamp );
	
	$dauer = $laufzeit;
	$cert = "wildcard1_cert.pem";
	$pfad = "/var/www/html/users/{$user}/";
	$pfadcsr = "/var/www/html/".$csrlocation;
	$pfadcert = "/var/www/html/users/{$user}/{$user}{$type}{$datum}{$uhrzeit}.crt";
	
	//echo "{$user} {$type} {$dauer} {$pfadcsr} {$pfadcert}";
	//echo "<br>";
	
	//Zertifikatsname: /var/www/html/users/User+Zertifikatsart+Datum(yyyymmdd)+Uhrzeit(hhmm).crt
	
	$subca = "/etc/ssl/serverca/serverca.pem";
	$privkey = "/etc/ssl/serverca/servercakey.pem";
	
	//Shell-Befehl zum signieren eines Zertifikates
	//serverca für normale zertifikate und userca für subca
 	
	if ($type == "singlecert");
	{
		//Einfaches Zertifikat
		//Zertifikatsname: /var/www/html/users/user+einfaches+datum(yyyymmdd)+uhrzeit(hhmm).crt
		
		$descriptors = array(
			0 => array("pipe", "r"),
			1 => array("pipe", "w")
		);

		$process = proc_open('openssl ca -name serverca -in ' .$pfadcsr. ' -days ' .$dauer. ' -out ' .$pfadcert, $descriptors, $pipes);

		if(is_resource($process)) {
			list ($out, $in) = $pipes;
			
			fwrite($out, "y\n");
			fwrite($out, "y\n");
			
			//echo stream_get_contents($in);
		}
	}
	
	if ($type == "intermediate");
	{
		//Intermediate Zertifikat
		//Zertifikatsname: /var/www/html/users/user+intermediate+datum(yyyymmdd)+uhrzeit(hhmm).pem
			
		$descriptors = array(
			0 => array("pipe", "r"),
			1 => array("pipe", "w")
		);

		$process = proc_open('openssl ca -name userca -in ' .$pfadcsr. ' -days ' .$dauer. ' -out ' .$pfadcert, $descriptors, $pipes);

		if(is_resource($process)) {
			list ($out, $in) = $pipes;
			
			fwrite($out, "y\n");
			fwrite($out, "y\n");
			
			//echo stream_get_contents($in);
		}
	}
	
	
	if ($type == "wildcard");
	{
		//Wildcard Zertifikat
		//Zertifikatsname: /var/www/html/users/user+wildacrd+datum(yyyymmdd)+uhrzeit(hhmm).crt
			
		$descriptors = array(
			0 => array("pipe", "r"),
			1 => array("pipe", "w")
		);

		$process = proc_open('openssl ca -name serverca -in ' .$pfadcsr. ' -days ' .$dauer. ' -out ' .$pfadcert, $descriptors, $pipes);

		if(is_resource($process)) {
			list ($out, $in) = $pipes;
			
			fwrite($out, "y\n");
			fwrite($out, "y\n");
			
			//echo stream_get_contents($in);
		}
	}

	/*if ($type == "san");  --> SAN Befehl googlen und anlegen
	{
		//SAN Zertifikat
		//Zertifikatsname: /var/www/html/users/user+san+datum(yyyymmdd)+uhrzeit(hhmm).crt
			
		$descriptors = array(
			0 => array("pipe", "r"),
			1 => array("pipe", "w")
		);

		$process = proc_open('openssl ca -name serverca -in ' .$pfadcsr. ' -days ' .$dauer. ' -out ' .$pfadcert, $descriptors, $pipes);

		if(is_resource($process)) {
			list ($out, $in) = $pipes;
			
			fwrite($out, "y\n");
			fwrite($out, "y\n");
			
			//echo stream_get_contents($in);
		}
	}*/
	
	
	echo "Das $type Zertifikat von User $user mit der Dauer $dauer Tage wurde signiert."
?>

<form action="admin.php" method="post"> <input type="submit" value="Back"> </form>
