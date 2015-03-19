<?php
	
	$type = $_POST["type"];
	$user = $_POST["user"];
	$laufzeit = $_POST["laufzeit"];
	$csrlocation = substr($_POST["csrlocation"], 3);
	$csr_pfad = $_POST['csr_pfad'];
		
	$timestamp = time ();
	$datum = date ( "Ymd", $timestamp );
	$uhrzeit = date ( "Hi", $timestamp );
	
	$dauer = $laufzeit;
	$pfad = "/var/www/html/users/{$user}/";
	$pfadcnf = "/var/www/html/users/{$user}/{$user}.cnf";
	$pfadcsr = "/var/www/html/".$csrlocation;
	$pfadcert = "/var/www/html/users/{$user}/{$user}{$type}{$datum}{$uhrzeit}.crt";
	$crt_pfad = "users/{$user}/{$user}{$type}{$datum}{$uhrzeit}.crt";
	$crt_timestamp = "{$datum}{$uhrzeit}";
	
	//inkludieren der db-verbindung:
	include '../dbconnect.php';

	/*
	var_dump($_POST);
	echo "<br>";
	echo "$pfad $pfadcnf $pfadcsr $crt_pfad $crt_timestamp";
	echo "<br>";
	*/
	
	
	

	//"-name serverca" für normale zertifikate und "-name userca" für subca
 	if ($type == "singlecert"){
		shell_exec('openssl ca -batch -name serverca -in ' .$pfadcsr. ' -days ' .$dauer. ' -out ' .$pfadcert);
	}
	
	if ($type == "intermediate"){
		shell_exec('openssl ca -batch -name userca -in ' .$pfadcsr. ' -days ' .$dauer. ' -out ' .$pfadcert);
	}
	
	if ($type == "wildcard"){
		shell_exec('openssl ca -batch -name serverca -in ' .$pfadcsr. ' -days ' .$dauer. ' -out ' .$pfadcert);
	}
	
	
	if ($type == "san"){
		shell_exec('openssl ca -batch -name serverca -out ' .$pfadcert.  ' -days ' .$dauer. ' -config ' .$pfadcnf. ' -extensions v3_req  -infiles ' .$pfadcsr);
	}
	
	/*
	
	if ($type == "singlecert"){
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
			
			
		}
					
		
	}
	
	
	
	if ($type == "intermediate"){
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
			
			
		}
	}
	
	
	if ($type == "wildcard"){
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

	
	
	if ($type == "san"){
	
	
		//SAN Zertifikat --> CNF-Datei löschen
		//Zertifikatsname: /var/www/html/users/user+san+datum(yyyymmdd)+uhrzeit(hhmm).crt
			
		$descriptors = array(
			0 => array("pipe", "r"),
			1 => array("pipe", "w")
		);

		$process = proc_open('openssl ca -name serverca -out ' .$pfadcert.  ' -days ' .$dauer. ' -config ' .$pfadcnf. ' -extensions v3_req  -infiles ' .$pfadcsr, $descriptors, $pipes);
				
		if(is_resource($process)) {
			list ($out, $in) = $pipes;
			
			fwrite($out, "y\n");
			fwrite($out, "y\n");
			
			//echo stream_get_contents($in);
		}
		
		
		//echo unlink("{$pfadcnf}"); 
		
	}
	
*/
	
	$eintrag = "UPDATE cert SET crt_pfad='$crt_pfad', crt_timestamp='$crt_timestamp', status=1 WHERE csr_pfad='$csr_pfad'";
	$eintragen = mysqli_query($db, $eintrag);
	
	echo "Das $type Zertifikat von User $user mit der Dauer $dauer Tage wurde signiert.";
?>

<form action="admin.php" method="post"> <input type="submit" value="Back"> </form>
