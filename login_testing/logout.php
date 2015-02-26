<?php
session_start();
?>

<?php 
session_destroy();
echo ("<a href=\"geheim.php\">Geschützer Bereich</a>");
?>