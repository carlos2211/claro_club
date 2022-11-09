<?php
session_start();
if (isset($_SESSION["id"])){



   	include("includes/connLocal.php");

  	include("clases/campana.class.php");
	
	$objCamp=new campana($link_local);
	$objCamp->id=35;
	$msg="";

	if($_POST["descripcion"]!="")
		$objCamp->descripcion=$_POST["descripcion"];
	else
		$msg.="ERROR. Falta Nombre Campaña<BR>";
	if($_POST["idconvenio"]!="")
		$objCamp->idconvenio=$_POST["idconvenio"];
	else
		$msg.="ERROR. Falta el Id del Convenio<BR>";
	if($_POST["VigenciaCampana"]!="")
		$objCamp->VigenciaCampana=$_POST["VigenciaCampana"];
	else
		$msg.="ERROR. Falta la Vigencia de la Campaña<BR>";
	if($_POST["stockCT"]!="")
		$objCamp->stockCT=$_POST["stockCT"];
	else
		$msg.="ERROR. Falta Stock Critico de la Campaña<BR>";

	if($msg=="")
	{
		$msg=$objCamp->insertarCampana();
	}
?>
<link rel="stylesheet" href="css/jquery-ui.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
<link rel="shorcut icon" href="img/favicon.ico">
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js" ></script>

<body><div class="msg"><?=$msg?></div>
	<div align="center">
		<br><br>
		<br><br>
		<!-- <img src="../images/exitosos.png" alt="..." height="100" width="100" class="img-rounded"><br><br> -->
		<div class="container">
			<div class="jumbotron">
			  <h2>Campa&ntilde;a Creada con Exito!</h2>
			  <h4>Presione el boton para regrasar al listado de Convenios</h4>
			  <p><button type="button" class="btn btn-primary btn-lg" onClick="self.location.href='Lista_Convenios.php'">Volver Atras</button><br><br></p>
			</div>
		</div>
	</div>
</body>
<?php
}else{

header ("Location: Login.php");

}
?>