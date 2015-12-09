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

</head>
<body>
<?php require_once('header.php'); ?>

<div class="container">
<div id="map"></div>
<div id="page_title">
	Your current trip status
</div>
<div id="page_content">

</div>

</div>

<?php require_once('footer.php'); ?>
</body>
<script src="./js/jquery.js"></script>
<script src="./js/jqueryui.js"></script>
<script src="./js/helper.js"></script>
<script src="./js/endpoints.js"></script>
</html>