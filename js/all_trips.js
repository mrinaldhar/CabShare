
$(document).ready(function() {
	getAllTrips();
	getPublicTrips();
});

function getShortAddr(longAddr) {
	var address = longAddr.split(',');
	if (address.length>2) {
		return longAddr.split(',')[0] + ", " + longAddr.split(',')[1];
	}
	else {
		return longAddr.split(',')[0];
	}
}

function getAllTrips() {
	var results = ajaxCall(API_dir+API_getAllTrips, {}, "GET", false);
	if (results["status"] == 0) {
		results = results["data"];
		for (var x=0; x<results.length; x++) {
		var current = results[x];
		$('#sidebar ul').append("<li class='anim' onclick='tripGOTO("+current["id"]+")'>"+getShortAddr(current["source_addr"])+" to "+getShortAddr(current["dest_addr"]) +"\
			<span id='subtitle'>"+current["travellers"]+" people travelling on "+current["date"]+" during "+getAMPM(current["start_time"])+" - " + getAMPM(current["end_time"]) + "</li>");

		}
	}
	else {
		alert("Some error happened. "); // Add this to notifications bar.
	}
	

}

function getPublicTrips() {
	var results = ajaxCall(API_dir+API_getPublicTrips, {}, "GET", false);
	console.log(results);
	if (results["status"] == 0) {
		results = results["data"];
		for (var x=0; x<results.length; x++) {
		var current = results[x];
		$('#matched_results').append('<li>\
			<span class="matched_name">'+current["username"]+'</span>\
			<span class="matched_contact"><a href="mailto:'+current["userid"]+'">'+current["userid"]+'</a> &bull; '+current["phone"]+'</span>\
			<span class="matched_route">'+getShortAddr(current["source_addr"])+' to '+getShortAddr(current["dest_addr"])+' &bull; '+ getAMPM(current["start_time"])+' - '+ getAMPM(current["end_time"])+'</span>\
			<span class="matched_details">'+current["travellers"]+' travellers on '+current["date"]+' &bull; '+current["comment"] +'</span></li>');
		
		}
	}
	else {
		alert("Some error happened. "); // Add this to notifications bar.
	}

	
}
