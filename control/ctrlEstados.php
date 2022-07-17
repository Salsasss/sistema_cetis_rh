<option value="0">-Seleccione un Municipio-</option>
<?php
    include('database/database.php');
    $db = conectarDB();
    //Creando el query que traera todos los estados de un pais
    $query = "SELECT * FROM municipios WHERE id_estado=".$_POST['id_estado']." order by municipio";
    $res = $db->query($query);
    if($res){
        while($municipio = $res->fetch_assoc()){
            ?>
            <option value="<?php echo $municipio['id_municipio'] ?>" >
                <?php echo $municipio['municipio'] ?>
            </option>
            <?php
        }
    }
?>