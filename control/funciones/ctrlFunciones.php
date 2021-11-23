<?php
require(__DIR__.'/../../modelo/PHPMailer/src/Exception.php');
require(__DIR__.'/../../modelo/PHPMailer/src/PHPMailer.php');
require(__DIR__.'/../../modelo/PHPMailer/src/SMTP.php');

//declarando una constante que ya existe
use PHPMailer\PHPMailer\PHPMailer;

//Valida si una palabra sobrepasa el limite de caracteres
function validaLongitud($len, $palabra){
    $bandera = true;
    if(strlen($palabra) > $len){
        $bandera = false;
    }
    return $bandera;
}

//Calcula la edad a partir de una fecha
function calculaEdad($fecNac){
    $fecNac2 = date_create($fecNac);      
    $edad = 0;
    //Obteniendo fechas actuales
    $anioAct = date('Y');//2021
    $mesAct = date('m');//02
    $diaAct = date('d');//25
    
    //Obteniendo fechas del usiario
    $anioNac  = $fecNac2->format('Y');
    $mesNac = $fecNac2->format('m');
    $diaNac = $fecNac2->format('d');
    //obteniendo edad en bruto
    $edad = $anioAct - $anioNac;        
    //si el mes de nacimiento es mayor al mes actual (aun no cumple anios)
    if($mesNac > $mesAct){
        $edad--;
    }
    //si el mes de nacimiento es igual al mes actual (y el dia de nacimiento es mayor al dia actual)
    if($mesNac == $mesAct && $diaNac > $diaAct){
        $edad--;
    }
    return $edad;
}

//Sanitizar el HTML
function sanitizar($html){
    return htmlspecialchars($html);
}

//Verifica si la sesion existe
function verificarSesion(){
    //Si no existe la sesion
    if(!isset($_SESSION['id_usuario']) && empty($_SESSION['id_usuario'])){
        include('inicioSesion.php');
        include('control/usuarios/ctrlInicioSesion.php');
    }
}

//Verifica si el usuario es de rango Administrador
function verificarAdministrador($botarUsuario = false){
    //Si existe la sesion
    if(isset($_SESSION['id_usuario']) && !empty($_SESSION['id_usuario'])){
        //trayendo el rango del usuario
        $rango = CUsuario::getRango($_SESSION['id_usuario']);
        //Si no es administrador
        if($botarUsuario){
            if($rango != 'Administrador'){
                //No es Administrador; bota al usuario
                unset($_SESSION['id_usuario']);//Vacia la variable session
                unset($_SESSION['rango']);//Vacia la variable session
                session_destroy();//Destruye la sesion
                header('Location: index.php');//Redirecciona al index que al no encontrar sesion lo llevara al login
            }else{
                //SI es Administrador
                return true;
            }
        }else{
            if($rango != 'Administrador'){
                //NO es Administrador; regresa un false
                return false;
            }else{
                //SI es Administrador
                return true;
            }
        }
    }
}
function validaPermisoOperacion($operacion, $botarUsuario=true){
    $id_operacion = '';
    switch($operacion){
        case 1: $id_operacion = 'MT81KW'; //Alta
            break;
        case 2: $id_operacion = 'V33CDZ'; //Lista
            break;
        case 3: $id_operacion = 'VCS6GM'; //Editar
            break;
        case 4: $id_operacion = 'S12WAT'; //Documentos
            break;
        case 5: $id_operacion = 'XE15K8'; //Baja
            break;
        case 6: $id_operacion = 'JLLWAO'; //Reporte datos
            break;
        case 7: $id_operacion = 'YI00YJ'; //Prejubilacion
            break;
        case 8: $id_operacion = '6LW8KT'; //Reporte prejubilacion
            break;
        case 9: $id_operacion = 'S9PUHK'; //Permiso economico
            break;
        case 10: $id_operacion = 'SNRRYI'; //Historial de permisos
            break;
        case 11: $id_operacion = 'NJPB0O'; //Reporte de Permiso
            break;
        case 12: $id_operacion = '6CS0PR'; //Lista de Usuarios
            break;
        case 13: $id_operacion = 'SCKYD4'; //Nuevo Usuario
            break;
        case 14: $id_operacion = '0WK3ZL'; //Eliminar Usuario
            break;
    }
    $usuario = CUsuario::find($_SESSION['id_usuario']);
    if($usuario){
        $query = 'SELECT COUNT(*) AS encontrado FROM rango_operacion WHERE id_rango = "'.$usuario->id_rango.'" AND id_operacion = "'.$id_operacion.'"';
        $res = CConecta::$db->query($query);
        $encontrado = $res->fetch_assoc()['encontrado'];

        if(!$encontrado || $encontrado==0 || empty($encontrado)){
            //Si No se encontro la relacion de acceso
            if($botarUsuario){
                //No tiene Acceso; bota al usuario
                unset($_SESSION['id_usuario']);//Vacia la variable session
                unset($_SESSION['rango']);//Vacia la variable session
                session_destroy();//Destruye la sesion
                header('Location: index.php');//Redirecciona al index que al no encontrar sesion lo llevara al login
            }else{
                return false;
            }
        }else{
            //Se ha encontrado la relacion de acceso
            return true;
        }
    }
}
//Envia un correo electronico
function enviarCorreo($correoDestino,$nombreDestino, $cuerpo){
    $bandera = true;
    $mail = new PHPMailer(true);

    //Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.live.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'aaronsalasc19.ce15@dgeti.sems.gob.mx'; //Correo del remitente
    $mail->Password   = 'Subnormal16';                          //Contrasena del remitente
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    //Recipientes
    $mail->setFrom($mail->Username, 'CETis 15: Sistema de Control de Recursos Humanos');
    $mail->addAddress($correoDestino,$nombreDestino); //Destinatario
    
    //Contenido
    $mail->isHTML(true);
    $mail->Subject = 'Sistema de Control de Recursos Humanos';    
    $mail->Body = $cuerpo;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()){
        $bandera = false;
    } 
    return $bandera;
}

//Genera un ID de tamaño N
function generaID($tamanio){
    $i = 0;
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $clave = '';
    while($i<$tamanio){
        $o = rand(0,strlen($caracteres)-1);
        $clave .= substr($caracteres,$o,1);
        $i++;
    }
    return $clave;
}

//R
function getDatoBuscarDocente($value){
    switch($value){
        case 1:
            return 'id_docente';
            break;
        case 2:
            return 'nombre';
            break;
        case 3:
            return 'apellido_pat';
            break;
        case 4:
            return 'apellido_mat';
            break;    
        default: return 'undefined';
    }
} 
function getDatoBuscarUsuario($value){
    switch($value){
        case 1:
            return 'id_usuario';
            break;
        case 2:
            return 'nombre';
            break;
        case 3:
            return 'correo';
            break;
        default: return 'undefined';
    }
} 

//Imprime de manera limpia una variable deteniendo la ejecucion
function debug($variable){
    echo '<pre>';
    var_dump($variable);
    echo '<pre>';
    exit;
}
//Imprime de manera limpia una variable pero SIN deteniendo la ejecucion
function debug2($variable){
    echo '<pre>';
    var_dump($variable);
    echo '<pre>';
}

//Imprime de manera limpia una variable sin detener la ejecucion
function debug3($variable){
    echo '<h2>'.$variable.'<h2>';
}

?>