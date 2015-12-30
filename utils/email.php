<?php

function getShortAddr($longAddr) {
	$address = explode(',', $longAddr);
	if (count($address)>=2) {
		return $address[0] . ", " . $address[1];
	}
	else {
		return $address[0];
	}
}


function send_email($to, $result) {

	$result = json_decode($result, true);

	if ($result["status"] == 0) {
			$headers = array("From: alerts@cabs.iiit.ac.in",
			    "Reply-To: no-reply@cabs.iiit.ac.in",
			    "X-Mailer: PHP/" . PHP_VERSION, 
			    "Content-Type: text/html; charset=ISO-8859-1",
			    "MIME-Version: 1.0"
			);
		$headers = implode("\r\n", $headers);

		$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">';
		$message .= '<html>';
		$message .= '<head>';

		$message .= '</head>';
		$message .= '<body style="font-family: Lucida, Tahoma, sans-serif;">';
		$message .= '	<table width="100%" align="center">';
		$message .= '		<tr>';
		$message .= '			<td width="100%" align="center">';
		$message .= '				<table width="60%">';
		$message .= '					<tr>';
		$message .= '						<td width="100%" align="center">';
		$message .= '							<h1> <a href="http://cabs.iiit.ac.in/" style="color: #3e3e3e;">CabShare</a> </h1>';
		$message .= '						</td>';
		$message .= '					</tr>';
		$message .= '					<tr>';
		$message .= '						<td width="100%" align="center">';
		$message .= '							<h3> It\'s a match made in <i>PHP</i>. </h3>';
		$message .= '						</td>';
		$message .= '					</tr>';
		$message .= '					<tr>';	
		$message .= '						<td width="100%" align="center">';
		$message .= '						<ul id="matched_results" style="list-style-type: none; width: 100%; text-align: center; padding: 0px;">';

		$data = $result["data"];

		foreach($data as $current) {
			$message .= '							<li style="display: block; color: rgba(0,0,0,0.5); border-bottom-width: 1px; border-bottom-color: #4a4a4a; border-bottom-style: dashed; padding: 20px;">';
			$message .= '								<span class="matched_name" style="display: block; width: 100%; color: rgba(0,0,0,1); font-size: 1.5em;">' . $current["userid"] . '</span>';
			$message .= '								<span class="matched_contact" style="display: block; width: 100%; color: rgba(0,0,0,1); margin-bottom: 5px; font-size: 0.9em;"><a href="mailto:' . $current["userid"] . '" style="color: black;">' . $current["userid"] . '</a> &bull; ' . $current["phone"] . '</span>';
			$message .= '								<span class="matched_route" style="display: block; width: 100%; font-size: 0.9em; color: rgba(0,0,0,0.5);">' . getShortAddr($current["source_addr"]) . ' to ' . getShortAddr($current["dest_addr"]) . ' &bull; ' . $current["start_time"] . ' - ' . $current["end_time"] . '</span>';
			$message .= '								<span class="matched_details" style="display: block; width: 100%; font-size: 0.9em;">' . $current["travellers"] . ' travellers &bull; ' . $current["comment"] . '</span>';
			$message .= '							</li>';
		}

		$message .= '						</ul>';
		$message .= '						</td>';
		$message .= '					</tr>';
		$message .= '					<tr>';
		$message .= '						<td width="100%" align="center">';
		$message .= '							<p><b><small> Designed by <a href="http://mrinaldhar.com" style="color: black;">Mrinal Dhar</a> &amp; <a href="http://amoghbl1.me" style="color: black;">Amogh Pradeep</a> | IIIT Hyderabad</small></b></p>';
		$message .= '						</td>';
		$message .= '					</tr>';
		$message .= '				</table>';
		$message .= '			</td>';
		$message .= '		</tr>';
		$message .= '	</table>';
		$message .= '</body>';
		$message .= '</html>';

		mail($to, "CabShare found matches for your upcoming trip!", $message, $headers);
	}
}

// Uncomment the following to test:

// $obj = array(
// 	"status" => 0, 
// 	"data" => array(
// 		array(
// 		"userid" => "mrinal.dhar",
// 		"start_time" => 1211,
// 		"end_time" => 1222, 
// 		"phone" => 7893550837,
// 		"source_addr" => "IIIT, Gachibowli", 
// 		"dest_addr" => "Airport, Hyderabad",
// 		"travellers" => 3,
// 		"comment" => "2 bags"
// 		)
// 		) );
// $obj = json_encode($obj);
// send_email("mrinal.dhar@research.iiit.ac.in", $obj);
?>
