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
echo "</head><body>";
?>
