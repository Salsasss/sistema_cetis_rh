<?php 
verificarSesion();
validaPermisoOperacion(4);
if(isset($_GET['id_docente']) && !empty($_GET['id_docente'])){
    $id = $_GET['id_docente'];
    $docente =  CDocente::find($id);
    $nombreCompuesto = $docente->id_docente.'_'.$docente->apellido_pat.'_'.$docente->apellido_mat;
    $documentos =  CDocumento::find($docente->id_docente);
    ?>
    <section class="contenedor">
        <h2 class="titulo">Documentos del Docente <?php echo $docente->nombre?></h2>
        <div class="parte-arriba-documento">
            <p class="nombre-documento">Acta de Nacimiento</p>
            <a class="boton verde descargar" href="documentosDocentes/<?php echo $nombreCompuesto.'/'.$documentos->file_acta?>" download='<?php echo $documentos->file_acta?>'>Descargar Documento</a>    
        </div>
        <div class="documento">
            <iframe src="documentosDocentes/<?php echo $nombreCompuesto.'/'.$documentos->file_acta?>" frameborder="0" load="lazy"></iframe>
        </div>
        <hr class="separador">
        <div class="parte-arriba-documento">
            <p class="nombre-documento">Clave Única de Registro de Población (CURP)</p>
            <a class="boton verde descargar" href="documentosDocentes/<?php echo $nombreCompuesto.'/'.$documentos->file_curp?>" download='<?php echo $documentos->file_curp?>'>Descargar Documento</a>    
        </div>
        <div class="documento">
            <iframe src="documentosDocentes/<?php echo $nombreCompuesto.'/'.$documentos->file_curp?>" frameborder="0" load="lazy"></iframe>
        </div>
        <hr class="separador">
        <div class="parte-arriba-documento">
            <p class="nombre-documento">Número de Seguridad Social (NSS)</p>
            <a class="boton verde descargar" href="documentosDocentes/<?php echo $nombreCompuesto.'/'.$documentos->file_nss?>" download='<?php echo $documentos->file_nss?>'>Descargar Documento</a>
        </div>
        <div class="documento">
            <iframe src="documentosDocentes/<?php echo $nombreCompuesto.'/'.$documentos->file_nss?>" frameborder="0" load="lazy"></iframe>
        </div>
        <hr class="separador">
        <div class="parte-arriba-documento">
            <p class="nombre-documento">Registro Federal de Contribuyentes (RFC)</p>
            <a class="boton verde descargar" href="documentosDocentes/<?php echo $nombreCompuesto.'/'.$documentos->file_rfc?>" download='<?php echo $documentos->file_rfc?>'>Descargar Documento</a>    
        </div>
        <div class="documento">
            <iframe src="documentosDocentes/<?php echo $nombreCompuesto.'/'.$documentos->file_rfc?>" frameborder="0"  load="lazy"></iframe>
        </div>
    </section> 
<?php
}else{
    header('Location: index.php?opc=2');
}
?>