<?php
    if($docente->validar()){
        if(!isset($_GET['id_docente']) && empty($_GET['id_docente'])){
            //Comprobamos que las claves unicas sean de hecho unicas
            $resultado = $docente->clavesUnicas();
            if($resultado==''){
                //Guardando docente
                if($docente->guardar()){
                    $carpetaDocentes = 'documentosDocentes/'.$docente->id_docente.'_'.$docente->apellido_pat.'_'.$docente->apellido_mat.'/';
                    //Creando la carpeta documentosDocentes si no existe
                    if(!is_dir('documentosDocentes')){
                        mkdir('documentosDocentes');
                    }
                    //Creando la carpeta individual si no existe
                    if(!is_dir($carpetaDocentes)){
                        mkdir($carpetaDocentes);
                    }
                    $nombresFiles = guardarDocumentos($docente);
                    
                    $documento = new CDocumento($nombresFiles);
                    $documento->id_docente = $docente->id_docente;
                    
                    //Guardando los documentos
                    if($documento->guardar()){
                        ?> <script type="text/javascript">window.location="index.php?opc=2";</script> <?php
                    }
                }
            }else{
                ?>
                    <ul class="mensaje error"><?php echo $resultado ?></ul>
                <?php                    
            }
        }else{
            //Editando Docente
            $docente = CDocente::find($_GET['id_docente']);

            //Si se cambio el nombre hay que actualizar el nombre de los documentos
            if($docente->apellido_pat != $_POST['docente']['apellido_pat'] || $docente->apellido_mat != $_POST['docente']['apellido_mat']){
                actualizarNombresDocumentos($docente);
            }
            //Sincronizando el objeto
            $docente = sincronizar($_POST['docente'], $docente);

            //Guardando los documentos
            $documentos = CDocumento::find($docente->id_docente);
            $nombresFiles = guardarDocumentos($docente, $documentos);
            if(!empty($nombresFiles)){
                $documentos = sincronizar($nombresFiles, $documentos);
                //Guardando objeto documento
                $documentos->guardar();
            }

            //Guardando docente
            if($docente->guardar()){
                ?> <script type="text/javascript">window.location="index.php?opc=2";</script> <?php
            }
        }     
    }
?>