function generarRFC() {
    if (
        ($("#nombre").val() != "") &&
        ($("#apellido_pat").val() != "") &&
        ($("#apellido_mat").val() != "") &&
        ($("#fecha_nac").val() != "")
    ) {
        dia = $("#fecha_nac").val().substr(8, 2);
        mes = $("#fecha_nac").val().substr(5, 2);
        anio = $("#fecha_nac").val().substr(2, 2);

        var RFC = [];
        RFC[0] = $("#apellido_pat").val().charAt(0).toUpperCase();
        RFC[1] = $("#apellido_pat").val().slice(1).replace(/[^aeiou]/gi, "").charAt(0).toUpperCase();
        RFC[2] = $("#apellido_mat").val().charAt(0).toUpperCase();
        RFC[3] = $("#nombre").val().charAt(0).toUpperCase();
        RFC[4] = anio;
        RFC[5] = mes;
        RFC[6] = dia;

        return RFC.join("");
    }
}

function generarPlaceholderRFC() {
    $("#rfc").attr("placeholder", generarRFC());
}

function validaCoincideRFC() {
    rfcGenerada = generarRFC(); //RFC generada
    rfcIngresada = $("#rfc").val().substr(0, 10).toUpperCase(); //RFC ingresada
    if (!rfcGenerada || rfcGenerada.length != 10) {
        //Si ya existe el mensaje que lo borre
        if ($("#error-rfc-mensaje").length > 0) {
            $("#error-rfc-mensaje").remove('p');
        }
        $("#error-rfc").append('<p class="mensaje error" id="error-rfc-mensaje">Por favor llene los datos anteriores</p>');
        $("#submit-docente").prop('disabled', true); //Desactivando el boton submit
    } else {
        //Si ya existe el mensaje que lo borre
        if ($("#error-rfc-mensaje").length > 0) {
            $("#error-rfc-mensaje").remove('p');
        }
        //Comprobando si coinciden las rfc
        if (rfcGenerada != rfcIngresada) {
            //SI NO COINCIDEN
            //Si ya existe el mensaje que lo borre
            if ($("#error-rfc-mensaje").length > 0) {
                $("#error-rfc-mensaje").remove('p');
            }
            //Si no coinciden
            if (!$("#error-rfc-mensaje").length > 0) {
                $("#error-rfc").append('<p class="mensaje error" id="error-rfc-mensaje">Los datos ingresados y el rfc no coinciden</p>');
                $("#submit-docente").prop('disabled', true);
                //$("#submit-docente").attr('onClick', 'errorClavesSubmit(this);');
            }
        } else {
            //SI COINCIDEN
            //Si ya coinciden y el mensaje existe; lo borra
            if ($("#error-rfc-mensaje").length > 0) {
                $("#error-rfc-mensaje").remove('p');
                $("#submit-docente").prop('disabled', false);
            }
            //Si ya coinciden pero hacen falta los ultimos 2 caracteres
            if ($("#rfc").val().length != 13) {
                $("#error-rfc").append('<p class="mensaje error" id="error-rfc-mensaje">El rfc requiere 13 caracteres</p>');
                $("#submit-docente").prop('disabled', true); //Desactivando el boton submit
            }
            if ($("#rfc").val().length == 13) {
                $("#submit-docente").prop('disabled', false); //Activando el boton submit
            }
        }
        if (rfcIngresada == "") {
            //Si se vacia el input rfc; se quita el error
            if ($("#error-rfc-mensaje").length > 0) {
                $("#error-rfc-mensaje").remove('p');
                $("#submit-docente").prop('disabled', false);
            }
        }
    }
}

function errorClavesSubmit(e) {
    if (e) {
        $("#errores-formulario").append('<p class="mensaje error" id="error-formulario">Por favor revise con las claves unicas</p>');
    }
}