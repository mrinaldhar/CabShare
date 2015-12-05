<?php
	$login_status = isLoggedIn();
	if ($login_status):
?>
		<table class="header">
			<tr>
				<td width="30%">
					<button class="btn anim">+ New trip</button>
					<button class="btn anim">View current status</button>
					<button class="btn anim">All other poolers</button>
				</td>
				<td width="40%">
					<span id="logo_top">Cab Share<span id="iiith">@IIIT-H</span></span>
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
					<button class="btn anim">About</button>

				</td>
				<td width="40%">
					<span id="logo_top">Cab Share<span id="iiith">@IIIT-H</span></span>
				</td>
				<td width="30%">
					<small>Helped <span id="completed_people" class="blue1">0 people</span> complete <span id="completed_trips" class="blue1">0 trips</span> so far...</small>

				</td>
			</tr>
		</table>

<?php
	endif;
?>