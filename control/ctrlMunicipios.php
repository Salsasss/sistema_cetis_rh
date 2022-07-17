<option value="0">-Seleccione una Localidad-</option>
<?php
    include('database/database.php');
    $db = conectarDB();
    //Creando el query que traera todos los estados de un pais
    $query = "SELECT * FROM localidades WHERE id_municipio=".$_POST['id_municipio']." order by localidad";
    $res = $db->query($query);
    if($res){
        while($localidad = $res->fetch_assoc()){
            ?>
            <option value="<?php echo $localidad['id_localidad'] ?>">
                <?php echo $localidad['localidad'] ?>
            </option>
            <?php
        }
    }
?>