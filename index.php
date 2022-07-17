<?php
date_default_timezone_set("America/Mexico_City");
session_start();




include('control/funciones/ctrlFunciones.php');
include('control/funciones/ctrlFuncionesDocumentos.php');
include('control/funciones/ctrlFuncionesObjetos.php');
include('control/database/database.php');
require('modelo/CConecta.php');
require('modelo/CDocente.php');
require('modelo/CBajaDocente.php');
require('modelo/CPrejubilacion.php');
require('modelo/CDocumento.php');
require('modelo/CPermiso.php');
require('modelo/CUsuario.php');
$db = conectarDB();
CConecta::setDB($db);

if(isset($_SESSION['id_usuario']) && !empty($_SESSION['id_usuario'])){
    //Si existe la variable SESSION 'id_usuario' y no esta vacia
    if(CUsuario::validaTiempo($_SESSION['id_usuario'])==false){
        unset($_SESSION['id_usuario']);
        unset($_SESSION['rango']);
        session_destroy();
        header('Location: ?');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sistema de Control de Recursos Humanos</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="multimedia/imagenes/logoClaro.png">    
    <link rel="stylesheet" href="css/base/globales.css">
    <link rel="stylesheet" href="css/base/variables.css">
    <link rel="stylesheet" href="css/layout/botones.css">
    <link rel="stylesheet" href="css/layout/mensajes.css">
    <link rel="stylesheet" href="css/layout/header.css">
    <link rel="stylesheet" href="css/layout/footer.css">
    <link rel="stylesheet" href="css/layout/inicioSesion.css">
    <link rel="stylesheet" href="css/layout/formularios.css">
    <link rel="stylesheet" href="css/layout/listaDocentes.css">
    <link rel="stylesheet" href="css/layout/vistaDocumentos.css">
    <link rel="stylesheet" href="css/layout/buscador.css">
    <link rel="stylesheet" href="css/layout/filtro.css">
    <link rel="stylesheet" href="css/layout/paginador.css">
    <link rel="stylesheet" href="css/layout/historialPermisos.css">
    <link rel="stylesheet" href="css/layout/listaPrejubilacion.css">
    <link rel="stylesheet" href="css/layout/informacionDocente.css">
    <link rel="stylesheet" href="css/layout/acciones.css">
    <link rel="stylesheet" href="css/layout/barraOpciones.css">
    <link rel="stylesheet" href="css/layout/navegacion.css">
    <link rel="stylesheet" href="css/layout/contenedorReportes.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/posicionarFooter.js"></script>
</head>
<body <?php if(!isset($_SESSION['id_usuario']) && empty($_SESSION['id_usuario'])){ echo 'class="fondo-todo"';}?>>
    <?php        
        if(!isset($_SESSION['id_usuario']) && empty($_SESSION['id_usuario'])){
            //Si no existe la sesion
            include('inicioSesion.php');
        }else{
            //Si ya existe muestra la pagina principal
            include('vista/paginaPrincipal.php');        
        }
    ?>        
    <script src="js/funciones.js"></script>
</body>
</html>
