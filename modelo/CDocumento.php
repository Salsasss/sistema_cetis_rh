<?php
class CDocumento{
    private static $columnasDB = ['id_docente','id_documentos','file_acta','file_curp','file_nss','file_rfc'];
    private static $tabla = 'documentos';
    public $id_docente; //Llave Foranea
    public $id_documentos; //Llave Primaria
    public $file_acta;
    public $file_curp;
    public $file_nss;
    public $file_rfc;

    function __construct($args = []){
        //Si el arreglo no existe lo llena de valores vacios
        foreach(self::$columnasDB as $columna){
            if(!isset($args[$columna])){
                $args[$columna] = "";
            }
        }
        $this->id_docente = $args['id_docente'];        
        $this->file_acta = $args['file_acta'];
        $this->file_curp = $args['file_curp'];
        $this->file_nss = $args['file_nss'];
        $this->file_rfc = $args['file_rfc'];        
    }
    //Registra o actualiza los documentos
    public function guardar(){
        if(!isset($this->id_documentos) && empty($this->id_documentos)){
            //Actualizar un registro de documentos
            $this->id_documentos = generaID(6);
            $atributos = getAtributos(self::$columnasDB, $this);
            return CConecta::crear(self::$tabla, $atributos);
        }else{
            //Actualizar un registro de documentos
            $atributos = getAtributos(self::$columnasDB, $this);
            return CConecta::actualizar(self::$tabla, $atributos);
        }
    }
    //Busca Documentos por un campo
    public static function find($valor, $campo = 'id_docente'){
        return CConecta::find(self::$tabla, $campo, $valor, 'CDocumento');
    }    
}
?>