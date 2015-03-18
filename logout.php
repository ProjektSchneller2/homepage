<?php
require_once 'header.php';
echo "<div class=\"container\">";
session_destroy();
echo "<p class=\"bg-success\">Logout erfolgreich";
echo "<a href=\"anmeldung.html\">zur Anmeldung</a></p>";
echo "</div>";
?>
