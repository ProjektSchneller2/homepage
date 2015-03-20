<?php

include '../dbconnect.php';

$username = $_POST["username"];

//Get email adress
$abfrage = "SELECT email FROM login WHERE username LIKE '$username' LIMIT 1";
$ergebnis = mysqli_query($db, $abfrage);
$row = mysqli_fetch_object ($ergebnis);
$empfaenger = $row->email;

//Mail content
$text = "Sehr geehrte Damen und Herren,\n \nIhr Account wurde NICHT freigeschaltet! \n\nBei Fragen wenden Sie sich bitte an projektca@gmx.de . \n\nMit freundlichen Grüsse Ihre Supercert GmbH";

//Mail versand
$absendername = "Supercert GmbH";
$absendermail = "projektca@gmx.de";
$betreff = "Ablehnung Ihres Accounts";
mail ( $empfaenger, $betreff, $text, "From: $absendername <$absendermail>" );

//User in DB entfernen
$abfrage = "DELETE FROM login WHERE username='$username'";
$ergebnis = mysqli_query($db, $abfrage);

header('Location: admin.php');

?>