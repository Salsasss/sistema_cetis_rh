<form class="form-recuperar-cuenta" action="" method="POST">
    <fieldset class="contenedor-fieldset">
        <div class="contenido-recuperar chica">
            <div class="campo">
                <p class="parrafo blanco texto-izquierda">Ingresa tu correo electr&oacute;nico para poder buscar tu cuenta.</p>
                <input class="centrar-texto" type="email" name="correo-recuperar" id="correo" value="<?php if(isset($_POST['correo-recuperar']) && !empty($_POST['correo-recuperar']))echo $_POST['correo-recuperar']?>" required>
            </div>
            <div class="contenedor-buscar">
                <a class="boton cancelar accion-recuperar" href="?">Cancelar</a>
                <input class="boton azul submit accion-recuperar" type="submit" value="Buscar">
            </div>
        </div>
    </fieldset>
    <div class="mensaje-sesion-recuperar bajo">
        <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST'){   
                include('control/usuarios/recuperarCuenta/ctrlBuscarCuenta.php');
            }
        ?>
    </div>
</form>