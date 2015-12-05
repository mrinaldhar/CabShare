<?php 
error_reporting(E_ALL);
session_start();
require_once("./utils/ldap.php");
require_once("./utils/userhelper.php");
?>
<!doctype html>
<html>
<head>
<title>Cab Share</title>
<link rel="stylesheet" href="./css/global.css" />
<style>
#login_form {
	width: 100%;
}
#login_form input {
	display: block;
	width: 100%;
	/*padding: 10px;*/
	padding-top: 10px;
	padding-bottom: 10px;
	padding-left: 10px;
	border: 2px solid #0091EA;
	border-radius: 3px;
	font-family: quickbold;
	outline-width: 0px;
	font-size: 0.9em;
	margin-top: 5px;
	-webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
	-moz-box-sizing: border-box;    /* Firefox, other Gecko */
	box-sizing: border-box;         /* Opera/IE 8+ */
}
#login_form input:active {
	box-shadow: 0 0 1px black;
}
.submit-btn {
	background-color: #0091EA;
	box-shadow: 0 0 0px black;
}
.container {
	left: 33%;
	text-align: center;
	width: 33%;
	top: 30%;
}
#page_title {
	padding-bottom: 30px;
	display: block;
}
</style>
</head>
<body>
<?php require_once('header.php'); ?>

<div class="container">
<form id="login_form" action="login.php" method="POST">
	<span id="page_title">Login using your IIIT-H credentials</span>
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
</form>
</div>

<?php require_once('footer.php'); ?>
</body>
<script src="./js/jquery.js"></script>
<script src="./js/jqueryui.js"></script>
</html>