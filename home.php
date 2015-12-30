<?php 
session_start();
require_once('./utils/ldap.php');
require_once('./utils/userhelper.php');
if (!isLoggedIn()) {
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';                                 // the user is redirected to the home page if logged in
	header('Location: ' . $home_url); 
}
?>
<!doctype html>
<html>
<head>
<title>Cab Share</title>
<link rel="stylesheet" href="./css/global.css" />
<style>
#page_title {
	margin-bottom: 20px;
}
.tab_select {
	text-align: center;
	cursor: pointer;
	padding: 7px;
	font-size: 0.8em;
	/*border: 1px dashed rgba(0,0,0,0.5);*/
}
.tab_select:hover {
	/*background-color: rgba(0,0,0,0.8);*/
	/*color: white;*/
}
.selected {
	background-color: rgba(0,0,0,0.65);
	color: white;

}
.container {
	width: 50%;
}
#page_title {
	font-size: 1.1em;
}
#subtitle {
	display: block;
	font-size: 0.7em;
	color: rgba(0,0,0,0.5);
}
.tab {
	margin-top: 10px;
	font-size: 0.8em;
	display: none;
}
.selected_data {
	display: block;
}
#map {
	height: 500px;
}
#sidebar {
	position: fixed;
	right: 0px;
	top: 100px;
	padding-top: 10px;
	padding-bottom: 10px;
	border-radius: 1px;
	display: block;
	max-width: 30%;
	width: 30%;
	background-color: rgba(255,255,255,0.8);
	box-shadow: 0 0 1px black;
	height: 70%;
	max-height: 70%;
}
#sidebar ul {
	list-style-type: none;
	padding: 0px;
	max-height: 90%;
	height: 90%;
	overflow: scroll;
}
#sidebar ul li {
	padding-top: 10px;
	padding-bottom: 10px;
	cursor: pointer;
	padding-left: 20px;
	padding-right: 20px;
	font-size: 0.9em;
}
#sidebar ul li:hover {
	background-color: rgba(0,0,0,0.1);


}
#sidebar p {
	/*font-size: 0.9em;*/
	padding-left: 20px;
	color: rgba(0,0,0,0.7);
}
#right-panel {
	width: 100%;
	display: block;
	text-align: center;
}
#container {
	padding-bottom: 50px;
}
#matched_results {
	list-style-type: none;
	padding: 0px;
}
#matched_results li {
	display: block;
	margin-bottom: 20px;
	padding: 10px;
	color: rgba(0,0,0,0.5);
}
#matched_results li span {
	display: block;
	width: 100%;
}
.matched_route {

	color: rgba(0,0,0,0.5);
}
.matched_name {
	color: rgba(0,0,0,1);
	font-size: 1.7em;

}
.matched_contact {
	color: rgba(0,0,0,1);
	margin-bottom: 5px;
	font-size: 0.9em;
}
</style>
</head>
<body>
<?php require_once('header.php'); ?>

<div class="container">
<div id="page_title">

</div>
<div id="page_subtitle">

</div>
<div id="page_content">
<table width="100%">
<tr>
	<td width="50%" id="tab_2" class="tab_select anim">
		<big>Route for this trip</big>
	</td>
</tr>
</table>
<div id="tab_2_data" class="tab anim">
<br />
<button class="btn anim">Download as PDF</button>		<!-- Use jsPDF to implement this. Should be simple. -md -->
<br /><br />
		<div id="map"></div>			
		<div id="right-panel"></div>
</div>
</div>

</div>


<div id="sidebar">
	<p>Your previous trips</p>
	<ul>
	</ul>
</div>
<?php require_once('footer.php'); ?>
</body>
<script src="./js/jquery.js"></script>
<script src="./js/jqueryui.js"></script>
<script src="./js/helper.js"></script>
<script src="./js/endpoints.js"></script>

<script>
var SOURCE_ADDR, DEST_ADDR;

$(document).ready(function() {
	getLatestTrip();
	getAllTrips();
	$('.tab_select').click(function() {
		var tab_id = this.id.split('_')[1];
		$('.tab_select').removeClass('selected');
		// $(this).addClass('selected');
		$('.tab').removeClass('selected_data');
		$('#tab_'+tab_id+"_data").addClass('selected_data');
		if (tab_id == "2") {
			google.maps.event.trigger(map, 'resize');
		}
		// $('.tab').fadeOut(1000, function() {
		// 	alert('hi');
		// });
	});
	$('#tab_2').click();
});

