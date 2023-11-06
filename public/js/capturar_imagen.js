
function capturarImagen()
{
  simpleMapScreenshoter.takeScreen('blob', {
    caption: function () {
        return 'Hello world'
    }
  }).then(blob => {
    uploadImageToServer(blob);
  }).catch(e => {
      alert(e.toString())
  })
}

function uploadImageToServer(blob) {
    // Crear un objeto FormData y adjuntar la imagen
    var formData = new FormData();
    formData.append('_token', csrfToken);
    formData.append('capturedImage', blob, 'foto.png');

    // Realizar una solicitud POST al servidor para subir la imagen
    fetch('/subir-imagen', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            alert('Imagen cargada exitosamente');
        } else {
            alert('Error al cargar la imagen');
        }
    })
    .catch(error => {
        alert('Error de red: ' + error);
    });
}