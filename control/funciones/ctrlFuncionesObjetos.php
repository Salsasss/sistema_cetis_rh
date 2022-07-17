<?php
//Obtiene un arreglo asociativo con los atributos del objeto
function getAtributos($columnasDB, $obj){
    $atributos = [];
    foreach($columnasDB as $columna){
        $atributos[$columna] = $obj->$columna;
      //  echo $atributos[$columna].'<br>';        
    }
    $sanitizado = [];
    foreach($atributos as $key => $value){//o recorremos como un arreglo asociativo
        $sanitizado[$key] = CConecta::$db->escape_string($value);
    }
    //debug($sanitizado);
    return $sanitizado;
}
//Sincroniza el objeto docente con nuevos datos
function sincronizar($args = [], $obj = []){
    foreach($args as $key => $value){
        if(property_exists($obj, $key) && !is_null($value)){
            $obj->$key = $value;
        }
    }    
    return $obj;
}
?>