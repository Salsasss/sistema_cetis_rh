<option value="0">-Seleccione un Municipio-</option>
<?php
    include('database/database.php');
    require('../modelo/CDocente.php');
    require('../modelo/CConecta.php');
    include('funciones/ctrlFunciones.php');
    $db = conectarDB();
    CConecta::setDB($db);
    //Creando el query que traera todos los estados de un pais
    $query = "SELECT * FROM municipios WHERE id_estado=".$_POST['id_estado']." order by municipio";
    $res = $db->query($query);
    $docente = CDocente::find($_POST['id_docente']);
    if($res){
        while($municipio = $res->fetch_assoc()){
            ?>
            <option value="<?php echo $municipio['id_municipio'] ?>" <?php if($docente->id_municipio==$municipio['id_municipio']) echo 'selected'?> >
                <?php echo $municipio['municipio'] ?>
            </option>
            <?php
        }
    }
?>