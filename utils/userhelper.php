<?php
function isAdmin() {
    // Just add yourself here, if you are worthy, et vous recevrez le pouvoir!
    $admin = array("amogh.pradeep",
        "mrinal.dhar"); 
    return in_array(getUid(), $admin);
}
function getUid() {
    // Let's take uid to be email for our portal.
	return $_SESSION['ldapstuff'][0]['mail'][0];
}
function getMailId() {
	return $_SESSION['ldapstuff'][0]['mail'][0];
}
function getName() {
	return $_SESSION['ldapstuff'][0]['givenname'][0];
}
function isLoggedIn() {
	return isset($_SESSION['ldapstuff']);
}
?>
