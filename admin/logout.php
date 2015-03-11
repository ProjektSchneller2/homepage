<?php
session_start();
?>
<?php


	session_destroy();
	echo "Logout erfolgreich";
	echo ("<p><a href=\"anmeldung.html\">zur Admin-Anmeldung</a></p>");
	echo ("<p><a href=\"../anmeldung.html\">zur User-Anmeldung</a></p>");

?>