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
	$cert = "wildcard1_cert.pem";
	$pfad = "/var/www/html/users/{$user}/";
	$pfadcnf = "/var/www/html/users/{$user}/{$user}.cnf";
	$pfadcsr = "/var/www/html/".$csrlocation;
	$pfadCA = "/etc/ssl/serverca/serverca.pem";
	$pfadKey = "/etc/ssl/serverca/private/servercakey.pem";
	$pfadcert = "/var/www/html/users/{$user}/{$user}{$type}{$datum}{$uhrzeit}.crt";
	$crt_pfad = "users/{$user}/{$user}{$type}{$datum}{$uhrzeit}.crt";
	$crt_timestamp = "{$datum}{$uhrzeit}";
	
	//inkludieren der db-verbindung:
	include '../dbconnect.php';

	
	//"-name serverca" fÃ¼r normale zertifikate und "-name userca" fÃ¼r subca
 	
	if ($type == "singlecert");
	{
		//Einfaches Zertifikat
		//Zertifikatsname: /var/www/html/users/user+einfaches+datum(yyyymmdd)+uhrzeit(hhmm).crt
		
		$descriptors = array(
			0 => array("pipe", "r"),
			1 => array("pipe", "w")
		);
		#erstellung des Certs mit x509
		#Falls funktioniert, c&p auf wildcard und SAN
		$process = proc_open('openssl.exe x509 -req -CA '.$pfadCA.' -CAkey '.$pfadKey.' -CAcreateserial -in '.$pfadcsr.' -out '.$pfadcert.' -days 365 -extensions v3_req -extfile '.$pfadcnf.'');
		#Backup mit ca Befehl
		#$process = proc_open('openssl ca -batch -in '.$pfadcsr.' -out '.$pfadcert.' -days 365 -cert '.$pfadCA.' -keyfile '.$pfadKey.' -config '.$pfadcnf.' -extensions v3_req');
		
		#Original Schnulf Code
		#$process = proc_open('openssl ca -name serverca -in ' .$pfadcsr.' -days ' .$dauer. ' -out ' .$pfadcert, $descriptors, $pipes);

		if(is_resource($process)) {
			list ($out, $in) = $pipes;
			
			fwrite($out, "y\n");
			fwrite($out, "y\n");
			
			
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

	
	
	if ($type == "san");  
	{
	
	
		//SAN Zertifikat --> CNF-Datei lÃ¶schen
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
	
	$eintrag = "UPDATE cert SET crt_pfad='$crt_pfad', crt_timestamp='$crt_timestamp', status=1 WHERE csr_pfad='$csr_pfad'";
	$eintragen = mysqli_query($db, $eintrag);
	
	echo "Das $type Zertifikat von User $user mit der Dauer $dauer Tage wurde signiert.";
	
	//email versand
	
	$username =$_SESSION["user"];
	
	$abfrage = "SELECT email FROM login WHERE username LIKE '$username' LIMIT 1";
	$ergebnis = mysqli_query($db, $abfrage);
	$row = mysqli_fetch_object ($ergebnis);
	$email = $row->email;
	
	
	
	
	//Mail versand
	$empfaenger =$email;
	$absendername = "Supercert GmbH";
	$absendermail = "projektca@gmx.de";
	$betreff = "Ihr Zertifikat wurde erstellt";
	$text = "Ihr Zertifikat wurde soeben signiert und ist nun in Ihrem Kundenprofil verfügbar";
	
	// Auf Nennung des Users wird aus SicherheitsgrÃ¼nden verzichtet, da die Information direkt im Adminpanel bereitsteht
	
	mail ( $empfaenger, $betreff, $text, "From: $absendername <$absendermail>" );
	
?>

<form action="admin.php" method="post"> <input type="submit" value="Back"> </form>
