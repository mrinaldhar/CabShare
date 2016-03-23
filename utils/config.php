<?php
$db_mysql_host='localhost';//Default MySQL db at localhost
$db_mysql_user='root';//db user name
$db_mysql_password='!@#OsDgMySqLSeRvEr!@#';//db password for auth
$db_mysql_name='cab_share';
$db_mysql_table_name='new_cab_share';
$link = mysqli_connect($db_mysql_host, $db_mysql_user, $db_mysql_password, $db_mysql_name) or die("OOPS");
if(!$link)
        die("Could not Connect.");
?>
