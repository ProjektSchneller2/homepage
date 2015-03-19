<?php 
session_start();
require_once '../header.php';
echo "<div class=\"container\">";
$_SESSION['backend']=True;

if(!isset($_SESSION["admin"]))
{
	echo "Bitte erst <a href=\"anmeldung.html\">einloggen</a>";
	exit;
}

$cancelmailcontent="Sehr geehrte Damen und Herren,\n \nLeider m�ssen wir Ihre CSR ablehnen, der Grund lautet wie folgt:\n\n";
$sign="\n\nMit freundlichen Gr�sse Ihre Supercert GmbH";

//datenbankabfrage - kunde fehlt noch
if($_POST['cancelmail']!==Null){
	if($_POST['cancel']!==""){
	$text=$cancelmailcontent.$_POST['cancel'].$sign;
	//var_dump($cancel);
	//echo $cancel;
	//CSR aus DB L�schen
	include '../dbconnect.php';
	
	$csr_pfad=$_SESSION['csr_pfad'];
	 $eintrag="DELETE FROM cert WHERE csr_pfad='$csr_pfad'";
	 $eintragen= mysqli_query($db, $eintrag);
	 var_dump($eintrag);
	
	$username =$_SESSION["user"];
	
	$abfrage = "SELECT email FROM login WHERE username LIKE '$username' LIMIT 1";
	$ergebnis = mysqli_query($db, $abfrage);
	$row = mysqli_fetch_object ($ergebnis);
	$email = $row->email;
	//var_dump($email);
	//var_dump($abfrage);
	
	
	
	//Mail versand
	$empfaenger =$email;//"projektca@gmx.de";
	$absendername = "Supercert GmbH";
	$absendermail = "projektca@gmx.de";
	$betreff = "Ablehnung Ihrer Zertifikats-Request";

	// Auf Nennung des Users wird aus Sicherheitsgründen verzichtet, da die Information direkt im Adminpanel bereitsteht

	mail ( $empfaenger, $betreff, $text, "From: $absendername <$absendermail>" );
	header("Location:admin.php");
	exit;
	}
	else{
		$notice=True;
	}
			
		}



	if ($notice==True){
		echo "<h3>Sie haben das Textfeld nicht ausgef�llt, die Mail konnte nicht versendet werden";
	}
	
	
	$_SESSION['csr_pfad']=$_POST['csr_pfad'];
	
	echo "<h3>Bitte geben Sie einen Grund ein, warum die vorliegende CSR-Datei fehlerhaft ist:</h3>	";
	
 


echo "<p>Die Antwort beginnt mit:</p>".$cancelmailcontent;


echo "<form action=\"canceled.php\" method=\"POST\">";
		echo "<p>";
		echo"<textarea name=\"cancel\"></textarea>";
		echo "</p>";
		echo "<input type=\"submit\" name=\"cancelmail\" value=\"Benachrichtigung versenden!\">";
echo "</form>";


echo $sign;

echo "</div>";
	?>

