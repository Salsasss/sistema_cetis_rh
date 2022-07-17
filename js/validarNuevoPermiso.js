//Funcion que quita la posibilidad de pedir permisos en dias en que ya se ha pedido
function validarPermisos() {
    //Primero desabilitamos las fechas
    var mensaje = '';
    if (document.getElementById('fechaPermiso')) {
        const fechaInput = document.getElementById('fechaPermiso');
        fechaInput.addEventListener('input', e => {
            mensaje = '';
            dia = new Date(e.target.value).getUTCDay(); //me dara el dia elegido en un numero entre 0 - 6; 0 siendo domingo y 6 sabado
            if (dia === 6 || dia === 0) { // si el dia es sabado o domingo
                e.preventDefault(); //se previene la accion por default
                fechaInput.value = '';
                mensaje += '<li> No se puede pedir Permisos en Fines de Semana<br></li>';
                mostrarAlerta(mensaje, 'ERROR', '.formulario', false);
            }
            //cargando los permisos usados por ese docente
            //console.log(permisosUsados);
        });
    }
}
validarPermisos();