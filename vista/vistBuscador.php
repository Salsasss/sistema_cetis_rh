<form class="contenido-filtro buscador <?php if($_GET['opc']==3 || $_GET['opc']==4)echo 'grande'?>" action="?opc=<?php echo $_GET['opc'] ?>&cambio=1" method="POST">
    <div class="buscador-input">
        <select name="datoBuscar">
            <option value="1" <?php if(isset($_POST['datoBuscar']) && !empty($_POST['datoBuscar']) && $_POST['datoBuscar']==1)echo 'selected' ?> >Clave</option>
            <option value="2" <?php if(isset($_POST['datoBuscar']) && !empty($_POST['datoBuscar']) && $_POST['datoBuscar']==2){echo 'selected';}if(!isset($_POST['datoBuscar'])){echo'selected';}?>>Nombre</option>
            <option value="3" <?php if(isset($_POST['datoBuscar']) && !empty($_POST['datoBuscar']) && $_POST['datoBuscar']==3)echo 'selected' ?> >Apellido Paterno</option>
            <option value="4" <?php if(isset($_POST['datoBuscar']) && !empty($_POST['datoBuscar']) && $_POST['datoBuscar']==4)echo 'selected' ?> >Apellido Materno</option>
        </select>
        <input type="text" name="nomBuscar" id="nomBuscar" placeholder="Buscar" value="<?php if(isset($_POST['nomBuscar']) && !empty($_POST['nomBuscar']))echo $_POST['nomBuscar']?>">
        <a href="#" onclick="document.forms[0].submit();return false;"><img class="boton-buscar" src="multimedia/imagenes/buscar.svg" /></a>
    </div>
    <a class="link-borrar-busqueda" href="?opc=<?php echo $_GET['opc'].'&nomBuscar='?>"><img class="borrar-busqueda" src="multimedia/imagenes/equis.svg" alt=""></a>
</form>
