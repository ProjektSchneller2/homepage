<?php

include '../dbconnect.php';


$username = $_POST["username"];
$abfrage = "UPDATE login SET freischaltung = 1 WHERE username = '$username'";
$ergebnis = mysqli_query($db, $abfrage);
mkdir ("../users/".$username, 0700);
header('Location: admin.php');

?>