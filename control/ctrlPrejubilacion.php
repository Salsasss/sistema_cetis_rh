<?php
if(
  (isset($_GET['pre']) && !empty($_GET['pre']) && $_GET['pre']==1)
  &&
  (isset($_GET['id_docente']) && !empty($_GET['id_docente']))
){
    //docente a iniciar su proceso prejubilatorio
    $id_docente_prejubilar = $_GET['id_docente'];
    //Lista de docentes Aptos
    $query = 'SELECT * FROM docentes WHERE estado="Activo"';
    $arreglo = CConecta::consultarSQL($query);
    $docentesAptos = CDocente::aptosPrejubilacion($arreglo);
    //Buscando el docente en los docentes Aptos
    foreach($docentesAptos as $docente){
      //Si se encontro
      if($id_docente_prejubilar == $docente->id_docente){
        //Guardando la prejubilacion en la base de datos
        $prejubilacion = new CPrejubilacion($docente);
        if($prejubilacion->guardar()){
          //Cambiando su estado a Prejubilatorio
          $docente->estado = 'Prejubilatorio';

          if($docente->guardar()){
            //Mensaje de Exito
            ?><p class="mensaje exito">¡Proceso Prejubilatorio iniciado correctamente!<p><?php
            //Redireccionando
            ?> <script type="text/javascript">setTimeout(() => {window.location="?opc=2"}, 3000) </script> <?php
          }} 
        }      
      }
    }
?>