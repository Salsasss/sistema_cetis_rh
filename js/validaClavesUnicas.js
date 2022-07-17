//Funcion que valida que un CURP sea valido
function curpValida(curp) {
    var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
        validado = curp.match(re);

    if (!validado) { //Coincide con el formato general?
        return false;
    }

    //Validar que coincida el dígito verificador
    function digitoVerificador(curp17) {
        //Fuente https://consultas.curp.gob.mx/curpRegistradasP/
        var diccionario = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
            lngSuma = 0.0,
            lngDigito = 0.0;
        for (var i = 0; i < 17; i++)
            lngSuma = lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
        lngDigito = 10 - lngSuma % 10;
        if (lngDigito == 10) return 0;
        return lngDigito;
    }

    if (validado[2] != digitoVerificador(validado[1])) {
        return false;
    }
    return true; //Validado
}

//Funcion que valida que un NSS sea valido
function nssValido(nss) {
    const re = /^(\d{2})(\d{2})(\d{2})\d{5}$/,
        validado = nss.match(re);

    if (!validado) // 11 dígitos y subdelegación válida?
        return false;

    const subDeleg = parseInt(validado[1], 10),
        anno = new Date().getFullYear() % 100;
    var annoAlta = parseInt(validado[2], 10),
        annoNac = parseInt(validado[3], 10);

    //Comparar años (excepto que no tenga año de nacimiento)
    if (subDeleg != 97) {
        if (annoAlta <= anno) annoAlta += 100;
        if (annoNac <= anno) annoNac += 100;
        if (annoNac > annoAlta)
            return false; // Err: se dio de alta antes de nacer!
    }

    return luhn(nss);
}

function luhn(nss) {
    var suma = 0,
        par = false,
        digito;

    for (var i = nss.length - 1; i >= 0; i--) {
        var digito = parseInt(nss.charAt(i), 10);
        if (par)
            if ((digito *= 2) > 9)
                digito -= 9;

        par = !par;
        suma += digito;
    }
    return (suma % 10) == 0;
}

//Funcion que valida que un RFC sea valido
function rfcValida(rfc) {

    var patternPM = "^(([A-ZÑ&]{3})([0-9]{2})([0][13578]|[1][02])(([0][1-9]|[12][\\d])|[3][01])([A-Z0-9]{3}))|" +
        "(([A-ZÑ&]{3})([0-9]{2})([0][13456789]|[1][012])(([0][1-9]|[12][\\d])|[3][0])([A-Z0-9]{3}))|" +
        "(([A-ZÑ&]{3})([02468][048]|[13579][26])[0][2]([0][1-9]|[12][\\d])([A-Z0-9]{3}))|" +
        "(([A-ZÑ&]{3})([0-9]{2})[0][2]([0][1-9]|[1][0-9]|[2][0-8])([A-Z0-9]{3}))$";
    var patternPF = "^(([A-ZÑ&]{4})([0-9]{2})([0][13578]|[1][02])(([0][1-9]|[12][\\d])|[3][01])([A-Z0-9]{3}))|" +
        "(([A-ZÑ&]{4})([0-9]{2})([0][13456789]|[1][012])(([0][1-9]|[12][\\d])|[3][0])([A-Z0-9]{3}))|" +
        "(([A-ZÑ&]{4})([02468][048]|[13579][26])[0][2]([0][1-9]|[12][\\d])([A-Z0-9]{3}))|" +
        "(([A-ZÑ&]{4})([0-9]{2})[0][2]([0][1-9]|[1][0-9]|[2][0-8])([A-Z0-9]{3}))$";

    if (rfc.match(patternPM) || rfc.match(patternPF)) {
        return true;
    } else {
        return false;
    }
}