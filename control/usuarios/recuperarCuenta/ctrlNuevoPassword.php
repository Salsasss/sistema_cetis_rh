<?php
if(isset($_GET['generar']) && !empty($_GET['generar']) &&  $_GET['generar']==1){
    //Generando la nueva contraseña
    $usuario->actualizarPassword();
    //Vaciando y destruyendo la sesion
    unset($_SESSION['recuperar']);
    //session_destroy();
    //Mensaje de exito
    ?> <p class="mensaje exito sesion">Compruebe su correo electr&oacute;nico, hemos enviado un correo con su nueva contrase&ntilde;a </p> <?php
}
?>