function getShortAddr(longAddr) {
	var address = longAddr.split(',');
	if (address.length>2) {
		return longAddr.split(',')[0] + ", " + longAddr.split(',')[1];
	}
	else {
		return longAddr.split(',')[0];
	}
}
function getLatestTrip() {
	var result = ajaxCall(API_dir+API_getLatestTrip, {}, "GET", false);
	console.log(result);
	
	if (result["status"] == 0) {
		result = result["data"];
	}
	else {
		alert("Some error happened. "); // Add this to notifications bar.
	}
	SOURCE_ADDR = result["source_addr"];
	DEST_ADDR = result["dest_addr"];
	TRIP_LOADED = 1;
	// matchTrip(result["id"]);
	$('#page_title').html("Trip from <span class='loc'>"+ getShortAddr(result["source_addr"]) + "</span> to <span class='loc'>" + getShortAddr(result["dest_addr"]) + "</span>");
	$('#page_title').append("<span id='subtitle'>"+result["travellers"]+" people travelling on "+result["date"]+" during "+result["start_time"]+" - " + result["end_time"] + "<br />\
		</span>");
}

function getAllTrips() {
	var results = ajaxCall(API_dir+API_getAllTrips, {}, "GET", false);
	if (results["status"] == 0) {
		results = results["data"];
		for (var x=0; x<results.length; x++) {
		var current = results[x];
		$('#sidebar ul').append("<li class='anim'>"+getShortAddr(current["source_addr"])+" to "+getShortAddr(current["dest_addr"]) +"\
			<span id='subtitle'>"+current["travellers"]+" people travelling on "+current["date"]+" during "+current["start_time"]+" - " + current["end_time"] + "</li>");

		}
	}
	else {
		alert("Some error happened. "); // Add this to notifications bar.
	}
	

}

// function matchTrip(trip_id) {
// 	var data = {
// 		tripId: trip_id
// 	}
// 	console.log(data);
// 	var results = ajaxCall(API_dir+API_matchTrip, data, "GET", false);
// 	console.log(results);
// 	if (results["status"] == 0) {
// 		results = results["data"];
// 		for (var x=0; x<results.length; x++) {
// 		var current = results[x];
// 		$('#matched_results').append('<li>\
// 		<span class="matched_name">'+current["userid"]+'</span>\
// 		<span class="matched_contact">'+current["userid"]+' &bull; '+current["phone"]+'</span>\
// 		<span class="matched_route">'+getShortAddr(current["source_addr"])+' to '+getShortAddr(current["dest_addr"])+' &bull; '+current["start_time"]+' - '+current["end_time"]+'</span>\
// 		<span class="matched_details">'+current["travellers"]+' travellers &bull; '+current["comment"] +'</span></li>');
		
// 		}
// 	}
// 	else {
// 		alert("Some error happened. "); // Add this to notifications bar.
// 	}

	
// }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUDzz-esKOYa1XHFFek8plrCKJw-OI_5I&libraries=places&callback=initMap"
        async defer></script>
<script>

function initMap() {
  var directionsDisplay = new google.maps.DirectionsRenderer;
  var directionsService = new google.maps.DirectionsService;
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 14,
    center: {lat: 17.4456, lng: 78.3497}
  });
  // google.maps.event.trigger(map, 'resize')
  directionsDisplay.setMap(map);
  directionsDisplay.setPanel(document.getElementById('right-panel'));



  // directionsDisplay.setPanel(document.getElementById('right-panel'));
    calculateAndDisplayRoute(directionsService, directionsDisplay);
}

function calculateAndDisplayRoute(directionsService, directionsDisplay) {
  var start = SOURCE_ADDR;
  var end = DEST_ADDR;
  directionsService.route({
    origin: start,
    destination: end,
    travelMode: google.maps.TravelMode.DRIVING
  }, function(response, status) {
    if (status === google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    } else {
      console.log('Directions request failed due to ' + status);
    }
  });
}


</script>
</html>
