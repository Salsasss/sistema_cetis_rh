<form class="inicio-sesion" action="" method="POST">
    <fieldset class="contenedor-fieldset">
        <div class="contenido-inicio">
            <div class="campo">
                <label for="correo">Correo Electr&oacute;nico</label>
                <input class="centrar-texto" type="email" name="correo" id="correo" value="<?php if(isset($_POST['correo']) && !empty($_POST['correo']))echo $_POST['correo']?>" required>
            </div>
            <div class="campo">
                <label for="password">Contrase&ntilde;a</label>
                <input class="password centrar-texto" id="password" type="password" maxlength="6" name="password" id="password" value="<?php if(isset($_POST['password'])&& !empty($_POST['password']))echo $_POST['password']?>" required>
                <!-- <div class="boton-mostrar-contra" type="button" onclick="mostrarContrasena()">Ver</div> -->
            </div>
            <input class="boton azul boton-centrado submit" type="submit" value="Iniciar Sesi&oacute;n">

            <a class="link-recuperar" href="?buscar=1">¿Olvidaste tu contrase&ntilde;a?</a>
        </div>
    </fieldset>
    <div class="mensaje-sesion">
        <?php
            include('control/usuarios/ctrlInicioSesion.php');
        ?>
    </div>
</form>