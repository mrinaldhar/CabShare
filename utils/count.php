<?php
session_start();
require_once("ldap.php");
require_once("userhelper.php");
require_once("triphelper.php");


function getAllTrips() { 

    include "config.php";
    $query = "SELECT * FROM " . $db_mysql_table_name . " ORDER BY id DESC";

	$success = mysqli_query($link, $query);
	if($success) {
        $countPeople = 0;
        $countTrips = 0;
        while ($row = mysqli_fetch_assoc($success)) {
            $countTrips += 1;
            $countPeople += intval(getTravellers($row));
        }
       $response = array(
            "status" => 0,
            "data" => array(
                "people" => $countPeople,
                "trips" => $countTrips
            )
        );
        echo json_encode($response);
    }
    else {
        $response = array(
            "status" => 1,
            "error" => "Unable to run select in DB" );
        echo json_encode($response);
    }
}

getAllTrips();
?>
