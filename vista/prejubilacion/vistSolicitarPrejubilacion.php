<?php
verificarSesion();
validaPermisoOperacion(7);
if(isset($_GET['id_docente']) && !empty($_GET['id_docente']) ){
    $id = $_GET['id_docente']; 
    $docente = CDocente::find($id);
    ?>
    <section class="contenedor">
        <h2 class="titulo">Proceso Prejubilatorio</h2>
        <div class="informacion-docente">
            <div>
                <div class="campo-informacion">
                    <p class="parrafo texto-derecha">Clave del Docente:</p>
                    <p class="dato"><?php echo $docente->id_docente?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo texto-derecha">Nombre Completo:</p>    
                    <p class="dato"><?php echo $docente->nombre?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo texto-derecha">Sexo:</p>
                    <p class="dato"><?php echo $docente->sexo?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo texto-derecha">Edad:</p>
                    <p class="dato"><?php echo calculaEdad($docente->fecha_nac)?> a&ntilde;os</p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo texto-derecha">A&ntilde;os de Servicio:</p>
                    <p class="dato"><?php echo calculaEdad($docente->fecha_ingreso)?> a&ntilde;os</p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo texto-derecha">Fecha de Nacimiento:</p>
                    <p class="dato"><?php echo $docente->fecha_nac?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo texto-derecha">Tel&eacute;fono Celular:</p>
                    <p class="dato"><?php echo $docente->getTelefono(); ?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo">Estado</p>
                    <p class="dato"><?php echo getEstado($docente->id_estado) ?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo">Municipio</p>
                    <p class="dato"><?php echo getMunicipio($docente->id_municipio) ?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo">Localidad</p>
                    <p class="dato"><?php echo getLocalidad($docente->id_localidad) ?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo">Colonia</p>
                    <p class="dato"><?php echo $docente->colonia ?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo">Calle:</p>
                    <p class="dato"><?php echo $docente->calle ?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo">Numero Interior:</p>
                    <p class="dato"><?php echo $docente->numero_int ?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo">Numero Exterior:</p>
                    <p class="dato"><?php echo $docente->numero_ext ?></p>
                </div>                    
                <div class="campo-informacion">
                    <p class="parrafo texto-derecha">Clave Única de Registro de Población (CURP):</p>
                    <p class="dato"><?php echo $docente->curp?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo texto-derecha">Número de Seguridad Social (NSS):</p>
                    <p class="dato"><?php echo $docente->nss?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo texto-derecha">Registro Federal de Contribuyentes (RFC):</p>
                    <p class="dato"><?php echo $docente->rfc?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo texto-derecha">Grado M&aacute;ximo de estudios:</p>
                    <p class="dato"><?php echo getGradoEstudios($docente->id_grado_estudio) ?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo texto-derecha">Horas impartidas por Paza:</p>
                    <p class="dato"><?php echo $docente->horas_plaza?> Horas</p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo texto-derecha">Fecha de Ingreso a la Instituci&oacute;n:</p>
                    <p class="dato"><?php echo $docente->fecha_ingreso?></p>
                </div>   
                <div class="campo-informacion">
                    <p class="parrafo texto-derecha">Fecha de Registro:</p>
                    <p class="dato"><?php echo $docente->fecha_registro?></p>
                </div>
            </div>        
        </div>
        <div class="contenedor-informacion-docente">
            <div class="contenido-submit">
                <a class="boton boton verde prejubilacion"href="?opc=10&pre=1&id_docente=<?php echo $docente->id_docente?>">Solicitar Proceso Prejubilatorio</a>
            </div>
        </div>
    </section> 
    <?php
}else{
    header('Location: index.php?opc=2');    
}
?>