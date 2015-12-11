<?php
session_start();
require_once("ldap.php");
require_once("userhelper.php");

function addTripToDb($source, $destination, $date, $start_time, $end_time, $phone, $travellers, $comment) {
    
    if(!isLoggedIn()) {
        $response = array(
            "status" => 1,
            "error" => "Invalid session" );
        echo json_encode($response);
        return;
    }

    include "config.php";

    $query = "INSERT INTO new_cab_share (userid, source_addr, dest_addr, date, start_time, end_time, phone, travellers, comment) VALUES ('". getUid() . "', '" . $source . "', '" . $destination . "', '" . $date . "', '" . $start_time . "', '" . $end_time ."', '" . $phone . "', '" . $travellers . "', '" . $comment . "')";

	$success = mysqli_query($link, $query);
	if($success) {
			$tripId = mysqli_insert_id($link);
			$data = array(
				"message" => "Added new trip",
                "tripId" => $tripId );

			$response = array(
						"status" => 0,
						"data" => $data );

            echo json_encode($response);
    }
    else {
        $response = array(
            "status" => 1,
            "error" => "Unable to insert into DB" );
        echo json_encode($response);
    }
}

// We get all our parameters here and then use them to insert.
$source_addr = $_POST["source_addr"];
$dest_addr = $_POST["dest_addr"];
$date = $_POST["date"];
$start_time = $_POST["start_time"];
$end_time = $_POST["end_time"];
$phone = $_POST["phone_number"];
$travellers = $_POST["travellers"];
$comment = $_POST["comment"];

// Testing trip addition.
// addTripToDb("test", "test", "test", "test", "test", "test", "test", "test");
if ($source_addr!='' && $dest_addr!='' && $date!='' && $start_time!='' && $end_time!='' && $travellers!='') {
    addTripToDb($source_addr, $dest_addr, $date, $start_time, $end_time, $phone, $travellers, $comment);

}
else {
    $response = array(
            "status" => 1,
            "error" => "Cannot be empty." );
        echo json_encode($response);
}

?>
