<?php
session_start();
require_once("ldap.php");
require_once("userhelper.php");

function getPublicTrips() { 
    if(!isLoggedIn()) {
        $response = array(
            "status" => 1,
            "error" => "Invalid session" );
        echo json_encode($response);
        return;
    }

    include "config.php";
    $query = "SELECT * FROM " . $db_mysql_table_name . " WHERE private='No' AND STR_TO_DATE(date,'%m/%d/%Y') >= DATE_FORMAT(NOW(),'%Y-%m-%d') ORDER BY id DESC";

	$success = mysqli_query($link, $query);
	if($success) {
        $rows = array();
        while ($row = mysqli_fetch_assoc($success))
            $rows[] = $row;
        $response = array(
            "status" => 0,
            "data" => $rows
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

getPublicTrips();
?>
