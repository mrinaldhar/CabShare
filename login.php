<?php
require_once("./utils/ldap.php");
require_once("./utils/userhelper.php");

$username = $_POST['username']; // TODO: Escape this properly. 
$password = $_POST['password'];
$response = login($username, $password);
if ($response == true) {
	echo "True";
}
else if ($response == false) {
	echo "False";
}

// Redirect.

?>