<?php 
class CConecta{
    public static $db;
    
    public static function setDB($database){
        self::$db = $database;
    }
    //Hacer una consulta SQL
    public static function consultarSQL($query, $objeto = 'CDocente'){
        $resultado = self::$db->query($query);
        if($resultado){
            //Iterar los resultados
            $array = [];
            while($registro = $resultado->fetch_assoc()){
               
                if($objeto == 'n/a'){
                    $array[] = $resultado->fetch_assoc();
                }else{
                    $array[] = self::crearObjeto($registro, $objeto);
                }
            }
           
            $resultado->free();//Liberar la memoria

            return $array; //Retornando el arreglo
        }else{
            //Si no hay resultado retorna false 
            return false;
        }
    }            
    //Lista todos lo registros
    public static function all($tabla, $objeto){
        $query = "SELECT * FROM ".$tabla;
        $resultado = self::consultarSQL($query,$objeto);
        return $resultado;
    }
    //Crea un registro
    public static function crear($tabla, $atributos){
        $nombres = join(", ",array_keys($atributos));//join crea un string a partir de un arreglo, es como si lo aplanara
        $valores = join("', '",array_values($atributos));
        //Creando el query
        $query = "INSERT INTO ".$tabla."(";
        $query.= $nombres;
        $query.= ") VALUES ('";
        $query.= $valores;
        $query.= "')";
        //Insertando en la base de datos
        $resultado = self::$db->query($query);
        return $resultado;
    }
    //Actualiza un registro
    public static function actualizar($tabla, $atributos, $valor = 'id_docente'){
        $valores = [];
        foreach($atributos as $key => $value){
            $valores[] = "$key"."='$value'";
        }
        $valores = join(', ',$valores);

        if($tabla == 'permisos'){
            //Creando el query de los permisos    
            $query = "UPDATE ".$tabla." SET ";
            $i = 0;
            foreach($atributos as $key => $value){
                if(!empty($value)){
                    if($i != 0){
                        $query.= ", ".$key."='".$value."'";
                    }else{
                        $query.= $key."='".$value."'";
                    }
                }
                $i++;
            }
            $query.= " WHERE ".$valor."='".self::$db->escape_string($atributos[$valor])."'";
        }else{
            //Creando el query
            $query = "UPDATE ".$tabla." SET ";
            $query.= $valores;
            $query.= " WHERE ".$valor."='".self::$db->escape_string($atributos[$valor])."'";
            $query.= " LIMIT 1";
        }
        //Actualizando en la base de datos
        $resultado = self::$db->query($query);    

        return $resultado;
    }
    //Busca un registro por su campo
    public static function find($tabla, $campo, $valor, $objeto = 'CDocente'){
        $query = "SELECT * FROM ".$tabla." WHERE ".$campo."='".$valor."'";
        $resultado = self::consultarSQL($query, $objeto);        
        
        if((count($resultado)==1) && $objeto != 'CPermiso'){
            //Si solo hay un docente retorna la unica posicion
            return array_shift($resultado);
        }else{
            //Retorna todo el arreglo
            return $resultado;
        }
    }
    //Convierte de arreglo a objeto
    public static function crearObjeto($registro, $objeto){
        if($objeto=='CDocente'){
            $objeto = new CDocente();
        }else if($objeto=='CDocumento'){
            $objeto = new CDocumento();
        }else if($objeto=='CUsuario'){
            $objeto = new CUsuario();
        }else if($objeto=='CPermiso'){
            $objeto = new CPermiso();
        }else if($objeto=='CBajaDocente'){
            $objeto = new CBajaDocente();
        }else if($objeto=='CPrejubilacion'){
            $objeto = new CPrejubilacion();
        }
        foreach($registro as $key => $value){
            if(property_exists($objeto, $key)){//esta funcion comprueba
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }
}