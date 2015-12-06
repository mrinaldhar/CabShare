<?php

function addTripToDb($source, $destination, $date, $time, $phone, $travellers, $comment) {
    $query = "INSERT INTO " . " new_cab_share " . " (source_addr, dest_addr, date, time, phone, travellers, comment) VALUES ('" . $source . "', '" . $destination . "', '" . $date . "', '" . $time . "', '" . $phone . "', '" . $travellers . "', '" . $travellers . "')";
		echo $query . "\n";
		include "config.php";
		$success = mysqli_query($link, $query);
		if($success) {
				$tripId = mysqli_insert_id($link);
				$data = array(
						"message" => "Added new trip",
						"tripId" => $tripId
				);
				$response = array(
						array(
							"status" => "0",
							"data" => $data
						)
				);
				echo json_encode($response);
    }
    else {
        echo "problem";
    }
    //mysql_close($link);
}

// We get all our parameters here and then use them to insert.
$source_addr = $_POST["source_addr"];
$dest_addr = $_POST["dest_addr"];
$date = $_POST["date"];
$time = $_POST["time"];
$phone = $_POST["phone"];
$travellers = $_POST["travellers"];
$comment = $_POST["comment"];

// Testing trip addition.
// addTripToDb("test", "test", "test", "test", "test", "test", "test", "test");

addTripToDb($source_addr, $dest_addr, $date, $time, $phone, $travellers, $comment);

?>
