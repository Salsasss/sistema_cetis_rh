<option value="0">-Seleccione una Localidad-</option>
<?php
    include('database/database.php');
    require('../modelo/CDocente.php');
    require('../modelo/CConecta.php');
    include('funciones/ctrlFunciones.php');
    $db = conectarDB();
    CConecta::setDB($db);
    //Creando el query que traera todos los estados de un pais
    $query = "SELECT * FROM localidades WHERE id_municipio=".$_POST['id_municipio']." order by localidad";
    $res = $db->query($query);
    $docente = CDocente::find($_POST['id_docente']);
    if($res){
        while($localidad = $res->fetch_assoc()){
            ?>
            <option value="<?php echo $localidad['id_localidad'] ?>" <?php if($docente->id_localidad==$localidad['id_localidad']) echo 'selected'?> >
                <?php echo $localidad['localidad'] ?>
            </option>
            <?php
        }
    }
?>