<?php
  include("includes/connLocal.php");
  include("includes/conn.php");
  
  include("clases/convenio.class.php");
  include("clases/campana.class.php");
  include("clases/codigo.class.php");

	$objCod=new codigo($link_local);
	$objCod->rut=$_POST["rut"];
	$objCod->codigo=$_POST["codigo"];

	$msg="";
    $rut=($_POST["rut"]);
	$codigo=($_POST["codigo"]);

	if($_POST["rut"]!="")
		$objCod->rut=$_POST["rut"];
	else
		$msg.="ERROR. Falta rut <BR>";

	if($_POST["codigo"]!="")
		$objCod->codigo=$_POST["codigo"];
	else
		$msg.="ERROR. en codigo <BR>";

	if($msg=="")
	{
		$msg=$objCod->utilizacodigo();
	}
?>
