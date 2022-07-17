<?php
if(
  (isset($_GET['id_docente']) && !empty($_GET['id_docente']))
  &&
  (isset($_POST['motivo']) && !empty($_POST['motivo']))
){
  //Buscando al docente
  $docente = CDocente::find($_GET['id_docente']);
  //Si no esta Inactivo ya
  if($docente->estado != 'Inactivo'){
    //Guardando la baja en la base de datos
    $baja = new CBajaDocente($docente, $_POST['motivo']);
    if($baja->guardar()){
      //Actualizando su estado a Inactivo
      $docente->estado = 'Inactivo';
      
      if($docente->guardar()){
        //Mensaje de Exito
        ?><p class="mensaje exito">¡Proceso de Baja completado correctamente!<p><?php
        //Redireccionando
        ?> <script type="text/javascript">setTimeout(() => {window.location="?opc=2"}, 3000) </script> <?php
      }
    }
  }
}
?>