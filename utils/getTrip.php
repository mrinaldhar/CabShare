<?php

require_once("ldap.php");
require_once("userhelper.php");

function getTrip() { 
    if(!isLoggedIn()) {
        $response = array(
            "status" => "1",
            "error" => "Invalid session" );
        echo json_encode($response);
        return;
    }

    include "config.php";
    $query = "SELECT * from " . $db_mysql_table_name . "ORDER_BY id DESC LIMIT 1 WHERE uid=" . getUid();

	$success = mysqli_query($link, $query);
	if($success) {
			$tripId = mysqli_insert_id($link);

            echo json_encode($response);
    }
    else {
        $response = array(
            "status" => "1",
            "error" => "Unable to run select in DB" );
        echo json_encode($response);
    }
}

getTrip();
?>
