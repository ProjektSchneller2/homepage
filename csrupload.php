<form name="uploadformular" enctype="multipart/form-data" action="csrupload.php" method="post" >
Bitte laden Sie hier Ihre signierte CSR Datei hoch: <input type="file" name="uploaddatei" size="60" maxlength="255" >
<input type="Submit" name="csrupload" value="Datei hochladen">
</form>

<?php
session_start();


if(!isset($_SESSION["username"]))
{
	echo "Bitte erst <a href=\"anmeldung.html\">einloggen</a>";
	exit;
}
echo "<pre>";
echo "FILES:<br />";
print_r ($_FILES );
echo "</pre>";
if ( $_FILES['uploaddatei']['name']  != Null )
{
	// Datei wurde durch HTML-Formular hochgeladen
	// und kann nun weiterverarbeitet werden

	// Kontrolle, ob Dateityp zulässig ist
	$zugelassenedateitypen = array("application/cert");

	if ( ! in_array( $_FILES['uploaddatei']['type'] , $zugelassenedateitypen ))
	{
		echo "<p>Dateitype ist NICHT zugelassen</p>";
	}
	else
	{
		move_uploaded_file (
		$_FILES['uploaddatei']['tmp_name'] ,
		'hochgeladenes/'. $_FILES['uploaddatei']['name'] );

		echo "<p>Hochladen war erfolgreich: ";
		echo '<a href="hochgeladenes/'. $_FILES['uploaddatei']['name'] .'">';
		echo 'hochgeladenes/'. $_FILES['uploaddatei']['name'];
		echo '</a>';
	}
}

 

//foreach ($_FILES["csr"]["error"] as $key => $error) {
	//if ($error == UPLOAD_ERR_OK) {
	//	$tmp_name = $_FILES["csr"]["tmp_name"][$key];
		//$name = $_FILES["csr"]["name"][$key];
		//move_uploaded_file($tmp_name, "data/$name");
//	}
//}
?>


