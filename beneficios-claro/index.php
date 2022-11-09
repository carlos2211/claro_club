<?php
    require 'includes/conn.php';
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html>
<head>

    <!-- Google Tag Manager -->
    <!--<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-TVGSCZP');</script>-->
    <!-- End Google Tag Manager -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" >
    <link rel="shorcut icon" href="assets/img/favicon.ico">
    <title>Beneficios | Claro Chile</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
    <script src="assets/js/jquery-3.3.1.min.js"></script>
</head>
<body>

    <!-- Google Tag Manager (noscript) -->
    <!--<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TVGSCZP"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>-->
    <!-- End Google Tag Manager (noscript) -->

    <!-- MAGAZINE -->
    <section>
    </section>
    <!-- BENEFICIOS -->
    <div class="filtros-container">
        <div style="display:inline-block;margin:auto;">
            <label>Filtrar por:</label>
            <span class="select">
                <select id="category" name="category">
                    <option value="all">Ver Todos</option>
                    <?php
                        $sql = "SELECT DISTINCT (c.idcat), cc.nombre FROM convenio c, categoria_convenio cc WHERE c.idcat = cc.id AND cc.status = 0";
                        $rs = mysql_query($sql, $con);
                        while ($row = mysql_fetch_array($rs)) { ?>
                            <option value="<?php echo $row["idcat"]?>"><?php echo utf8_encode($row["nombre"])?></option>
                        <?php }
                    ?>
                </select>
            </span>
            <span class="select">
                <select id="regiones" name="regiones">
                    <option value="all_regions">Ver Todos</option>
                    <option value="Antofagasta">Antofagasta</option>
                    <option value="Araucania">Araucanía</option>
                    <option value="AricayParinacota">Arica y Parinacota</option>
                    <option value="Atacama">Atacama</option>
                    <option value="Aysen">Aysén</option>
                    <option value="BioBio">Bío Bío</option>
                    <option value="Coquimbo">Coquimbo</option>
                    <option value="LosRios">Los Rios</option>
                    <option value="LosLagos">Los lagos</option>
                    <option value="Magallanes">Magallanes</option>
                    <option value="Maule">Maule</option>
                    <option value="Metropolitana">Metropolitana</option>
                    <option value="OHiggins">O'Higgins</option>
                    <option value="Tarapaca">Tarapacá</option>
                    <option value="Valparaiso">Valparaíso</option>
                </select>
            </span>
        </div>
    </div>
    <section class="beneficios">
        <?php
            if (isset($_GET["type"]))
                $tipo_filtro = $_GET["type"];
            if($tipo_filtro == "cat"){
                if (isset($_GET["section"]))
                    $category = $_GET["section"];
                if($category != "all"){
                    $consulta_noticias = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND c.id = ci.idconvenio AND idcat = $category AND ci.detalle=0 AND c.status = 0";
                    $rs_noticias = mysql_query($consulta_noticias, $con);
                    $num_total_registros = mysql_num_rows($rs_noticias);
                    if ($num_total_registros > 0) {
                        $TAMANO_PAGINA = 6;
                        $pagina = false;
                        if (isset($_GET["pagina"]))
                            $pagina = $_GET["pagina"];
                        if (!$pagina) {
                            $inicio = 0;
                            $pagina = 1;
                        }
                        else {
                            $inicio = ($pagina - 1) * $TAMANO_PAGINA;
                        }
                        $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
                        if($category == "307"){
                            $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND c.id = ci.idconvenio AND idcat = $category AND c.status = 0 ORDER BY orden_cat_belleza ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
                        }else if($category == "308"){
                            $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND c.id = ci.idconvenio AND idcat = $category AND c.status = 0 ORDER BY orden_cat_cursos ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
                        }else if($category == "309"){
                            $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND c.id = ci.idconvenio AND idcat = $category AND c.status = 0 ORDER BY orden_cat_entretencion ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
                        }else if($category == "310"){
                            $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND c.id = ci.idconvenio AND idcat = $category ORDER BY orden_cat_gastronomia AND c.status = 0 ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
                        }else if($category == "311"){
                            $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND c.id = ci.idconvenio AND idcat = $category AND c.status = 0 ORDER BY orden_cat_tiempo ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
                        }else if($category == "312"){
                            $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND c.id = ci.idconvenio AND idcat = $category AND c.status = 0 ORDER BY orden_cat_tiendas ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
                        }else if($category == "313"){
                            $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND c.id = ci.idconvenio AND idcat = $category AND c.status = 0 ORDER BY orden_cat_servicios ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
                        }else if($category == "314"){
                            $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND c.id = ci.idconvenio AND idcat = $category AND c.status = 0 ORDER BY orden_cat_viajes ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
                        }else{
                            $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND c.id = ci.idconvenio AND idcat = $category AND c.status = 0 ORDER BY orden_home ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
                        }
                        $rs = mysql_query($consulta, $con);
                        while ($row = mysql_fetch_array($rs)) {?>
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
                            echo '<li class="page-number"><a href="'.$url.'?type=cat&section='.$id_category.'&pagina='.($pagina-1).'"><</a></li>';
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
                            echo '<li class="page-number"><a href="'.$url.'?type=cat&section='.$id_category.'&pagina='.($pagina+1).'">></a></li>';
                            // echo '<li class="page-number"><a href="'.$url.'?type=cat&section='.$id_category.'&pagina='.($pagina+1).'"><i class="ico-chevron-right"></i></a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
                  <?php }
                }else{
                    $consulta_noticias2 = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND c.id = ci.idconvenio AND c.status = 0";
                    $rs_noticias2 = mysql_query($consulta_noticias2, $con);
                    $num_total_registros2 = mysql_num_rows($rs_noticias2);
                    if ($num_total_registros2 > 0) {
                        $TAMANO_PAGINA = 6;
                        $pagina = false;
                        if (isset($_GET["pagina"]))
                            $pagina = $_GET["pagina"];
                        if (!$pagina) {
                            $inicio = 0;
                            $pagina = 1;
                        }
                        else {
                            $inicio = ($pagina - 1) * $TAMANO_PAGINA;
                        }
                        $total_paginas2 = ceil($num_total_registros2 / $TAMANO_PAGINA);
                        $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND c.status = 0 AND c.id = ci.idconvenio ORDER BY orden_home ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
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
                            echo '<li class="page-number"><a href="'.$url.'?type=cat&section='.$id_category.'&pagina='.($pagina-1).'"><</a></li>';
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
                            echo '<li class="page-number"><a href="'.$url.'?type=cat&section='.$id_category.'&pagina='.($pagina+1).'">></a></li>';
                            // echo '<li class="page-number"><a href="'.$url.'?type=cat&section='.$id_category.'&pagina='.($pagina+1).'"><i class="ico-chevron-right"></i></a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
                    <?php }
                }
            }else if($tipo_filtro == "reg"){
                if (isset($_GET["region"]))
                    $region = $_GET["region"];
                if($region != "all_regions"){
                    $consulta_noticias = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND c.id = ci.idconvenio AND c.status = 0 AND regiones LIKE '%".$region."%'";
                    $rs_noticias = mysql_query($consulta_noticias, $con);
                    $num_total_registros = mysql_num_rows($rs_noticias);
                    if ($num_total_registros > 0) {
                        $TAMANO_PAGINA = 6;
                        $pagina = false;
                        if (isset($_GET["pagina"]))
                            $pagina = $_GET["pagina"];
                        if (!$pagina) {
                            $inicio = 0;
                            $pagina = 1;
                        }
                        else {
                            $inicio = ($pagina - 1) * $TAMANO_PAGINA;
                        }
                        $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
                        $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND c.id = ci.idconvenio AND c.status = 0 AND regiones LIKE '%".$region."%' ORDER BY orden_home ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
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
                            echo '<li class="page-number"><a href="'.$url.'?type=reg&region='.$region_url.'&pagina='.($pagina-1).'"><</a></li>';
                            // echo '<li class="page-number"><a href="'.$url.'?type=reg&region='.$region_url.'&pagina='.($pagina-1).'"><i class="ico-chevron-left"></i></a></li>';
                        }
                        for ($i=1; $i <= $total_paginas; $i++) { 
                            if ($i == $current_page || ($i ==1 && !$current_page)) {
                                echo('<li class="page-number active"><a  href="'.$url.'?type=reg&region='.$region_url.'&pagina='.($i).'">'.$i.'</a></li>');
                            } else {
    
                                echo('<li class="page-number"><a href="'.$url.'?type=reg&region='.$region_url.'&pagina='.($i).'">'.$i.'</a></li>');
                            }
                        }
                        if ($current_page != $total_paginas) {
                            echo '<li class="page-number"><a href="'.$url.'?type=reg&region='.$region_url.'&pagina='.($pagina+1).'">></a></li>';
                            // echo '<li class="page-number"><a href="'.$url.'?type=reg&region='.$region_url.'&pagina='.($pagina+1).'"><i class="ico-chevron-right"></i></a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
                   <?php }
                }else{
                    $consulta_noticias2 = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND c.id = ci.idconvenio AND c.status = 0";
                    $rs_noticias2 = mysql_query($consulta_noticias2, $con);
                    $num_total_registros2 = mysql_num_rows($rs_noticias2);
                    if ($num_total_registros2 > 0) {
                        $TAMANO_PAGINA = 6;
                        $pagina = false;
                        if (isset($_GET["pagina"]))
                            $pagina = $_GET["pagina"];
                        if (!$pagina) {
                            $inicio = 0;
                            $pagina = 1;
                        }
                        else {
                            $inicio = ($pagina - 1) * $TAMANO_PAGINA;
                        }
                        $total_paginas2 = ceil($num_total_registros2 / $TAMANO_PAGINA);
                        $consulta = "SELECT c.id, c.marca, cc.tagline, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND c.status = 0 AND c.id = ci.idconvenio ORDER BY orden_home ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
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
                            echo '<li class="page-number"><a href="'.$url.'?type=reg&region='.$region.'&pagina='.($pagina-1).'"><</a></li>';
                            // echo '<li class="page-number"><a href="'.$url.'?type=reg&region='.$region.'&pagina='.($pagina-1).'"><i class="ico-chevron-left"></i></a></li>';
                        }
                        for ($i=1; $i <= $total_paginas; $i++) { 
                            if ($i == $current_page || ($i ==1 && !$current_page)) {
                                echo('<li class="page-number active"><a  href="'.$url.'?type=reg&region='.$region.'&pagina='.($i).'">'.$i.'</a></li>');
                            } else {
    
                                echo('<li class="page-number"><a href="'.$url.'?type=reg&region='.$region.'&pagina='.($i).'">'.$i.'</a></li>');
                            }
                        }
                        if ($current_page != $total_paginas) {
                            echo '<li class="page-number"><a href="'.$url.'?type=reg&region='.$region.'&pagina='.($pagina+1).'">></i></a></li>';
                            // echo '<li class="page-number"><a href="'.$url.'?type=reg&region='.$region.'&pagina='.($pagina+1).'"><i class="ico-chevron-right"></i></a></li>';
                        }
                        
                    }
                    ?>
                </ul>
            </div>
                    <?php }
                }
            }
        ?>
    </section>
