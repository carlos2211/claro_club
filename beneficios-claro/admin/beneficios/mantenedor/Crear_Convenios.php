<?php
session_start();
if (isset($_SESSION["id"])){

    include("includes/connLocal.php");

    $sql = "SELECT * FROM categoria_convenio WHERE status = 0";
    $result=mysql_query($sql,$link_local);
    $option = "";
    while ($rs = mysql_fetch_assoc($result)){
        $option.= '<option value="'.$rs['id'].'">'.$rs['nombre'].'</option>';
    }
?>

    <!doctype html>

    <html lang="en">

    <head>
        <title>Crear Convenio</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/jquery-ui.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css" >
        <link rel="shorcut icon" href="img/favicon.ico">
        <script src="js/jquery-1.10.2.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script src="js/jquery.min.js"></script>
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
                    <h4 align="center">Crear Convenio</h4>
                    <a href="Mantenedor_Claro.php" class="button green "><span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span>    Volver</a>
                </strong>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal" method="POST" action="Agregar_Convenio.php " role="form" id="Crear_Convenio" enctype="multipart/form-data">
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="nombreConvenio">Nombre Convenio</label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" id="nombreConvenio" name="nombreConvenio" placeholder="">
                                </div>
                            </div>
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="nombreConvenio"></label>
                                <div class="col-xs-6">
                                    <input type="checkbox" checked="checked" name="sin_titulo" value="1"> No mostrar el título en el detalle<br>
                                </div>
                            </div>
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="breveDes">Breve Descripción</label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" id="breveDes" name="breveDes" placeholder="">
                                </div>
                            </div>
                            <!--<div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="promocion">Texto Promoción</label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" id="promocion" name="promocion" placeholder="">
                                </div>
                            </div>-->
                        <fieldset>
                            <legend>Detalle Convenio</legend>
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="descuento">Descuento (Opcional)</label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" id="descuento" name="descuento" placeholder="">
                                </div>
                            </div>


                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="alerta">Alerta (Cinta)</label>
                                <div class="col-xs-6">
                                    <input type="text" maxlength="20" class="form-control" id="alerta" name="alerta" placeholder="">
                                </div>
                            </div>
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="oferta">Oferta (Cinta)</label>
                                <div class="col-xs-6">
                                    <input type="text" maxlength="10" class="form-control" id="oferta" name="oferta" placeholder="">
                                </div>
                            </div>
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="modouso">Modo de uso</label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" id="modouso" name="modouso" placeholder="">
                                </div>
                            </div>
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="url">URL</label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" id="url" name="url" placeholder="">
                                </div>
                            </div>
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="detalle">Detalle</label>
                                <div class="col-xs-6">
                                    <textarea class="form-control" rows="5" id="detalle" name="detalle" placeholder="" style="resize: none" rows="10" cols="80"></textarea>
                                </div>
                            </div>
                            <div class="form-group has-error">
                                <label class="col-sm-3 control-label" for="legal">Legales</label>
                                <div class="col-xs-6">
                                    <textarea class="form-control" rows="5" id="legal" name="legal" placeholder="" style="resize: none"></textarea>
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
                                <label class="col-sm-3 control-label" for="vigenciaDesde">Vigencia</label>
                                <div class="col-xs-3">
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="vigenciaDesde" name="vigenciaDesde"/>
                                        <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="vigenciaHasta" name="vigenciaHasta"/>
                                        <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                            <fieldset id="sucursales">
                                <legend>Sucursales</legend>
                                <div class="form-group has-error" >
                                    <label class="col-sm-3 control-label" for="sucursal">Nombre</label>
                                    <div class="col-xs-6">
                                        <input type="text" class="form-control nombre_suc" id="nombre_sucursal0" name="nombre_sucursal[]" placeholder="">
                                    </div>
                                    <button type="button" class="btn btn-success" value="mas" id="btn_mas" name="btn_mas">+</button>
                                </div>
                                <div class="form-group has-error">
                                    <label class="col-sm-3 control-label" >Coordenadas</label>
                                    <div class="col-xs-3">  
                                        <input type="text" maxlength="10" class="form-control latitud" id="latitud0" name="latitud[]" placeholder="Latitud" />             
                                    </div>
                                    <div class="col-xs-3">
                                        <input type="text" maxlength="11" class="form-control longitud" id="longitud0" name="longitud[]" placeholder="Longitud"/>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="row" style="margin-left: 0px;margin-right: 0px">
                                <div class="col-xs-5">
                                    <select name="from[]" id="search" class="form-control" size="8" multiple="multiple">
                                        <option value="Arica y Parinacota">Arica y Parinacota</option>
                                        <option value="Tarapaca">Tarapacá</option>
                                        <option value="Antofagasta">Antofagasta</option>
                                        <option value="Atacama">Atacama</option>
                                        <option value="Coquimbo">Coquimbo</option>
                                        <option value="Valparaiso">Valparaíso</option>
                                        <option value="OHiggins">O'Higgins</option>
                                        <option value="Maule">Maule</option>
                                        <option value="Bio Bio">Bío Bío</option>
                                        <option value="Araucania">Araucanía</option>
                                        <option value="Los Rios">Los Rios</option>
                                        <option value="Los Lagos">Los lagos</option>
                                        <option value="Magallanes">Magallanes</option>
                                        <option value="Aysen">Aysén</option>
                                        <option value="Metropolitana">Metropolitana</option>
                                    </select>
                                </div>
                                <div class="col-xs-2">
                                    <button type="button" id="search_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                    <button type="button" id="search_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                </div>
                                <div class="col-xs-5">
                                    <select name="to[]" id="search_to" class="form-control" size="8" multiple="multiple"></select>
                                </div>
                                <input style="display:none" id="regiones" name="regiones">
                            </div>
                            <div class="form-group has-error" style="margin-top: 15px">
                                <label class="col-sm-3 control-label" for="imagen">Logo Convenio</label>
                                <div class="col-xs-6">
                                    <input type="file" class="form-control" id="imagen" name="imagen">
                                    <output id="list" style="padding-top: 0px;"></output>
                                </div>
                            </div>
                            <div class="form-group has-error" style="margin-top: 15px">
                                <label class="col-sm-3 control-label" for="imagen2">Imagen detalle</label>
                                <div class="col-xs-6">
                                    <input type="file" class="form-control" id="imagen2" name="imagen2">
                                    <output id="list2" style="padding-top: 0px;"></output>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-5 col-sm-9">
                                    <button type="button" class="btn btn-danger" value="guardar" onclick="enviar()">Crear Convenio</button>
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
    var pos = 1;
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
                        "<input type='text' maxlength='10' class='form-control latitud' id='latitud"+pos+"' name='latitud[]"+pos+"' placeholder='Latitud' />"+
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
        console.log(pos);
        $("#sucursal"+element+"").remove();
        $("#"+element+"").remove();
        $("#btn_mas").show();
        
    }
     ClassicEditor
        .create( document.querySelector('#detalle'))
        .catch( error => {
            console.error( error );
        } );

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
            $("#Crear_Convenio").submit();
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
                $("#Crear_Convenio").submit();
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

    $( document ).ready(function() {
        $(".ck-file-dialog-button").remove();
    });
</script>

<script>
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
    document.getElementById('imagen').addEventListener('change', archivo, false);
    document.getElementById('imagen2').addEventListener('change', archivo2, false);
</script>