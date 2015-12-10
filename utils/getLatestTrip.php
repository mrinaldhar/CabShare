<?php
session_start();
require_once("ldap.php");
require_once("userhelper.php");

function getLatestTrip() { 
    if(!isLoggedIn()) {
        $response = array(
            "status" => 1,
            "error" => "Invalid session" );
        echo json_encode($response);
        return;
    }

    include "config.php";
    $query = "SELECT * FROM " . $db_mysql_table_name . " WHERE userid='".getUid()."' ORDER BY -id LIMIT 1 ";

	$success = mysqli_query($link, $query);
	if($success) {
            if (mysqli_num_rows($success) == 1) {
                $row = mysqli_fetch_assoc($success);
                $response = array(
                    "status" => 0,
                    "data" => $row
                );
            }
            echo json_encode($response);
    }
    else {
        $response = array(
            "status" => 1,
            "error" => "Unable to run select in DB" );
        echo json_encode($response);
    }
}

getLatestTrip();
?>
