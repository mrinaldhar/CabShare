function initMap() {
  var directionsDisplay = new google.maps.DirectionsRenderer;
  var directionsService = new google.maps.DirectionsService;
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 14,
    center: {lat: 17.4456, lng: 78.3497}
  });
  google.maps.event.trigger(map, 'resize')
  directionsDisplay.setMap(map);
  directionsDisplay.setPanel(document.getElementById('right-panel'));



  // directionsDisplay.setPanel(document.getElementById('right-panel'));
    calculateAndDisplayRoute(directionsService, directionsDisplay);
}

function calculateAndDisplayRoute(directionsService, directionsDisplay) {
  var start = SOURCE_ADDR;
  var end = DEST_ADDR;
  directionsService.route({
    origin: start,
    destination: end,
    travelMode: google.maps.TravelMode.DRIVING
  }, function(response, status) {
    if (status === google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    } else {
      console.log('Directions request failed due to ' + status);
    }
  });
}