<?php ini_set('display_errors', 1); ?> 
<?php

include("class/conectar.class.php");
include("class/control.class.php");

$token = (isset($_GET["token"])) ? $_GET["token"] : "";
$id = (isset($_GET["id"])) ? $_GET["id"] : "";

if ( $token == "ZGVzY3VlbnRvX2RldGFsbGUucGhw" && $id !="" ) {

$club = 35 ; //Club 

$control = new control();

$control->club=$club;
$control->id_convenio=$id;

    $result = $control->descuento_detalle_mantenedor();

    echo json_encode($result);

}else{

    $result=array('mensaje'=>"error token or id");

    echo json_encode($result); 

}



