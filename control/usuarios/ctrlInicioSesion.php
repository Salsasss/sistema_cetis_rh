<?php 
if( 
    (isset($_POST['correo']) && !empty($_POST['correo']))
    &&
    (isset($_POST['password']) && !empty($_POST['password']) && validaLongitud(6,$_POST['password']))
){   
    $correo = CConecta::$db->escape_string($_POST['correo']);
    $password = CConecta::$db->escape_string($_POST['password']);

    $usuarioEncontrado = CUsuario::find($correo, 'correo');    
    if(!empty($usuarioEncontrado) && $usuarioEncontrado->estatus == 1){
        //Si se encontro el usuario
        $autenticado = password_verify($password, $usuarioEncontrado->password);        
        if($autenticado==true){
            //Si se verifico la contraseña
            $_SESSION['id_usuario'] = $usuarioEncontrado->id_usuario;
            $_SESSION['rango'] = $usuarioEncontrado->id_rango;
            $usuarioEncontrado->actualizarFecha();//Se actualiza la ultima vez que se inicio sesion
            //Mensaje de Exito
            ?><p class="mensaje exito sesion">¡Bienvenido!<p><?php
            //Redireccionando
            ?> <script type="text/javascript">setTimeout(() => {window.location="index.php"}, 1000) </script> <?php
        }else{
            ?><p class="mensaje error sesion">Contrase&ntilde;a Incorrecta<p><?php            
        }
    }else{
        ?><p class="mensaje error sesion">El Usuario no existe<p><?php
    }
}
?>