<?php
if($login=="logout")
{
	session_destroy();
	echo "Logout erfolgreich";
}
?>