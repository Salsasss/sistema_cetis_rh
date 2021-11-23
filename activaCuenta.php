<?php
    include('modelo/CConecta.php');
    include('modelo/CUsuario.php');
    include('control/database/database.php');
    include('control/funciones/ctrlFunciones.php');
    $db = conectarDB();
    CConecta::setDB($db);
    if(
        isset($_GET['id_usuario']) && 
        !empty($_GET['id_usuario']) && 
        strlen($_GET['id_usuario'])==6 
    ){
        $usuario = CUsuario::find($_GET['id_usuario']);
        $usuario->estatus = 1;
        if($usuario->actualizar()){
            header('location: index.php?opc=5');
        }
    }else{
        header('location: index.php?opc=2');
    }
?>