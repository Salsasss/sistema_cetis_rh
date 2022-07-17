//funcion que muestra una alerta, puede ser de error o de exito
function mostrarAlerta(mensaje, error = null, padre = '.formulario', desaparecer = false) {
    if (document.querySelector('.mensaje.error')) {
        document.querySelector('.mensaje.error').remove();
    }
    const alerta = document.createElement('UL');
    alerta.innerHTML = mensaje;
    alerta.classList.add('mensaje');
    if (error != null) {
        alerta.classList.add('error'); //Si hay algun error
    } else {
        alerta.classList.add('exito'); //Si no hay ningun error
    }
    const formulario = document.querySelector(padre);
    formulario.appendChild(alerta);
    if (desaparecer == true) {
        setTimeout(() => {
            alerta.remove();
        }, 5000)
    }
}

//Funcion para comprobar la longitud de un texto
function comprobarLongitud(texto = '', min, max, tipo) {
    error = '';
    if (min == max && texto.length != min) {
        error = '<li>' + tipo + ' requiere ' + min + ' caracteres <br> </li>';
    }
    if (texto.length < min) {
        error = '<li>' + tipo + ' requiere mas caracteres <br> </li>';
    }
    if (texto.length > max) {
        error = '<li>' + tipo + ' sobrepasa el maximo de caracteres <br> </li>';
    }
    return error;
}

//Funcion que comprueba que no haya caracteres No validos
function comprobarTexto(texto = '', caracteres, tipo) {
    error = '';
    bandera = false;
    for (i = 0; i < texto.length; i++) {
        for (o = 0; o < caracteres.length; o++) {
            if (texto.charAt(i) == caracteres.charAt(o)) {
                bandera = false;
                break;
            } else {
                bandera = true;
            }
        }
        if (bandera == true) {
            error = '<li>' + tipo + ' tiene caracteres No v&aacute;lidos <br> </li>';
        }
    }
    return error;
}

//Funcion que comprueba que el numero sea entero y entre en el rango de edad
function comprobarNumero(numero, tipo) {
    error = '';
    if (isNaN(numero)) {
        error = '<li>' + tipo + ' debe ser un numero entero <br> </li>';
    }
    if (tipo == 'La Edad') {
        if (numero < 21 || numero > 100) {
            error = '<li> Edad No valida <br> </li>';
        }
    }
    return error;
}

//Funcion que calcula la edad teniendo como parametro de entrada una fecha
function calculaEdad(fecNac) {
    var edad = 0;
    //Obteniendo fechas actuales
    var fechaActual = new Date();
    var diaAct = fechaActual.getDate();
    var mesAct = fechaActual.getMonth() + 1;
    var anioAct = fechaActual.getFullYear();

    //Obteniendo fechas del usiario
    var diaNac = fecNac.getDate() + 1;
    var mesNac = fecNac.getMonth() + 1;
    var anioNac = fecNac.getFullYear();

    //Obteniendo edad en bruto
    edad = anioAct - anioNac;
    //Si el mes de nacimiento es mayor al mes actual (aun no cumple anios)
    if (mesNac > mesAct) {
        edad--;
    }
    //Si el mes de nacimiento es igual al mes actual (y el dia de nacimiento es mayor al dia actual)
    if (mesNac == mesAct && diaNac > diaAct) {
        edad--;
    }
    return edad;
}

function mostrarContrasena() {
    var contra = document.getElementById("password");
    if (contra.type == "password") {
        contra.type = "text";
    } else {
        contra.type = "password";
    }
    setTimeout(() => {
        contra.type = "password";
    }, 1500)
}