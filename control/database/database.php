<?php

function conectarDB() : mysqli{
    $db = new mysqli('localhost','root','','sistema_cetis_rh');

    if(!$db){
        echo "Error al conectar :(";
        exit;
    }
    return $db;
}
?>