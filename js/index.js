$(document).ready(function() {
  var count = ajaxCall(API_dir+API_count, {}, "GET", false);			// Yeah yeah, I know. Synchronous AJAX. I got lazy. Kill me. 
  																		// TODO: Add support for a callback to be passed to ajaxCall 
  																		// function or some people will keep crying over this. -_-
  if (count["status"] == 0) {
	  $('#completed_people').text(count["data"]["people"]+" people");
	  $('#completed_trips').text(count["data"]["trips"]+" trips");
  }  
});
