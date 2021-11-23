<?php
verificarSesion();
validaPermisoOperacion(5);
if(isset($_GET['id_docente']) && !empty($_GET['id_docente']) ){
    $id = $_GET['id_docente']; 
    $docente = CDocente::find($id);
    ?>
    <section class="contenedor">
        <h2 class="titulo">Dando de Baja al Docente</h2>
        <div class="informacion-docente">
            <div>
                <div class="campo-informacion">
                    <p class="parrafo">Clave del Docente:</p>
                    <p class="dato"><?php echo $docente->id_docente ?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo">Nombre Completo:</p>    
                    <p class="dato"><?php echo $docente->nombre ?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo">Sexo:</p>
                    <p class="dato"><?php echo $docente->sexo ?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo">Edad:</p>
                    <p class="dato"><?php echo calculaEdad($docente->fecha_nac) ?> a&ntilde;os</p>
                </div>                       
                <div class="campo-informacion">
                    <p class="parrafo">Fecha de Nacimiento:</p>
                    <p class="dato"><?php echo $docente->fecha_nac ?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo">Tel&eacute;fono Celular</p>
                    <p class="dato"><?php echo $docente->celular ?></p>
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
                    <p class="parrafo">Clave Única de Registro de Población (CURP):</p>
                    <p class="dato"><?php echo $docente->curp ?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo">Número de Seguridad Social (NSS):</p>
                    <p class="dato"><?php echo $docente->nss ?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo">Registro Federal de Contribuyentes (RFC):</p>
                    <p class="dato"><?php echo $docente->rfc ?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo">Grado M&aacute;ximo de estudios:</p>
                    <p class="dato"><?php echo $docente->grado_estudios ?></p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo">Horas impartidas por Paza:</p>
                    <p class="dato"><?php echo $docente->horas_plaza ?> Horas</p>
                </div>
                <div class="campo-informacion">
                    <p class="parrafo">Fecha de Ingreso a la Instituci&oacute;n:</p>
                    <p class="dato"><?php echo $docente->fecha_ingreso ?></p>             
                </div>
                <div class="campo-informacion">
                    <p class="parrafo">Fecha de Registro en el Sistema:</p>
                    <p class="dato"><?php echo $docente->fecha_registro ?></p>             
                </div>
            </div>
            <form class="formulario baja" action="?opc=9&id_docente=<?php echo $docente->id_docente?>" method="POST">
                <label for="motivo">Motivo: </label>
                <textarea name="motivo" id="motivo" cols="30" rows="10" placeholder="Motivo por el cual se Da de Baja al Docente" required></textarea>        
                <div class="contenido-submit">                
                    <input class="boton verde submit boton-baja " type="submit" value="Dar Docente de Baja Definitiva">            
                </div>
            </form>
        </div>
        <!-- <script src="js/validaBaja.js"></script> -->
    </section>
<?php
}else{
    header('Location: index.php?opc=2');
}
 ?>