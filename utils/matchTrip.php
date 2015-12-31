<?php
session_start();
error_reporting();
require_once("ldap.php");
require_once("userhelper.php");
require_once("triphelper.php");
require_once("keys.php");
require_once("email.php");

function getDistance($address1, $address2) {
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $address1 . "&destinations=" . $address2 ."&mode=driving&key=" . $mapsAPIKey;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['value'];
    return $dist;
}

function timeCoincides($t1, $t2) {
    $s1 = intval(getStartTime($t1));
    $e1 = intval(getEndTime($t1));
    $s2 = intval(getStartTime($t2));
    $e2 = intval(getEndTime($t2));
    return (($s1 <= $e2) and ($e1 >= $s2));
}
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

    $query = "SELECT * FROM " . $db_mysql_table_name . 
        " WHERE state=0" .
        " AND userid!='" . getUid() . "'" .
        " AND date='" . getTripDate($matchTrip) . "'"; // Ensures rides are on the same day.

	$success = mysqli_query($link, $query);
	if($success) {
        $rows = array();
        while ($row = mysqli_fetch_assoc($success)) {
            if(timeCoincides($row, $matchTrip)) { // Ensures that they start at around the same time.
                if(getDistance(getDestAddr($row), getDestAddr($matchTrip)) <= 3000) {
                    if(getDistance(getSourceAddr($row), getSourceAddr($matchTrip)) <= 3000) {
                       $rows[] = $row;
                    }
                }
            }
        }
        $rows = json_encode($rows);
        send_email(getMailId(), $rows);
    }
    else {
        $response = array(
            "status" => 1,
            "error" => "Unable to run query in DB" );
        echo json_encode($response);
    }
}
?>
