//Funcion que valida los datos de entrada a la hora de iniciar sesion
function validarDatosInicioSesion() {
    const formulario = document.querySelector('.formulario.inicio-sesion');
    if (formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault();
            var mensaje = '';
            //validando el correo electronico
            const correoUsuario = document.getElementById('correo');
            mensaje += comprobarLongitud(correoUsuario.value, 10, 60, 'El Correo electr&oacute;nico');
            mensaje += comprobarTexto(correoUsuario.value, 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúÁÉÍÓÚ,_-.@:1234567890 ', 'El Correo electr&oacute;nico');

            //validando la contrasena
            const contra = document.getElementById('password');
            mensaje += comprobarLongitud(contra.value, 6, 6, 'La contrase&ntilde;a');
            mensaje += comprobarTexto(contra.value, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890', 'La contrase&ntilde;a');

            if (mensaje == '') {
                formulario.submit();
            } else {
                mostrarAlerta(mensaje, 'ERROR', '.contenedor-chico.errores');
            }
            return;
        });
    }
}

validarDatosInicioSesion();