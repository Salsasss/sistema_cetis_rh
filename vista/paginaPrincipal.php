<header class="site-header">        
    <div class="header">
        <div class="barra-superior">
            <a href="index.php">                    
                <img class="logo" src="multimedia/imagenes/logo-svg.svg" alt="logotipo del CETis 15">
            </a>         
            <nav class="navegacion">            
                <div class="enlaces-externos">
                    <a class="enlace" href="http://www.cetis15.edu.mx" target="_blank">
                        <img class="icono" src="multimedia/imagenes/web.svg" alt="logotipo del CETis 15">
                    </a>
                    <a class="enlace" href="https://www.facebook.com/Cetis-15-Vinculación-Epigmenio-González-227631599207658/" target="_blank">
                        <img class="icono facebook" src="multimedia/imagenes/facebook.svg" alt="logotipo del CETis 15">
                    </a>       
                </div>
                <p class="enlace">Hola, <?php
                    if(isset($_SESSION['id_usuario']) && !empty($_SESSION['id_usuario'])){
                        $usu = CUsuario::find($_SESSION['id_usuario']);
                        if($usu){
                            echo $usu->nombre;
                        }
                    }
                ?></p>
                <a class="enlace cerrar-sesion"href="?opc=13">Cerrar Sesi&oacute;n</a>
            </nav>
        </div>
    </div>    
</header>
<div class="mobile-menu">
    <img class="iconos-menu" src="multimedia/imagenes/barras.svg" alt="iconos-menu">
</div>
<div class="barra-opciones">        
    <a class="opcion principal <?php if(isset($_GET['opc']) && !empty($_GET['opc']) && $_GET['opc']==1) echo 'seleccionada'?>" href="?opc=1">Alta de Docente</a>
    <a class="opcion principal <?php if(!isset($_GET['opc']) || $_GET['opc']==2) echo 'seleccionada'?>" href="?opc=2">Lista de Docentes</a>
    <a class="opcion principal <?php if(isset($_GET['opc']) && !empty($_GET['opc']) && $_GET['opc']==4) echo 'seleccionada'?>" href="?opc=4">Permisos Econ&oacute;micos</a>
    <a class="opcion principal <?php if(isset($_GET['opc']) && !empty($_GET['opc']) && $_GET['opc']==3) echo 'seleccionada'?>" href="?opc=3">Procesos Prejubilatorios</a>
    <?php
        if(validaPermisoOperacion(12,false)){
            ?> <a href="?opc=5" <?php if(isset($_GET['opc']) && !empty($_GET['opc'])){if($_GET['opc']==5){echo 'class="opcion principal seleccionada"';}else{echo 'class="opcion principal "';}}else{echo 'class="opcion principal "';} ?> > Administrar Usuarios</a> <?php
        }
    ?>
</div>
<div class="contenedor-errores">
    <?php
        if(!isset($_SESSION['id_usuario']) && empty($_SESSION['id_usuario'])){
            //Si no existe la sesion
            include('inicioSesion.php');
            include('control/usuarios/ctrlInicioSesion.php');
        }else{
            include ('control/ctrlPrincipal.php');        
        }
    ?>
</div>
<footer class="footer <?php if(isset($_GET['opc']) && !empty($_GET['opc']) && $_GET['opc']==2){echo 'fixed';}?>">
    <div class="footer-contenido">
        <div class="derechos">
            <p>Aar&oacute;n Salas Ch&aacute;vez <?php echo $anio = Date('Y'); ?> &copy;</p>
        </div>      
    </div>
</footer>
<script src="js/navegacion.js"></script>    
