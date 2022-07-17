<?php
if($usuario->validar()){
    //Si no falta ningun dato
    $correoRepetido = CUsuario::find($usuario->correo, 'correo');
    if(!empty($correoRepetido)){
        //Si el correo ya esta registrado
        ?> <p class="mensaje error contenedor-chico">No es posible utilizar un Correo Electr&oacute;nico ya registrado<p> <?php
    }else if($usuario->registroMail()){
        //Si se envio el correo
        $usuario->guardar();
        ?> <p class="mensaje exito contenedor-chico">Para Finalizar el registro compruebe su correo electr&oacute;nico, hemos enviado un correo con un enlace para Activar su cuenta<p> <?php
    }
}

?>
