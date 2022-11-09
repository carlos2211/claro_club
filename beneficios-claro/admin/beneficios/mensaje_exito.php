<?php
session_start();

$id = $_SESSION["idconvenio"];

if ($id != ""){


include("nav/global.php");
include("lib/nusoap.php");

$glob = new globales;
$rut = $_SESSION["rut"];


$wsdl= $glob->ws_codigos;


$client= new nusoap_client($wsdl);

//echo $glob->local;

  $cuerpo = $glob->trae_datos("".$glob->local."/descuento_detalle.php?token=ZGVzY3VlbnRvX2RldGFsbGUucGhw&id=".$id);
  $detalle_convenio=json_decode($cuerpo, true);

    if ($detalle_convenio['emite_codigo'] == 1){

                    //echo "debo asignar codigo con webservices";
                    //echo "codigo: ". $_SESSION["codigo"];

    //print_r(array('rut'=>$rut,'idconvenio'=>$id,'mail'=>$mail,'fono'=>$_SESSION["celular"]));
    $result2= $client->call('obtener_codigo', array('rut'=>$rut,'idconvenio'=>$id,'mail'=>$mail,'fono'=>$_SESSION["celular"]));
    $tipo_mensaje = 1;


    //print_r($result2);

        if ($result2[0]["idmensaje"] == 0 ){
            $_SESSION['codigo'] =  $result2[0]["Codigo"];
             
        }else{
           // header("Location: ..");
        }
        
        $mensaje_final="<div class='codigo'><p>Debes presentar el siguiente código  :</p><span>".$_SESSION['codigo']."</span></div>";
        $tipo_mensaje=1;

    }else{
            //echo "codigo random segun convenio ".$id;+
            //$codigo_convenio = str_pad($id,"4","0",STR_PAD_LEFT)."0001".rand(0,9999) ;
        $mensaje_final="<div class='codigo'><p>".$detalle_convenio['mensaje_convenio']."</p></div>";
        $tipo_mensaje=4;


    }
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
</head>

<body>
    <div class="container">
        <h1><?=$detalle_convenio['nombre']?></h1>
        <!---->
        <ul class="links">
            <?if ($detalle_convenio['url']!=""){?>
             <li class="web"><a href="http://<?=$detalle_convenio['url']?>" target="_blank">website</a></li>
            <?}
            if ($detalle_convenio['facebook']!=""){?>
            <li class="facebook"><a href="http://<?=$detalle_convenio['facebook']?>" target="_blank">facebook</a></li>
            <?}
            if ($detalle_convenio['twiter']!=""){?>            
            <li class="twitter"><a href="http://<?=$detalle_convenio['twiter']?>" target="_blank">twitter</a></li>
            <?}
            if ($detalle_convenio['youtube']!=""){?>        
            <li class="youtube"><a href="http://<?=$detalle_convenio['youtube']?>" target="_blank">youtube</a></li>
            <?}?>            
        </ul>
                <!---->
        <div class="respuesta">
            <h2>¡Felicidades, ya puedes disfrutar de este Beneficio Claro Club!</h2>
            <!---->
            <div class="sms" style="display:none;">
                <p>En instantes, llegará un <b>SMS</b> a tu teléfono celular con el código que debes presentar.</p>
            </div>
            <?=$mensaje_final?>
            <?
                /*Envio uso de convenios*/

                  $resultaux= $client->call('uso_convenio', array('idconvenio'=>$id,'nombreconvenio'=>$detalle_convenio['nombre'],'tipocodigo'=>$tipo_mensaje,'codigoemitido'=>trim(strip_tags($mensaje_final)),'comentario'=>'comentario test'));
                /*Fin Envio uso de convenios*/
            ?>  
            <div class="link" style="display:none;">
                <p>Obtén el cupón en el siguiente link:</p>
                <a href="" class="b-green" target="_blank">Cupón de Beneficio</a>
            </div>
        </div>
        <!---->
        <div class="no-cliente" style="display:none;">
            <h2>No se pudo obtener el Beneficio</h2>
            <p>Tu Rut y Teléfono Celular no cohinciden o no pertenece a Cliente Claro</p>
        </div>
    </div>
    <!-- SCRIPT -->
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-83713618-1', 'auto');
  ga('send', 'pageview');

</script>
    <script src="assets/js/functions.js" type="text/javascript"></script>
    <!--[if lt IE 8]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</body>

</html>


<?
    
}else{
 header("Location: ..");

}
?>