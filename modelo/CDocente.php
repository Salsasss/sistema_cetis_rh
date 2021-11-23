<?php
class CDocente{
    private static $columnasDB = ['id_docente','nombre','apellido_pat','apellido_mat','fecha_nac','sexo','celular','colonia','calle','numero_int','numero_ext','curp','nss','rfc','grado_estudios','horas_plaza','fecha_ingreso','fecha_registro','estado'];
    private static $tabla = 'docentes';
    public $id_docente; //Llave Primaria
    public $nombre;
    public $apellido_pat;
    public $apellido_mat;
    public $fecha_nac;
    public $edad;
    public $sexo;
    public $celular;
    public $colonia;
    public $calle;
    public $numero_int;
    public $numero_ext;
    public $curp;
    public $nss;
    public $rfc;
    public $grado_estudios;
    public $horas_plaza;
    public $fecha_ingreso;
    public $fecha_registro;
    public $p_disponibles;
    public $estado;

    function __construct($args = []){    
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido_pat = $args['apellido_pat'] ?? '';
        $this->apellido_mat = $args['apellido_mat'] ?? '';
        $this->fecha_nac = $args['fecha_nac'] ?? '';
        $this->edad = calculaEdad($args['fecha_nac'] ?? '');
        $this->sexo = $args['sexo'] ?? '';
        $this->celular = $args['celular'] ?? '';
        $this->colonia = $args['colonia'] ?? '';
        $this->calle = $args['calle'] ?? '';
        $this->numero_int = $args['numero_int'] ?? '';
        $this->numero_ext = $args['numero_ext'] ?? '';
        $this->curp = $args['curp'] ?? '';
        $this->nss = $args['nss'] ?? '';
        $this->rfc = $args['rfc'] ?? '';
        $this->grado_estudios = $args['grado_estudios'] ?? '';
        $this->horas_plaza = $args['horas_plaza'] ?? '';
        $this->fecha_ingreso = $args['fecha_ingreso'] ?? '';
        $this->fecha_registro = date('Y-m-d');
        $this->p_disponibles = 9;
        $this->estado = 'Activo';
    }
    //Valida que no falte ningun dato en el objeto
    public function validar(){
        if(
            (empty($this->nombre))
            ||
            (empty($this->apellido_pat))
            ||
            (empty($this->apellido_mat))
            ||
            (empty($this->fecha_nac))
            ||
            (empty($this->sexo))
            ||
            (empty($this->celular))
            ||
            (empty($this->colonia))
            ||
            (empty($this->calle))
            ||
            (empty($this->numero_int))
            ||
            (empty($this->numero_ext))
            ||
            (empty($this->nss))
            ||
            (empty($this->rfc))
            ||
            (empty($this->grado_estudios))
            ||
            (empty($this->fecha_ingreso))
            ||
            (empty($this->horas_plaza))
        ){
            return false;//Si falta algun dato
        }else{
            return true;//Si No falta ningun dato
        }    
    }
    //Retorna todos los docentes registrados
    public static function all(){
        return CConecta::all(self::$tabla);
    }    
    //Guarda un docente: Crear o Actualizar
    public function guardar(){
        if(!isset($this->id_docente) && empty($this->id_docente)){
            //Dar de alta un docente
            $this->id_docente = generaID(6);//Generando un el id_docente
            $atributos = getAtributos(self::$columnasDB, $this);
            return CConecta::crear(self::$tabla, $atributos);
        }else{
            //Actualizar un docente
            $atributos = getAtributos(self::$columnasDB, $this);
            return CConecta::actualizar(self::$tabla, $atributos);
        }
    }
    //Busca un docente por campo
    public static function find($valor, $campo = 'id_docente'){
        return CConecta::find(self::$tabla, $campo, $valor, 'CDocente');
    }
    //Funcion que retorna los docentes que pueden hacer su proceso prejubilatorio
    public static function aptosPrejubilacion($arreglo){        
        $docentesAptos = array();
        foreach($arreglo as $docente){
            //Si su estado es Activo
            if($docente->estado == 'Activo'){
                $edad = calculaEdad($docente->fecha_nac);
                $aniosServicio = calculaEdad($docente->fecha_ingreso);
                
                if($docente->sexo == 'Masculino'){
                    //Comprobando requisitos para hombres
                    if($edad >= 65 && $aniosServicio >= 30){
                        $docentesAptos[] = $docente;
                    }                
                }else if($docente->sexo == 'Femenino'){
                    //Comprobando requisitos para mujeres
                    if($edad >= 60 && $aniosServicio >= 28){
                        $docentesAptos[] = $docente;
                    }                
                }
            }
        }
        return $docentesAptos; 
    }
    //Funcion que retorna los docentes que tengan dias disponibles
    public static function aptosPermiso($docentes){
        $docentesAptos = array();
        foreach($docentes as $docente){
            $disponibles = CPermiso::permisosDisponibles($docente->id_docente);
            if($disponibles > 0){
                $docentesAptos[] = $docente;
            }
        }
        return $docentesAptos; 
    }
    //Funcion que comprueba que el CURP, NSS y RFC no esten registrados ya en el sistema
    public function clavesUnicas(){
        $mensaje = '';
        
        $registrado = CDocente::find($this->curp, 'curp');
        if(!empty($registrado)){
            $mensaje .= '<li> CURP No V&aacute;lida: Ya registrada en el Sistema <br> </li>';
        }

        $registrado = CDocente::find($this->nss, 'nss');
        if(!empty($registrado)){
            $mensaje .= '<li> NSS No V&aacute;lida: Ya registrada en el Sistema <br> </li>';
        }

        $registrado = CDocente::find($this->rfc, 'rfc');
        if(!empty($registrado)){
            $mensaje .= '<li> RFC No V&aacute;lida: Ya registrada en el Sistema <br> </li>';
        }

        return $mensaje;
    }
}
?>