<?php
//Verbindungsdaten zur Datenbank zum inkludieren

//Datenbankverbindungs-Variable
$db = mysqli_connect("localhost", "root", "", "dhbw_ca_test");
//Funktionstest
if(!$db)
{
	exit("Verbindungsfehler: ".mysqli_connect_error());
}


?>