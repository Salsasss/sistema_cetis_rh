//Funcion que convierte el texto de un input a Mayusculas
function mayus(e) {
    e.value = e.value.toUpperCase();
}

//Funcion que limita a tener N catidad de caracteres
function maxnum(e, max) {
    var digitos = ('' + e.value).length;
    if (digitos > max) {
        e.value = e.value.substring(0, max);
    }
}

//Funcion que limita un numero a tener 11 caracteres
function celula(e) {
    var digitos = ('' + e.value).length;
    if (digitos == 3 || digitos == 7) {
        e.value = e.value + '-';
    }
    maxnum(e, 11);
}

//Funcion que comprueba que la entrada solo sean numeros
function soloNumeros(e) {
    var letras = "abcdefghijklmnñopqrstuvwxyz~`!@#$%^&*()_+=[]{};:'',.<>/?|";
    for (var i = 0; i < letras.length; i++) {
        if (e.value.indexOf(letras.charAt(i)) != -1) {
            e.value = e.value.replace(letras.charAt(i), '');
        }
    }
}