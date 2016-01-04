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
<link rel="stylesheet" href="./css/all_trips.css" />
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
<script src="./js/all_trips.js"></script>
</html>
