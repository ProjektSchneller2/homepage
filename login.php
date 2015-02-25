<?php
//Einlogdaten + PWHash



if (isset($_POST['username'])) {
	$username = $_POST['username'];
} else {
	$error = TRUE;
}
if (isset($_POST['password'])) {
	$pw = hash("sha512", $_POST['password']);
} else {
	$error = TRUE;
}

$account = NULL;
if ($db->get_admin($username) != NULL) {
	$account = reset($db->get_admin($username));
}

if ($account['password'] == $pw) {
	$_SESSION['accountaccept'] = TRUE;
} else {
	$_SESSION['accountaccept'] = FALSE;
}

header('Location: supercert.php');

?>