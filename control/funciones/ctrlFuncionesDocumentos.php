<?php
//Funcion que recibe como parametro el nombre del valor, y su tamaño maximo 
function validaTamanio($nombre, $max){
    $bandera = true;      
    if($_FILES['docente_files'][$nombre]['size'] > $max){
        $bandera = false;
    }
    return $bandera;
}
//Funcion que valida que la extension de un documento sea una de las admitidas
function validaExtension($nombre, $tipos){
    $bandera = false;
    $i = 0;    
    //strtoupper() convirete a mayusculas
    while($i < count($tipos)){
        //si la extension del documento es igual a alguna de las validas bandera se iguala a true
        if(strtoupper(getExtension($nombre))==strtoupper($tipos[$i])){
            $bandera = true;
            $i = count($tipos);
        }
        $i++;
    }
    return $bandera;
}
//Funcion que recibe como parametro el nombre del valor enviado por $_FILES['docente_files'] y retorna su extension
function getExtension($nombre){
    $ext = '';
    $palInv = strrev($_FILES['docente_files']['name'][$nombre]);//gpj.2.otof
    $cont = 0;
    $pos = 0;
    while($cont<strlen($palInv)){
        if(substr($palInv, $cont, 1)=='.'){
            $pos = $cont;
            $cont = strlen($palInv);
        }
        $cont++;
    }
    $exInv = substr($palInv, 0 , $pos);
    $ext = strrev($exInv);
    return $ext;
}
//Funcion que guarda un documento
function guardarDocumentos($docente, $objetoDocumentos = ''){
    $carpetaDocentes = 'documentosDocentes/'.$docente->id_docente.'_'.$docente->apellido_pat.'_'.$docente->apellido_mat.'/';

    $documentos = ['file_acta', 'file_curp', 'file_nss', 'file_rfc'];
    $nombresDocumentos = ['_ActNac.', '_CURP.', '_NSS.', '_RFC.'];

    $nombresFiles = [];

    for($i = 0; $i < 4; $i++){
        if(isset($_FILES['docente_files']['name'][$documentos[$i]]) && !empty($_FILES['docente_files']['name'][$documentos[$i]])){
            //Moviendo el documento del NSS
            if(!getExtension($documentos[$i])==''){
                //Si se esta actualizando borra el documento anterior
                if(isset($_GET['id_docente'])){
                    $nom = $documentos[$i];
                    unlink($carpetaDocentes.$objetoDocumentos->$nom);
                }
                //Guardando el documento en el servidor
                $nombresFiles[$documentos[$i]] = $docente->id_docente.'_'.$docente->apellido_pat.'_'.$docente->apellido_mat.$nombresDocumentos[$i].getExtension($documentos[$i]);
                move_uploaded_file($_FILES['docente_files']['tmp_name'][$documentos[$i]],$carpetaDocentes.$nombresFiles[$documentos[$i]]);
            }
        }
    }
    //Retornando el arreglo las direcciones de los documentos    
    return $nombresFiles;
}
//Actualiza el nombre de los documentos
function actualizarNombresDocumentos($docente){
    $documentos = CDocumento::find($docente->id_docente);

    $rutaAntigua = 'documentosDocentes/'.$docente->id_docente.'_'.$docente->apellido_pat.'_'.$docente->apellido_mat;
    $rutaActual = 'documentosDocentes/'.$docente->id_docente.'_'.$_POST['docente']['apellido_pat'].'_'.$_POST['docente']['apellido_mat'];
    
    //Renombrando la carpeta
    rename($rutaAntigua,$rutaActual);

    $nombresFiles = [];

    $nombresFiles['file_acta'] = str_replace($docente->id_docente.'_'.$docente->apellido_pat.'_'.$docente->apellido_mat, $docente->id_docente.'_'.$_POST['docente']['apellido_pat'].'_'.$_POST['docente']['apellido_mat'], $documentos->file_acta);
    //Renombrando el documento Acta de nacimiento1
    rename($rutaActual.'/'.$documentos->file_acta, $rutaActual.'/'.$nombresFiles['file_acta']);

    $nombresFiles['file_curp'] = str_replace($docente->id_docente.'_'.$docente->apellido_pat.'_'.$docente->apellido_mat, $docente->id_docente.'_'.$_POST['docente']['apellido_pat'].'_'.$_POST['docente']['apellido_mat'], $documentos->file_curp);
    //Renombrando el documento CURP
    rename($rutaActual.'/'.$documentos->file_curp,$rutaActual.'/'.$nombresFiles['file_curp']);

    $nombresFiles['file_nss'] = str_replace($docente->id_docente.'_'.$docente->apellido_pat.'_'.$docente->apellido_mat, $docente->id_docente.'_'.$_POST['docente']['apellido_pat'].'_'.$_POST['docente']['apellido_mat'], $documentos->file_nss);
    //Renombrando el documento NSS
    rename($rutaActual.'/'.$documentos->file_nss,$rutaActual.'/'.$nombresFiles['file_nss']);

    $nombresFiles['file_rfc'] = str_replace($docente->id_docente.'_'.$docente->apellido_pat.'_'.$docente->apellido_mat, $docente->id_docente.'_'.$_POST['docente']['apellido_pat'].'_'.$_POST['docente']['apellido_mat'], $documentos->file_rfc);
    //Renombrando el documento RFC
    rename($rutaActual.'/'.$documentos->file_rfc,$rutaActual.'/'.$nombresFiles['file_rfc']);

    //Actualizando los nombres en el objeto para guardarlos en la base de datos
    $documentos = sincronizar($nombresFiles, $documentos);
    $documentos->guardar();
}

?>