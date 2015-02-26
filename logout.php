<?php
session_start();
?>
<?php


	session_destroy();
	echo "Logout erfolgreich";
	echo ("<p><a href=\"anmeldung.html\">zur Anmeldung</a></p>");

?>