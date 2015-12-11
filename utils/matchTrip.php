<?php
session_start();
require_once("ldap.php");
require_once("userhelper.php");

function matchTrip($tripId) { 
    if(!isLoggedIn()) {
        $response = array(
            "status" => 1,
            "error" => "Invalid session" );
        echo json_encode($response);
        return;
    }

    include "config.php";
    $myTripQuery = "SELECT * FROM " . $db_mysql_table_name . " WHERE id='" . $tripId . "'";
    $tripQuerySuccess = mysqli_query($link, $myTripQuery);
    if($tripQuerySuccess) {
        if (mysqli_num_rows($tripQuerySuccess) == 1)
            $matchTrip = mysqli_fetch_assoc($tripQuerySuccess);
        else {
            $response = array(
                "status" => 1,
                "error" => "Duplicate id in DB ");
            echo json_encode($response);
        }
    }
    else {
        $response = array(
            "status" => 1,
            "error" => "Unable to run query in DB" );
        echo json_encode($response);
    }

    $query = "SELECT * FROM " . $db_mysql_table_name . " WHERE state=0 AND userid!='" . getUid() . "'";

	$success = mysqli_query($link, $query);
	if($success) {
        $rows = array();
        while ($row = mysqli_fetch_assoc($success)) {

            $rows[] = $row;
        }
    }
    else {
        $response = array(
            "status" => 1,
            "error" => "Unable to run query in DB" );
        echo json_encode($response);
    }
}

getAllTrips();
?>
