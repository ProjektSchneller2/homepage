<?php 
session_start();
require_once "dbconnect.php";

if($_SESSION['backend']==True){$admin="../";}
else{$admin="";}
echo "<!DOCTYPE html><html>";
echo "<head>";
	echo "<link href=\"".$admin."css/bootstrap.min.css\""."rel=\"stylesheet\">";
echo "</head><body>";
?>
