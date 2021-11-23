<section class="contenedor">        
    <?php
    verificarSesion();
    validaPermisoOperacion(1);
    if($_SERVER['REQUEST_METHOD']==='POST'){
        //Si se envian datos por POST
        $docente = new CDocente($_POST['docente']);
    }else if(!isset($docente) && !isset($docente)){
        $docente = new CDocente();
    }
    if(!isset($docente->id_docente)){
        ?> <h2 class="titulo">Alta de Docente</h2> <?php
    }else{
        ?> <h2 class="titulo">Editar Docente</h2> <?php
    }
    ?>
    <form class="formulario datos <?php if(isset($docente->id_docente)){echo 'editar';}?>" action="" method="POST" enctype="multipart/form-data">
        <fieldset>
            <?php if(isset($docente->id_docente)){ ?>
                <p class="parrafo-clave">Clave del Docente: </p><p class='clave'><?php echo sanitizar($docente->id_docente) ?></p>
            <?php } ?>            

            <label for="nombre">Nombre:</label>
            <input type="text" id='nombre' name="docente[nombre]" placeholder="Nombre del Docente" value="<?php echo sanitizar($docente->nombre) ?>" >

            <label for="apellido_pat">Apellido Paterno:</label>
            <input type="text" id='apellido_pat' name="docente[apellido_pat]" placeholder="Apellido Paterno del Docente" value="<?php echo sanitizar($docente->apellido_pat) ?>" >

            <label for="apellido_mat">Apellido Materno:</label>
            <input type="text" id='apellido_mat' name="docente[apellido_mat]" placeholder="Apellido Materno del Docente" value="<?php echo sanitizar($docente->apellido_mat) ?>" >
            
            <div class="campo-doble">              
                <div>
                    <label for="sexo">Sexo:</label>
                    <select name="docente[sexo]" id='sexo' >
                        <option value="" <?php if(empty($docente->sexo)) echo 'selected'?> disabled>~Seleccione~</option>
                        <option value="Masculino" <?php if(sanitizar($docente->sexo)=='Masculino') echo 'selected'?> >Masculino</option>
                        <option value="Femenino" <?php if(sanitizar($docente->sexo)=='Femenino') echo 'selected'?> >Femenino</option>
                    </select>
                </div>
                <div>
                    <label for="fecha_nac">Fecha de Nacimiento:</label>
                    <input class="fecha" type="date" id='fecha_nac' name='docente[fecha_nac]' max="<?php echo $anio = Date('Y-m-d');?>" value="<?php echo sanitizar($docente->fecha_nac) ?>" >
                </div>            
            </div>
            
            <label for="celular">Tel&eacute;fono Celular:</label>
            <input type="text" id='celular' name="docente[celular]" placeholder="10 Digitos" onkeyup="soloNumeros(this);" onkeypress="celula(this);" value="<?php echo sanitizar($docente->celular) ?>" >

            <label for="file_acta">Acta de Nacimiento (Documento Digital)</label>
            <input class="documentos" type="file" id="file_acta" name="docente_files[file_acta]" accept="application/pdf,image/jpg,image/jpeg,image/png" <?php if(!isset($docente->id_docente)) echo ''?> >

        </fieldset>
        <fieldset>            
                <div class="campo-doble">
                    <div>
                        <label for="colonia">Colonia:</label>
                        <input type="text" id='colonia' name="docente[colonia]" placeholder="Colonia del Docente" value="<?php echo sanitizar($docente->colonia) ?>">
                    </div>
                    <div>
                        <label for="calle">Calle:</label>
                        <input type="text" id='calle' name="docente[calle]" placeholder="Calle del Docente" value="<?php echo sanitizar($docente->calle) ?>">
                    </div>
                </div>

                <div class="campo-doble">
                    <div>
                        <label for="numero_int">N&uacute;mero Interior:</label>
                        <input type="text" id='numero_int' name="docente[numero_int]" placeholder="Numero interior de la vivienda" value="<?php echo sanitizar($docente->numero_int) ?>">
                    </div>
                    <div>
                    <label for="numero_ext">N&uacute;mero Exterior:</label>
                        <input type="text" id='numero_ext' name="docente[numero_ext]" placeholder="Numero exterior de la vivienda" value="<?php echo sanitizar($docente->numero_ext) ?>">
                    </div>
                </div>
        </fieldset>
        <fieldset>            
            <?php 
                if(isset($docente->id_docente)){
                    ?>
                    <div class="campo-doble">
                        <div></div>
                        <div class="centrar-texto"><p class="parrafo">Reemplazar Documentos (Opcional)</p></div>
                    </div>
                    <?php
                }
            ?>                

            <div class="campo-doble">
                <div>
                    <label for="curp">CURP:</label>
                    <input type="text" id='curp' name="docente[curp]" placeholder='Clave Única de Registro de Población'  maxlength="18" value="<?php echo sanitizar($docente->curp) ?>" >
                </div>
                <div>
                    <label for="file_curp">CURP (Documento Digital)</label>
                    <input class="documentos" type="file" id="file_curp" name="docente_files[file_curp]" accept="application/pdf,image/jpg,image/jpeg,image/png" <?php if(!isset($docente->id_docente)) echo ''?>>                    
                </div>            
            </div>
            <div class="campo-doble">
                <div>            
                    <label for="nss">NSS:</label>
                    <input type="number" id='nss' name="docente[nss]" placeholder='Número de Seguridad Social'onkeypress="maxnum(this,10);" value="<?php echo sanitizar($docente->nss) ?>" >
                </div>               
                <div>
                    <label for="file_nss">NSS (Documento Digital)</label>
                    <input class="documentos" type="file" id="file_nss" name="docente_files[file_nss]" accept="application/pdf,image/jpg,image/jpeg,image/png" <?php if(!isset($docente->id_docente)) echo ''?>>                    
                </div>
            </div>
            <div class="campo-doble">
                <div>
                    <label for="rfc">RFC:</label>
                    <input type="text" id='rfc' name="docente[rfc]" placeholder='Registro Federal de Contribuyentes'  maxlength="13" value="<?php echo sanitizar($docente->rfc) ?>">      
                </div>                
                <div>                
                    <label for="file_rfc">RFC (Documento Digital)</label>
                    <input class="documentos" type="file" id="file_rfc" name="docente_files[file_rfc]" accept="application/pdf,image/jpg,image/jpeg,image/png" <?php if(!isset($docente->id_docente)) echo ''?>>                    
                </div>                            
            </div>
            <label for="grado_estudios">Grado de Estudios:</label>
            <select id="grado_estudios" name="docente[grado_estudios]">
                <option value="" <?php if(empty($docente->grado_estudios)) echo 'selected'?> disabled>~Seleccione~</option>
                <option value="Universidad" <?php if(sanitizar($docente->grado_estudios)=='Universidad') echo 'selected'?>>Universidad</option>
                <option value="Maestria" <?php if(sanitizar($docente->grado_estudios)=='Maestria') echo 'selected'?>>Maestria</option>
                <option value="Doctorado" <?php if(sanitizar($docente->grado_estudios)=='Doctorado') echo 'selected'?>>Doctorado</option>
            </select>
            
            <label for="horas_plaza">Horas de la Plaza:</label>
            <input type="number" id='horas_plaza' name='docente[horas_plaza]' value="<?php echo sanitizar($docente->horas_plaza) ?>" >

            <label for="fecha_ingreso">Fecha de Ingreso a la Instituci&oacute;n</label>
            <input type="date" id='fecha_ingreso' name='docente[fecha_ingreso]' max="<?php echo $anio = Date('Y-m-d');?>" value="<?php echo sanitizar($docente->horas_plaza) ?>" >

        </fieldset>
        <div class="contenido-submit">
            <input class="boton verde submit" type="submit" value="<?php if(isset($docente->id_docente)){echo 'Guardar Cambios';}else{echo 'Registrar Docente';} ?>">
        </div>
        <?php
        if($_SERVER['REQUEST_METHOD']==='POST'){
            include('control/docentes/ctrlGuardarDocente.php');
        }    
        ?>
    </form>
    <!-- <script src="js/validaNuevoDocente.js"></script> -->
    <!-- <script src="js/validaDatosEntrada.js"></script> -->
    <!-- <script src="js/validaClavesUnicas.js"></script> -->
</section>
