$(function() {
    $( "#datepicker" ).datepicker({minDate:0});
    function slideTime(event, ui){
    var val0 = $("#slider-range").slider("values", 0),
        val1 = $("#slider-range").slider("values", 1),
        minutes0 = parseInt(val0 % 60, 10),
        hours0 = parseInt(val0 / 60 % 24, 10),
        minutes1 = parseInt(val1 % 60, 10),
        hours1 = parseInt(val1 / 60 % 24, 10);
    startTime = getTime(hours0, minutes0);
    endTime = getTime(hours1, minutes1);
    $("#time").text(startTime + ' - ' + endTime);
}
var startTime;
var endTime;
  $("#slider-range").slider({
        range: true,
        min: 0,
        max: 1439,
        values: [540, 1020],
        slide: slideTime
    });
function slideTime(event, ui){
    var val0 = $("#slider-range").slider("values", 0),
        val1 = $("#slider-range").slider("values", 1),
        minutes0 = parseInt(val0 % 60, 10),
        hours0 = parseInt(val0 / 60 % 24, 10),
        minutes1 = parseInt(val1 % 60, 10),
        hours1 = parseInt(val1 / 60 % 24, 10);
    startTime = getTime(hours0, minutes0);
    endTime = getTime(hours1, minutes1);
    $("#time").text(startTime + ' - ' + endTime);
    startTime24H = "";
    endTime24H = "";
    if (hours0<10) {
        startTime24H = "0";
    }
    if (hours1<10) {
        endTime24H = "0";
    }
    startTime24H = startTime24H + hours0;
    endTime24H = endTime24H + hours1;

    if (minutes0<10) {
        startTime24H = startTime24H + "0";
    }
    if (minutes1<10) {
        endTime24H = endTime24H + "0";
    }

    startTime24H = startTime24H + minutes0;
    endTime24H = endTime24H + minutes1;

    $('#start_time').val(startTime24H);
    $('#end_time').val(endTime24H);
    console.log(startTime24H + " - " + endTime24H);
}
function getTime(hours, minutes) {
    var time = null;
    minutes = minutes + "";
    if (hours < 12) {
        time = "AM";
    }
    else {
        time = "PM";
    }
    if (hours == 0) {
        hours = 12;
    }
    if (hours > 12) {
        hours = hours - 12;
    }
    if (minutes.length == 1) {
        minutes = "0" + minutes;
    }
    return hours + ":" + minutes + " " + time;
}
slideTime();
  });

$('#form_table').submit(function() {        // What kind of name is form_table anyway. -md.
  console.log($('#phone').val());
  var data = {
  source_addr: $('#autocomplete').val(),    // Rename these to the right things, sometime in the future. It doesn't look proper, does it. -Sherlock Holmes. 
  dest_addr: $('#autocomplete2').val(), 
  date: $('#datepicker').val(), 
  start_time: $('#start_time').val(),
  end_time: $('#end_time').val(),
  phone_number: $('#phone').val(), 
  travellers: $('#num_cotravel').val(),
  comment: $('#comments').val(), 
  "private": $('#privacy').val().split(' - ')[0]
  }
  console.log(data);
  if (data["source_addr"]!=="" && data["dest_addr"]!=="" && data["data"]!=="" && data["start_time"]!=="" && data["end_time"]!=="" && data["travellers"]!=="") {  
   $('#submit_btn').val("Adding trip and finding matches...");   
var result = ajaxCall(API_dir+API_addTrip, data, "POST", true);
  console.log(result);
// if (result["status"] == 0) {
   window.setTimeout(function() {
     window.location="./home.php";
   }, 5000);
//  }
//  else {
//    alert("Problem. Retry maybe? ");
//return false;
// }
}
else {
  alert("Some required fields were left empty.");
  return false;
}
});
function submitform_addTrip() {
  
}
