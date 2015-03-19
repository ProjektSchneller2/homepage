<?php

require_once '../header.php';
echo "<div class=\"container\">";
$_SESSION['backend']=True;

if(!isset($_SESSION["admin"]))
{
	echo "Bitte erst <a href=\"anmeldung.html\">einloggen</a>";
	exit;
}

	
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
	

	

	//"-name serverca" fÃ¼r normale zertifikate und "-name userca" fÃ¼r subca
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
		
		
		
		
	}
	
*/
	// Update Zertifikats-Information
	$eintrag = "UPDATE cert SET crt_pfad='$crt_pfad', crt_timestamp='$crt_timestamp', status=1 WHERE csr_pfad='$csr_pfad'";
	$eintragen = mysqli_query($db, $eintrag);
	
	//Get email adress
	$abfrage = "SELECT email FROM login WHERE username LIKE '$user' LIMIT 1";
	$ergebnis = mysqli_query($db, $abfrage);
	$row = mysqli_fetch_object ($ergebnis);
	$empfaenger = $row->email;
	
	//Mail content
	$text = "Sehr geehrte Damen und Herren,\n \nIhre CSR wurde akzeptiert! \n\nSie können Ihr fertiges Zertifikat nun ihn Ihrem Kundenprofil herunterladen. \n\nMit freundlichen Grüsse Ihre Supercert GmbH";
	
	//Mail versand
	$absendername = "Supercert GmbH";
	$absendermail = "projektca@gmx.de";
	$betreff = "Annahme Ihrer Zertifikats-Request";
	mail ( $empfaenger, $betreff, $text, "From: $absendername <$absendermail>" );
	
	echo "Das $type Zertifikat von User $user mit der Dauer $dauer Tage wurde signiert.";
	echo "<form action=\"admin.php\" method=\"post\"> <input type=\"submit\" value=\"Back\"> </form>";
	echo "</div>";
?>



