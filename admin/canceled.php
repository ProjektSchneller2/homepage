<?php 
session_start();
$_SESSION['backend']=True;
if(!isset($_SESSION["admin"]))
{
	echo "Bitte erst <a href=\"anmeldung.html\">einloggen</a>";
	exit;
}

//datenbankabfrage - kunde fehlt noch
if($_POST['cancelmail']!==Null){
	if($_POST['cancel']!==""){
	$text=$cancelmailcontent.$_POST['cancel'].$sign;
	//var_dump($cancel);
	//echo $cancel;
	$empfaenger = "projektca@gmx.de";
	$absendername = "Supercert GmbH";
	$absendermail = "projektca@gmx.de";
	$betreff = "Ablehnung Ihrer Zertifikats-Request";

	// Auf Nennung des Users wird aus SicherheitsgrÃ¼nden verzichtet, da die Information direkt im Adminpanel bereitsteht

	mail ( $empfaenger, $betreff, $text, "From: $absendername <$absendermail>" );
	//CSR aus DB Löschen
	/*include '../dbconnect.php';
	$csr_pfad=$_POST['csr_pfad'];
	$eintrag="DELETE FROM cert WHERE csr_pfad='$csr_pfad'";
	$eintragen= mysqli_query($db, $eintrag);*/
	header("Location:admin.php");
	exit;
	}
	else{
		$notice=True;
	}
			
		}



	if ($notice==True){
		echo "<h3>Sie haben das Textfeld nicht ausgefüllt, die Mail konnte nicht versendet werden";
	}
	echo "<h3>Bitte geben Sie einen Grund ein, warum die vorliegende CSR-Datei fehlerhaft ist:</h3>	";
	
 
$cancelmailcontent="<p>Sehr geehrte Damen und Herren,</p>Leider müssen wir Ihre CSR ablehnen, der Grund lautet wie folgt:<p>&nbsp;</p>";

echo "<p>Die Antwort beginnt mit:</p>".$cancelmailcontent;


echo "<form action=\"canceled.php\" method=\"POST\">";
		echo "<p>";
		echo"<textarea name=\"cancel\"></textarea>";
		echo "</p>";
		echo "<input type=\"submit\" name=\"cancelmail\" value=\"Benachrichtigung versenden!\">";
echo "</form>";

$sign="Mit freundlichen Grüsse Ihre Supercert GmbH";
echo $sign;


	?>

