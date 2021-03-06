
<?php
require_once 'header.php';
echo "<div class=\"container\">";
$timestamp = time ();
$datum = date ( "Ymd", $timestamp );
$uhrzeit = date ( "Hi", $timestamp );


if ($_FILES != Null) {
if (! isset($_SESSION)){
	session_start();
}
	
	/*
	  echo "<pre>";
	  echo "FILES:<br />";
	  print_r ($_FILES );
	  echo "</pre>";
	  var_dump($_FILES);
	  var_dump($_SESSION);
	  var_dump($_POST);
	 
	var_dump ( $_SESSION );*/
	if ($_FILES ['csruploadfile'] ['name'] != Null) {
		
		$zugelassenedateitypen = array (
				"application/x-x509-ca-cert" || "application/octet-stream" || "application/pkcs10" 
		);
		
		if (! in_array ( $_FILES ['csruploadfile'] ['type'], $zugelassenedateitypen )) {
			echo "<p>Dateitype ist NICHT zugelassen</p>";
		} else {
			
			if (isset($_POST['singlecertwildcard'])){
				$_SESSION ['certtype'] = 'singlecertwildcard';
			}
			
			$filepath = 'users/' . $_SESSION ['username'] ."/". $_SESSION ['certtype'] . $datum . $uhrzeit . /*$_FILES ['csruploadfile'] ['name']*/".csr";
			$db_timestamp = $datum.$uhrzeit;
			$username = $_SESSION ['username'];
			
			//�bertragen der Zertifikatsdaten in die DB
			include 'dbconnect.php';
			$laufzeit = $_SESSION['dauer'];
			$laufzeit= mysqli_real_escape_string ($db, $laufzeit);
			$eintrag = "INSERT INTO cert (user, csr_pfad, laufzeit, status, csr_timestamp) VALUES ('$username', '$filepath', '$laufzeit' , 0, '$db_timestamp')";
			$eintragen = mysqli_query($db, $eintrag);
			
			if($eintragen){
					
				move_uploaded_file ( $_FILES ['csruploadfile'] ['tmp_name'], 'users/' . $_SESSION ['username'] ."/". $_SESSION ['certtype'] . $datum . $uhrzeit . /*$_FILES ['csruploadfile'] ['name']*/".csr" );
								
				// Mail Notification f�r Admin
				$empfaenger = "projektca@gmx.de";
				$absendername = "CSR Anfrage Formular";
				$absendermail = "projektca@gmx.de";
				$betreff = "Eine neue Zertifikatsanfrage ist eingetroffen";
				// Auf Nennung des Users wird aus Sicherheitsgr�nden verzichtet, da die Information direkt im Adminpanel bereitsteht
				$text = "Eine neue CSR wurde hochgeladen.";
				mail ( $empfaenger, $betreff, $text, "From: $absendername <$absendermail>" );
				
				
				
				
				
				echo "<p>&nbsp;</p>";
				echo "<table><tr><td style=\"border-radius:100%; background: #5bc0de; width: 35px; height: 35px; text-align: center; padding: 15px 17px;\"><b>3.</b></td><td style=\"padding-left:10px;\"><b>Pr&uuml;fung der CSR</b></td></tr></table><p>&nbsp;</p>";
				echo "<p>Der Upload Ihrer CSR Datei war erfolgreich!</p>";
				echo "<p>Als n�chstes werden wir Ihre Anfrage pr�fen. Sollte Ihre Anfrage sowie die CSR Datei korrekt sein werden wir Ihr signiertes Zertifikat erstellen.</p>";
				echo "<p>Dieses, sowie den aktuellen Bearbeitungsstand k�nnen Sie Ihrem Kundenprofil entnehmen.<br>Zu diesem <a href=\"supercert.php\">gelangen Sie hier.</a></p>";
				
			
		
			}else{
				echo "<p>&nbsp;</p>";
				echo "<table><tr><td style=\"border-radius:100%; background: #5bc0de; width: 35px; height: 35px; text-align: center; padding: 15px 17px;\"><b>3.</b></td><td style=\"padding-left:10px;\"><b>Pr&uuml;fung der CSR</b></td></tr></table><p>&nbsp;</p>";
				echo "<p>Der Upload Ihrer CSR Datei war nicht erfolgreich!</p>";
				echo "<p>Sie d�rfen aus Sicherheitsgr�nden nur eine CSR-Anfrage pro Minute stellen.</p>";
				echo "<p>Zur�ck zu Ihrem Kundenprofil <a href=\"supercert.php\">gelangen Sie hier.</a></p>";
			}
			// echo '<a href="'.$_SESSION['username'].'/'. $_FILES['csruploadfile']['name'] .'">';
			// echo $_SESSION['username']. $_FILES['csruploadfile']['name'];
			// echo '</a>';
		}
		if($_SESSION ['certtype'] == "san")
		{
			//CNF-Dateiger�st kopieren
			$from = "/var/www/html/sanconfig/grund.cnf";
			$to = "/var/www/html/users/{$username}/grund.cnf";
			copy($from, $to);
			
			//Datei umbennen in cnf
			rename("/var/www/html/users/{$username}/grund.cnf", "/var/www/html/{$filepath}.cnf");
			$cnfdatei = "/var/www/html/{$filepath}.cnf";
			
			
			//Common Name als DNS hinzuf�gen
			//CSR auslesen und in die Variable schreiben
			$csr = shell_exec('openssl req -noout -text -in /var/www/html/' .$filepath);			
			//Variablen deklarieren
			$pos = strpos($csr,"CN=");
			$posmail = strpos($csr,"emailAddress");
			//Position um 3 vergr��ern da "CN=" weggerechnet werden muss
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
			
		
			
			
			//SAN eingaben in variable packen
			$saninput = "\n
			[ alt_names ]
DNS.1 = {$_POST["dns1"]}
DNS.2 = {$cn[0]}"; 
			
			//CNF-Datei mit den Usereingaben f�llen
			$inhalt = file_get_contents($cnfdatei);
			file_put_contents($cnfdatei, $inhalt .= "{$saninput}");
			
			//SAN Angaben in eine Textdatei abspeichern um diese bei der �berpr�fung des Admins anzuzeigen
			//Datei erstellen
			$sandatei = fopen("/var/www/html/users/{$username}/santxt" . $_SESSION ['certtype'] . $datum . $uhrzeit . ".txt", "a+");
						
			//SAN Angaben in die erstellte Datei schreiben
			fwrite($sandatei, $saninput);
			
			//Datei schlie�en
			fclose($sandatei);		
		}
		
	}
} 
else {
	// echo "<pre>";
	// echo "FILES:<br />";
	// print_r ($_FILES );
	// echo "</pre>";
	// var_dump($_SESSION);
	// var_dump($_POST);
	echo "<html>";
	echo "<div class=\"container\">";
	echo "<p>&nbsp;</p>";
	echo "<div class=\"form-group\">";
	
	echo "<table><tr><td style=\"border-radius:100%; background: #5bc0de; width: 35px; height: 35px; text-align: center; padding: 15px 17px;\"><b>2.</b></td><td style=\"padding-left:10px;\"><b>Ben&ouml;tigte Informationen</b></td></tr></table><p>&nbsp;</p>";
    echo "<label for=\"exampleInputFile\">Bitte laden Sie Ihre CSR auf unseren Server:</label>";
	echo "<form name=\"uploadformular\" enctype=\"multipart/form-data\" action=\"csrupload.php\" method=\"post\">";
	echo "<p><input type=\"file\" name=\"csruploadfile\" id=\"exampleInputFile\">";
	
	
	//Zusatzeingaben bei dem SAN-Zertifikat
	if ($_SESSION ['certtype'] == "san")	
	{
		echo "<p>DNS: <input type=\"text\" name=\"dns1\" /></p>";		
		
	
	}
	
	//Zusatzeingaben beim Singlecert-Zertifikat
	if ($_SESSION ['certtype'] == "singlecert"){
		echo "<p>";
		echo "<div class=\"checkbox\">";
		echo "<label>";
		echo "<input type=\"checkbox\" name=\"singlecertwildcard\"> Wildcard beantragen/hinzuf&uuml;gen";
		echo "</label>";
		echo "</div>";
		echo "</p>";
	}
	
	
	echo "<p><br><input type=\"Submit\" name=\"csrupload\" value=\"Datei hochladen und kostenpflichtig bestellen\" class=\"btn btn-primary\">";
	echo "</form>";
	
	echo "<form name=\"cancel\" action=\"supercert.php\" method=\"post\">";
	echo "<br><input type=\"Submit\" name=\"cancel\" value=\"Abbrechen\" class=\"btn btn-primary\"></p>";
	echo "</form>";
	echo "</div>";
	echo "</div>";
	echo "</html>";
}
if ($_SESSION ['certtype'] == "intermediate")
{
	echo "<h2 class=\"alert alert-danger\">Wichtiger Hinweis!</h2>";
	echo "<p>Ein Intermediate Zertifikat berechtigt zur Signierung weiterer Zertifikate und ist dadurch sehr <strong>m&auml;chtig</strong>.</p>Um uns und unsere Kunden bzw. die ausgestellten Zertifikate zu sch&uuml;tzen werden wir Intermediate Zertifikat nur an <br><strong>vertrauensw&uuml;rdige, ausgew&auml;hlte,  Kunden, wie z.B. &Ouml;ffentliche Einrichtungen, Forschungseinrichtungen, etc. vergeben.</strong><br>Wir pr&uuml;fen jede Anfrage einzeln und benachrichtigen Sie �ber unsere Entscheidung.";
}

// foreach ($_FILES["csr"]["error"] as $key => $error) {
// if ($error == UPLOAD_ERR_OK) {
// $tmp_name = $_FILES["csr"]["tmp_name"][$key];
// $name = $_FILES["csr"]["name"][$key];
// move_uploaded_file($tmp_name, "data/$name");
//}
//}

include 'footer.php';
?>