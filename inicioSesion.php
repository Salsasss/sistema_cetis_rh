<div class="contenido-izquierda">
    <h2 class="titulo-pagina">Sistema de Control de Recursos Humanos</h2>
</div>
<div class="derecha">
    <a href="index.php">
        <img class="logo-inicio" src="multimedia/imagenes/logo-svg.svg" alt="logotipo del CETis 15">
    </a>
    <?php
        if(isset($_GET['buscar']) && !empty($_GET['buscar']) && $_GET['buscar']==1){
            //Si se desea buscar una cuenta para su recuperacion
            include('vista/usuarios/recuperarCuenta/vistBuscarCuenta.php');
        }else if(isset($_SESSION['recuperar']) && !empty($_SESSION['recuperar']) && isset($_GET['recuperar']) && !empty($_GET['recuperar'])){
            //Si se desea generar una nueva contraseña
            if($_SESSION['recuperar'] == $_GET['recuperar']){                
                //Si la clave de seguridad es valida
                include('vista/usuarios/recuperarCuenta/vistNuevoPassword.php');
            }else{
                //Si la clave SESSION no coincide con la clave GET (se ha utilizado un link diferente)
                include('vista/vistInicioSesion.php');
                ?> <p class="mensaje error sesion">El enlace ha expirado. Por favor vuelva a intentarlo</p> <?php                        
            }
        }else if(isset($_GET['recuperar']) && !empty($_GET['recuperar'])){
            //Si no existe la clave SESSION (se ha utilizado el link despues de algun tiempo)
            include('vista/vistInicioSesion.php');
            ?> <p class="mensaje error sesion">El enlace ha expirado. Por favor vuelva a intentarlo</p> <?php                    
        }else{
            //Simplemente muestra el formulario de inicio de sesion
            include('vista/vistInicioSesion.php');
        }
    ?>
</div>
<!-- <script src="js/validaInicioSesion.js"></script> -->
