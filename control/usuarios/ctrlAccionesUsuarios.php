<?php 
verificarSesion();
if(isset($_GET['acc']) && !empty($_GET['acc'])){
    switch($_GET['acc']){
        case 1:
            include('ctrlInicioSesion.php');
            break;
        case 2:
            include('vista/usuarios/vistNuevoUsuario.php');
            break;     
        case 4:
            include('ctrlEliminarUsuario.php');
            break;        
        default: include('control/ctrlInicioSesion.php');
    }
}

?>