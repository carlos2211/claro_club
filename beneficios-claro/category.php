<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    $id_category = $_POST['category'];
    include 'includes/conn.php';
    $fecha_hoy = date("Y-m-d");

    if($id_category != "all"){
        $sql_category = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND  str_to_date('".$fecha_hoy."','%Y-%m-%d') BETWEEN c.fecha_contrato AND str_to_date(cc.vigencia,'%Y-%m-%d') AND c.id = ci.idconvenio AND idcat = $id_category AND ci.detalle=0 AND ci.detalle=0 AND c.status=0";
        $rs_category = mysql_query($sql_category, $con);
        $num_total_registros = mysql_num_rows($rs_category);
        if ($num_total_registros > 0) {
            $TAMANO_PAGINA = 6;
            $pagina = false;
            if (isset($_POST["pagina"]))
                $pagina = $_POST["pagina"];
            if (!$pagina) {
                $inicio = 0;
                $pagina = 1;
            }
            else {
                $inicio = ($pagina - 1) * $TAMANO_PAGINA;
            }
            $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
            if($id_category == "307"){
                $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND  str_to_date('".$fecha_hoy."','%Y-%m-%d') BETWEEN c.fecha_contrato AND str_to_date(cc.vigencia,'%Y-%m-%d') AND c.id = ci.idconvenio AND idcat = $id_category AND ci.detalle=0 AND c.status=0 ORDER BY orden_cat_belleza ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
            }else if($id_category == "308"){
                $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND  str_to_date('".$fecha_hoy."','%Y-%m-%d') BETWEEN c.fecha_contrato AND str_to_date(cc.vigencia,'%Y-%m-%d') AND c.id = ci.idconvenio AND idcat = $id_category AND ci.detalle=0 AND c.status=0 ORDER BY orden_cat_cursos ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
            }else if($id_category == "309"){
                $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND  str_to_date('".$fecha_hoy."','%Y-%m-%d') BETWEEN c.fecha_contrato AND str_to_date(cc.vigencia,'%Y-%m-%d') AND c.id = ci.idconvenio AND idcat = $id_category AND ci.detalle=0 AND c.status=0 AND STR_TO_DATE( c.fecha_contrato, '%Y-%m-%d' ) <= str_to_date('".$fecha_hoy."','%Y-%m-%d')  ORDER BY orden_cat_entretencion ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
            }else if($id_category == "310"){
                $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND  str_to_date('".$fecha_hoy."','%Y-%m-%d') BETWEEN c.fecha_contrato AND str_to_date(cc.vigencia,'%Y-%m-%d') AND c.id = ci.idconvenio AND idcat = $id_category AND ci.detalle=0 AND c.status=0 ORDER BY orden_cat_gastronomia ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
            }else if($id_category == "311"){
                $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND  str_to_date('".$fecha_hoy."','%Y-%m-%d') BETWEEN c.fecha_contrato AND str_to_date(cc.vigencia,'%Y-%m-%d') AND c.id = ci.idconvenio AND idcat = $id_category AND ci.detalle=0 AND c.status=0 ORDER BY orden_cat_tiempo ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
            }else if($id_category == "312"){
                $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND  str_to_date('".$fecha_hoy."','%Y-%m-%d') BETWEEN c.fecha_contrato AND str_to_date(cc.vigencia,'%Y-%m-%d') AND c.id = ci.idconvenio AND idcat = $id_category AND ci.detalle=0 AND c.status=0 ORDER BY orden_cat_tiendas ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
            }else if($id_category == "313"){
                $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND  str_to_date('".$fecha_hoy."','%Y-%m-%d') BETWEEN c.fecha_contrato AND str_to_date(cc.vigencia,'%Y-%m-%d') AND c.id = ci.idconvenio AND idcat = $id_category AND ci.detalle=0 AND c.status=0 ORDER BY orden_cat_servicios ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
            }else if($id_category == "314"){
                $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND  str_to_date('".$fecha_hoy."','%Y-%m-%d') BETWEEN c.fecha_contrato AND str_to_date(cc.vigencia,'%Y-%m-%d') AND c.id = ci.idconvenio AND idcat = $id_category AND ci.detalle=0 AND c.status=0 ORDER BY orden_cat_viajes ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
            }else{
                $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND  str_to_date('".$fecha_hoy."','%Y-%m-%d') BETWEEN c.fecha_contrato AND str_to_date(cc.vigencia,'%Y-%m-%d') AND c.id = ci.idconvenio AND idcat = $id_category AND ci.detalle=0 AND c.status=0 ORDER BY orden_home ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
            }
            //$consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND  str_to_date('".$fecha_hoy."','%Y-%m-%d') BETWEEN c.fecha_contrato AND str_to_date(cc.vigencia,'%Y-%m-%d') AND c.id = ci.idconvenio AND idcat = $id_category ORDER BY orden_home ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
            $rs = mysql_query($consulta, $con);
            while ($row = mysql_fetch_array($rs)) { ?>
                <article class="calugas">
                    <div class="imagen-fondo" style="background: url('https://clarofans.clarochile.cl/admin/beneficios/mantenedor/upload/<?php echo $row["name_imagen"]?>') no-repeat; background-size: 100%;">
                    </div>
                    <span class="contenido">
                                    <h2><?php echo $row["marca"];?></h2>
                                    <p><?php echo utf8_encode($row["tagline"]);?></p>
                                </span>
                    <a class="boton-beneficio" href="https://clarofans.clarochile.cl/admin/beneficios/descuento_detalle.php?id=<?php echo $row["id"]?>" target="_blank">Obtener beneficio ></a>
                </article>
            <?php } ?>
            <div id="page-selection" class="paginador">
                <ul class="navegacion pageControl number">
                    <?php
                    $current_page = intval( $_POST["pagina"]);
                    if ($total_paginas > 1) {
                        if ($current_page >  1 ) {
                            // echo '<li class="page-number"><a href="'.$url.'?type=cat&section='.$id_category.'&pagina='.($pagina-1).'"><i class="ico-chevron-left"></i></a></li>';
                            echo '<li class="page-number"><a href="'.$url.'?type=cat&section='.$id_category.'&pagina='.($pagina-1).'"><<</i></a></li>';
                        }
                        for ($i=1; $i <= $total_paginas; $i++) { 
                            if ($i == $current_page || ($i ==1 && !$current_page)) {
                                echo('<li class="page-number active"><a  href="'.$url.'?type=cat&section='.$id_category.'&pagina='.($i).'">'.$i.'</a></li>');
                            } else {
    
                                echo('<li class="page-number"><a href="'.$url.'?type=cat&section='.$id_category.'&pagina='.($i).'">'.$i.'</a></li>');
                            }
                        }
                        if ($current_page != $total_paginas) {
                            echo '<li class="page-number"><a href="'.$url.'?type=cat&section='.$id_category.'&pagina='.($pagina+1).'">></i></a></li>';
                            // echo '<li class="page-number"><a href="'.$url.'?type=cat&section='.$id_category.'&pagina='.($pagina+1).'"><i class="ico-chevron-right"></i></a></li>';
                        }
                        
                    }
                    ?>
                </ul>
            </div>
       <?php }else{
            echo "<p>NO SE HAN ENCONTRADO RESULTADOS.</p>";
        }
    }else{
        $sql_category = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND  str_to_date('".$fecha_hoy."','%Y-%m-%d') BETWEEN c.fecha_contrato AND str_to_date(cc.vigencia,'%Y-%m-%d') AND c.id = ci.idconvenio AND ci.detalle=0 AND c.status=0";
        $rs_category = mysql_query($sql_category, $con);
        $num_total_registros = mysql_num_rows($rs_category);
        if ($num_total_registros > 0) {
            $TAMANO_PAGINA = 6;
            $pagina = false;
            if (isset($_POST["pagina"]))
                $pagina = $_POST["pagina"];
            if (!$pagina) {
                $inicio = 0;
                $pagina = 1;
            }
            else {
                $inicio = ($pagina - 1) * $TAMANO_PAGINA;
            }
            $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
            $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND  str_to_date('".$fecha_hoy."','%Y-%m-%d') BETWEEN c.fecha_contrato AND str_to_date(cc.vigencia,'%Y-%m-%d') AND ci.detalle=0 AND c.status=0 AND c.id = ci.idconvenio ORDER BY orden_home ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
            $rs = mysql_query($consulta, $con);
            while ($row = mysql_fetch_array($rs)) { ?>
                <article class="calugas">
                    <div class="imagen-fondo" style="background: url('https://clarofans.clarochile.cl/admin/beneficios/mantenedor/upload/<?php echo $row["name_imagen"]?>') no-repeat; background-size: 100%;">
                    </div>
                    <span class="contenido">
                                    <h2><?php echo $row["marca"];?></h2>
                                    <p><?php echo utf8_encode($row["tagline"]);?></p>
                                </span>
                    <a class="boton-beneficio" href="https://clarofans.clarochile.cl/admin/beneficios/descuento_detalle.php?id=<?php echo $row["id"]?>" target="_blank">Obtener beneficio ></a>
                </article>
            <?php } ?>
            <div id="page-selection" class="paginador">
                <ul class="navegacion pageControl number">
                    <?php
                    $current_page = intval( $_POST["pagina"]);
                    if ($total_paginas > 1) {
                        if ($current_page >  1 ) {
                            echo '<li class="page-number"><a href="'.$url.'?type=cat&section='.$id_category.'&pagina='.($pagina-1).'"><</i></a></li>';
                            // echo '<li class="page-number"><a href="'.$url.'?type=cat&section='.$id_category.'&pagina='.($pagina-1).'"><i class="ico-chevron-left"></i></a></li>';
                        }
                        for ($i=1; $i <= $total_paginas; $i++) { 
                            if ($i == $current_page || ($i ==1 && !$current_page)) {
                                echo('<li class="page-number active"><a  href="'.$url.'?type=cat&section='.$id_category.'&pagina='.($i).'">'.$i.'</a></li>');
                            } else {
    
                                echo('<li class="page-number"><a href="'.$url.'?type=cat&section='.$id_category.'&pagina='.($i).'">'.$i.'</a></li>');
                            }
                        }
                        if ($current_page != $total_paginas) {
                            echo '<li class="page-number"><a href="'.$url.'?type=cat&section='.$id_category.'&pagina='.($pagina+1).'">></i></a></li>';
                            // echo '<li class="page-number"><a href="'.$url.'?type=cat&section='.$id_category.'&pagina='.($pagina+1).'"><i class="ico-chevron-right"></i></a></li>';
                        }
                        
                    }
                    ?>
                </ul>
            </div>
       <?php }else{
            echo "<p>NO SE HAN ENCONTRADO RESULTADOS.</p>";
        }
    }
?>
