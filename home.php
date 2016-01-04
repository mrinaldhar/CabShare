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
<link rel="shortcut icon" href="./favicon.png" type="image/x-icon">
<link rel="icon" href="./favicon.png" type="image/x-icon">
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
	text-align: center;
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
	list-style-type: none; width: 100%; text-align: center; padding: 0px;
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
.adp-directions {
	width: 100%;
	max-width: 100%;
}
</style>
</head>
<body>
<?php require_once('header.php'); ?>

<div class="container" id="toPrint">
<div id="page_title">

</div>
<div id="page_subtitle">

</div>
<div id="page_content">
<div id="tab_2_data" class="tab anim selected_data">
<button class="btn anim" id="savepdfbtn">Print this page.</button>		<!-- Use jsPDF to implement this. Should be simple. -md -->
<br /><br />
		<div id="map"></div>			
		<div id="right-panel"></div>
</div>
</div>

</div>


<div id="sidebar">
	<p>Your CabShare trips</p>
	<ul>
	</ul>
</div>
<?php require_once('footer.php'); ?>
</body>
<script src="./js/jquery.js"></script>
<script src="./js/jqueryui.js"></script>
<script src="./js/helper.js"></script>
<script src="./js/endpoints.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUDzz-esKOYa1XHFFek8plrCKJw-OI_5I&libraries=places&callback=initMap"
        async defer></script>
<script>
var SOURCE_ADDR, DEST_ADDR;

$(document).ready(function() {
	var tripID = getUrlVars()["id"];
	if (tripID) {
		getTrip(tripID);
	}
	else {
		getTrip(-1);		
	}
	getAllTrips();
	// google.maps.event.trigger(map, 'resize');
	$('#savepdfbtn').click(function() {
		// savePDF();
		window.print();
	});
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
function getTrip(tripID) {
	if (tripID != -1) {
		var data = {
			trip_id: tripID
		}
		var result = ajaxCall(API_dir+API_getTrip, data, "GET", false);
	}
	else {
		var data = {};
		var result = ajaxCall(API_dir+API_getLatestTrip, data, "GET", false);
	}
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
	$('#page_title').append("<span id='subtitle'>"+result["travellers"]+" people travelling on "+result["date"]+" during "+getAMPM(result["start_time"])+" - " + getAMPM(result["end_time"]) + "<br />\
		</span>");
}

function getAllTrips() {
	var results = ajaxCall(API_dir+API_getAllTrips, {}, "GET", false);
	if (results["status"] == 0) {
		results = results["data"];
		for (var x=0; x<results.length; x++) {
		var current = results[x];
		$('#sidebar ul').append("<li onclick='tripGOTO("+current["id"]+")' class='anim'>"+getShortAddr(current["source_addr"])+" to "+getShortAddr(current["dest_addr"]) +"\
			<span id='subtitle'>"+current["travellers"]+" people travelling on "+current["date"]+" during "+getAMPM(current["start_time"])+" - " + getAMPM(current["end_time"]) + "</li>");

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

<script>

function initMap() {
  var directionsDisplay = new google.maps.DirectionsRenderer;
  var directionsService = new google.maps.DirectionsService;
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 14,
    center: {lat: 17.4456, lng: 78.3497}
  });
  google.maps.event.trigger(map, 'resize')
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
<script src="./js/jspdf.min.js"></script>
<script src="./js/jspdf.plugin.from_html.js"></script>
<script src="./js/jspdf.plugin.split_text_to_size.js"></script>
<script src="./js/jspdf.plugin.standard_fonts_metrics.js"></script>
<script>
function savePDF() {
var doc = new jsPDF();          
var elementHandler = {
};
var source = window.document.getElementById("toPrint");
doc.fromHTML(
    source,
    15,
    15,
    {
      'width': 180,'elementHandlers': elementHandler
    });

doc.output("dataurlnewwindow");
}
</script>
</html>
