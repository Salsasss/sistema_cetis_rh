<?php
if(
    (isset($_POST['fechaPermiso']) && !empty($_POST['fechaPermiso']))
){
    $permisos = CPermiso::find($_GET['id_docente']);

    $permisoValido = true;
    //Revisando si el permiso es repetido
    foreach($permisos as $permiso){
        if($permiso->fecha_ausento == $_POST['fechaPermiso']){
            //Si ya se ha solicitado un permiso esa fecha
            $permisoValido = false;
        }
    }
    //Solo continuaremos si no es un permiso repetido
    if($permisoValido){

        //Meses usados
        $mesesUsados = [];
        foreach($permisos as $permiso){
            $mesesUsados[] = explode('-',$permiso->fecha_ausento)[1];
        }
        
        //Mes en que se esta solicitando el permiso
        $mesSolicitado = explode('-',($_POST['fechaPermiso']))[1];

        //Recorriendo los meses en que se ha usado un permiso
        $repetido = 0;
        foreach($mesesUsados as $mesUsado){
            if($mesUsado == $mesSolicitado){
                $repetido++;
            }
        }
        
        //Si no se ha solicitado mas de 3 permisos en el mismo mes        
        if($repetido < 3){
            //Creando el Permiso
            $permiso = new CPermiso();
            $permiso->id_docente = $_GET['id_docente'];
            $permiso->fecha_ausento = $_POST['fechaPermiso'];
            
            if($permiso->guardar()){    
                $disponibles = CPermiso::permisosDisponibles($_GET['id_docente']);
                
                $query = "UPDATE docentes SET disponibles='".$disponibles."' WHERE id_docente='".$_GET['id_docente']."'";
                $res = CConecta::$db->query($query);
                
                //Mensaje de Exito
                ?> <p class="mensaje exito">¡Permiso Econ&oacute;mico Solicitado Exitosamente!<br></p><?php 
                
                //Redireccionando
                ?> <script type="text/javascript">setTimeout(() => {window.location="index.php?opc=4"}, 2000) </script> <?php
            }
        }else{
            ?> <p class="mensaje error">No se pueden utilizar mas de 3 Permisos en el mismo mes<br></p><?php 
        }
    }else{
        //Permiso repetido
        ?> <p class="mensaje error">D&iacute;a ya utilizado para Permiso Econ&oacute;mico<br></p><?php 
    }

}
?>