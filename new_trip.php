<?php 
session_start();
require_once('./utils/ldap.php');
require_once('./utils/userhelper.php');
if (!isLoggedIn()) {
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';                                 // the user is redirected to the home page if logged in
	// header('Location: ' . $home_url); 
}
?>
<!doctype html>
<html>
<head>
<title>Cab Share</title>
<link rel="stylesheet" href="./css/global.css" />
<link rel="stylesheet" href="./css/datepicker.css" />
<link rel="stylesheet" href="./css/datetheme.css" />
<link rel="stylesheet" href="./css/jqueryui.css" />



<style>
#form_table {
	margin-top: 20px;
	width: 100%;
	max-width: 100%;
}
#form_table tr td {
	padding-top: 10px;
	padding-bottom: 10px;
}
#form_table {
	width: 100%;
	padding-bottom: 100px;
}
#time {
	display: block;
	margin-top: 10px;
}
#page_content {
	text-align: center;
}

#map {
	height: 400px;
	display: block;
      }
#right-panel {
	display: block;
}
.ui-slider-handle, .ui-state-default, .ui-corner-all{
	z-index: 1;
	outline-width: 0px;
}


</style>
</head>
<body>
<?php require_once('header.php'); ?>

<div class="container">
<div id="page_title">
	Create a new trip
</div>
<div id="page_content">
	<form id="form_table" action="add_trip.php" method="POST">
		<input type="hidden" name="email" value="<?php echo getMailId(); ?>" />
		<input type="hidden" name="username" value="<?php echo getName(); ?>" />
		<table width="100%">
			

			<tr>
				<td width="30%">
				</td>
				<td width="30%">
				</td>
				<td valign="top" rowspan="9" width="40%" style="vertical-align: top; padding-left: 15px; text-align: center;">
				    <div id="map"></div>
					<div id="right-panel"></div>

				</td>
			</tr>


			<tr>
				<td width="30%">
					Trip starts from: 
				</td>
				<td width="30%">
					<input id="autocomplete" placeholder="Enter the source address"
						             onFocus="geolocate()" type="text" name="source_addr"></input>
				</td>
			</tr>
			<tr>
				<td width="30%">
					Trip ends at: 
				</td>
				<td width="30%">
					<input id="autocomplete2" placeholder="Enter the destination address"
						             onFocus="geolocate()" type="text" name="dest_addr"></input>
				</td>
			</tr>

			<tr>
				<td width="30%">
					Time:<br /><small>(When are you comfortable with the cab arriving?)</small>
				</td>
				<td width="30%">
					<div id="slider-range"></div>
					<span id="time"></span>
					<input type="hidden" id="time_duration" name="time_duration" />
				</td>
			</tr>

			<tr>
				<td width="30%">
					Date:
				</td>
				<td width="30%">
			        <input type="text" id="datepicker" class="picker" name="date" placeholder="What date do you want a cab for?"></div>
				</td>
			</tr>

			

			<tr>
				<td width="30%">
					Contact Number:
				</td>
				<td width="30%">
					<input type="text" name="phone_number" placeholder="This is optional but recommended." />
				</td>
			</tr>

			<tr>
				<td width="30%">
					Number of co-travellers:
				</td>
				<td width="30%">
					<input type="text" name="co_travellers" placeholder="Including you." />
				</td>
			</tr>

			<tr>
				<td width="30%">
					Comments:
				</td>
				<td width="30%">
					<input type="text" name="comments" placeholder="About quantity of luggage, etc." />
				</td>
			</tr>

			<tr>
				<td valign="top" width="30%" colspan="2" style="vertical-align: top;">
					<input type="submit" class="btn anim" value="Add this trip" />
				</td>
			</tr>


			



		</table>
	</form>
</div>

</div>

<?php require_once('footer.php'); ?>
</body>
<script src="./js/jquery.js"></script>
<script src="./js/jqueryui.js"></script>
<script>
var placeSearch, autocomplete;
var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};

