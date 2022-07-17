<?php
validaPermisoOperacion(14);
if(isset($_GET['id_usuario']) && !empty($_GET['id_usuario'])){
    $query2 = 'SELECT COUNT(*) FROM usuarios';    
    $res = CConecta::$db->query($query2);
    $cantidad = $res->fetch_assoc()['COUNT(*)'];
    
    if($cantidad > 1){
        //Si hay mas de un Usuario  
        $usuario = CUsuario::find($_GET['id_usuario']);
        if(isset($usuario->id_usuario)){
            //Si el usuario no esta vacio
            if($usuario->borrar()==1){
                //Redireccionando
                header('Location: ?opc=5');
            }
        }
    }
}
?>