<?php
verificarSesion();
validaPermisoOperacion(9);
if(isset($_GET['id_docente']) && !empty($_GET['id_docente']) ){
    $id_docente = $_GET['id_docente'];
    $docente = CDocente::find($id_docente);
    ?>
    <section class="contenedor">
        <h2 class="titulo">Solicitar Permiso Econ&oacute;mico</h2>
        <div class="informacion-docente">
        <p class="parrafo-clave">Clave del Docente: </p>
        <p class='clave'><?php echo $docente->id_docente ?></p>

        <p class="parrafo-clave">Nombre Completo: </p>
        <p class="dato izquierda"><?php echo $docente->nombre.' '.$docente->apellido_pat.' '.$docente->apellido_mat ?></p>

        <p class="parrafo-clave">Permisos Disponibles: </p>
        <p class="dato izquierda"><?php echo CPermiso::permisosDisponibles($docente->id_docente) ?> Permisos</p>    

        <form action="" method="POST" class="formulario solicitar-permiso">
            <label for="">Fecha en la cual se usara el Permiso Econ&oacute;mico:</label>
            <input class="fecha" type="date" name="fechaPermiso" id="fechaPermiso"
            min="<?php echo $min = Date('Y-m-d');?>"
            max="<?php $anio = Date('Y');$mes = Date('m')+1;
            if(strlen($mes)==1){
                $mes = '0'.$mes;
            }
            if($mes=='01'||$mes=='03'||$mes=='05'||$mes=='07'||$mes=='08'||$mes=='10'||$mes=='12'){$dia=31;}
            else if($mes=='02'){echo $dia=28;}
            else{$dia=30;}
            echo $anio.'-'.$mes.'-'.$dia;
            ?>" required>
            <div class="contenido-submit">
                <input class="boton verde boton-permiso" type="submit" value="Solicitar Permiso Econ&oacute;mico">
            </div>
        </div>        
        </form>
    </section>
    <script src="js/funciones.js"></script>
    <script src="js/validarNuevoPermiso.js"></script>
    <?php
}else{
    header('Location: index.php?opc=2');
}
?>