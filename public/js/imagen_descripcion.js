// Selecciona el botón
var botonDescargar = document.getElementById("botonDescargar");

function cambiarId(id, descripcion, imagen)
{
    const idDireccion = document.getElementById('idDireccion');
    const ant_descripcion = document.getElementById('descripcion');
    
    if(imagen == '')
    {
        console.log(imagen);
        botonDescargar.style.display = "none";
    }else{
        botonDescargar.style.display = "block";
    }

    idDireccion.value = id;
    ant_descripcion.value = descripcion;
}


/* var botonEditar = document.getElementById("img_desc");

botonEditar.addEventListener("click", function(){

}); */

// Agrega un evento click al botón
botonDescargar.addEventListener("click", function() {
    id = document.getElementById('idDireccion').value
    $.ajax({
        url: 'descargar-imagen',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': window.csrfToken
        },
        data: {
            'id': id
        },
        xhrFields: {
            responseType: 'blob' // Solicitar el tipo de respuesta como un blob (archivo)
        },
        success: function(data) {
        var a = document.createElement('a');
        var url = window.URL.createObjectURL(data);
        a.href = url;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        },
        error: function(xhr, status, error) {
        console.log("Error:", error);
        }
    });
    
});

