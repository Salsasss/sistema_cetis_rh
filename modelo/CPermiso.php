<?php
class CPermiso{
    private static $columnasDB = ['id_docente','id_permiso','fecha_ausento'];
    private static $tabla = 'permisos';
    public $id_docente; //Llave Foranea
    public $id_permiso; //Llave Primaria
    public $fecha_ausento;

    function __construct($docente = '', $fecha_ausento = ''){    
        if(isset($docente->id_docente) && !empty($docente->id_docente)){
            $this->id_docente = $docente->id_docente;
        }
        if(!isset($fecha_ausento) || empty($fecha_ausento)){
            $this->fecha_ausento = $fecha_ausento;
        }
    }
    //Retorna todos los docentes registrados
    public static function all(){        
        return CConecta::all(self::$tabla);
    }
    //Guarda los permisos: Crear o Actualizar
    public function guardar(){
        if(!isset($this->id_permiso) && empty($this->id_permiso)){
            //Dar de alta los permisos
            $this->id_permiso = generaID(6);//Generando un el id_permiso
            $atributos = getAtributos(self::$columnasDB, $this);
            return CConecta::crear(self::$tabla, $atributos);        
        }else{
            //Actualizar los permisos
            $atributos = getAtributos(self::$columnasDB, $this);
            return CConecta::actualizar(self::$tabla, $atributos);
        }
    }
    //Busca los permisos por campo
    public static function find($valor, $campo = 'id_docente'){
        return CConecta::find(self::$tabla, $campo, $valor, 'CPermiso');
    }
    //Retorna la cantidad de permisos disponibles de un docente
    public static function permisosDisponibles($id_docente){
        $disponibles = 0;

        $query = 'SELECT COUNT(*) FROM permisos WHERE id_docente="'.$id_docente.'"';
        $res = CConecta::$db->query($query);
        //Cantidad de permisos usados        
        $cantidadUsados = $res->fetch_assoc()['COUNT(*)'];

        //Cantidad de permisos disponibles
        $disponibles = 9 - $cantidadUsados;
        
        return $disponibles;        
    }
    //Retorna el mes mas solicitado por un docente
    public static function mesMasSolicitado($id_docente){    
        $permisos = self::find($id_docente);
        //Meses usados
        $mesesUsados = [];
        foreach($permisos as $permiso){
            $mesesUsados[] = intval(explode('-',$permiso->fecha_ausento)[1]);
        }

        //Veces que se ha usado un mes    
        $meses = array(0,0,0,0,0,0,0,0,0,0,0,0);
        $mesesMasUsados = array();

        //Incrementando las veces que se ha usado cada mes
        if(count($mesesUsados)>0){//Solo se hara todo si realmente hay meses
            foreach($mesesUsados as $mes){
                $meses[$mes-1]++;
            }
            //Obteniendo el mes mas solicitado        
            $repetido = max($meses);
            $i=0;
            foreach($meses as $mes){
                if($mes==$repetido){
                    $mesesMasUsados[] = $i;
                }
                $i++;
            }        
            //Ordenandolos por el metodo burbuja
            for ($i=0; $i<count($mesesMasUsados); $i++){
                for ($j=0; $j<count($mesesMasUsados); $j++){
                    if ($mesesMasUsados[$i] < $mesesMasUsados[$j]){
                        $aux = $mesesMasUsados[$i];
                        $mesesMasUsados[$i] = $mesesMasUsados[$j];
                        $mesesMasUsados[$j] = $aux;
                    }
                }
            }
        }
        //Retornando el arreglo con los meses usados ya ordenados
        return $mesesMasUsados;
    }
}
?>