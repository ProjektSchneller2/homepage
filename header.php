<?php 
session_start();

if($_SESSION['backend']==True){$admin="../";}
else{$admin="";}
echo "<head>";
	echo "<link href=\"".$admin."css/bootstrap.min.css\""."rel=\"stylesheet\">";
echo "</head>";
		
?>