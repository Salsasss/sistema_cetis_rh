<?php
$usuario = CUsuario::find($_GET['id_usuario']);
if(isset($_SESSION['recuperar']) && !empty($_SESSION['recuperar'])){    
    ?>
    <div class="inicio-sesion" >
        <div class="contenedor-fieldset">
            <div class="contenido-recuperar">
                <div class="campo">
                    <p class="parrafo blanco centrar-texto">Nombre de Usuario: </p>
                    <p class="dato"><?php echo $usuario->nombre ?></p>
                </div>
                <div class="campo">
                    <p class="parrafo blanco centrar-texto">Rango de la Cuenta: </p>
                    <p class="dato"><?php echo getRango($usuario->id_rango) ?></p>
                </div>
                <a class="boton azul submit accion-recuperar" href="?recuperar=<?php echo $_SESSION['recuperar']?>&id_usuario=<?php echo $_GET['id_usuario']?>&generar=1">Generar Nueva Contrase&ntilde;a</a>                
            </div>
        </div>
        <div class="mensaje-sesion-recuperar">        
            <?php
                include('control/usuarios/recuperarCuenta/ctrlNuevoPassword.php');            
            ?>
        </div>
    </div>
    <?php
}
?>
