<?php
session_start();
require_once 'header.php';
echo "<div class=\"container\">";
?>
<?php


	session_destroy();
	echo "Logout erfolgreich";
	echo ("<p><a href=\"anmeldung.html\">zur Anmeldung</a></p>");
	echo "</div>";
?>