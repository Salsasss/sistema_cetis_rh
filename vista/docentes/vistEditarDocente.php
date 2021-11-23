<?php
verificarSesion();
validaPermisoOperacion(3);
if(isset($_GET['id_docente']) && !empty($_GET['id_docente'])){
    $docente = CDocente::find($_GET['id_docente']);
    include('vista/docentes/vistFormularioDocente.php');
}else{
    header('Location: index.php?opc=2');
}
?>