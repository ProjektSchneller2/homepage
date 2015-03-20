<?php
	
	$type = $_POST["type"];
	$user = $_POST["user"];
	$laufzeit = $_POST["laufzeit"];
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
	
	/*
	echo "<br>";
	var_dump($_POST);
	echo "<br>";
	*/
	
	//inkludieren der db-verbindung:
	include '../dbconnect.php';



	$textinputserverca = "-----BEGIN CERTIFICATE-----
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
-----END CERTIFICATE-----
-----BEGIN CERTIFICATE-----
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
-----END CERTIFICATE-----";
	
	$textinputuserca = "
-----BEGIN CERTIFICATE-----
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
LS+hyLExKY64R/8=
-----END CERTIFICATE-----
-----BEGIN CERTIFICATE-----
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
-----END CERTIFICATE-----";


	//"-name serverca" für normale zertifikate und "-name userca" für subca
	
	
	
	//Singlecert
 	if ($type == "singlecert"){		
	//Userbility Feature für einfaches Zertifikat durch hinzufügen einer zusätzlichen DNS 
		
		//CSR auslesen und in die Variable schreiben
		$csr = shell_exec('openssl req -noout -text -in ' .$pfadcsr);	
		
		//Variablen deklarieren
		$poswww = strpos($csr,"CN=www.");
		$pos = strpos($csr,"CN=");
		$posmail = strpos($csr,"emailAddress");
		
		//Herausfinden ob in der CSR CN=www.example.com oder CN=example.com steht
		//Abfrage welcher Fall eintrifft, falls der erste Fall eintritt ansonsten 2. Fall
		if ($poswww != 0)
		{	
			//Position um 3 vergrößern da "CN=" weggerechnet werden muss
			$poswww = $poswww + 7;
			$substring = substr($csr, $poswww);
			
			//Abfrage ob in der CSR eine Mailadresse angegeben wurde
			if ($posmail != 0){
				//Common Name in die variable schreiben
				$cn = explode("/", $substring);
				//echo "<br>{$cn[0]}<br>";
			}
			else{
				//Common Name in die variable schreiben
				$cn = explode(" ", $substring);
				//echo "<br>{$cn[0]}<br>";
			}
			
			//Config anlegen
			//CNF-Dateigerüst kopieren
			$from = "/var/www/html/sanconfig/grund.cnf";
			$to = "/var/www/html/users/{$user}/grund.cnf";
			copy($from, $to);
			
			//Datei umbennen in cnf
			rename("/var/www/html/users/{$user}/grund.cnf", "/var/www/html/users/{$user}/{$user}.cnf");
			
			//SAN ergänzen
			$saninput = "\n[ alt_names ]
DNS.1 = {$cn[0]}"; 
			
			//CNF-Datei mit den Ergänzungen füllen
			$inhalt = file_get_contents("/var/www/html/users/{$user}/{$user}.cnf");
			file_put_contents("/var/www/html/users/{$user}/{$user}.cnf", $inhalt .= "{$saninput}");
			
			$pfadcnf = "/var/www/html/users/{$user}/{$user}.cnf";
			
			//Zertifikat mit der Config singieren
			shell_exec('openssl ca -batch -name serverca -out ' .$pfadcert.  ' -days ' .$dauer. ' -config ' .$pfadcnf. ' -extensions v3_req  -infiles ' .$pfadcsr);
			
		}
		else
		{
			//Position um 3 vergrößern da "CN=" weggerechnet werden muss
			$pos = $pos + 3;
			$substring = substr($csr, $pos);
			
			//Abfrage ob in der CSR eine Mailadresse angegeben wurde
			if ($posmail != 0){
				//Common Name in die variable schreiben
				$cn = explode("/", $substring);
				//echo "<br>{$cn[0]}<br>";
			}
			else{
				//Common Name in die variable schreiben
				$cn = explode(" ", $substring);
				//echo "<br>{$cn[0]}<br>";
			}
			
			//Config anlegen
			//CNF-Dateigerüst kopieren
			$from = "/var/www/html/sanconfig/grund.cnf";
			$to = "/var/www/html/users/{$user}/grund.cnf";
			copy($from, $to);
			
			//Datei umbennen in cnf
			rename("/var/www/html/users/{$user}/grund.cnf", "/var/www/html/users/{$user}/{$user}.cnf");
			
			//SAN ergänzen
			$saninput = "\n[ alt_names ]
DNS.1 = www.{$cn[0]}"; 
			
			//CNF-Datei mit den Ergänzungen füllen
			$inhalt = file_get_contents("/var/www/html/users/{$user}/{$user}.cnf");
			file_put_contents("/var/www/html/users/{$user}/{$user}.cnf", $inhalt .= "{$saninput}");
			
			$pfadcnf = "/var/www/html/users/{$user}/{$user}.cnf";
			
			//Zertifikat mit der Config singieren
			shell_exec('openssl ca -batch -name serverca -out ' .$pfadcert.  ' -days ' .$dauer. ' -config ' .$pfadcnf. ' -extensions v3_req  -infiles ' .$pfadcsr);
		}
		
		//Zertifikatskette
		$text = file_get_contents("{$pfadcert}");
		file_put_contents("{$pfadcert}", $text .= "{$textinputserverca}");
		
		//Config löschen
		unlink("/var/www/html/users/{$user}/{$user}.cnf"); 		
	}
	
	//Single zzgl. WIldcard Zertifikat
	if($type == "singlecertwildcard"){
	//Userbility Feature, durch hinzufügen einer zusätzlichen DNS 
		
		//CSR auslesen und in die Variable schreiben
		$csr = shell_exec('openssl req -noout -text -in ' .$pfadcsr);	
		
		//Variablen deklarieren
		$poswww = strpos($csr,"CN=www.");
		$pos = strpos($csr,"CN=");
		$posmail = strpos($csr,"emailAddress");
		
		//Herausfinden ob in der CSR CN=www.example.com oder CN=example.com steht
		//Abfrage welcher Fall eintrifft, falls der erste Fall eintritt ansonsten 2. Fall
		if ($poswww != 0)
		{	
			//Position um 3 vergrößern da "CN=" weggerechnet werden muss
			$poswww = $poswww + 7;
			$substring = substr($csr, $poswww);
			
			//Abfrage ob in der CSR eine Mailadresse angegeben wurde
			if ($posmail != 0){
				//Common Name in die variable schreiben
				$cn = explode("/", $substring);
				//echo "<br>{$cn[0]}<br>";
			}
			else{
				//Common Name in die variable schreiben
				$cn = explode(" ", $substring);
				//echo "<br>{$cn[0]}<br>";
			}
			
			//Config anlegen
			//CNF-Dateigerüst kopieren
			$from = "/var/www/html/sanconfig/grund.cnf";
			$to = "/var/www/html/users/{$user}/grund.cnf";
			copy($from, $to);
			
			//Datei umbennen in cnf
			rename("/var/www/html/users/{$user}/grund.cnf", "/var/www/html/users/{$user}/{$user}.cnf");
			
			//SAN ergänzen
			$saninput = "\n[ alt_names ]
DNS.1 = {$cn[0]}
DNS.2 = *.{$cn[0]}"; 
			
			//CNF-Datei mit den Ergänzungen füllen
			$inhalt = file_get_contents("/var/www/html/users/{$user}/{$user}.cnf");
			file_put_contents("/var/www/html/users/{$user}/{$user}.cnf", $inhalt .= "{$saninput}");
			
			$pfadcnf = "/var/www/html/users/{$user}/{$user}.cnf";
			
			//Zertifikat mit der Config singieren
			shell_exec('openssl ca -batch -name serverca -out ' .$pfadcert.  ' -days ' .$dauer. ' -config ' .$pfadcnf. ' -extensions v3_req  -infiles ' .$pfadcsr);
			
		}
		else
		{
			//Position um 3 vergrößern da "CN=" weggerechnet werden muss
			$pos = $pos + 3;
			$substring = substr($csr, $pos);
			
			//Abfrage ob in der CSR eine Mailadresse angegeben wurde
			if ($posmail != 0){
				//Common Name in die variable schreiben
				$cn = explode("/", $substring);
				//echo "<br>{$cn[0]}<br>";
			}
			else{
				//Common Name in die variable schreiben
				$cn = explode(" ", $substring);
				//echo "<br>{$cn[0]}<br>";
			}
			
			//Config anlegen
			//CNF-Dateigerüst kopieren
			$from = "/var/www/html/sanconfig/grund.cnf";
			$to = "/var/www/html/users/{$user}/grund.cnf";
			copy($from, $to);
			
			//Datei umbennen in cnf
			rename("/var/www/html/users/{$user}/grund.cnf", "/var/www/html/users/{$user}/{$user}.cnf");
			
			//SAN ergänzen
			$saninput = "\n[ alt_names ]
DNS.1 = www.{$cn[0]}
DNS.2 = *.{$cn[0]}"; 
			
			//CNF-Datei mit den Ergänzungen füllen
			$inhalt = file_get_contents("/var/www/html/users/{$user}/{$user}.cnf");
			file_put_contents("/var/www/html/users/{$user}/{$user}.cnf", $inhalt .= "{$saninput}");
			
			$pfadcnf = "/var/www/html/users/{$user}/{$user}.cnf";
			
			//Zertifikat mit der Config singieren
			shell_exec('openssl ca -batch -name serverca -out ' .$pfadcert.  ' -days ' .$dauer. ' -config ' .$pfadcnf. ' -extensions v3_req  -infiles ' .$pfadcsr);
		}
		
		//Zertifikatskette
		$text = file_get_contents("{$pfadcert}");
		file_put_contents("{$pfadcert}", $text .= "{$textinputserverca}");
		
		//Config löschen
		unlink("/var/www/html/users/{$user}/{$user}.cnf"); 		
	}
	
	//Issuing CA Zertifikat
	if ($type == "intermediate"){
		shell_exec('openssl ca -batch -name userca -in ' .$pfadcsr. ' -days ' .$dauer. ' -out ' .$pfadcert);
		
		//Zertifikatskette
		$text = file_get_contents("{$pfadcert}");
		file_put_contents("{$pfadcert}", $text .= "{$textinputuserca}");
	}
	
	//Wildcard Zertifikat
	if ($type == "wildcard"){
		shell_exec('openssl ca -batch -name serverca -in ' .$pfadcsr. ' -days ' .$dauer. ' -out ' .$pfadcert);
		
		//Zertifikatskette
		$text = file_get_contents("{$pfadcert}");
		file_put_contents("{$pfadcert}", $text .= "{$textinputserverca}");
	}
	
	//SAN Zertifikat
	if ($type == "san"){
		//Zertifikat mit der Config singieren
		shell_exec('openssl ca -batch -name serverca -out ' .$pfadcert.  ' -days ' .$dauer. ' -config ' .$pfadcnf. ' -extensions v3_req  -infiles ' .$pfadcsr);
		
		//Config löschen
		unlink("{$pfadcnf}"); 
		
		//Zertifikatskette hinzufügen
		$text = file_get_contents("{$pfadcert}");
		file_put_contents("{$pfadcert}", $text .= "{$textinputserverca}");
	}
	
	
	//Löschen der Datebenbank der ausgestellten Zertifikate
	//Für ServerCA
	shell_exec('rm /etc/ssl/serverca/index.txt');
	shell_exec('touch /etc/ssl/serverca/index.txt');
	shell_exec('rm /etc/ssl/serverca/serial');
	shell_exec('cp /etc/ssl/serial /etc/ssl/serverca/serial');
	
	//Für UserCA
	shell_exec('rm /etc/ssl/userca/index.txt');
	shell_exec('touch /etc/ssl/userca/index.txt');
	shell_exec('rm /etc/ssl/userca/serial');
	shell_exec('cp /etc/ssl/serial /etc/ssl/userca/serial');

	
