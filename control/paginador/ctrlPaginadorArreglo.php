<?php
    $cantPaginas = ceil(count($arregloSinPaginar)/6);
    if($cantPaginas>1){
        //solo se paginara si la cantidad de paginas es mayor a 1
        $pag = 0;
        if(isset($_GET['pag']) && !empty($_GET['pag'])){
            $pag = $_GET['pag'];
        }
        ?><div class="paginador <?php if(isset($_GET['opc']) && !empty($_GET['opc']) && $_GET['opc']!=2){echo 'contenedor';}?>"><?php

        //Boton Anterior
        ?><a class="pag-paginador atras-delante <?php if($pag==0) echo 'desactivado'?>" href="<?php if($pag>0){echo '?opc='.$_GET['opc']?>&pag=<?php echo $pag-1; if(isset($_GET['ver']) && !empty($_GET['ver'])){echo '&ver='.$_GET['ver'];} if(isset($_POST['datoBuscar']) && !empty($_POST['datoBuscar']) && isset($_POST['nomBuscar']) && !empty($_POST['nomBuscar'])){echo '&datoBuscar='.$_POST['datoBuscar'].'&nomBuscar='.$_POST['nomBuscar'];}}?>"><</a><?php
        

        $i = 0;
        ?><div class="paginador-numeros"><?php
        if($cantPaginas>1){
            while($i < $cantPaginas){
                ?>
                    <a class="pag-paginador <?php if($pag==$i)echo 'seleccionado' ?>" href="?opc=<?php echo $_GET['opc']?>&pag=<?php echo $i; if(isset($_GET['ver']) && !empty($_GET['ver'])){echo '&ver='.$_GET['ver'];} if(isset($_POST['datoBuscar']) && !empty($_POST['datoBuscar']) && isset($_POST['nomBuscar']) && !empty($_POST['nomBuscar'])){echo '&datoBuscar='.$_POST['datoBuscar'].'&nomBuscar='.$_POST['nomBuscar'];} ?>"                                
                    ><p><?php echo($i+1);?></p></a>
                <?php
                $i++;
            }
        }
        ?></div><?php

        //Boton Siguiente        
        ?><a class="pag-paginador atras-delante <?php if($pag>=$cantPaginas-1) echo 'desactivado'?>" href="<?php if($pag<$cantPaginas-1){echo '?opc='.$_GET['opc']?>&pag=<?php echo $pag+1; if(isset($_GET['ver']) && !empty($_GET['ver'])){echo '&ver='.$_GET['ver'];} if(isset($_POST['datoBuscar']) && !empty($_POST['datoBuscar']) && isset($_POST['nomBuscar']) && !empty($_POST['nomBuscar'])){echo '&datoBuscar='.$_POST['datoBuscar'].'&nomBuscar='.$_POST['nomBuscar'];}}?>">></a><?php
    

        ?></div><?php
        $arregloPaginado = array();
        $indice = ($pag*6);
        $tope = $indice+6;
        if($tope>=count($arregloSinPaginar)){
            $tope = count($arregloSinPaginar);
        }
        $indiceNuevo = 0;
        while($indice<$tope){
            $arregloPaginado[$indiceNuevo] =  $arregloSinPaginar[$indice];
            $indiceNuevo++;
            $indice++;
        }
    }else{
        $arregloPaginado = $arregloSinPaginar;
    }

?>