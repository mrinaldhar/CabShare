<?php
function isAdmin() {
    // Just add yourself here, if you are worthy, et vous recevrez le pouvoir!
    $admin = array("amogh.pradeep",
        "mrinal.dhar"); 
    return in_array(getUid(), $admin);
}
function getUid() {
		return $_SESSION['ldapstuff'][0]['uid'][0];
}
function getMailId() {
		return $_SESSION['ldapstuff'][0]['mail'][0];
}
function getName() {
		return $_SESSION['ldapstuff'][0]['givenname'][0];
}
?>
