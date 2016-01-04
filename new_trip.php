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
<link rel="stylesheet" href="./css/datepicker.css" />
<link rel="stylesheet" href="./css/datetheme.css" />
<link rel="stylesheet" href="./css/jqueryui.css" />
<link rel="stylesheet" href="./css/new_trip.css" />
<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
<link rel="icon" href="./favicon.ico" type="image/x-icon">
</head>
<body>
<?php require_once('header.php'); ?>

<div class="container">
<div id="page_title">
	Create a new trip
</div>
<div id="page_content">
	<form id="form_table" onsubmit="return false;">
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
					<input type="hidden" id="start_time" name="start_time" />
					<input type="hidden" id="end_time" name="end_time" />

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
					<input type="text" id="phone" name="phone_number" placeholder="This is optional but recommended." />
				</td>
			</tr>

			<tr>
				<td width="30%">
					Number of co-travellers:
				</td>
				<td width="30%">
					<input type="text" id="num_cotravel" name="co_travellers" placeholder="Including you." />
				</td>
			</tr>

			<tr>
				<td width="30%">
					Comments:
				</td>
				<td width="30%">
					<input type="text" id="comments" name="comments" placeholder="About quantity of luggage, etc." />
				</td>
			</tr>

			<tr>
				<td width="30%">
					Hide this trip from other people<br />on the "All trips" page?<br />
					<small>PRIVACY Note: Allowing this trip to show up on the "All Trips" page might help other travellers to directly contact you without using the CabShare matching algorithm. </small>

				</td>
				<td width="30%">
					<select class="select_input" id="privacy" name="privacy">
						<option> Yes - DONT show this trip on public page. </option>
						<option> No - ALLOW other people to see this trip on public page. </option>
					</select>
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUDzz-esKOYa1XHFFek8plrCKJw-OI_5I&libraries=places&callback=initAutocomplete"
        async defer></script>
<script src="./js/new_trip.js"></script>
<script src="./js/new_trip_maps.js"></script>
<script src="./js/helper.js"></script>
<script src="./js/endpoints.js"></script>
<script>
$('#form_table').submit(function() {        // What kind of name is form_table anyway. -md.
  console.log($('#phone').val());
  var data = {
  source_addr: $('#autocomplete').val(),    // Rename these to the right things, sometime in the future. It doesn't look proper, does it. -Sherlock Holmes. 
  dest_addr: $('#autocomplete2').val(), 
  date: $('#datepicker').val(), 
  start_time: $('#start_time').val(),
  end_time: $('#end_time').val(),
  phone_number: $('#phone').val(), 
  travellers: $('#num_cotravel').val(),
  comment: $('#comments').val(), 
  "private": $('#privacy').val()
  }
  console.log(data);
  var result = ajaxCall(API_dir+API_addTrip, data, "POST", false);
  console.log(result);
  if (result["status"] == 0) {
    window.location="./home.php";
  }
  else {
    alert("Problem. ");
  }
  return false;
});
function submitform_addTrip() {
  
}
</script>
</html>