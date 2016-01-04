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
<link rel="stylesheet" href="./css/home.css" />
<link rel="shortcut icon" href="./favicon.png" type="image/x-icon">
<link rel="icon" href="./favicon.png" type="image/x-icon">
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
<script src="./js/home.js"></script>
<script src="./js/home_maps.js"></script>

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
