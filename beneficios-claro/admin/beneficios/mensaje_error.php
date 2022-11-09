<?php
session_start();

$id = $_SESSION["idconvenio"];

include("nav/global.php");

$glob = new globales;


  $cuerpo = $glob->trae_datos("".$glob->local."/descuento_detalle.php?token=ZGVzY3VlbnRvX2RldGFsbGUucGhw&id=".$id);
  $detalle_convenio=json_decode($cuerpo, true);
  $i=$_GET["n"];

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
            <li class="youtube"><a href="http://<?=$detalle_convenio['youtube']?>" class="_blank">youtube</a></li>
            <?}?>            
        </ul>
                <!---->
        <!---->
<?
switch ($i) {
    case 1:
        $mensaje= "Tu Rut y Teléfono Celular no coinciden o no pertenece a Cliente Claro";
        break;
    case 2:
        $mensaje="Tu Rut no pertenece a Cliente Claro";
        break;
    case 3:
         $mensaje= "Tu Teléfono Celular no pertenece a Cliente Claro";
        break;
    case 4:
         $mensaje= "Tu Rut y Teléfono Celular no coinciden o no pertenece a Cliente Claro";
        break;
    default:
        $mensaje= "Existe un error al acceder a la pagina.";     
}

?>

        <div class="no-cliente">
            <h2>No se pudo obtener el Beneficio</h2>
            <p><?=$mensaje?></p>
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



