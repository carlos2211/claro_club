<?

$id = (isset($_GET["id"])) ? $_GET["id"] : "";

if ($id != ""){

include("nav/global.php");

$glob = new globales;

  $cuerpo = $glob->trae_datos("".$glob->local."/descuento_detalle.php?token=ZGVzY3VlbnRvX2RldGFsbGUucGhw&id=".$id);
  $detalle_convenio=json_decode($cuerpo, true);

  //print_r($detalle_convenio);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es-CL">

<head>
    <title>Clarochile</title>
    <!-- Meta -->
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <meta http-equiv="Content-Language" content="es">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!-- Meta Responsive -->
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <!-- Meta SEO -->
    <meta name="Title" content="Clarochile">
    <meta name="description" content="Clarochile" />
    <meta name="distribution" content="global">
    <meta name="author" content="Claro Chile">
    <meta name="robots" content="all,index,follow" />
    <meta name="googlebot" content="all,index,follow" />
    <meta name="google" content="notranslate" />
    <!-- STYLE -->
    <link rel="stylesheet" href="assets/css/screen.css" type="text/css">
    <!-- SCRIPT -->
    <script src="assets/js/jquery-1.10.2.min.js"></script>
    <script src="assets/js/jquery.placeholder.min.js"></script>
    <script src="assets/js/modernizr.js" type="text/javascript"></script>
    <script src="js/comun.js" type="text/javascript"></script>
    <script type="text/javascript">

    function valida_cli(){
        var paso;
        paso=true;
        $("#enviar").prop( "disabled", true );

        $("#f_rut").removeClass("error");

        //alert("entro");

        if ($("#rut").val()=="" && paso){
            paso=false;
            $("#f_rut").addClass("error");
            $("#error_rut").html("Ingresa un rut");
            $("#enviar").prop( "disabled", false );
            $("#rut").focus();

        }

        if (Rut($("#rut").val()) != true && paso){
            paso=false;
            $("#f_rut").addClass("error");
            $("#error_rut").html("Ingresa un rut válido");
            $("#enviar").prop( "disabled", false );
            $("#rut").focus();
        }

        if ($("#celular").val()=="" && paso){
            paso=false;
            $("#f_celular").addClass("error");
            $("#error_celular").html("Ingresa un número válido");
            $("#enviar").prop( "disabled", false );
            $("#celular").focus();
        }
        if (!/^([0-9])*$/.test($("#celular").val())&& paso){
            paso=false;
            $("#f_celular").addClass("error");
            $("#error_celular").html("Ingresa un número válido");
            $("#enviar").prop( "disabled", false );
            $("#celular").focus();
        } 
        if (($("#celular").val().length > 9 || $("#celular").val().length < 4)  && paso){
            paso=false;
            $("#f_celular").addClass("error");
            $("#error_celular").html("Ingresa un número válido");
            $("#enviar").prop( "disabled", false );
            $("#celular").focus();
        } 
        if(paso){

            $("#form1").submit();


        }
      


        //alert($("#rut").val());
        
        //alert(respuesta);
    }

    function limpia(e){

        if (e='rut'){

            $("#f_rut").removeClass("error");

        }
        if (e='celular'){

            $("#f_celular").removeClass("error");


        }

    }
 
    </script>
</head>

<body>
    <div class="container">
        <h1><?=$detalle_convenio['nombre']?></h1>
        <!---->
        <ul class="links">
            <li class="facebook"><a href="https://www.facebook.com/clarochile" target="_blank">facebook</a></li>
            <li class="twitter"><a href="https://twitter.com/clarochile_cl" target="_blank">twitter</a></li>
            <li class="youtube"><a href="https://www.youtube.com/user/canalclarochile" target="_blank">youtube</a></li>

        </ul>
        <!---->
        <div class="beneficio">
            <ul class="menu">
                <li class="activo obtener"><a href="#obtener">Obtener</a></li>
                <li class="detalles"><a href="#detalles">Detalles</a></li>
                <li class="sucursales"><a href="#sucursales">Sucursales</a></li>
            </ul>
            <div class="contenido">
                <? if ($id == 1581){ ?>

<style>
.botonera {
margin-left: 17%;
}
.botonera a {
padding: 10px;
cursor: pointer;
font-size: 0;
display: block;
height: 100px;
width: 80px;
float: left;
}
.b1 {
background: url(images/cineplanet/35off.png) no-repeat;
}
.b1:hover {
background: url(images/cineplanet/35off.png) no-repeat;
}
.b2 {
background: url(images/cineplanet/3doff.png) no-repeat;
}
.b2:hover {
background: url(images/cineplanet/3don.png) no-repeat;
}
.b3 {
background: url(images/cineplanet/popcorn.png) no-repeat;
}
.b3:hover {
background: url(images/cineplanet/popcorn.png) no-repeat;
}
.b4 {
background: url(images/cineplanet/cineoff.png) no-repeat;
}
.b4:hover {
background: url(images/cineplanet/cineon.png) no-repeat;
}

</style>
                <div class="botonera" id="obtener">
                        <a class="b1" href="detalle0b30.html?id=2">Cine 2D</a>
                        <a class="b2" href="detalled708.html?id=3">Cine 3D</a>
                        <a class="b3" href="detalled61c.html?id=5">Confiteria</a>
                        <a href="http://www.cineplanet.cl/" target="_blank" class="b4">Ver cartelera</a>
                </div>

                <? }else{?>

                <div id="obtener">
                    <h2>Para obtener el beneficio ingresa tus datos de cliente</h2>
                    <form name="form1" id="form1" action="descuento_detalle_.php" method="post">
                        <fieldset id="f_rut" name="f_rut">
                            <label>Rut</label>
                            <input name="rut" id="rut" type="text" placeholder="12.345.678-9" maxlength="12" onkeypress="return carac_rut(event);" onchange="limpia('rut');">
                            <i id="error_rut" name="error_rut"></i>
                        </fieldset>
                        <fieldset id="f_celular" name="f_celular"> 
                            <label>Teléfono celular</label>
                            <input name="celular" id="celular" type="text" placeholder="987654321" maxlength="9" min="4" onKeyPress="solocar_num(event.keyCode,String.fromCharCode(event.keyCode));" onchange="limpia('celular');">
                            <i id="error_celular" name="error_celular"></i>
                        </fieldset>
                        <input type="hidden" id="idconvenio" name="idconvenio" value="<?=$id?>">
                        <fieldset>
                            <button class="b-red" onclick="valida_cli()" type="button" name="enviar" id="enviar" >Obtener beneficio</button>
                        </fieldset>
                    </form>
                    <div class="sms">
                        <p><?=$detalle_convenio['mecanica']?> y recibiras el código del Beneficio</p>
                    </div>
                </div>
                <?}?>
                <!---->
                <div id="detalles">
                    <ul class="descuento">
                        <li>
                            <b><?=$detalle_convenio['nombre']?></b>
                            <p><?=str_replace("|","</br>",$detalle_convenio['detalle'])?></p>
                            
                        </li>

                    </ul>
                    <ul class="legales">
                        <?
                        /*FORMATEAR FECHA*/

                        $dia=date("d", strtotime($detalle_convenio['vigencia']));

                        $mes_espanol=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                        $mes_numero=array("01","02","03","04","05","06","07","08","09","10","11","12");
                        $mes=str_replace($mes_numero,$mes_espanol,date("m", strtotime($detalle_convenio['vigencia'])));

                        $anio=date("Y", strtotime($detalle_convenio['vigencia']));

                        $fecha_escrita = $dia." de ".$mes." de ".$anio;

                        /*FIN FORMATEAR FECHA*/



                        ?>
                        <li>Vigencia hasta el  <?=$fecha_escrita?>.</li>
                        <li><?=$detalle_convenio['importante']?></li>
                    </ul>
                </div>
                <!---->


                <div id="sucursales">
                <?
                      $cuerpo = $glob->trae_datos("".$glob->local."descuentos_direcciones.php?token=ZGVzY3VlbnRvX2RpcmVjY2lvbmVzLnBocA==&id=".$id);
                      echo $cuerpo;
                        ?>
                   
                </div>
            </div>
        </div>
    </div>
    <!-- SCRIPT -->
    <script src="assets/js/functions.js" type="text/javascript"></script>
    <!--[if lt IE 8]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</body>

</html>
<?    
}
else
{

//header('Location: ..');  
}
?>

