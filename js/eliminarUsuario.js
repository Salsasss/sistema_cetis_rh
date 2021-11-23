//Funcion que valida la eliminacion de un usuario
function eliminarUsuario() {
    //Cargamos todos los botones con querySelectorAll
    const eliminarUsuario = document.querySelectorAll('.boton.accion.eliminar.usuario');
    //Si exiten los botones
    if (eliminarUsuario) {
        //Recorremos todos los botones
        eliminarUsuario.forEach(boton => {
            //A cada boton le asignamos un evento de tipo click
            boton.addEventListener('click', function(e) {
                if (eliminarUsuario.length > 1) {
                    e.preventDefault();
                    var eliminar = confirm('¿Está seguro de querer Eliminar Permanentemente este usuario?');
                    if (eliminar) {
                        //Cargamos la direccion del enlace
                        var direccion = 'http://localhost/sistema_cetis_rh/' + boton.getAttribute("href");
                        setTimeout(() => {
                            window.location = direccion;
                        }, 2000);
                    }
                } else {
                    e.preventDefault();
                    alert('¡No es posible eliminar el ultimo usuario!');
                }
            });
        });
    }
}

eliminarUsuario();