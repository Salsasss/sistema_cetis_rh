<?php
class CBajaDocente{
    private static $columnasDB = ['id_docente','id_baja','fecha_baja','motivo'];
    private static $tabla = 'bajas_docentes';
    public $id_docente; //Llave Foranea
    public $id_baja; //Llave Primaria
    public $fecha_baja;
    public $motivo;

    function __construct($docente = '',$motivo = ''){
        if(isset($docente->id_docente) && !empty($docente->id_docente)){
            $this->id_docente = $docente->id_docente;
        }
        $this->id_baja = generaID(6);//Generando un el id_baja
        $this->fecha_baja = date('Y-m-d');
        $this->motivo = $motivo ?? '';
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
        return CConecta::find(self::$tabla, $campo, $valor, 'CBajaDocente');
    }
}
?>