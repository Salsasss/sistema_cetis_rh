<section class="contenedor">        
    <?php
    verificarSesion();
    validaPermisoOperacion(1);
    if($_SERVER['REQUEST_METHOD']==='POST'){
        //Si se da click en submit 
        $docente = new CDocente($_POST['docente']);
        //Igualando la PK del objeto cuando se edita
        if(isset($_GET['id_docente'])){
            $docente->id_docente = $_GET['id_docente'];
        }
        include('control/docentes/ctrlGuardarDocente.php');
    }else if(!isset($docente)){
        //Alta docente
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
                <p class="parrafo-clave">Clave del Docente: </p><p id="id_docente" class='clave'><?php echo sanitizar($docente->id_docente) ?></p>
            <?php } ?>            

            <label for="nombre">Nombre:</label>
            <input type="text" id='nombre' name="docente[nombre]" placeholder="Nombre del Docente" onkeyup="generarPlaceholderCURP(); generarPlaceholderRFC(); validaCoincideCURP(); validaCoincideRFC();"  value="<?php echo sanitizar($docente->nombre)?>" <?php if(!isset($docente->id_docente)) echo 'required'?> > 

            <label for="apellido_pat">Apellido Paterno:</label>
            <input type="text" id='apellido_pat' name="docente[apellido_pat]" placeholder="Apellido Paterno del Docente" onkeyup="generarPlaceholderCURP(); generarPlaceholderRFC(); validaCoincideCURP(); validaCoincideRFC();"  value="<?php echo sanitizar($docente->apellido_pat) ?>" <?php if(!isset($docente->id_docente)) echo 'required'?> >

            <label for="apellido_mat">Apellido Materno:</label>
            <input type="text" id='apellido_mat' name="docente[apellido_mat]" placeholder="Apellido Materno del Docente" onkeyup="generarPlaceholderCURP(); generarPlaceholderRFC(); validaCoincideCURP(); validaCoincideRFC();"  value="<?php echo sanitizar($docente->apellido_mat) ?>" <?php if(!isset($docente->id_docente)) echo 'required'?> >
            
            <div class="campo-doble">              
                <div>
                    <label for="sexo">Sexo:</label>
                    <select name="docente[sexo]" id='sexo' onkeyup="generarPlaceholderCURP(); validaCoincideCURP();" onchange="generarPlaceholderCURP(); validaCoincideCURP();" <?php if(!isset($docente->id_docente)) echo 'required'?> >
                        <option value="" <?php if(empty($docente->sexo)) echo 'selected'?> disabled>-Seleccione-</option>
                        <option value="Masculino" <?php if(sanitizar($docente->sexo)=='Masculino') echo 'selected'?> >Masculino</option>
                        <option value="Femenino" <?php if(sanitizar($docente->sexo)=='Femenino') echo 'selected'?> >Femenino</option>
                    </select>
                </div>
                <div>
                    <label for="fecha_nac">Fecha de Nacimiento:</label>
                    <input class="fecha" type="date" id='fecha_nac' name='docente[fecha_nac]' max="<?php echo $fecha = date('Y-m-d');?>" onkeyup="generarPlaceholderCURP(); generarPlaceholderRFC(); validaCoincideCURP(); validaCoincideRFC();" onchange="generarPlaceholderCURP(); generarPlaceholderRFC(); validaCoincideCURP(); validaCoincideRFC();" value="<?php echo sanitizar($docente->fecha_nac) ?>" <?php if(!isset($docente->id_docente)) echo 'required'?> >
            </div>
            </div>
            
            <label for="celular">Tel&eacute;fono Celular:</label>
            <input type="text" id='celular' name="docente[celular]" placeholder="10 Digitos" onkeyup="soloNumeros(this);" onkeypress="celula(this);" value="<?php if(!isset($docente->id_docente)){echo sanitizar($docente->celular);}else{echo sanitizar($docente->getTelefono());} ?>" <?php if(!isset($docente->id_docente)) echo 'required'?> >

            <label for="file_acta">Acta de Nacimiento (Documento Digital)</label>
            <input class="documentos" type="file" id="file_acta" name="docente_files[file_acta]" accept="application/pdf,image/jpg,image/jpeg,image/png" <?php if(!isset($docente->id_docente)) echo ''?> <?php if(!isset($docente->id_docente)) echo 'required'?> >

        </fieldset>
        <fieldset>
            <div class="campo-doble">
                <div>
                    <label for="id_estado">Estado:</label>
                    <select name="docente[id_estado]" id="id_estado" onkeyup="generrPlaceholderCURP(); validaCoincideCURP();" onchange="generarPlaceholderCURP(); validaCoincideCURP();" <?php if(!isset($docente->id_docente)) echo 'required'?> >
                        <option value="" selected disabled>-Seleccione-</option>
                        <?php
                        $estados = array('Aguascalientes','Baja California','Baja California Sur','Campeche','Chiapas','Chihuahua','Coahuila de Zaragoza','Colima','Ciudad de México','Durango','Guanajuato','Guerrero','Hidalgo','Jalisco','Estado de Mexico','Michoacan de Ocampo','Morelos','Nayarit','Nuevo Leon','Oaxaca','Puebla','Queretaro de Arteaga','Quintana Roo','San Luis Potosi','Sinaloa','Sonora','Tabasco','Tamaulipas','Tlaxcala','Veracruz de Ignacio de la Llave','Yucatan','Zacatecas');
                        $i = 1;
                        foreach($estados as $estado){
                            ?> <option value="<?php echo $i; ?>" <?php if(sanitizar($docente->id_estado)==$i) echo 'selected'?> > <?php echo $estado; ?> </option><?php
                            $i++;
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="id_municipio">Municipio:</label>
                    <select name="docente[id_municipio]" id="id_municipio" <?php if(!isset($docente->id_docente)) echo 'required'?> >                
                    </select>
                </div>
            </div>
            <div>
                <label for="id_localidad">Localidad:</label>
                <select name="docente[id_localidad]" id="id_localidad" <?php if(!isset($docente->id_docente)) echo 'required'?> >                
                </select>
            </div>
            <div class="campo-doble">
                <div>
                    <label for="colonia">Colonia:</label>
                    <input type="text" id='colonia' name="docente[colonia]" placeholder="Colonia del Docente" value="<?php echo sanitizar($docente->colonia) ?>" <?php if(!isset($docente->id_docente)) echo 'required'?> >
                </div>
                <div>
                    <label for="calle">Calle:</label>
                    <input type="text" id='calle' name="docente[calle]" placeholder="Calle del Docente" value="<?php echo sanitizar($docente->calle) ?>" <?php if(!isset($docente->id_docente)) echo 'required'?> >
                </div>
            </div>

            <div class="campo-doble">
                <div>
                    <label for="numero_int">N&uacute;mero Interior:</label>
                    <input type="text" id='numero_int' name="docente[numero_int]" placeholder="Numero interior de la vivienda" value="<?php echo sanitizar($docente->numero_int) ?>" <?php if(!isset($docente->id_docente)) echo 'required'?> >
                </div>
                <div>
                <label for="numero_ext">N&uacute;mero Exterior:</label>
                    <input type="text" id='numero_ext' name="docente[numero_ext]" placeholder="Numero exterior de la vivienda" value="<?php echo sanitizar($docente->numero_ext) ?>" <?php if(!isset($docente->id_docente)) echo 'required'?> >
                </div>
            </div>
        </fieldset>
        <fieldset>            
            <?php 
                if(isset($docente->id_docente)){
                    ?>
                    <div class="campo-doble">
                        <div></div>
                        <div><p class="parrafo">Reemplazar Documentos (Opcional)</p></div>
                    </div>
                    <?php
                }
            ?>
            <div class="campo-doble">
                <div>
                    <label for="curp">CURP:</label>
                    <input type="text" id='curp' name="docente[curp]" placeholder='Clave Única de Registro de Población' maxlength="18" onkeyup="mayus(this); generarPlaceholderCURP(); validaCoincideCURP();" value="<?php echo sanitizar($docente->curp) ?>" <?php if(!isset($docente->id_docente)) echo 'required'?> >
                </div>
                <div>
                    <label for="file_curp">CURP (Documento Digital)</label>
                    <input class="documentos" type="file" id="file_curp" name="docente_files[file_curp]" accept="application/pdf,image/jpg,image/jpeg,image/png" <?php if(!isset($docente->id_docente)) echo 'required'?> >
                </div>
            </div>
            <div id="error-curp"></div>
            <div class="campo-doble">
                <div>            
                    <label for="nss">NSS:</label>
                    <input type="number" id='nss' name="docente[nss]" placeholder="N&uacute;mero de Seguridad Social" onkeypress="maxnum(this,10);" value="<?php echo sanitizar($docente->nss) ?>" <?php if(!isset($docente->id_docente)) echo 'required'?> >
                </div>               
                <div>
                    <label for="file_nss">NSS (Documento Digital)</label>
                    <input class="documentos" type="file" id="file_nss" name="docente_files[file_nss]" accept="application/pdf,image/jpg,image/jpeg,image/png" <?php if(!isset($docente->id_docente)) echo 'required'?> >
                </div>
            </div>
            <div class="campo-doble">
                <div>
                    <label for="rfc">RFC:</label>
                    <input type="text" id='rfc' name="docente[rfc]" placeholder='Registro Federal de Contribuyentes' maxlength="13" onkeyup="mayus(this); generarPlaceholderRFC(); validaCoincideRFC();" value="<?php echo sanitizar($docente->rfc) ?>" <?php if(!isset($docente->id_docente)) echo 'required'?> >
                </div>
                <div>
                    <label for="file_rfc">RFC (Documento Digital)</label>
                    <input class="documentos" type="file" id="file_rfc" name="docente_files[file_rfc]" accept="application/pdf,image/jpg,image/jpeg,image/png" <?php if(!isset($docente->id_docente)) echo 'required'?> >
                </div>
            </div>
            <div id="error-rfc"></div>
            <label for="id_grado_estudio">Grado de Estudios:</label>
            <select id="id_grado_estudio" name="docente[id_grado_estudio]" <?php if(!isset($docente->id_docente)) echo 'required'?> >
                <option value="" <?php if(empty($docente->id_grado_estudio)) echo 'selected'?> disabled>-Seleccione-</option>
                <option value="1" <?php if(sanitizar($docente->id_grado_estudio)=='1') echo 'selected'?>>Universidad</option>
                <option value="2" <?php if(sanitizar($docente->id_grado_estudio)=='2') echo 'selected'?>>Maestria</option>
                <option value="3" <?php if(sanitizar($docente->id_grado_estudio)=='3') echo 'selected'?>>Doctorado</option>
            </select>
            
            <label for="horas_plaza">Horas de la Plaza:</label>
            <input type="number" id='horas_plaza' name='docente[horas_plaza]' onkeypress="maxnum(this,1);"maxnum(this,2);" placeholder="Horas impartidas por el Docente" value="<?php echo sanitizar($docente->horas_plaza) ?>" <?php if(!isset($docente->id_docente)) echo 'required'?> >

            <label for="fecha_ingreso">Fecha de Ingreso a la Instituci&oacute;n</label>
            <input type="date" id='fecha_ingreso' name='docente[fecha_ingreso]' max="<?php echo $anio = Date('Y-m-d');?>" value="<?php echo sanitizar($docente->fecha_ingreso) ?>" <?php if(!isset($docente->id_docente)) echo 'required'?> >

        </fieldset>
        <div class="contenido-submit">
            <input class="boton verde submit" type="submit" id="submit-docente" value="<?php if(isset($docente->id_docente)){echo 'Guardar Cambios';}else{echo 'Registrar Docente';} ?>">
        </div>
        <div id="errores-formulario">
        </div>
    </form>
    <script src="js/entidadesRepublica.js"></script>
    <script src="js/generarCURP.js"></script>
    <script src="js/generarRFC.js"></script>
    <script src="js/validaNuevoDocente.js"></script>
    <script src="js/validaDatosEntrada.js"></script>
    <script src="js/validaClavesUnicas.js"></script>
</section>
