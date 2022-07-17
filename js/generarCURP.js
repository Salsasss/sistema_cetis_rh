var estados = ['Aguascalientes', 'Baja California', 'Baja California Sur', 'Campeche', 'Chiapas', 'Chihuahua', 'Coahuila de Zaragoza', 'Colima', 'Ciudad de México', 'Durango', 'Guanajuato', 'Guerrero', 'Hidalgo', 'Jalisco', 'Estado de Mexico', 'Michoacan de Ocampo', 'Morelos', 'Nayarit', 'Nuevo Leon', 'Oaxaca', 'Puebla', 'Queretaro de Arteaga', 'Quintana Roo', 'San Luis Potosi', 'Sinaloa', 'Sonora', 'Tabasco', 'Tamaulipas', 'Tlaxcala', 'Veracruz de Ignacio de la Llave', 'Yucatan', 'Zacatecas'];
var abreviacion = ["AS", "BC", "BS", "CC", "CS", "CH", "CL", "CM", "CX", "DG", "GT", "GR", "HG", "JC", "MC", "MN", "MS", "NT", "NL", "OC", "PL", "QT", "QR", "SP", "SL", "SR", "TC", "TS", "TL", "VZ", "YN", "ZS"]

function generarCURP() {
    if (
        ($("#nombre").val() != "") &&
        ($("#apellido_pat").val() != "") &&
        ($("#apellido_mat").val() != "") &&
        ($("#fecha_nac").val() != "") &&
        ($("#sexo").val() != "") &&
        ($("#id_estado").val() != "")
    ) {
        dia = $("#fecha_nac").val().substr(8, 2);
        mes = $("#fecha_nac").val().substr(5, 2);
        anio = $("#fecha_nac").val().substr(2, 2);
        sexo = "";
        if ($("#sexo").val() == "Masculino") {
            sexo = "H";
        } else if ($("#sexo").val() == "Femenino") {
            sexo = "M";
        }
        var CURP = [];
        CURP[0] = $("#apellido_pat").val().charAt(0).toUpperCase();
        CURP[1] = $("#apellido_pat").val().slice(1).replace(/[^aeiou]/gi, "").charAt(0).toUpperCase();
        CURP[2] = $("#apellido_mat").val().charAt(0).toUpperCase();
        CURP[3] = $("#nombre").val().charAt(0).toUpperCase();
        CURP[4] = anio;
        CURP[5] = mes;
        CURP[6] = dia;
        CURP[7] = sexo;
        CURP[8] = abreviacion[$("#id_estado").val() - 1];
        CURP[9] = $("#apellido_pat").val().slice(1).replace(/[aeiou]/gi, "").charAt(0).toUpperCase();
        CURP[10] = $("#apellido_mat").val().slice(1).replace(/[aeiou]/gi, "").charAt(0).toUpperCase();
        CURP[11] = $("#nombre").val().slice(1).replace(/[aeiou]/gi, "").charAt(0).toUpperCase();

        return CURP.join("");
    }
}

function generarPlaceholderCURP() {
    $("#curp").attr("placeholder", generarCURP());
}

function validaCoincideCURP() {
    curpGenerada = generarCURP(); //CURP generada
    curpIngresada = $("#curp").val().substr(0, 16).toUpperCase(); //CURP ingresada
    if (!curpGenerada || curpGenerada.length != 16) {
        //Si ya existe el mensaje que lo borre
        if ($("#error-curp-mensaje").length > 0) {
            $("#error-curp-mensaje").remove('p');
        }
        $("#error-curp").append('<p class="mensaje error" id="error-curp-mensaje">Por favor llene los datos anteriores</p>');
        $("#submit-docente").prop('disabled', true); //Desactivando el boton submit
    } else {
        //Si ya existe el mensaje que lo borre
        if ($("#error-curp-mensaje").length > 0) {
            $("#error-curp-mensaje").remove('p');
        }
        //Comprobando si coinciden las curp
        if (curpGenerada != curpIngresada) {
            //SI NO COINCIDEN
            //Si ya existe el mensaje que lo borre
            if ($("#error-curp-mensaje").length > 0) {
                $("#error-curp-mensaje").remove('p');
            }
            //Si no coinciden
            if (!$("#error-curp-mensaje").length > 0) {
                $("#error-curp").append('<p class="mensaje error" id="error-curp-mensaje">Los datos ingresados y la curp no coinciden</p>');
                $("#submit-docente").prop('disabled', true); //Desactivando el boton submit
                //$("#submit-docente").attr('onClick', 'errorClavesSubmit(this);');
            }
        } else {
            //SI COINCIDEN
            //Si ya coinciden y el mensaje existe; lo borra
            if ($("#error-curp-mensaje").length > 0) {
                $("#error-curp-mensaje").remove('p');
                $("#submit-docente").prop('disabled', false); //Activando el boton submit
            }
            //Si ya coinciden pero hacen falta los ultimos 2 caracteres
            if ($("#curp").val().length != 18) {
                $("#error-curp").append('<p class="mensaje error" id="error-curp-mensaje">La curp requiere 18 caracteres</p>');
                $("#submit-docente").prop('disabled', true); //Desactivando el boton submit
            }
            if ($("#curp").val().length == 18) {
                $("#submit-docente").prop('disabled', false); //Activando el boton submit
            }
        }
    }
    if (curpIngresada == "") {
        //Si se vacia el input curp; se quita el error
        if ($("#error-curp-mensaje").length > 0) {
            $("#error-curp-mensaje").remove('p');
            $("#submit-docente").prop('disabled', false); //Activando el boton submit
        }
    }
}

function errorClavesSubmit(e) {
    if (e) {
        $("#errores-formulario").append('<p class="mensaje error" id="error-formulario">Por favor revise con las claves unicas</p>');
    }
}