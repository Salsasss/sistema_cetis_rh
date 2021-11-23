<?php 
verificarSesion();
validaPermisoOperacion(2);
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
    <h2 class="titulo">Lista de Docentes en el Sistema</h2>
    <div class="contenedor-grande">
        <div class="titulos-filtro">
            <p class="filtro-titulo">Buscador </p>
            <p class="filtro-titulo desktop">Visualizar por</p>
        </div>
        <div class="filtro">
            <?php
                include('vista/vistBuscador.php');
            ?>
            <p class="filtro-titulo mobil">Visualizar por</p>
            <div class="contenido-filtro ver-por">
                <a class="opcion redondo <?php if(!isset($_GET['ver']) && empty($_GET['ver'])){echo 'seleccionada';}?>" href="?opc=2<?php if(isset($_POST['nomBuscar']) && !empty($_POST['nomBuscar'])){echo '&nomBuscar='.$_POST['nomBuscar'];} ?>">Ver Todos</a>
                <a class="opcion redondo <?php if(isset($_GET['ver']) && !empty($_GET['ver'] && $_GET['ver']==1)){echo 'seleccionada';}?>" href="?opc=2&ver=1<?php if(isset($_POST['nomBuscar']) && !empty($_POST['nomBuscar'])){echo '&nomBuscar='.$_POST['nomBuscar'];} ?> ">Docentes Activos</a>
                <a class="opcion redondo <?php if(isset($_GET['ver']) && !empty($_GET['ver'] && $_GET['ver']==2)){echo 'seleccionada';}?>" href="?opc=2&ver=2<?php if(isset($_POST['nomBuscar']) && !empty($_POST['nomBuscar'])){echo '&nomBuscar='.$_POST['nomBuscar'];} ?> ">Docentes Dados de Baja</a>
                <a class="opcion redondo <?php if(isset($_GET['ver']) && !empty($_GET['ver'] && $_GET['ver']==3)){echo 'seleccionada';}?>" href="?opc=2&ver=3<?php if(isset($_POST['nomBuscar']) && !empty($_POST['nomBuscar'])){echo '&nomBuscar='.$_POST['nomBuscar'];} ?> ">Docentes en Proceso Prejubilatorio</a>
            </div>                        
        </div>           
    <?php    
    $query = 'docentes';
    $objeto = 'CDocente';
    //Buscador
    if(
        (isset($_POST['datoBuscar']) && !empty($_POST['datoBuscar']))
        &&
        (isset($_POST['nomBuscar']) && !empty($_POST['nomBuscar']))
    ){
        $datoBuscar = getDatoBuscarDocente($_POST['datoBuscar']);
        $nomBuscar = $_POST['nomBuscar'];
        $query .= ' WHERE '.$datoBuscar.' LIKE "%'.$_POST['nomBuscar'].'%"';
    }
    if(isset($_GET['ver']) && !empty($_GET['ver'])){
        if(isset($_POST['nomBuscar']) && !empty($_POST['nomBuscar'])){
            $query .= ' AND ';
        }else{
            $query .= ' WHERE ';
        }
        //Filtro
        $ver = $_GET['ver'];
        if($ver==1){
            $query .= "estado='Activo'";
        }
        if($ver==2){
            $query .= "estado='Inactivo'";
        }
        if($ver==3){
            $query .= "estado='Prejubilatorio'";
        }
    }

    $c = 'SELECT COUNT(*) FROM '.$query;
    $res = CConecta::$db->query($c);
    $cantPaginas = $res->fetch_assoc()['COUNT(*)'];

    //Solo se puede generar reportes de datos si hay docentes
    if($cantPaginas>0){
        ?>
            <div class="reporte-botones-ver">
                <div class="contenido-reporte-botones-ver contenedor-boton-reporte">
                    <div class="reporte">
                        <a class="boton verde reporte" href="vista/reportes/reportesDatosPDF.php?todos=1" target="_blank">Generar Reportes de Datos (PDF)</a>
                    </div>
                </div>
                <div class="contenedor-checks">
                    <div class="contenedor-check" for="check-ver">
                        <input class="check-ver" id="ver-direcciones" type="checkbox">
                        <label for="ver-direcciones">Ver Direcciones</label>
                    </div>
                    <div class="contenedor-check" for="check-ver">
                        <input class="check-ver" id="ver-grado" type="checkbox">
                        <label for="ver-grado">Ver Grado Grado M&aacute;ximo de Estudios</label>
                    </div>
                    <div class="contenedor-check" for="check-ver">
                        <input class="check-ver" id="ver-horas" type="checkbox">
                        <label for="ver-horas">Ver Horas por Plaza</label>
                    </div>
                </div>            
            </div>
        </div>
        <?php
    }
    include('control/paginador/ctrlPaginador.php');
   
    unset($_SESSION['reporte']);
    $_SESSION['reporte'] = $query;
    
    //Si no hay ningun docente en cada caso
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
        }else if(isset($ver)){
            ?> <h3 class="centrar-texto">Actualmente no hay Ning&uacute;n Docente<?php
            switch($ver){
                case 1: ?> Activo</h3> <?php
                    break;
                case 2: ?> Dado de Baja</h3> <?php
                    break;
                case 3: ?> en Proceso Prejubilatorio</h3> <?php
                    break;
                default:
            }
        }else{
            ?> <h3 class="centrar-texto">Actualmente no hay Ning&uacute;n Docente registrado en el sistema</h3><?php
        }
    }else{
        ?>
        <table class="tabla docentes">
            <tr class="fila cabecera titulo"><th colspan="21">Docentes en el Sistema</th></tr>
            <tr class="fila cabecera nombres-datos">
                <th>Estado</th>
                <th>Clave</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Sexo</th>
                <th>Edad</th>
                <th>Fecha Nacimiento</th>
                <th>Tel&eacute;fono Celular</th>
                <th class="direc">Colonia</th>
                <th class="direc">Calle</th>
                <th class="direc">Num. Exterior</th>
                <th class="direc">Num. Interior</th>
                <th>CURP</th>
                <th>NSS</th>
                <th>RFC</th>
                <th class="grado">Grado M&aacute;ximo de Estudios</th>
                <th class="horas">Horas por Plaza</th>
                <th>Fecha de registro</th>
                <th>Acciones</th>
            </tr>
            <?php      
            foreach($arregloPaginado as $docente){
                ?>
                <tr class="fila datos-docentes">
                    <td class='campo-tabla estado <?php echo $docente->estado ?>'> <p class="nombres-datos-mobile">Estado:</p> <p> <?php echo $docente->estado?> </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Clave:</p>  <p> <?php echo $docente->id_docente ?> </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Nombre:</p>  <p> <?php echo $docente->nombre ?> </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Apellido Paterno:</p>  <p> <?php echo $docente->apellido_pat ?> </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Apellido Materno:</p>  <p> <?php echo $docente->apellido_mat ?> </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Sexo:</p>  <p> <?php echo $docente->sexo ?> </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Edad:</p>  <p> <?php echo calculaEdad($docente->fecha_nac);?> A&ntilde;os </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Fecha de Nacimiento:</p>  <p> <?php echo $docente->fecha_nac ?> </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Tel&eacute;fono Celular:</p>  <p> <?php echo $docente->celular ?> </p> </td>
                    <td class="campo-tabla direc"> <p class="nombres-datos-mobile">Colonia:</p>  <p> <?php echo $docente->colonia ?> </p> </td>
                    <td class="campo-tabla direc"> <p class="nombres-datos-mobile">Calle:</p>  <p> <?php echo $docente->calle ?> </p> </td>
                    <td class="campo-tabla direc"> <p class="nombres-datos-mobile">Num. Exterior: </p>  <p> <?php echo $docente->numero_int ?> </p> </td>
                    <td class="campo-tabla direc"> <p class="nombres-datos-mobile">Num. Interior: </p>  <p> <?php echo $docente->numero_ext ?> </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">CURP:</p>  <p> <?php echo $docente->curp ?> </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">NSS:</p>  <p> <?php echo $docente->nss ?> </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">RFC:</p>  <p> <?php echo $docente->rfc ?> </p> </td>
                    <td class="campo-tabla grado"> <p class="nombres-datos-mobile">Grado M&aacute;ximo de Estudios:</p>  <p> <?php echo $docente->grado_estudios ?> </p> </td>
                    <td class="campo-tabla horas"> <p class="nombres-datos-mobile">Horas por Plaza:</p>  <p> <?php echo $docente->horas_plaza ?> Hrs </p> </td>
                    <td class="campo-tabla"> <p class="nombres-datos-mobile">Fecha de Ingreso:</p>  <p> <?php echo $docente->fecha_ingreso ?> </p> </td>
                    <td class="acciones">
                        <div class="contenedor-acciones">
                            <p class="boton verde mostrar-acciones grande">Acciones</p>
                            <ul class="submenu">
                                <li class="li-accion"><a class="boton accion editar" href="?opc=8&id_docente=<?php echo $docente->id_docente ?>">Editar Datos</a></li>
                                <li class="li-accion"><a class="boton accion editar" href="?opc=7&id_docente=<?php echo $docente->id_docente ?>">Ver Documentos</a></li>
                                <li class="li-accion"><a class="boton accion editar" href="?opc=6&id_docente=<?php echo $docente->id_docente ?>">Historial de Permisos</a></li>
                                <li class="li-accion">                                        
                                    <div class="contenedor-acciones-reporte">
                                        <p class="boton verde mostrar-acciones">Generar Reporte PDF</p>
                                        <ul class="submenu-dos">
                                            <li class="li-accion"><a class="boton accion editar" href="vista/reportes/reportesDatosPDF.php?todos=0&id_docente=<?php echo $docente->id_docente ?>" target="_blank">Reporte de Datos</a></li>
                                            <li class="li-accion desktop"><a class="boton accion editar" href="vista/reportes/reportesPermisosPDF.php?id_docente=<?php echo $docente->id_docente ?>" target="_blank">Reporte de Permisos</a></li>
                                            <?php
                                                if($docente->estado=='Prejubilatorio'){
                                                    ?><li class="li-accion"><a class="boton accion editar" href="vista/reportes/reportesPrejubilacionPDF.php?todos=0&id_docente=<?php echo $docente->id_docente ?>" target="_blank">Reporte de Prejubilaci&oacute;n</a></li><?php
                                                }
                                            ?>
                                        </ul>
                                    </div>
                                </li>                            
                                <li class="li-accion mobil"><a class="boton accion editar" href="vista/reportes/reportesPermisosPDF.php?id_docente=<?php echo $docente->id_docente ?>" target="_blank">Reporte de Permisos</a></li>
                                <?php
                                    if($docente->estado!='Inactivo'){//si el docente esta inactivo no se muestran los botones editar ni proceso de baja
                                        if(validaPermisoOperacion(5,false)){
                                            ?><li class="li-accion"><a class="boton accion eliminar" href="?opc=9&id_docente=<?php echo $docente->id_docente ?>">Proceso de Baja</a></li><?php
                                        }
                                    }
                                ?>
                            </ul>
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
<script>
    $(document).ready(function(){
        $('.direc').hide();
        $('.grado').hide();
        $('.horas').hide();


        $('#ver-direcciones').click(function(){
            if($('#ver-direcciones').is(':checked')){
                $('.direc').show();
            }else{
                $('.direc').hide();
            }
        });

        $('#ver-grado').click(function(){
            if($('#ver-grado').is(':checked')){
                $('.grado').show();
            }else{
                $('.grado').hide();
            }
        });

        $('#ver-horas').click(function(){
            if($('#ver-horas').is(':checked')){
                $('.horas').show();
            }else{
                $('.horas').hide();
            }
        });

    });

</script>