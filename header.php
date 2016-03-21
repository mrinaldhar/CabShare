<?php
	$login_status = isLoggedIn();
	if ($login_status):
?>
		<table class="header">
			<tr>
				<td width="30%">
					<a href="./new_trip.php"><button class="btn anim">+ New trip</button></a>
					<a href="./home.php"><button class="btn anim">Current trip</button></a>
					<a href="./all_trips.php"><button class="btn anim">All public trips</button></a>
				</td>
				<td width="40%">
					<span id="logo_top">Cab Share<span id="iiith"> &bull; IIIT-H</span></span>
				</td>
				<td width="30%">
					<a href="./logout.php"><button class="btn anim">Logout: <?php echo getName(); ?></button></a>
				</td>
			</tr>
		</table>

<?php
	else:
?>

		<table class="header">
			<tr>
				<td width="30%">

				</td>
				<td width="40%">
					<span id="logo_top">Cab Share<span id="iiith">&bull; IIIT-H</span></span>
				</td>
				<td width="30%">
					<small>Helped <span id="completed_people" class="blue1">0 people</span> complete <span id="completed_trips" class="blue1">0 trips</span> so far...</small>

				</td>
			</tr>
		</table>

<?php
	endif;
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-75353142-1', 'auto');
  ga('send', 'pageview');

</script>
