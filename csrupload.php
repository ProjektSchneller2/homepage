
<?php
$timestamp = time ();
$datum = date ( "dmY", $timestamp );
$uhrzeit = date ( "Hi", $timestamp );
$ftp_pfad = 'ca/';

if ($_FILES != Null) {
	session_start ();
	
	/*
	 * echo "<pre>";
	 * echo "FILES:<br />";
	 * print_r ($_FILES );
	 * echo "</pre>";
	 * var_dump($_SESSION);
	 * var_dump($_POST);
	 */
	var_dump ( $_SESSION );
	if ($_FILES ['csruploadfile'] ['name'] != Null) {
		
		$zugelassenedateitypen = array (
				"application/x-x509-ca-cert" || "application/octet-stream" || "application/pkcs10" 
		);
		
		if (! in_array ( $_FILES ['csruploadfile'] ['type'], $zugelassenedateitypen )) {
			echo "<p>Dateitype ist NICHT zugelassen</p>";
		} else {
			
			// Prueft ob das Hauptverzeichnis bereits existiert,
			
			if (is_dir ( $ftp_pfad . '/' . $_SESSION ['certtype'] )) {
				
				if (is_dir ( $ftp_pfad . '/' . $_SESSION ['certtype'] . '/transfer' )) {
				} 

				else {
					
					if (mkdir ( $ftp_pfad . '/docs/transfer', 0700 )) 
					{
						
				
					} 

			else 
					{
						mkdir($ftp_pfad.'/'.$_SESSION ['certtype']);				
					}
				}
			} 

			else 

			{
				
				// Erstellt das Verzeichnis
				
				if (mkdir ( $ftp_pfad . '/docs', 0700 )) 

				{
					
					echo 'Verzeichnis docs erstellt!';
				} 

				else 

				{
					
					echo 'Error: kann das Verzeichnis docs nicht erstellen! ';
					
					return false; // Funktion verlassen
				}
				
				if (mkdir ( $ftp_pfad . '/docs/transfer', 0700 )) {
					echo 'Verzeichnis transfer erstellt!';
				} 

				else 

				{
					echo 'Error: kann das Verzeichnis transfer nicht erstellen! ';
				}
			}
			move_uploaded_file ( $_FILES ['csruploadfile'] ['tmp_name'], $_SESSION ['username'] . '/' . $_SESSION ['certtype'] . '/' . $datum . '/' . $uhrzeit . '/' . $_FILES ['csruploadfile'] ['name'] );
			// Mail Adresse muss noch im Webserver in der init hinterlegt werden
			$empfaenger = "dhbwprojektitsec@gmail.com";
			$absendername = "CSR Anfrage Formular";
			$absendermail = "dhbwprojektitsec@gmail.com";
			$betreff = "Eine neue Zertifikatsanfrage ist eingetroffen";
			// Auf Nennung des Users wird aus Sicherheitsgründen verzichtet, da die Information direkt im Adminpanel bereitsteht
			$text = "Eine neue CSR wurde hochgeladen.";
			mail ( $empfaenger, $betreff, $text, "From: $absendername <$absendermail>" );
			
			echo "<p>Der Upload Ihrer CSR Datei war erfolgreich!</p>";
			echo "<p>Als nächstes werden wir Ihre Anfrage prüfen. Sollte Ihre Anfrage sowie die CSR Datei korrekt sein werden wir Ihr signiertes Zertifikat erstellen.</p>";
			echo "<p>Dieses, sowie den aktuellen Bearbeitungsstand können Sie Ihrem Kundenprofil entnehmen.<br>Zu diesem <a href=\"supercert.php\">gelangen Sie hier.</a></p>";
			// echo '<a href="'.$_SESSION['username'].'/'. $_FILES['csruploadfile']['name'] .'">';
			// echo $_SESSION['username']. $_FILES['csruploadfile']['name'];
			// echo '</a>';
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
	echo "<form name=\"uploadformular\" enctype=\"multipart/form-data\" action=\"csrupload.php\" method=\"post\">";
	echo "Bitte laden Sie hier Ihre signierte CSR Datei hoch: ";
	echo "<p><input type=\"file\" name=\"csruploadfile\" size=\"60\" maxlength=\"255\" >";
	echo "<input type=\"Submit\" name=\"csrupload\" value=\"Datei hochladen\">";
	echo "<p>";
	echo "</form>";
	echo "</html>";
}

// foreach ($_FILES["csr"]["error"] as $key => $error) {
// if ($error == UPLOAD_ERR_OK) {
// $tmp_name = $_FILES["csr"]["tmp_name"][$key];
// $name = $_FILES["csr"]["name"][$key];
// move_uploaded_file($tmp_name, "data/$name");
// }
// }
?>


