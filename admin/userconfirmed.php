<?php

include '../dbconnect.php';

$username = $_POST["username"];

//User in DB freischalten
$abfrage = "UPDATE login SET freischaltung = 1 WHERE username = '$username'";
$ergebnis = mysqli_query($db, $abfrage);

//Verzeichnis erstellen
mkdir ("../users/".$username);
chmod ("../users/".$username, 0775);

//Get email adress
$abfrage = "SELECT email FROM login WHERE username LIKE '$username' LIMIT 1";
$ergebnis = mysqli_query($db, $abfrage);
$row = mysqli_fetch_object ($ergebnis);
$empfaenger = $row->email;

//Mail content
$text = "Sehr geehrte Damen und Herren,\n \nIhr Account wurde freigeschaltet! \n\nSie können sich nun auf Ihrem Kundenprofil anmelden. \n\nMit freundlichen Grüsse Ihre Supercert GmbH";

//Mail versand
$absendername = "Supercert GmbH";
$absendermail = "projektca@gmx.de";
$betreff = "Freischaltung Ihres Accounts";
mail ( $empfaenger, $betreff, $text, "From: $absendername <$absendermail>" );

header('Location: admin.php');

?>