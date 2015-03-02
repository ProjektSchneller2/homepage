<html>
<form name="uploadformular" enctype="multipart/form-data" action="csrupload.php" method="post" >
Bitte laden Sie hier Ihre signierte CSR Datei hoch: 
<p><input type="file" name="csruploadfile" size="60" maxlength="255" >
<input type="Submit" name="csrupload" value="Datei hochladen">
<p>
</form>
</html>
<?php


if ($_FILES != Null){
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

var_dump($_POST);
if ( $_FILES['csruploadfile']['name']  != Null )
{
	//if($dateityp == "application/x-x509-ca-cert" 
	//|| $dateityp == "application/octet-stream" 
	//|| $dateityp == "application/pkcs10")
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

		echo "<p>Hochladen war erfolgreich: ";
		echo '<a href="'.$_SESSION['username'].'/'. $_FILES['csruploadfile']['name'] .'">';
		echo $_SESSION['username']. $_FILES['csruploadfile']['name'];
		echo '</a>';
	}
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


