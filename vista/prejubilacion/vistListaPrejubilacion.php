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
    <h2 class="titulo">Docentes Aptos para proceso Prejubilatorio</h2>
    <div class="contenedor-grande">
        <?php
            include('vista/vistBuscador.php');
        ?>
    </div>
    <?php
    $query = 'SELECT * FROM docentes';
    $objeto = 'CDocente';
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
    $arregloSinPaginar = CDocente::aptosPrejubilacion($arreglo);
    
    //Solo se puede generar reportes de datos si hay docentes
    ?>
    <div class="reporte-chico">
        <a class="boton verde reporte" href="vista/reportes/reportesPrejubilacionPDF.php?id=1&todos=1" target="_blank">Generar Reporte de Prejubilaciones (PDF)</a>
    </div>
    <?php

    include('control/paginador/ctrlPaginadorArreglo.php');

    //Si no hay ningun Docente
    if(empty($arregloPaginado)){
        if(isset($_POST['datoBuscar']) && isset($nomBuscar)){
            ?> <h3 class="centrar-texto">No se ha encontrado Ning&uacute;n Docente de <?php
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
            ?> <h3 class="centrar-texto">Ning&uacute;n Docente cumple con los requisitos para el proceso Prejubilatorio</h3><?php
        }
    }else{
        ?>
        <table class="tabla contenedor-algo-grande">
            <tr class="fila cabecera titulo"><th colspan="10">Docentes Aptos para Prejubilaci&oacute;n</th></tr>
            <tr class="fila cabecera nombres-datos">
                <th>Clave</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Sexo</th>
                <th>Edad</th>
                <th>A&ntilde;os de Servicio</th>
                <th>Fecha de nacimiento</th>
                <th>Fecha de Ingreso a la Institución</th>
                <th>Acci&oacute;n</th>
            </tr>
            <?php        
            foreach($arregloPaginado as $docente){
                ?>
                <tr class="fila datos-docentes">
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Clave:</p> <p> <?php echo $docente->id_docente ?> </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Nombre:</p>  <p> <?php echo $docente->nombre ?> </p> </td>            
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Apellido Paterno:</p>  <p> <?php echo $docente->apellido_pat ?> </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Apellido Materno:</p>  <p> <?php echo $docente->apellido_mat ?> </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Sexo:</p>  <p> <?php echo $docente->sexo ?> </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Edad:</p>  <p> <?php echo calculaEdad($docente->fecha_nac);?> A&ntilde;os </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">A&ntilde;os de Servicio:</p>  <p> <?php echo calculaEdad($docente->fecha_ingreso);?> A&ntilde;os </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Fecha de Nacimiento:</p>  <p> <?php echo $docente->fecha_nac ?> </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Fecha de Ingreso a la Institución:</p>  <p> <?php echo $docente->fecha_ingreso ?> </p> </td>
                    <td class="acciones">
                        <?php
                            if($docente->estado=='Activo'){//si el docente esta inactivo no se muestran los botones editar ni proceso de baja                        
                                ?>                                
                                <div class="botones-acciones">                      
                                    <a class="boton accion editar" href="?opc=10&id_docente=<?php echo $docente->id_docente ?>">Solicitar Prejubilaci&oacute;n</a>
                                </div>
                                <?php
                            }
                        ?>
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