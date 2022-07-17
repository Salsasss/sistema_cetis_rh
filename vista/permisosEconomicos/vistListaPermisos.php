<?php 
verificarSesion();
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
<section class="seccion">
    <h2 class="titulo">Docentes con d&iacute;as de Ausento disponibles</h2>
    <div class="contenedor-grande">        
        <?php
            include('vista/vistBuscador.php');
        ?>
    </div>   
    <?php
        $query = 'SELECT * FROM docentes ';
        $objeto = 'CDocente';
        //Buscador
        if(
            (isset($_POST['datoBuscar']) && !empty($_POST['datoBuscar']))
            &&
            (isset($_POST['nomBuscar']) && !empty($_POST['nomBuscar']))
        ){
            $datoBuscar = getDatoBuscarDocente($_POST['datoBuscar']);
            $nomBuscar = $_POST['nomBuscar'];
            $query .= ' WHERE '.$datoBuscar.' LIKE "%'.$_POST['nomBuscar'].'%" AND estado="Activo"';
        }else{
            $query.= " WHERE estado='Activo'";
        }
        $arreglo = CConecta::consultarSQL($query);
        $arregloSinPaginar = CDocente::aptosPermiso($arreglo);
        ?>
            <div class="reporte-chico">
                <a class="boton verde reporte" href="vista/reportes/reportesPermisosPDF.php?todos=1" target="_blank">Generar Reporte de Permisos (PDF)</a>
            </div>
        <?php

        include('control/paginador/ctrlPaginadorArreglo.php');

        unset($_SESSION['reporte']);
        if(
            (!isset($_POST['datoBuscar']) && empty($_POST['datoBuscar']))
            &&
            (!isset($_POST['nomBuscar']) && empty($_POST['nomBuscar']))
        ){
            $_SESSION['reporte'] = 'SELECT * FROM docentes';
        }else{
            $_SESSION['reporte'] = $query;
        }
        
        //Si no hay ningun Docente
        if(empty($arregloSinPaginar)){
            if(isset($_POST['datoBuscar']) && isset($nomBuscar)){
                ?> <h3 class="titulo">No se ha encontrado Ning&uacute;n Docente de <?php
                switch($_POST['datoBuscar']){
                    case 1: ?> Clave "<?php echo $nomBuscar; ?>"</h3><?php
                        break;
                    case 2: ?> Nombre "<?php echo $nomBuscar; ?>"</h3><?php
                        break;
                    case 3: ?> Apellido Paterno "<?php echo $nomBuscar; ?>"</h3><?php
                        break;
                    case 4: ?> Apellido Materno "<?php echo $nomBuscar; ?>"</h3><?php
                        break;
                    default:
                }      
            }else{                
                ?> <h3 class="titulo">Ning&uacute;n Docente tiene Permisos Econ&oacute;micos disponibles</h3><?php
            }
        }else{            
            ?>            
            <table class="tabla contenedor">
                <tr class="fila cabecera titulo"><th colspan="7">Docentes con Permisos Econ&oacute;micos disponibles</th></tr>
                <tr class="fila cabecera nombres-datos">
                    <th>Clave</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Permisos Disponibles</th>            
                    <th class="acciones-dos">Acciones</th>
                </tr>
                <?php
                foreach($arregloPaginado as $docente){
                    $permisos = CPermiso::find($docente->id_docente);
                    ?>
                    <tr class="fila datos-docentes">
                        <td class="campo-tabla"> <p class="nombres-datos-mobile">Clave:</p> <p> <?php echo $docente->id_docente ?> </p> </td>
                        <td class="campo-tabla"> <p class="nombres-datos-mobile">Nombre:</p> <p> <?php echo $docente->nombre ?> </p> </td>
                        <td class="campo-tabla"> <p class="nombres-datos-mobile">Apellido Paterno:</p> <p> <?php echo $docente->apellido_pat ?> </p> </td>
                        <td class="campo-tabla"> <p class="nombres-datos-mobile">Apellido Materno:</p> <p> <?php echo $docente->apellido_mat ?> </p> </td>
                        <td class="campo-tabla"> <p class="nombres-datos-mobile">Permisos Disponibles:</p> <p> <?php echo CPermiso::permisosDisponibles($docente->id_docente) ?> </p> </td>            
                        <td class="acciones-dos">
                            <div class="contenedor-acciones-dos">
                                <a class="boton accion editar" href="?opc=6&id_docente=<?php echo $docente->id_docente?>">Historial de Permisos </a>
                                <a class="boton accion editar" href="?opc=11&id_docente=<?php echo $docente->id_docente?>">Solicitar Permiso Econ&oacute;mico</a>
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
</section>