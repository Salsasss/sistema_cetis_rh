<?php
if(isset($_POST['correo-recuperar']) && !empty($_POST['correo-recuperar'])){
    $correo = $_POST['correo-recuperar'];
    $usuario = CUsuario::find($correo, 'correo');
    //Si se encontro el usuario
    if(!empty($usuario)){
        $usuario->recuperarCuenta();
        ?> <p class="mensaje exito sesion">Compruebe su correo electr&oacute;nico, hemos enviado un correo con un enlace para restablecer su contrase&ntilde;a </p> <?php
    }else{
        ?> <p class="mensaje error sesion">No hubo ning&uacute;n resultado en la busqueda</p> <?php
    }
}else{
    ?> <p class="mensaje error sesion">Introduzca el correo a buscar</p> <?php
}

?>
