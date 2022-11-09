<script>
    function redirect(){
        window.location.href = "http://clarofans.clarochile.cl/admin/beneficios/mantenedor/Lista_Convenios.php";
    }
</script>

<?php
    include("includes/connLocal.php");
    $service = $_GET["idconvenio"];
    //Se busca el número de orden  en home del último convenio
     $sql_orden = "SELECT MAX(orden_home) as orden_home FROM convenio";
     $result_orden=mysql_query($sql_orden,$link_local);
     $max_orden_home = mysql_fetch_assoc( $result_orden);

     //Se obtiene toda la información relevante del convenio a deshabilitar.
     $sql_orden = "SELECT orden_home, orden_cat_destacados, orden_cat_belleza, orden_cat_cursos, orden_cat_entretencion, orden_cat_gastronomia, orden_cat_tiempo, orden_cat_servicios, orden_cat_tiendas,orden_cat_viajes, idcat FROM convenio WHERE id = '$service'";
        $result_orden=mysql_query($sql_orden,$link_local);
        $array_orden = mysql_fetch_assoc( $result_orden);
    
        
        //CAMBIAR ORDEN HOME
        if($array_orden['orden_home']!= $max_orden_home['orden_home'] ){
                $sql = "UPDATE convenio set orden_home=orden_home-1 where orden_home <=".$max_orden_home['orden_home']."  AND  orden_home > ".$array_orden['orden_home'];
                 $result=mysql_query($sql,$link_local);

            $sql="UPDATE convenio set orden_home=".$max_orden_home['orden_home']." WHERE id=".$service; 
            $result=mysql_query($sql,$link_local);
        }
        //FIN CAMBIAR ORDEN HOME

        $cat_conv['306']='destacados';
        $cat_conv['307']='belleza';
        $cat_conv['308']='cursos';
        $cat_conv['309']='entretencion';
        $cat_conv['310']='gastronomia';
        $cat_conv['311']='tiempo';
        $cat_conv['312']='tiendas';
        $cat_conv['313']='servicios';
        $cat_conv['314']='viajes';

        $orden_cat="orden_cat_".$cat_conv[$array_orden['idcat']];
        //Se busca el número de orden  en categoría del último convenio
         $sql_orden = "SELECT MAX(". $orden_cat.") as orden_cat FROM convenio";
         $result_orden=mysql_query($sql_orden,$link_local);
         $max_orden_cat= mysql_fetch_assoc( $result_orden);
        
           
        if($max_orden_cat['orden_cat']!= $array_orden[$orden_cat]){
               
            $sql = "UPDATE convenio set $orden_cat=$orden_cat-1 where $orden_cat <=".$max_orden_cat['orden_cat']."  AND  $orden_cat > ".$array_orden[$orden_cat]." AND idcat=".$array_orden['idcat'];;
            $result=mysql_query($sql,$link_local);

            $sql="UPDATE convenio set $orden_cat=".$max_orden_cat['orden_cat']." Where id=".$service; 
            $result=mysql_query($sql,$link_local);
        }




    mysql_query("update convenio set status = 1 where id=".$service, $link_local);
    mysql_query("update cliente_convenio set status = 1 where idconvenio=".$service, $link_local);
    mysql_query("update imagen_convenio set status = 1 where idconvenio=".$service, $link_local);
    echo "<script>";
    echo "redirect()";
    echo "</script>";
?>
