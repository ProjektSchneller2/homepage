<?php 
if (! isset($_SESSION)){
	session_start();
}
require_once "dbconnect.php";

if(isset($_SESSION['backend']) && $_SESSION['backend']==True){$admin="../";}
else{$admin="";}
echo "<!DOCTYPE html><html>";
echo "<head>";
	echo "<link href=\"".$admin."css/bootstrap.min.css\""."rel=\"stylesheet\">";
echo "</head><body><div style=\"height: 100px; background-color:#5bc0de; text-align:center; \"><div class=\"container\"><font color=\"#FFFFFF\"><h1><strong><br>SUPERCERT GmbH</stromg></h1></font></div></div>";
?>
