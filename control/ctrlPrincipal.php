<?php
if(isset($_GET['opc']) && !empty($_GET['opc'])){
    $pag = $_GET['opc'];    
    switch($pag){
        case 1:            
            include('vista/docentes/vistFormularioDocente.php');
            break;
        case 2:
            include('vista/docentes/vistListaDocentes.php');
            break;
        case 3:
            include('vista/prejubilacion/vistListaPrejubilacion.php');
            break;
        case 4: 
            include('vista/permisosEconomicos/vistListaPermisos.php');
            break;
        case 5:
            include('vista/usuarios/vistListaUsuarios.php');
            break;
        case 6:
            include('vista/permisosEconomicos/vistHistorialPermisos.php');            
            break;
        case 7:
            include('vista/docentes/vistDocumentosDocente.php');
            break;
        case 8: 
            include('vista/docentes/vistEditarDocente.php');
            break;
        case 9:
            include('control/docentes/ctrlBajaDocente.php');
            include('vista/docentes/vistBajaDocente.php');
            break;
        case 10:
            include('control/ctrlPrejubilacion.php');
            include('vista/prejubilacion/vistSolicitarPrejubilacion.php');
            break;
        case 11:
            include('control/ctrlPermisos.php');
            include('vista/permisosEconomicos/vistSolicitarPermiso.php');
            break;
        case 12: 
            include('control/usuarios/ctrlAccionesUsuarios.php');
            break;
        case 13:
            unset($_SESSION['id_usuario']);
            session_destroy();         
            header('Location: ?');
            break;
        case 14:
            break;
        case 15:
            include('control/ctrlReportes.php');
            break;  
    }    
}else{
    $_GET['opc'] = 2;
    include('vista/docentes/vistListaDocentes.php');                        
}
?>