</body>
</html>

<script>
    var ref="";
    $(document).ready(function(){
    

        
        var load = $('select[name=category]').val();
        var load_type = '<?php echo $_GET["type"]; ?>';
        if( load_type != ""){
            if(load_type == "cat"){
                var load_url = '<?php echo $_GET["section"]; ?>';
                if( load_url != ""){
                    $("#category option[value=<?php echo $_GET["section"]?>]").attr("selected",true);
                    load = load_url;
                }
                $.ajax({
                    type: "POST",
                    url: "category.php",
                    data: "category="+load+"&pagina=<?php echo $pagina; ?>",
                    dataType: "html",
                    error: function(){
                        alert("Error petición ajax");
                    },
                    success: function(data){
                        $('.beneficios').empty();
                        $('.beneficios').append(data);
                       
                    }
                });
            }else if(load_type == "reg"){
                var load_reg = $('select[name=regiones]').val();
                var load_url_reg = '<?php echo $_GET["region"]; ?>';
                if( load_url_reg != ""){
                    $("#regiones option[value=<?php $rg = str_replace(" ", "", $_GET["region"]); echo $rg?>]").attr("selected",true);
                    load_reg= load_url_reg;
                }
                $.ajax({
                    type: "POST",
                    url: "region.php",
                    data: "region="+load_reg+"&pagina=<?php echo $pagina; ?>",
                    dataType: "html",
                    error: function(){
                        alert("Error petición ajax");
                    },
                    success: function(data){
                        $('.beneficios').empty();
                        $('.beneficios').append(data);
                        
                    }
                });
            }
        }else{
            var load_url = '<?php echo $_GET["section"]; ?>';
            if( load_url != ""){
                $("#category option[value=<?php echo $_GET["section"]?>]").attr("selected",true);
                load = load_url;
            }
            $.ajax({
                type: "POST",
                url: "category.php",
                data: "category="+load+"&pagina=<?php echo $pagina; ?>",
                dataType: "html",
                error: function(){
                    alert("Error petición ajax");
                },
                success: function(data){
                    $('.beneficios').empty();
                    $('.beneficios').append(data);
                    
                }
            });
        }

        $("select[name=category]").change(function(){
            var selected_change = $('select[name=category]').val();
            $("#regiones").val('all_regions');
            //history.replaceState(null, null, 'http://test2.claro-cl.tmx-internacional.net/personas/servicios/claro-club/?type=cat&section='+selected_change+'&pagina=1');
            $.ajax({
                type: "POST",
                url: "category.php",
                data: "category="+selected_change+"&pagina=1",
                dataType: "html",
                error: function(){
                    alert("Error petición ajax");
                },
                success: function(data){
                    $('.beneficios').empty();
                    $('.beneficios').append(data);
                    
                }
            });
        });

        $("select[name=regiones]").change(function(){
            var selected_region = $('select[name=regiones]').val();
             $("#category").val('all');
            //history.replaceState(null, null, 'http://test2.claro-cl.tmx-internacional.net/personas/servicios/claro-club/?type=reg&region='+selected_region+'&pagina=1');
            $.ajax({
                type: "POST",
                url: "region.php",
                data: "region="+selected_region+"&pagina=1",
                dataType: "html",
                error: function(){
                    alert("Error petición ajax");
                },
                success: function(data){
                    $('.beneficios').empty();
                    $('.beneficios').append(data);
                    
                }
            });
        });
    });
</script>