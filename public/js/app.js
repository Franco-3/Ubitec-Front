var map;
  function initMap() {
    const directionsService = new google.maps.DirectionsService();
    const directionsRenderer = new google.maps.DirectionsRenderer(/*{draggable: true}*/);
    map = new google.maps.Map(document.getElementById("map"), {
    zoom: 10,
    center: { lat: -33.3504261, lng: -60.2908364 },
  });

  submitBtn = document.getElementById("submit");

  directionsRenderer.setMap(map);
  submitBtn.addEventListener("click", () => {
    calculateAndDisplayRoute(directionsService, directionsRenderer);
  });

  //

}
var toExel = [];

function calculateAndDisplayRoute(directionsService, directionsRenderer) {
  const waypts = [];
  var pase = '<?php echo json_encode($array);?>';
  const longArray = pase.length;

  for (let i = 0; i < longArray; i++) {

      waypts.push({
        location: pase[i],
        stopover: true,
      });

  }

  directionsService
    .route({
      origin: '<?php echo $start; ?>',
      destination: '<?php echo $end; ?>',
      waypoints: waypts,
      optimizeWaypoints: true,
      travelMode: google.maps.TravelMode.DRIVING,
    })
    .then((response) => {
      directionsRenderer.setDirections(response);

      const route = response.routes[0];
      const summaryPanel = document.getElementById("directions-panel");

      summaryPanel.innerHTML = "";

      // For each route, display summary information.
      for (let i = 0; i < route.legs.length; i++) {
        const routeSegment = i + 1;

        summaryPanel.innerHTML +=
          "<b>Ruta Número: " + routeSegment + "</b><br>";
        summaryPanel.innerHTML += route.legs[i].start_address.substr(0,30) + "..." + " <strong>Hacia </strong> ";
        summaryPanel.innerHTML += route.legs[i].end_address.substr(0,33) + "..." + "<br>";
        summaryPanel.innerHTML += route.legs[i].distance.text + "<br><br>";

        toExel.push(route.legs[i].end_address);
      }
    })
    .catch((e) => window.alert("Directions request failed due to " + status));
}

    // Solution 2, Without FileSaver.js
    var Results = [toExel];
    exportToCsv = function() {
      var CsvString = "";
      Results.forEach(function(RowItem, RowIndex) {
        RowItem.forEach(function(ColItem, ColIndex) {
          ColItem = ColItem.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
          CsvString += ColItem + ",";
          CsvString += "\r\n";
        });

      });
      CsvString = "data:application/vnd.ms-excel;charset=utf-8," + encodeURIComponent(CsvString);
      var x = document.createElement("A");
      x.setAttribute("href", CsvString);
      x.setAttribute("download", "Rutas.xls");
      document.body.appendChild(x);
      x.click();
    };

window.initMap = initMap;

  var searchInput = 'search_input';

  const center = { lat: -33.3334669, lng: -60.2110494 };
  const defaultBounds = {
      north: center.lat + 0.2,
      south: center.lat - 0.2,
      east: center.lng + 0.2,
      west: center.lng - 0.2,
    };

    const options = {
      bounds: defaultBounds,
      strictBounds: false,
    };

    var latitude;
    var longitude;

  $(document).ready(function () {
      var autocomplete;
      autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), options);


      google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var places = autocomplete.getPlace();

        latitude = places.geometry.location.lat();
        longitude = places.geometry.location.lng();

        var marker = new google.maps.Marker({
          position: {lat: latitude, lng: longitude},
          map: map,
          title: ''
        });

        map.setZoom(15);
        map.setCenter({lat: latitude, lng: longitude});

        window.location.href = "#map";


    });

  });