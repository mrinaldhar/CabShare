<?php
require_once('userhelper.php');
function iiit_username_clean($user) {
	$s = explode("@",$str);
	return $s[0];
}
function login($user, $password) {


	if(empty($user) || empty($password)) return false;
	$user = iiit_username_clean($user);
	$ldap_host = "ldap.iiit.ac.in";
	$ldap_port = "636";
 
	$ldap_dn = "OU=Users,DC=iiit,DC=ac,DC=in";
 
	// Need to make this ldaps :P
	$ldap = ldap_connect($ldap_host);

	// First we connect anonymously and search, then we connect again inside, with the right address and pass.
	if($bind = @ldap_bind($ldap)) {
		$filter = "(uid=".$user.")";
		// $attr = array("memberof");
		$result = ldap_search($ldap, $ldap_dn, $filter) or exit("Unable to search LDAP server");
		$entries = ldap_get_entries($ldap, $result);
		ldap_unbind($ldap);

		// Our initial search returned no entries, this means the username is wrong.
		if($entries["count"] == 0)
			return false;

		$ldap = ldap_connect($ldap_host);
		$ldaprdn = $entries[0]['dn'];
		$ldapbind = ldap_bind($ldap, $ldaprdn, $password);

		// This means that the password was wrong.	
		// So this is the auth step, along with the previous check.
		if($ldapbind) {
			$_SESSION['ldapstuff'] = $entries;
			return true;
		}	
		return false;
	} else {
		// THIS IS SERIOUSLY IMPOSSIBLE
		// invalid name or password
		return false;
	}
}

function logout() {
    session_start();
    session_unset();
    // Apparently, our predecessors thought this was a good idea, so I'll include it, for historical purposes.
    unset($_SESSION['ldapstuff']);
    return true;
}
?>
