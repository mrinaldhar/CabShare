<?php
require_once("./utils/ldap.php");
require_once("./utils/userhelper.php");
session_start();

$username = $_POST['username']; // TODO: Escape this properly. 
$password = $_POST['password'];
$response = login($username, $password);
if ($response == true) {
	$logfile = fopen("./logs/userlog.txt", "a");
 	$txt = $_SERVER['REMOTE_ADDR'] . " " . $username . "\n";
	fwrite($logfile, $txt);
	fclose($logfile);
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/home.php';                                 // the user is redirected to the home page if logged in
	header('Location: ' . $home_url); 
}
else if ($response == false) {
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php?err=invalid';                                 // the user is redirected to the home page if logged in
	header('Location: ' . $home_url); 
}
// Redirect.

?>
