<?php

include '../dbconnect.php';


$username = $_POST["username"];
$abfrage = "UPDATE login SET freischaltung = 1 WHERE username = '$username'";
$ergebnis = mysqli_query($db, $abfrage);
echo "<a href=\"admin.php\">admin.php</a>";

?>