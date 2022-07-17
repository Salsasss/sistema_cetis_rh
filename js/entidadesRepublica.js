//Cambia de manera dinamica los municipios dependiendo el estado seleccionado'
$(document).ready(function() {
    $("#id_estado option:selected").each(function() {
        id_docente = $('#id_docente').text();
        id_estado = $(this).val();
        $.post("control/ctrlEditarEstados.php", { id_docente: id_docente, id_estado: id_estado }, function(data) {
            $("#id_municipio").html(data);
        });
    });
    setTimeout(() => { //esperamos tiempo para que JS reconozca que hay un municipio seleccionado
        $("#id_municipio option:selected").each(function() {
            id_docente = $('#id_docente').text();
            id_municipio = $(this).val();
            $.post("control/ctrlEditarMunicipios.php", { id_docente: id_docente, id_municipio: id_municipio }, function(data) {
                $("#id_localidad").html(data);
            });
        });
    }, 100);
});

//Cambia de manera dinamica los municipios dependiendo el estado seleccionado
$(document).ready(function() {
    $("#id_estado").on('change', function() {
        $("#id_estado option:selected").each(function() {
            id_estado = $(this).val();
            $.post("control/ctrlEstados.php", { id_estado: id_estado }, function(data) {
                $("#id_municipio").html(data);
            });
        });
    });
});

//Cambia de manera dinamica las entidades dependiendo el municipio seleccionado
$(document).ready(function() {
    $("#id_municipio").on('change', function() {
        $("#id_municipio option:selected").each(function() {
            id_municipio = $(this).val();
            $.post("control/ctrlMunicipios.php", { id_municipio: id_municipio }, function(data) {
                $("#id_localidad").html(data);
            });
        });
    });
});