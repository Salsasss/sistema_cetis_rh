<?php
verificarSesion();
validaPermisoOperacion(13);
if($_SERVER['REQUEST_METHOD']==='POST'){
    $usuario = new CUsuario($_POST['usuario']);
}else if(!isset($usuario)){
    $usuario = new CUsuario();
}
?>
<section class="seccion contenedor">
    <h2 class="titulo">Nuevo Usuario</h2>
    <form class="formulario nuevo-usuario" action="" method="POST">
        <fieldset>
            <legend>Datos del Usuario</legend>
            <label for="">Nombre de Usuario:</label>
            <input type="text" name="usuario[nombre]" id="usunom" value="<?php echo sanitizar($usuario->nombre) ?>" required>

            <label for="">Correo electr&oacute;nico:</label>
            <input type="email" name="usuario[correo]" id="usucorreo" value="<?php echo sanitizar($usuario->correo) ?>" required>

            <label for="">Rango de la Cuenta</label>
            <select name="usuario[id_rango]" id="id_rango" required>
                <option value="" <?php if(empty($usuario->id_rango)) echo 'selected'?> disabled>-Seleccione-</option>
                <option value="Administrador" <?php if(sanitizar($usuario->id_rango)=='Administrador') echo 'selected'?> >Administrador</option>
                <option value="Asistente" <?php if(sanitizar($usuario->id_rango)=='Asistente') echo 'selected'?> >Asistente</option>
            </select>
        </fieldset>
        <div class="contenido-submit">
            <input type="submit" class="boton verde submit" name="" value="Registrar Usuario">
        </div>        
    </form>
    <script src="js/validaNuevoUsuario.js"></script>
    <?php
    if($_SERVER['REQUEST_METHOD']==='POST'){            
        include('control/usuarios/ctrlNuevoUsuario.php');        
    }
    ?>
</section>