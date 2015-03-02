
<?php



if ($_FILES != Null){
	session_start();

	
	
/*echo "<pre>";
echo "FILES:<br />";
print_r ($_FILES );
echo "</pre>";
var_dump($_SESSION);
var_dump($_POST);*/
if ( $_FILES['csruploadfile']['name']  != Null )
{
	
	$zugelassenedateitypen = array("application/x-x509-ca-cert"|| "application/octet-stream"|| "application/pkcs10");

	if ( ! in_array( $_FILES['csruploadfile']['type'] , $zugelassenedateitypen ))
	{
		echo "<p>Dateitype ist NICHT zugelassen</p>";
	}
	else
	{
		move_uploaded_file (
		$_FILES['csruploadfile']['tmp_name'] ,
		$_SESSION['username'].'/'. $_FILES['csruploadfile']['name'] );

		echo "<p>Der Upload Ihrer CSR Datei war erfolgreich!</p>";
		echo "<p>Als nächstes werden wir Ihre Anfrage prüfen. Sollte Ihre Anfrage sowie die CSR Datei korrekt sein werden wir Ihr signiertes Zertifikat erstellen.</p>";
		echo "<p>Dieses, sowie den aktuellen Bearbeitungsstand können Sie Ihrem Kundenprofil entnehmen.<br>Zu diesem <a href=\"supercert.php\">gelangen Sie hier.</a></p>";
		//echo '<a href="'.$_SESSION['username'].'/'. $_FILES['csruploadfile']['name'] .'">';
		//echo $_SESSION['username']. $_FILES['csruploadfile']['name'];
		//echo '</a>';
		
	}
}


} 

else {
	//echo "<pre>";
	//echo "FILES:<br />";
	//print_r ($_FILES );
	//echo "</pre>";
	//var_dump($_SESSION);
	//var_dump($_POST);
echo	"<html>";
echo "<form name=\"uploadformular\" enctype=\"multipart/form-data\" action=\"csrupload.php\" method=\"post\">";
echo "Bitte laden Sie hier Ihre signierte CSR Datei hoch: ";
echo "<p><input type=\"file\" name=\"csruploadfile\" size=\"60\" maxlength=\"255\" >";
echo "<input type=\"Submit\" name=\"csrupload\" value=\"Datei hochladen\">";
echo "<p>";
echo "</form>";
echo "</html>";
}

//foreach ($_FILES["csr"]["error"] as $key => $error) {
	//if ($error == UPLOAD_ERR_OK) {
	//	$tmp_name = $_FILES["csr"]["tmp_name"][$key];
		//$name = $_FILES["csr"]["name"][$key];
		//move_uploaded_file($tmp_name, "data/$name");
//	}
//}
?>


