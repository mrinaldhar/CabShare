<!doctype html>
<html>
<head>
<title>Cab Share</title>
<style>
@font-face {
	src: url('./fonts/myriadl.otf');
	font-family: myriadl;
}
@font-face {
	src: url('./fonts/quickbold.otf');
	font-family: quickbold;
}
body {
	padding: 0; 
	margin: 0;
	overflow: none;
	font-family: myriadl;
	background-color: #e0e0e0;
}
.footer {
	position: fixed;
	bottom: 0px;
	left: 0px;
	width: 100%;
	text-align: center;
	font-family: quickbold;
	background-color: rgba(0,0,0,0.8);
	padding-top: 7px;
	padding-bottom: 7px;
	color: white;
	/*box-shadow: 0 0 1px black;*/
	border-top: 3px solid black;
	font-size: 0.9em;
}
.footer a {
	color: #40C4FF;
	text-decoration: none;
}
.footer a:hover {
	color: #80D8FF;
}
.header {
	font-family: quickbold;
	position: fixed;
	top: 0px;
	width: 100%;
	left: 0px;
	border-bottom: 3px solid #0091EA;
	background-color: rgba(0,0,0,0.8);
	color: white;
	padding: 7px;
	padding-left: 20px;
	padding-right: 20px;
	text-align: center;
}
#logo_top {
	font-size: 1.5em;
}
#iiith {
	font-size: 0.7em;
	padding-left: 5px;
}
.btn {
	border: 2px solid #0091EA;
	background-color: rgba(0,0,0,0.3);
	border-radius: 3px;
	padding-top: 6px;
	padding-bottom: 6px;
	padding-left: 13px;
	padding-right: 13px;
	color: white;
	font-family: quickbold;
	cursor: pointer;
	box-shadow: 0 0 3px black;
}
.btn:hover {
	color: #0091EA;
	background-color: rgba(255,255,255,0.9);
}
.anim {
  -o-transition:.5s;
  -ms-transition:.5s;
  -moz-transition:.5s;
  -webkit-transition:.5s;
  transition:.5s;
}
</style>
</head>
<body>
<?php require_once('header.php'); ?>


<?php require_once('footer.php'); ?>
</body>
<script src="./js/jquery.js"></script>
<script src="./js/jqueryui.js"></script>
</html>