/*	Alternative Möglichkeit um Zertifikate zu signieren ohne "-batch", diese wurde anfangs genutzt und dann ersetzt durch die obige
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
		
		
		
		
	}
	
*/
	
	//Datenbank mit dem Datensatz des Zertifikates füllen
	$eintrag = "UPDATE cert SET crt_pfad='$crt_pfad', crt_timestamp='$crt_timestamp', status=1 WHERE csr_pfad='$csr_pfad'";
	$eintragen = mysqli_query($db, $eintrag);
	
	//E-Mail Adresse bekommen
	$abfrage = "SELECT email FROM login WHERE username LIKE '$user' LIMIT 1";
	$ergebnis = mysqli_query($db, $abfrage);
	$row = mysqli_fetch_object ($ergebnis);
	$empfaenger = $row->email;
		
	//Inhalt der E-Mail
	$text = "Sehr geehrte Damen und Herren,\n \nIhre CSR wurde akzeptiert! \n\nSie k��n Ihr fertiges Zertifikat nun ihn Ihrem Kundenprofil herunterladen. \n\nMit freundlichen Gr�� Ihre Supercert GmbH";
	
	//E-Mailversand
	$absendername = "Supercert GmbH";
	$absendermail = "projektca@gmx.de";
	$betreff = "Annahme Ihrer Zertifikats-Request";
	mail ( $empfaenger, $betreff, $text, "From: $absendername <$absendermail>" );
	
	echo "Das $type Zertifikat von User $user mit der Dauer $dauer Tage wurde signiert.";
?>

<form action="admin.php" method="post"> <input type="submit" value="Back"> </form>
