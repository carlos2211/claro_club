<?php
session_start();
if (isset($_SESSION["id"])){

   	include("includes/connLocal.php");

  	include("clases/codigo.class.php");
	
	$objCod=new codigo($link_local);
	$objCod->id=35;
	$msg="";

	if($_POST["idconvenio"]!="")
		$objCod->id_convenio=$_POST["idconvenio"];
	else
		$msg.="ERROR. Falta Id Convenio<BR>";
	if($_POST["cbCampana"]!="")
		$cbCampana=$_POST["cbCampana"];
	else
		$msg.="ERROR. Falta el Id de la Campaña<BR>";
	if($_POST["cantidad"]!="")
		$cantidad=$_POST["cantidad"];
	else
		$msg.="ERROR. Ingrese la Cantidad<BR>";
	if($_POST["VigenciaCod"]!="")
		$VigenciaCod=$_POST["VigenciaCod"];
	else
		$msg.="ERROR. Ingrese la Vigencia para el Codigo<BR>";

	$objCod->id_campana=$cbCampana;

	$contar=$objCod->cuentacodigo();

	// echo "variables:".$cantidad." ".$cbCampana." ".$contar;

	if($msg=="")
	{
		$msg=$objCod->insertarcodigo($cantidad,$cbCampana,$contar,$VigenciaCod);
	}
 //print_r($_POST);
?>
<link rel="stylesheet" href="css/jquery-ui.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
<link rel="shorcut icon" href="img/favicon.ico">
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js" ></script>

<body>
	<div align="center">
		<br><br>
		<div class="container">
			<div class="jumbotron">
			    <h2>Codigos Ingresados con Exito!</h2>
			    <h4>Presione el boton para regresar al listado de Convenios</h4>
			    <p>...</p>
			    <p><button type="button" class="btn btn-primary btn-md" onClick="self.location.href='Lista_Convenios.php'">Volver Atras</button><br><br></p>
			</div>
		</div>
	</div>
</body>
<?php
}else{

header ("Location: Login.php");

}
?>