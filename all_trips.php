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
	text-align: center;
	list-style-type: none;
	padding: 0px;
}
#matched_results li {
	display: block; color: rgba(0,0,0,0.5); border-bottom-width: 1px; border-bottom-color: #4a4a4a; border-bottom-style: dashed; padding: 20px;
}
.matched_route {
	display: block; width: 100%; font-size: 0.9em; color: rgba(0,0,0,0.5);
}
.matched_name {
display: block; width: 100%; color: rgba(0,0,0,1); font-size: 1.3em;

}
.matched_contact {
	display: block; width: 100%; color: rgba(0,0,0,1); margin-bottom: 5px; font-size: 0.9em;
}
.matched_details {
	display: block; width: 100%; font-size: 0.9em;
}
.adp-directions {
	width: 100%;
	max-width: 100%;
}
#page_subtitle {
	font-size: 0.35em;
	margin-top: 20px;
} 
a {
	color: black;
}
</style>
</head>
<body>
<?php require_once('header.php'); ?>

<div class="container" id="toPrint">
<div id="page_title">
All upcoming public trips

<div id="page_subtitle">
This page shows you the trips other people have added on CabShare, with privacy set to PUBLIC.<br />If you see a trip that you would like to join, please feel free to contact the person listed.
</div>
</div>
<div id="page_content">
	<ul id="matched_results">


	</ul>
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
<script>

$(document).ready(function() {
	getAllTrips();
	getPublicTrips();
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

function getAllTrips() {
	var results = ajaxCall(API_dir+API_getAllTrips, {}, "GET", false);
	if (results["status"] == 0) {
		results = results["data"];
		for (var x=0; x<results.length; x++) {
		var current = results[x];
		$('#sidebar ul').append("<li class='anim' onclick='tripGOTO("+current["id"]+")'>"+getShortAddr(current["source_addr"])+" to "+getShortAddr(current["dest_addr"]) +"\
			<span id='subtitle'>"+current["travellers"]+" people travelling on "+current["date"]+" during "+getAMPM(current["start_time"])+" - " + getAMPM(current["end_time"]) + "</li>");

		}
	}
	else {
		alert("Some error happened. "); // Add this to notifications bar.
	}
	

}

function getPublicTrips() {
	var results = ajaxCall(API_dir+API_getPublicTrips, {}, "GET", false);
	console.log(results);
	if (results["status"] == 0) {
		results = results["data"];
		for (var x=0; x<results.length; x++) {
		var current = results[x];
		$('#matched_results').append('<li>\
			<span class="matched_name">'+current["userid"]+'</span>\
			<span class="matched_contact"><a href="mailto:'+current["userid"]+'">'+current["userid"]+'</a> &bull; '+current["phone"]+'</span>\
			<span class="matched_route">'+getShortAddr(current["source_addr"])+' to '+getShortAddr(current["dest_addr"])+' &bull; '+ getAMPM(current["start_time"])+' - '+ getAMPM(current["end_time"])+'</span>\
			<span class="matched_details">'+current["travellers"]+' travellers &bull; '+current["comment"] +'</span></li>');
		
		}
	}
	else {
		alert("Some error happened. "); // Add this to notifications bar.
	}

	
}
</script>

</html>
