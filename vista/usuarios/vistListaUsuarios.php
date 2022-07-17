<?php 
verificarSesion();
validaPermisoOperacion(12);
if(
    (isset($_GET['datoBuscar']) && !empty($_GET['datoBuscar']))
    &&
    (isset($_GET['nomBuscar']) && !empty($_GET['nomBuscar']))
){
    if(!isset($_GET['cambio']) && empty($_GET['cambio'])){
        $_POST['datoBuscar'] = $_GET['datoBuscar'];
        $_POST['nomBuscar'] = $_GET['nomBuscar'];
    }
}
?>
<section class="seccion contenedor">
    <h2 class="titulo">Administrar Usuarios</h2>
    <div class="contenedor-grande">        
        <form class="formulario grande flex" action="index.php?opc=5&cambio=1" method="POST">        
            <div class="contenido-filtro buscador grande admin-usuarios">
                <div class="buscador-input">
                    <select name="datoBuscar">
                        <option value="1" <?php if(isset($_POST['datoBuscar']) && !empty($_POST['datoBuscar']) && $_POST['datoBuscar']==1)echo 'selected' ?> >Clave</option>
                        <option value="2" <?php if(isset($_POST['datoBuscar']) && !empty($_POST['datoBuscar']) && $_POST['datoBuscar']==2){echo 'selected';}if(!isset($_POST['datoBuscar'])){echo'selected';}?>>Nombre</option>
                        <option value="3" <?php if(isset($_POST['datoBuscar']) && !empty($_POST['datoBuscar']) && $_POST['datoBuscar']==3)echo 'selected' ?> >Correo Electr&oacute;nico</option>
                    </select>
                    <input type="text" name="nomBuscar" id="nomBuscar" placeholder="Usuario a Buscar" value="<?php if(isset($_POST['nomBuscar']) && !empty($_POST['nomBuscar']))echo $_POST['nomBuscar']?>">
                    <a href="#" onclick="document.forms[0].submit();return false;"><img class="boton-buscar" src="multimedia/imagenes/buscar.svg" /></a>
                </div>
                <a class="link-borrar-busqueda" href="?opc=5<?php echo '&nomBuscar='?>"><img class="borrar-busqueda" src="multimedia/imagenes/equis.svg" alt=""></a>
                <a class="opcion verde redondo grande boton-verde tablet nuevo-usuario" href="?opc=12&acc=2">Nuevo Usuario</a>
            </div>
        </form>
    </div>
    <a class="boton verde mobil" href="?opc=12&acc=2">Nuevo Usuario</a>
    <?php    
        $query = 'usuarios';
        $objeto = 'CUsuario';
        //Buscador
        if(
            (isset($_POST['datoBuscar']) && !empty($_POST['datoBuscar']))
            &&
            (isset($_POST['nomBuscar']) && !empty($_POST['nomBuscar']))
        ){
            $datoBuscar = getDatoBuscarUsuario($_POST['datoBuscar']);
            $nomBuscar = $_POST['nomBuscar'];
            $query .= ' WHERE '.$datoBuscar.' LIKE "%'.$_POST['nomBuscar'].'%" AND estatus=1';
        }
        include('control/paginador/ctrlPaginador.php');
        // //en caso de que este seleccionado una pagina que ya no exista
        // if(isset($_GET['pag']) && !empty($_GET['pag'] && $_GET['pag']>ceil(count($arregloSinPaginar)/6)-1)){
        //     $_GET['pag'] = ceil(count($arregloSinPaginar)/6)-1;
        // }
        //En caso de que no haya ningun usuario
        if(empty($arregloPaginado)){
            if(isset($_POST['datoBuscar']) && isset($nomBuscar)){
                ?> <h3 class="titulo">No se ha encontrado Ning&uacute;n Usuario de <?php
                switch($_POST['datoBuscar']){
                    case 1: ?> Clave "<?php echo $nomBuscar; ?>"</h3><?php
                        break;
                    case 2: ?> Nombre "<?php echo $nomBuscar; ?>"</h3><?php
                        break;
                    case 3: ?> Correo Electr&oacute;nico "<?php echo $nomBuscar; ?>"</h3><?php
                        break;
                    default:
                }      
            }else{
                ?> <h3 class="titulo">Actualmente no hay Ning&uacute;n Usuario registrado en el sistema</h3><?php
            }
        }else{
            ?>
            <div class="contenedor-mensajes">
            
            </div>
            <table class="tabla">
                <tr class="fila cabecera titulo"><th colspan="6">Usuarios en el Sistema</th></tr>
                <tr class="fila cabecera nombres-datos">
                    <th>Clave</th>
                    <th>Nombre de Usuario</th>
                    <th>Correo Electr&oacute;nico</th>
                    <th>Rango de la Cuenta</th>
                    <th>Fecha de Registro</th>
                    <th>Acci&oacute;n</th>
                </tr>
                <tr>
                <?php
                foreach($arregloPaginado as $usuario){
                    ?>
                    <tr class="fila datos-docentes">
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Clave:</p> <p> <?php echo $usuario->id_usuario ?> </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Nombre de Usuario:</p> <p> <?php echo $usuario->nombre ?> </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Correo Electr&oacute;nico:</p> <p> <?php echo $usuario->correo ?> </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Rango de la Cuenta:</p> <p> <?php echo getRango($usuario->id_rango) ?> </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Fecha de Registro:</p> <p> <?php echo $usuario->fecha_registro ?> </p> </td>
                    <td class="acciones">
                        <div class="contenedor-acciones-uno">                    
                            <a class="boton accion eliminar usuario" href="?opc=12&acc=4&id_usuario=<?php echo $usuario->id_usuario?>">Eliminar Usuario</a>
                        </div>                                     
                    </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        }
    ?>
    <script src="js/eliminarUsuario.js"></script>
</section>