
// Crea un objeto de mapa en un contenedor HTML específico
const map = L.map('map').setView([-33.38151239916761,-60.216151025578654], 13); 

// Agrega un proveedor de mapas (por ejemplo, OpenStreetMap)
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
	}).addTo(map);

try {
  const coordenadas =   window.responseData.data.coordinates //coordenadas que se agregaran como puntos en el mapa
  const polylinea = window.responseData.polyline; //polylnea que unira los puntos

  
  let contador = 1;
  coordenadas.forEach((element, index) => {
    const marker = L.marker(element).addTo(map);
  
    // Determinar el nombre del punto según la posición
    let nombrePunto;
    if (index === 0) {
      nombrePunto = 'Punto inicio';
    } else if (index === coordenadas.length - 1) {
      nombrePunto = 'Punto final';
    } else {
      nombrePunto = `Punto ${contador}`;
      contador++;
    }
  
    marker.bindTooltip(nombrePunto, { permanent: true, className: 'custom-tooltip' }).openTooltip();
  });

  var polyline = L.polyline(polylinea).addTo(map);
  map.fitBounds(polyline.getBounds());


} catch (error) {

}


  //codigo para pasar autocompletar las direcciones que introduce el usuario
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
    $('#formDirecciones input').on('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            // Puedes hacer una solicitud AJAX aquí para enviar los datos al controlador de Laravel si es necesario
        }
    });
      var autocomplete;
      autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), options);


      google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var places = autocomplete.getPlace();


        latitude = places.geometry.location.lat();
        longitude = places.geometry.location.lng();

        console.log(latitude, longitude)
        guardarDireccion(latitude, longitude);
      });

  });


  function guardarDireccion(latitude, longitude) {
    $.ajax({
        url: '/direcciones/rutas',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': window.csrfToken // Agrega el token CSRF en el encabezado
        },
        data: {
            'direccion': document.getElementById(searchInput).value,
            'tipo': document.getElementById("tipo").value,
            'latitud': latitude,
            'longitud': longitude,
        },
        success: function (response) {
          location.reload();
        },
        error: function (xhr) {
            // Manejar errores si es necesario
            console.log(xhr.responseText);
        }
    });
}