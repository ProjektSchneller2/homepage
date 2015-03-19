<?php
	$type = $_POST["type"];
	$user = $_POST["user"];
	$laufzeit = $_POST["laufzeit"];
	//$csrlocation = substr($_POST["csrlocation"], 3);
	$csr_pfad = $_POST['csr_pfad'];
		
	$timestamp = time ();
	$datum = date ( "Ymd", $timestamp );
	$uhrzeit = date ( "Hi", $timestamp );
	
	$dauer = $laufzeit;
	$pfad = "/var/www/html/users/{$user}/";
	$pfadcnf = "/var/www/html/users/{$user}/{$user}.cnf";
	$pfadcsr = "/var/www/html/".$csr_pfad;
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
		unlink("{$pfadcnf}"); 
	}
	
	shell_exec('rm /etc/ssl/serverca/index.txt');
	shell_exec('touch /etc/ssl/serverca/index.txt');
	shell_exec('rm /etc/ssl/serverca/serial');
	shell_exec('cp /etc/ssl/serial /etc/ssl/serverca/serial');
	
	shell_exec('rm /etc/ssl/userca/index.txt');
	shell_exec('touch /etc/ssl/userca/index.txt');
	shell_exec('rm /etc/ssl/userca/serial');
	shell_exec('cp /etc/ssl/serial /etc/ssl/userca/serial');
	
	
	
	$eintrag = "UPDATE cert SET crt_pfad='$crt_pfad', crt_timestamp='$crt_timestamp', status=1 WHERE csr_pfad='$csr_pfad'";
	$eintragen = mysqli_query($db, $eintrag);
	
	echo "Das $type Zertifikat von User $user wurde um $dauer Tage verlängert.";
?>

<form action="admin.php" method="post"> <input type="submit" value="Back"> </form>
