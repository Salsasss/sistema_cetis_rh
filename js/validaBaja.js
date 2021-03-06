//Funcion que valida los datos de entrada a la hora de dar de baja un docente
function validaBaja() {
    const formulario = document.querySelector('.formulario.baja');
    if (formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault();
            mensaje = '';
            const motivo = document.getElementById('motivo');

            //Comprobando que haya un motivo
            mensaje += comprobarLongitud(motivo.value, 10, 240, 'El Motivo');

            if (mensaje == '') {
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

validaBaja();