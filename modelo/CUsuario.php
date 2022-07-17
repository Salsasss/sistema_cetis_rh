<?php
class CUsuario{
    private static $columnasDB = ['id_usuario','nombre','correo','password','estatus','id_rango','fecha_registro','fecha_sesion'];
    private static $tabla = 'usuarios';
    public $id_usuario; //Llave Primaria
    public $nombre;
    public $correo;
    public $password;
    public $estatus;
    public $id_rango;
    public $fecha_registro;
    public $fecha_sesion;

    function __construct($args = []){
        //Si el arreglo no existe lo llena de valores vacios
        foreach(self::$columnasDB as $columna){
            if(!isset($args[$columna])){
                $args[$columna] = "";
            }
        }
        $this->id_usuario = generaID(6);
        $this->nombre = $args['nombre'];
        $this->correo = strtolower($args['correo']);
        $this->password = generaID(6);
        $this->estatus = 0;
        $this->id_rango = $args['id_rango'];        
        $this->fecha_registro = date('Y-m-d');
        $this->fecha_sesion = date('y-m-d H:m:s');
    }
    //Valida que no falte ningun dato en el objeto
    public function validar(){
        if(
            (empty($this->nombre))
            ||
            (empty($this->correo))
            ||
            (empty($this->password))
        ){
            return false;//Si falta algun dato
        }else{
            return true;//Si No falta ningun dato
        }    
    }
    //Retorna todos los Usuarios registrados
    public static function all(){
        return CConecta::all(self::$tabla);
    }
    //Dar de alta un Usuario    
    public function guardar(){        
        $this->password = password_hash($this->password,PASSWORD_DEFAULT);//Hasheando su password
        $atributos = $this->getAtributos();

        return CConecta::crear(self::$tabla, $atributos);                
    }
    //Busca un Usuario por campo
    public static function find($valor, $campo = 'id_usuario'){
        $res = CConecta::find(self::$tabla, $campo, $valor, 'CUsuario');
        if($res){
            if(is_array($res)){
                return $res[0];
            }else{
                return $res;
            }
        }else{
            return '';
        }
    }
    //Elimina un Usuario
    public function borrar(){
        $query = "DELETE FROM usuarios WHERE id_usuario='".$this->id_usuario."' LIMIT 1";
        return CConecta::$db->query($query);
    }
    //Actualizar un Usuario
    public function actualizar(){
        $atributos = $this->getAtributos();
        return CConecta::actualizar(self::$tabla, $atributos, 'id_usuario');
    }
    //Valida que el tiempo desde la ultima interaccion del Usuario no sea mayor a 20 minutos
    public static function validaTiempo($id_usuario){
        $usuario = self::find($id_usuario);        

        $tiempoActual = strtotime(date('d-m-Y H:i:s'));//Fecha actual en segundos        
        $ultimoTiempo = strtotime($usuario->fecha_sesion);//Ultima fecha de actividad en segundos
        $diferencia = $tiempoActual - $ultimoTiempo;//Diferencia en segundos
        //Si la diferencia es menor o igual a 1200; 20 minutos
        if($diferencia <= 1200){
            $usuario->actualizarFecha();//Se actualiza la ultima fecha de actividad
            return true;
        }
        return false;
    }
    //Envia un correo electronico con la validacion de la cuenta
    function registroMail(){    
        //Cuerpo del correo
        $cuerpo = '<h2>Bienvenido al Sistema de Control de Recursos Humanos del CETis No. 15</h2><br>';
        $cuerpo.= '<p>Para finalizar el registro da click en el siguiente enlace <a href="http://localhost/sistema_cetis_rh/activaCuenta.php?id_usuario='.$this->id_usuario.'">Finalizar Registro<a><br>';
        $cuerpo.= '<p>Los datos de tu Cuenta son: <br>';
        $cuerpo.= '<ul>
                    <li>Nombre de Usuario: '.$this->nombre.'<br></li>
                    <li>Contraseña de acceso: '.$this->password.'<br></li>
                    <li>Rango de la Cuenta: '.$this->id_rango.'<br></li>
                </ul>';
        $bandera = enviarCorreo($this->correo, $this->nombre, $cuerpo);    
        return $bandera;
    }
    //Actualiza la fecha de la ultima interaccion de Usuario
    public function actualizarFecha(){    
        $this->fecha_sesion = date('Y-m-d H:i:s');
        $query = "UPDATE usuarios SET fecha_sesion='".$this->fecha_sesion."' WHERE id_usuario='".$this->id_usuario."' LIMIT 1";
        CConecta::$db->query($query);
    }
    //Trae el rango del usuario
    public static function getRango($id_usuario){
        $query2 = 'SELECT r.nombre FROM usuarios u JOIN rangos r ON u.rango = r.id_rango WHERE u.id_usuario = "'.$id_usuario.'"';
        $res = CConecta::$db->query($query2);
        $rango = '';
        if($res){
            $rango = $res->fetch_assoc()['nombre'];
        }
        return $rango;
    }
    //Inicia el proceso de recupearcion de una cuenta
    public function recuperarCuenta(){
        //Vaciando sesiones anteriores
        unset($_SESSION['recuperar']);
        session_destroy();

        //Clave de seguridad para acceder
        session_start();
        $_SESSION['recuperar'] = generaID(6);

        //Cuerpo del correo
        $cuerpo = '<h2>Servicio al cliente</h2>';
        $cuerpo.= '<p>Hola, '.$this->nombre.'<br>';
        $cuerpo.= '<p>Para poder generar una nueva contrase&ntilde;a haz click el siguiente enlace <a href="http://localhost/sistema_cetis_rh/index.php?recuperar='.$_SESSION['recuperar'].'&id_usuario='.$this->id_usuario.'">Generar Nueva Contrase&ntilde;a<a><br>';

        //Enviando correo
        $bandera = enviarCorreo($this->correo, $this->nombre, $cuerpo);    
        return $bandera;
    }
    //Actualiza la fecha de la ultima interaccion de Usuario
    public function actualizarPassword(){
        //Generando nueva contraseña
        $this->password = generaID(6);

        //Cuerpo del correo con la nueva contraseña    
        $cuerpo = '<h2>Servicio al cliente</h2>';
        $cuerpo.= '<p>Hola, '.$this->nombre.'<br>';
        $cuerpo.= '<p>Tu nueva contrase&ntilde;a de acceso es: '.$this->password;
        $cuerpo.= '<p>Para Iniciar sesi&oacute;n ahora mismo haz click en el siguiente enlace: <a href="http://localhost/sistema_cetis_rh/index.php">Iniciar Sesi&oacute;n<a><br>';        

        //Enviando el correo
        $bandera = enviarCorreo($this->correo, $this->nombre, $cuerpo);

        //Hasheando la nueva contraseña y actualizando la base de datos
        $this->password = password_hash($this->password,PASSWORD_DEFAULT);        
        $query = "UPDATE usuarios SET password='".$this->password."' WHERE id_usuario='".$this->id_usuario."' LIMIT 1";
        $resultado = CConecta::$db->query($query);

        return $resultado;
    }    
    //
    public function getAtributos(){
        $atributos = [];
        foreach(self::$columnasDB as $columna){
            $atributos[$columna] = $this->$columna;
          //  echo $atributos[$columna].'<br>';        
        }
        $sanitizado = [];
        foreach($atributos as $key => $value){//o recorremos como un arreglo asociativo
            $sanitizado[$key] = CConecta::$db->escape_string($value);
        }
        //debug($sanitizado);
        return $sanitizado;
    }
}
?>