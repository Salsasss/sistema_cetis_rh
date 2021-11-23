//Funcion que valida los datos de entrada a la hora de registrar un Usuario
function validarDatosUsuario() {
    const formulario = document.querySelector('.formulario.chico.usuario');
    if (formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault();
            var mensaje = '';

            //Validando el nombre de usuario
            const nombreUsuario = document.getElementById('usunom');
            mensaje += comprobarLongitud(nombreUsuario.value, 5, 60, 'El Nombre de Usuario');
            mensaje += comprobarTexto(nombreUsuario.value, 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúÁÉÍÓÚ1234567890._- ', 'El Nombre de Usuario');

            //Validando el correo electronico
            const correoUsuario = document.getElementById('usucorreo');
            mensaje += comprobarLongitud(correoUsuario.value, 10, 60, 'El Correo electr&oacute;nico');
            mensaje += comprobarTexto(correoUsuario.value, 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúÁÉÍÓÚ,.@:1234567890 ', 'El Correo electr&oacute;nico');

            //Validando el rango de la cuenta
            const rango = document.getElementById('rango');
            if (rango.value != 'Administrador' && rango.value != 'Asistente') {
                mensaje += '<li> El Rango de la cuenta No es v&aacute;lido <br> </li>';
            }

            if (mensaje == '') {
                if (document.querySelector('.submit').value == 'Registrar Usuario') {
                    mostrarAlerta('¡Usuario registrado Correctamente!', );
                }
                setTimeout(() => {
                    formulario.submit();
                }, 2000)
            } else {
                mostrarAlerta(mensaje, 'ERROR');
            }
            return;
        });
    }
}
validarDatosUsuario();