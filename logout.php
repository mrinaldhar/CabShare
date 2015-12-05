<?php
require_once("./utils/ldap.php");
logout();

$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';                                 // the user is redirected to the home page if logged in
header('Location: ' . $home_url); 

?>