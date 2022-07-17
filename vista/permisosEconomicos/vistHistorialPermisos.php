<?php
verificarSesion();
validaPermisoOperacion(10);
if(isset($_GET['id_docente']) && !empty($_GET['id_docente']) ){
    $id_docente = $_GET['id_docente']; 
    $_POST['id_docente'] = $id_docente;
    
    $docente = CDocente::find($id_docente);    
    $permisos = CPermiso::find($id_docente);
    
    ?>
    <section class="contenedor">
        <h2 class="titulo">Historial de Permisos Econ&oacute;micos</h2>
        <div class="informacion-docente">    
            <div class="campo-informacion">
                <p class="parrafo texto-izquierda">Clave del Docente</p>
                <p class="dato"><?php echo $docente->id_docente ?></p>
            </div>
            <div class="campo-informacion">
                <p class="parrafo texto-izquierda">Nombre</p>    
                <p class="dato"><?php echo $docente->nombre ?></p>
            </div>
            <div class="campo-informacion">
                <p class="parrafo texto-izquierda">Apellido Paterno</p>    
                <p class="dato"><?php echo $docente->apellido_pat ?></p>
            </div>
            <div class="campo-informacion">
                <p class="parrafo texto-izquierda">Apellido Materno</p>    
                <p class="dato"><?php echo $docente->apellido_mat ?></p>
            </div>
            <div class="campo-informacion">
                <p class="parrafo texto-izquierda">Permisos Disponibles</p>
                <p class="dato"><?php echo CPermiso::permisosDisponibles($docente->id_docente) ?> Permisos</p>    
            </div>
        </div>
        <div class="informacion-docente">
            <?php
                if(count($permisos) == 0){
                    ?> <p class="titulo-permiso largo">- No hay Permisos para mostrar -</p> <?php
                }else{
                    ?> <p class="titulo-permiso largo">- Permisos Utilizados -</p> <?php
                    $i = 0;
                    foreach($permisos as $permiso){
                        ?>                                            
                        <p class="titulo-permiso">Permiso N.<?php echo($i+1)?></p>
                        <div class="permiso">
                            <div class="campo-informacion">
                                <p class="parrafo texto-izquierda">Clave del Permiso </p>
                                <p class="dato" > <?php echo $permiso->id_permiso; ?></p>
                            </div>
                            <div class="campo-informacion">
                                <p class="parrafo texto-izquierda">Fecha Ausento </p>
                                <p class="dato" > <?php echo $permiso->fecha_ausento; ?></p>
                            </div>
                        </div>
                        <?php
                        $i++;
                    }
                }
            ?>
        </div>
        <div class="contenedor-informacion-docente">
            <div class="contenido-submit">
                <a class="boton verde" href="vista/reportes/reportesPermisosPDF.php?id_docente=<?php echo $docente->id_docente ?>" target="_blank">Generar Reporte Individual de Permisos (PDF)</a>
            </div>
        </div>
    </section> 
<?php
}else{
    header('Location: index.php?opc=2');
}
?>