<?php
if($login=="logout")
{
	$login = 1;
	session_destroy();
	echo "Logout erfolgreich";
}
?>