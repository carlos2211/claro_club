<?php
session_start();
if (isset($_SESSION["id"])){

    include("includes/connLocal.php");

    $cat_conv['306']['cat']='destacados';
    $cat_conv['307']['cat']='belleza';
    $cat_conv['308']['cat']='cursos';
    $cat_conv['309']['cat']='entretencion';
    $cat_conv['310']['cat']='gastronomia';
    $cat_conv['311']['cat']='tiempo';
    $cat_conv['312']['cat']='tiendas';
    $cat_conv['313']['cat']='servicios';
    $cat_conv['314']['cat']='viajes';

    $idconvenio=$_GET["idconvenio"];
    $sql = "SELECT COUNT(id) as total FROM convenio";
    $result=mysql_query($sql,$link_local);
    $total_conv = mysql_fetch_assoc($result);

    $sql = "SELECT idcat, COUNT( id ) as total FROM convenio GROUP BY idcat";
    $result=mysql_query($sql,$link_local); 
    
    while ($value = mysql_fetch_assoc($result)) { 
 
        $cat_conv[$value['idcat']]['total']=$value['total'];
    }

    $sql = "SELECT * FROM convenio WHERE id = '$idconvenio'";
    $result=mysql_query($sql,$link_local);
    $detalle_convenio = mysql_fetch_assoc($result);

    $sql = "SELECT * FROM sucursales WHERE id_convenio = '$idconvenio'";
    $sucursales=mysql_query($sql,$link_local);
     

    $sql = "SELECT * FROM cliente_convenio WHERE idconvenio = '$idconvenio'";
    $result=mysql_query($sql,$link_local);
    $cliente_convenio = mysql_fetch_assoc($result);

    $sql = "SELECT * FROM categoria_convenio WHERE status = 0";
    $result=mysql_query($sql,$link_local);
    $option = "";
    while ($rs = mysql_fetch_assoc($result)){
        if($detalle_convenio['idcat'] == $rs['id']){
            $option.= '<option value="'.$rs['id'].'" selected>'.$rs['nombre'].'</option>';
        }else{
            $option.= '<option value="'.$rs['id'].'">'.$rs['nombre'].'</option>';
        }
    }


    $sql = "SELECT * FROM imagen_convenio WHERE idconvenio = '$idconvenio' and detalle=0";
    $result=mysql_query($sql,$link_local);
    $imagen_convenio = mysql_fetch_assoc($result);

    $sql = "SELECT * FROM imagen_convenio WHERE idconvenio = '$idconvenio' and detalle=1";
    $result=mysql_query($sql,$link_local);
    $imagen_convenio2 = mysql_fetch_assoc($result);
    $imagen2=1;
    if(!$imagen_convenio2){
         $imagen2=0;
        //$imagen_convenio2 = $imagen_convenio;
    }
    
    
    ?>
    
    <!doctype html>

    <html lang="en">

    <head>
        <title>Modificar Convenio</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/jquery-ui.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css" >
        <link rel="stylesheet" href="css/select2.css" >
        <link rel="shorcut icon" href="img/favicon.ico">
        <script src="js/jquery-1.10.2.js"></script>
       

        <script src="js/jquery.min.js"></script>
         <script src="js/jquery-ui.js"></script>
         <script src="js/select2.min.js"></script>
        <script src="js/bootstrap.min.js" ></script>
        <script src="js/sweetalert.min.js"></script>
        <script src="js/multiselect.js"></script>
        <script src="js/ckeditor.js"></script>
        <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

        <style>
            .thumb{
                width: 100%;
                height: auto;
                border: 1px solid #a94442;
                border-top-color:white;
                border-radius: 0px 0px 4px 4px;
            }
        </style>
    </head>

    <body>
    <div class="container">
        <br><br>
        <div class="panel panel-danger">
            <div class="panel-heading">
                <strong>
                    <img src="img/logo_claro.png" width="120" height="41" class="img-rounded"><p align="right" ><strong>Usuario:</strong> <?=$_SESSION["usuario"];?><p><p align="right" ><a href="Login_out.php">Salir</a></p>
                    <h4 align="center">Modificar Convenio</h4>
                    <a href="Lista_Convenios.php" class="button green "><span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span>    Volver</a>
                </strong>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal" method="POST" action="Update_Convenio.php " role="form" id="Update_Convenio" enctype="multipart/form-data">
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="nombreConvenio">Nombre Convenio</label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" id="nombreConvenio" name="nombreConvenio" placeholder="" value="<?=$detalle_convenio['marca']?>">
                                    <input type="hidden" class="form-control" id="id_conv" name="id_conv" value="<?php echo $idconvenio ?>">
                                </div>
                            </div>
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="nombreConvenio"></label>
                                <div class="col-xs-6">
                                    <input type="checkbox" <?php if($detalle_convenio['sin_titulo']){ echo 'checked="checked"'; } ?> name="sin_titulo" value="1"> No mostrar el título en el detalle<br>
                                </div>
                            </div>
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="breveDes">Breve Descripción</label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" id="breveDes" name="breveDes" placeholder="" value="<?=$cliente_convenio['tagline']?>">
                                </div>
                            </div>
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="descuento">Descuento (Opcional)</label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" id="descuento" name="descuento" placeholder="" value="<?=$cliente_convenio['descuento']?>">
                                </div>
                            </div>
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="alerta">Alerta (Cinta)</label>
                                <div class="col-xs-6">
                                    <input type="text" maxlength="30" class="form-control" id="alerta" name="alerta" placeholder="" value="<?=$detalle_convenio['alerta']?>">
                                </div>
                            </div>
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="oferta">Oferta (Cinta)</label>
                                <div class="col-xs-6">
                                    <input type="text" maxlength="10" class="form-control" id="oferta" name="oferta" placeholder="" value="<?=$detalle_convenio['oferta']?>">
                                </div>
                            </div>
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="modouso">Modo de uso</label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" id="modouso" name="modouso" placeholder="" value="<?=$detalle_convenio['modouso']?>">
                                </div>
                            </div>
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="url">URL</label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" id="url" name="url" placeholder="" value="<?=$detalle_convenio['url']?>">
                                </div>
                            </div>
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="detalle">Detalle</label>
                                <div class="col-xs-6">
                                    <textarea class="form-control" rows="5" id="detalle" name="detalle" placeholder="" style="resize: none" rows="10" cols="80"><?=$detalle_convenio['detalle']?></textarea>
                                </div>
                            </div>
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="legal">Legales</label>
                                <div class="col-xs-6">
                                    <textarea class="form-control" rows="5" id="legal" name="legal" placeholder="" style="resize: none"><?=$detalle_convenio['importante']?></textarea>
                                </div>
                            </div>
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="categoria">Categoría</label>
                                <div class="col-xs-6">
                                    <select class="form-control" id="categoria" name="categoria">
                                        <option value = 0 selected>Seleccione Categoría</option>
                                        <?php echo $option ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="orden_cat">Orden Categoría</label>
                                <div class="col-xs-6">
                                    <select class="form-control" id="orden_cat" name="orden_cat">
                                        <option value = 0 >Seleccione Orden</option>

                                        <?php 
                                        $name_cat="orden_cat_".$cat_conv[$detalle_convenio['idcat']]['cat'];
                                        for($i=1;$i<=$cat_conv[$detalle_convenio['idcat']]['total'];$i++){
                                            if($i==$detalle_convenio[$name_cat]){
                                                echo "<option value = $i selected >".$i."</option>";
                                            }
                                            else{
                                                echo "<option value = $i >".$i."</option>";
                                            }


                                        } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="orden_home">Orden Home</label>
                                <div class="col-xs-6">
                                    <select class="form-control" id="orden_home" name="orden_home">
                                        <option value = 0 >Seleccione Orden</option>

                                        <?php for($i=1;$i<=$total_conv['total'];$i++){
                                            if($i==$detalle_convenio['orden_home']){
                                                echo "<option value = $i selected >".$i."</option>";
                                            }
                                            else{
                                                echo "<option value = $i >".$i."</option>";
                                            }


                                        } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="vigenciaDesde">Vigencia</label>
                                <div class="col-xs-3">
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="vigenciaDesde" name="vigenciaDesde" value="<?=$detalle_convenio['fecha_contrato']?>"/>
                                        <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="vigenciaHasta" name="vigenciaHasta" value="<?=$cliente_convenio['vigencia']?>"/>
                                        <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                            </div>
                            <fieldset id="sucursales">
                                <legend>Sucursales</legend>
                                <?php 
                                $count=0;
                                while ($fila =mysql_fetch_assoc($sucursales)) { 
                                    if($count > 0){
                                        echo "<div id='sucursal".$count."' >";
                                    }
                                    ?>

                                    <div class="form-group has-error" >
                                        <label class="col-sm-3 control-label" for="sucursal">Nombre</label>
                                        <div class="col-xs-6">
                                            <input type="text" class="form-control nombre_suc" id="nombre_sucursal<?php echo $count; ?>" name="nombre_sucursal[]" value="<?php echo $fila['nombre']; ?>" placeholder="">
                                        </div>
                                        <?php 
                                        if($count==0){ ?>                   
                                            <button type="button" class="btn btn-success" value="mas" id="btn_mas" name="btn_mas">+</button>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group has-error">
                                        <label class="col-sm-3 control-label" >Coordenadas</label>
                                        <div class="col-xs-3">  
                                            <input type="text" maxlength="10" class="form-control latitud" id="latitud<?php echo $count; ?>" name="latitud[]" placeholder="Latitud" value="<?php echo $fila['latitud']; ?>" />             
                                        </div>
                                        <div class="col-xs-3">
                                            <input type="text" maxlength="11" class="form-control longitud" id="longitud<?php echo $count; ?>" name="longitud[]" placeholder="Longitud" value="<?php echo $fila['longitud']; ?>" />
                                        </div>
                                        <?php if($count>0){ ?> 
                                            <a id="<?php echo $count; ?>" onclick="remove(<?php echo $count; ?>)"">Eliminar</a>
                                        <?php } ?>
                                    </div>
                                    <?php if($count>0){ ?> 
                                        </div>   
                                    <?php } ?>
                                        
                                <?php  $count++; } 
                                if($count==0){ ?>

                                <div class="form-group has-error" >
                                    <label class="col-sm-3 control-label" for="sucursal">Nombre</label>
                                    <div class="col-xs-6">
                                        <input type="text" class="form-control nombre_suc" id="nombre_sucursal<?php echo $count; ?>" name="nombre_sucursal[]" value="<?php echo $fila['nombre']; ?>" placeholder="">
                                    </div>
                                    <?php 
                                    if($count==0){ ?>                   
                                        <button type="button" class="btn btn-success" value="mas" id="btn_mas" name="btn_mas">+</button>
                                    <?php } ?>
                                </div>
                                <div class="form-group has-error">
                                    <label class="col-sm-3 control-label" >Coordenadas</label>
                                    <div class="col-xs-3">  
                                        <input type="text" maxlength="10" class="form-control latitud" id="latitud<?php echo $count; ?>" name="latitud[]" placeholder="Latitud" value="<?php echo $fila['latitud']; ?>" />             
                                    </div>
                                    <div class="col-xs-3">
                                        <input type="text" maxlength="11" class="form-control longitud" id="longitud<?php echo $count; ?>" name="longitud[]" placeholder="Longitud" value="<?php echo $fila['longitud']; ?>" />
                                    </div>
                                </div>

                               <?php  }

                                ?>                                                          
                                
                                
                            </fieldset>

                            <?php
                                $cadena = $detalle_convenio['regiones'];
                                $arr_regiones_bd = explode(",", $cadena);

                                $cadena_regiones = "Arica y Parinacota,Tarapaca,Antofagasta,Atacama,Coquimbo,Valparaiso,OHiggins,Maule,Bio Bio,Araucania,Los Rios,Aysen,Metropolitana,Los Lagos,Magallanes";
                                $arr_regiones = explode(",", $cadena_regiones);

                                $option_all = "";
                                $option_bd = "";

                                $result = array_diff($arr_regiones,$arr_regiones_bd);
                                foreach ($result as $clave => $valor_all) {
                                    $option_all .=  '<option value="'.$valor_all.'">'.$valor_all.'</option>';
                                }

                                foreach ($arr_regiones_bd as $clave => $valor_bd) {
                                    $option_bd .=  '<option value="'.$valor_bd.'">'.$valor_bd.'</option>';
                                }
                            ?>

                            <div class="row" style="margin-left: 0px;margin-right: 0px">
                                <div class="col-xs-5">
                                    <select name="from[]" id="search" class="form-control" size="8" multiple="multiple">
                                        <?php echo $option_all ?>
                                    </select>
                                </div>
                                <div class="col-xs-2">
                                    <button type="button" id="search_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                    <button type="button" id="search_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                </div>
                                <div class="col-xs-5">
                                    <select name="to[]" id="search_to" class="form-control" size="8" multiple="multiple">
                                        <?php echo $option_bd ?>
                                    </select>
                                </div>
                                <input style="display:none" id="regiones" name="regiones">
                            </div>
                            <div class="form-group has-error" style="margin-top: 15px">
                                <label class="col-sm-3 control-label" for="imagen">Logo Convenio</label>
                                <div class="col-xs-6">
                                    <input type="file" class="form-control" id="imagen" name="imagen">
                                    <input type="hidden" class="form-control" id="imagen_BD" name="imagen_BD" value="<?php echo $imagen_convenio['name_imagen'] ?>">
                                    <output id="list" style="padding-top: 0px;"></output>
                                </div>
                            </div>
                             <div class="form-group has-error" style="margin-top: 15px">
                                <label class="col-sm-3 control-label" for="image2n">Imagen detalle</label>
                                <div class="col-xs-6">
                                    <input type="file" class="form-control" id="imagen2" name="imagen2">
                                    <input type="hidden" class="form-control" id="imagen_BD2" name="imagen_BD2" value="<?php if($imagen2){ echo $imagen_convenio2['name_imagen']; } ?>">
                                    <output id="list2" style="padding-top: 0px;"></output>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-5 col-sm-9">
                                    <button type="button" class="btn btn-danger" value="guardar" onclick="enviar()">Modificar Convenio</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
    <?php
}else{

    header ("Location: Login.php");

}
?>

<script>
     var cats=<?php echo  json_encode($cat_conv); ?>;
</script>
<script>
    var pos = <?php echo $count; ?>;
    var imagen2 = <?php echo $imagen2; ?>;
    pos= parseInt(pos);
    if(pos==0){
        pos= 1;
    }
    $(window).load(function() {
        
        

        $( "#btn_mas" ).click(function() {
            var suc="<div id='sucursal"+pos+"' >"+
                "<div class='form-group has-error' >"+
                    "<label class='col-sm-3 control-label' for='sucursal'>Nombre</label>"+
                    "<div class='col-xs-6' id='sucursales' name='sucursales'>"+
                        "<input type='text' class='form-control nombre_suc' id='nombre_sucursal"+pos+"' name='nombre_sucursal[]"+pos+"' placeholder=''>"+
                    "</div>"+                            
                "</div>"+
                "<div class='form-group has-error'>"+
                    "<label class='col-sm-3 control-label' for='vigenciaDesde'>Coordenadas</label>"+
                    "<div class='col-xs-3'>"+
                        "<input type='text' class='form-control latitud' maxlength='10' id='latitud"+pos+"' name='latitud[]"+pos+"' placeholder='Latitud' />"+
                    "</div>"+
                    "<div class='col-xs-3'>"+
                        "<input type='text' maxlength='11' class='form-control longitud' id='longitud"+pos+"' name='longitud[]"+pos+"' placeholder='Longitud'/>"+
                    "</div>"+
                    "<a id='"+pos+"' onclick='remove("+pos+")'>Eliminar</a>"+
                "</div>"+
            "</div>";
            if(pos<=4){
                $("#sucursales").append(suc);
                pos = pos + 1;

            }
            else{
                $("#btn_mas").hide();
            }
        });
    });

    function remove(element) {
        pos = pos - 1;
        $("#sucursal"+element+"").remove();
        $("#"+element+"").remove();
        $("#btn_mas").show();
        
    }
    ClassicEditor
        .create( document.querySelector('#detalle'))
        .catch( error => {
            console.error( error );
        } );
    $("#orden_home").select2();
    $("#orden_cat").select2();
    $("#categoria").change(function(){    
        var val=$("#categoria").val();
        $("#orden_cat").html('');
        $("#orden_cat").append('<option value = 0 >Seleccione Orden</option>');
        for(i=1;i<=cats[val].total;i++){
            $("#orden_cat").append('<option value = '+i+'>'+i+'</option>');
        }
    });

    $('#search').multiselect({
        search: {
            left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
        },
        fireSearch: function(value) {
            return value.length > 3;
        }
    });

    function enviar() {
         var reg_lat = new RegExp(/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}$/);
        var reg_lng = new RegExp(/^-?([1-8]?[1-9]|[1-9]0|[1]?[1-7]?[1-9]|[1]?[1-8]0)\.{1}\d{1,6}$/);
        var lat_error=false;
        var lng_error=false;
        var name_error=false;
        var count_suc=0;
        $(".nombre_suc").each(function() {
            $(this).val($.trim($(this).val()));
            if($(this).val()==""){
                if($("#latitud"+count_suc).val()!="" || $("#longitud"+count_suc).val()!=""){
                    
                    name_error=true;
                }
            }

            count_suc=count_suc+1;
        });
        if( name_error==false && $("#latitud0").val()=="" && $("#longitud0").val()=="" &&  count_suc==1){
            regiones();
            $("#Update_Convenio").submit();


        }
        else{
            $(".latitud").each(function() {
                $(this).val($.trim($(this).val()));
                if( !reg_lat.exec($.trim($(this).val())) ) {         
                    lat_error=true;           
                }
            });

           $(".longitud").each(function() {
                $(this).val($.trim($(this).val()));
                if( !reg_lng.exec($.trim($(this).val())) ) {
                    lng_error=true;
                }
            });
           if(!lat_error && !lng_error && !name_error){
                regiones();
                $("#Update_Convenio").submit();
           }
           else{
                if(lat_error || lng_error){
                    alert('Introduzca coordenadas en un formato correcto');
                }
                else if(name_error){
                    alert('Introduzca nombres de sucursales');
                }
                
           }

        }
       
        
    }

    function regiones(){
        var concatValor = '';
        $("#search_to option").each(function(){
            if ($(this).val() != "" ){
                concatValor += $(this).val()+',';
            }
        });
        var regiones = concatValor.substr(0,concatValor.length - 1);
        $("#regiones").val(regiones);
    }

    function archivo(evt) {
        var files = evt.target.files; // FileList object
        // Obtenemos la imagen del campo "file".
        for (var i = 0, f; f = files[i]; i++) {
            //Solo admitimos imágenes.
            if (!f.type.match('image.*')) {
                continue;
            }
            var reader = new FileReader();
            reader.onload = (function(theFile) {
                return function(e) {
                    // Insertamos la imagen
                    document.getElementById("list").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                    $("#imagen").css({"border-bottom-color":"white", "border-radius": "4px 4px 0px 0px"});
                };
            })(f);
            reader.readAsDataURL(f);
        }
    }
    document.getElementById('imagen').addEventListener('change', archivo, false);

    function archivo2(evt) {
        var files = evt.target.files; // FileList object
        // Obtenemos la imagen del campo "file".
        for (var i = 0, f; f = files[i]; i++) {
            //Solo admitimos imágenes.
            if (!f.type.match('image.*')) {
                continue;
            }
            var reader = new FileReader();
            reader.onload = (function(theFile) {
                return function(e) {
                    // Insertamos la imagen
                    document.getElementById("list2").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                    $("#imagen2").css({"border-bottom-color":"white", "border-radius": "4px 4px 0px 0px"});
                };
            })(f);
            reader.readAsDataURL(f);
        }
    }
    document.getElementById('imagen2').addEventListener('change', archivo2, false);

    $( document ).ready(function() {
        $(".ck-file-dialog-button").remove();
        document.getElementById("list").innerHTML = ['<img class="thumb" src="http://clarofans.clarochile.cl/admin/beneficios/mantenedor/upload/<?php echo $imagen_convenio['name_imagen']?>" title=""/>'].join('');
       if(imagen2!=0){
        document.getElementById("list2").innerHTML = ['<img class="thumb" src="http://clarofans.clarochile.cl/admin/beneficios/mantenedor/upload/<?php echo $imagen_convenio2['name_imagen']?>" title=""/>'].join('');
       }
         
        
        
    });
</script>