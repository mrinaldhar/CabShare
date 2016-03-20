<?php 
session_start();
require_once("./utils/ldap.php");
require_once("./utils/userhelper.php");
if (isLoggedIn()) {
        $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/home.php';                                 // the user is redirected to the home page if logged in
        header('Location: ' . $home_url);
}
?>
<!-- 

	Developed by Mrinal Dhar, backend by Amogh Pradeep.

-->
<!doctype html>
<html>
<head>
<title>Cab Share</title>
<link rel="stylesheet" href="./css/global.css" />
<link rel="stylesheet" href="./css/index.css" />
<link rel="shortcut icon" href="./favicon.png" type="image/x-icon">
<link rel="icon" href="./favicon.png" type="image/x-icon">

</head>
<body>
<?php require_once('header.php'); ?>

<div class="container">

<form id="login_form" action="login.php" method="POST">
	<span id="page_title">Login using your IIIT-H credentials</span>
	<span id="page_content">
	<?php
		if (isset($_GET['err'])):
	?>
	<span id="error">Oops. We couldn't recognize your username/password combo.<br />Try again.</span>
	<?php
		endif;
	?>
	<input type="text" placeholder="The part before the @ in your IIIT-H email address" name="username" />
	<input type="password" placeholder="Your password" name="password" />
	<input type="submit" class="btn anim submit-btn" value="Login" />
	</span>
</form>
</div>

<?php require_once('footer.php'); ?>
</body>
<script src="./js/jquery.js"></script>
<script src="./js/jqueryui.js"></script>
<script src="./js/helper.js"></script>
<script src="./js/endpoints.js"></script>
<script src="./js/index.js"></script>
</html>
