<?php
class CPrejubilacion{
    private static $columnasDB = ['id_docente','id_prejubilacion','fecha_solicitud'];
    private static $tabla = 'prejubilaciones';
    public $id_docente; //Llave Foranea
    public $id_prejubilacion; //Llave Primaria
    public $fecha_solicitud;

    function __construct($docente = ''){
        if(isset($docente->id_docente) && !empty($docente->id_docente)){
            $this->id_docente = $docente->id_docente;
        }
        $this->id_prejubilacion = generaID(6);//Generando un el id_prejubilacion
        $this->fecha_solicitud = date('Y-m-d');
    }    
    //Retorna todos los docentes registrados
    public static function all(){
        return CConecta::all(self::$tabla);
    }
    //Guarda los permisos: Crear o Actualizar
    public function guardar(){
        $atributos = getAtributos(self::$columnasDB, $this);
        return CConecta::crear(self::$tabla, $atributos);        
    }
    //Busca los permisos por campo
    public static function find($valor, $campo = 'id_docente'){
        return CConecta::find(self::$tabla, $campo, $valor, 'CPrejubilacion');
    }
}
?>