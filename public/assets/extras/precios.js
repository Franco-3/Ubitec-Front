    // Obtenemos una referencia al botón y al div oculto
    var showButtonUser = document.getElementById("show-container-user");
    var hiddenContainerUser = document.getElementById("hidden-container-user");

    var showButtonEmpresa = document.getElementById("show-container-empresa");
    var hiddenContainerEmpresa = document.getElementById("hidden-container-empresa");

    hiddenContainerUser.style.display = "none" //ocultarlo al cargar la pagina
    hiddenContainerEmpresa.style.display = "none"
    // Agregamos un evento clic al botón
    showButtonUser.addEventListener("click", function () {
        // Verificamos si el div oculto está visible
        if (hiddenContainerUser.style.display === "none") {
            // Si está oculto, lo mostramos y ocultamos el otro
            hiddenContainerEmpresa.style.display = "none";
            hiddenContainerUser.style.display = "block";
        } else {
            // Si está visible, lo ocultamos
            hiddenContainerEmpresa.style.display = "none";
        }
    });

    showButtonEmpresa.addEventListener("click", function () {
        // Verificamos si el div oculto está visible
        if (hiddenContainerEmpresa.style.display === "none") {
            // Si está oculto, lo mostramos y ocultamos el otro
            hiddenContainerUser.style.display = "none";
            hiddenContainerEmpresa.style.display = "block";
        } else {
            // Si está visible, lo ocultamos
            hiddenContainerUser.style.display = "none";
        }
    });

    console.log('afsa');