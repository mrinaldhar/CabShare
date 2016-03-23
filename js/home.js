var SOURCE_ADDR, DEST_ADDR;

$(document).ready(function() {
	var tripID = getUrlVars()["id"];
	if (tripID) {
		getTrip(tripID);
	}
	else {
		getTrip(-1);		
	}
	getAllTrips();
	// google.maps.event.trigger(map, 'resize');
	$('#savepdfbtn').click(function() {
		// savePDF();
		window.print();
	});
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
function getTrip(tripID) {
	if (tripID != -1) {
		var data = {
			trip_id: tripID
		}
		var result = ajaxCall(API_dir+API_getTrip, data, "GET", false);
	}
	else {
		var data = {};
		var result = ajaxCall(API_dir+API_getLatestTrip, data, "GET", false);
	}
	console.log(result);
	if (result !=null) {	
	if (result["status"] == 0) {
		result = result["data"];
	}
	else {
		alert("Some error happened. "); // Add this to notifications bar.
	}
	SOURCE_ADDR = result["source_addr"];
	DEST_ADDR = result["dest_addr"];
	TRIP_LOADED = 1;
	// matchTrip(result["id"]);
console.log(result["data"]);
	$('#page_title').html("Trip from <span class='loc'>"+ getShortAddr(result["source_addr"]) + "</span> to <span class='loc'>" + getShortAddr(result["dest_addr"]) + "</span>");
	$('#page_title').append("<span id='subtitle'>"+result["travellers"]+" people travelling on "+result["date"]+" during "+getAMPM(result["start_time"])+" - " + getAMPM(result["end_time"]) + "<br />\
		</span>");
}
else {
$('#page_title').html("No trips created yet!");
}
}

function getAllTrips() {
	var results = ajaxCall(API_dir+API_getAllTrips, {}, "GET", false);
	if (results["status"] == 0) {
		results = results["data"];
		for (var x=0; x<results.length; x++) {
		var current = results[x];
		$('#sidebar ul').append("<li onclick='tripGOTO("+current["id"]+")' class='anim'>"+getShortAddr(current["source_addr"])+" to "+getShortAddr(current["dest_addr"]) +"\
			<span id='subtitle'>"+current["travellers"]+" people travelling on "+current["date"]+" during "+getAMPM(current["start_time"])+" - " + getAMPM(current["end_time"]) + "</li>");

		}
	}
	else {
		alert("Some error happened. "); // Add this to notifications bar.
	}
	

}
