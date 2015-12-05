<?php
require_once("ldap.php");
require_once("userhelper.php");
login("test.13", "abcde");

print_r($_SESSION['ldapstuff'][0]);
print "<br>";
print getUid();
print "<br>";
print "\n";

if(isAdmin())
  print "#t\n";
else
  print "#f\n";
print "<br>";
print getMailId()."\n";
print "<br>";
print getName()."\n";
print "<br>";
?>
