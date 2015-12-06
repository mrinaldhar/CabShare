<?php
$db_mysql_host='localhost';//Default MySQL db at localhost
$db_mysql_user='cab';//db user name
$db_mysql_password='callTHEcabbie';//db password for auth
$db_mysql_name='cab';
$link = mysqli_connect($db_mysql_host, $db_mysql_user, $db_mysql_password, $db_mysql_name) or die("OOPS");
if(!$link)
        die("Could not Connect.");
?>