function initAutocomplete() {
  // Create the autocomplete object, restricting the search to geographical
  // location types.
  autocomplete = new google.maps.places.Autocomplete(
      /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
      {types: ['geocode']});

  autocomplete2 = new google.maps.places.Autocomplete(
      /** @type {!HTMLInputElement} */(document.getElementById('autocomplete2')),
      {types: ['geocode']});

  // When the user selects an address from the dropdown, populate the address
  // fields in the form.
  autocomplete.addListener('place_changed', fillInAddress);
  autocomplete2.addListener('place_changed', fillInAddress);

  initMap();
}

// [START region_fillform]
function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();
  var place2 = autocomplete2.getPlace();

}
// [END region_fillform]

// [START region_geolocation]
// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle({
        center: geolocation,
        radius: position.coords.accuracy
      });
      autocomplete.setBounds(circle.getBounds());
    });
  }
}

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUDzz-esKOYa1XHFFek8plrCKJw-OI_5I&libraries=places&callback=initAutocomplete"
        async defer></script>
<script>
$(function() {
    $( "#datepicker" ).datepicker();
    function slideTime(event, ui){
    var val0 = $("#slider-range").slider("values", 0),
        val1 = $("#slider-range").slider("values", 1),
        minutes0 = parseInt(val0 % 60, 10),
        hours0 = parseInt(val0 / 60 % 24, 10),
        minutes1 = parseInt(val1 % 60, 10),
        hours1 = parseInt(val1 / 60 % 24, 10);
    startTime = getTime(hours0, minutes0);
    endTime = getTime(hours1, minutes1);
    $("#time").text(startTime + ' - ' + endTime);
}
var startTime;
var endTime;
  $("#slider-range").slider({
        range: true,
        min: 0,
        max: 1439,
        values: [540, 1020],
        slide: slideTime
    });
function slideTime(event, ui){
    var val0 = $("#slider-range").slider("values", 0),
        val1 = $("#slider-range").slider("values", 1),
        minutes0 = parseInt(val0 % 60, 10),
        hours0 = parseInt(val0 / 60 % 24, 10),
        minutes1 = parseInt(val1 % 60, 10),
        hours1 = parseInt(val1 / 60 % 24, 10);
    startTime = getTime(hours0, minutes0);
    endTime = getTime(hours1, minutes1);
    $("#time").text(startTime + ' - ' + endTime);
    $('#time_duration').val(startTime + ' - ' + endTime);
}
function getTime(hours, minutes) {
    var time = null;
    minutes = minutes + "";
    if (hours < 12) {
        time = "AM";
    }
    else {
        time = "PM";
    }
    if (hours == 0) {
        hours = 12;
    }
    if (hours > 12) {
        hours = hours - 12;
    }
    if (minutes.length == 1) {
        minutes = "0" + minutes;
    }
    return hours + ":" + minutes + " " + time;
}
slideTime();
  });
</script>
<script>
var typingTimer;                //timer identifier
var doneTypingInterval = 5000;  //time in ms, 5 second for example
//on keyup, start the countdown


function initMap() {

  var directionsDisplay = new google.maps.DirectionsRenderer;
  var directionsService = new google.maps.DirectionsService;
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 14,
    center: {lat: 17.4456, lng: 78.3497}
  });
  // google.maps.event.trigger(map, 'resize')
  directionsDisplay.setMap(map);
  // directionsDisplay.setPanel(document.getElementById('right-panel'));

  var onChangeHandler = function() {
    calculateAndDisplayRoute(directionsService, directionsDisplay);
  };
	// document.getElementById('autocomplete2').addEventListener('change', function() { console.log('hi'); });
  // document.getElementById('start').addEventListener('onFocus', onChangeHandler);
  document.getElementById('autocomplete2').addEventListener('change', onChangeHandler);
}

function calculateAndDisplayRoute(directionsService, directionsDisplay) {
  var start = document.getElementById('autocomplete').value;
  var end = document.getElementById('autocomplete2').value;
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