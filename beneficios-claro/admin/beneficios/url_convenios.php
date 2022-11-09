<?php
/*Soap*/

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);  

include("lib/nusoap.php");
/*enviar datos y recibir array*/

$id_categoria= 0;
$token = "Q0xBUk9DSElMRS1GSURFTElTMjAxNg==";
$wsdl           = "http://servicios.fidelis.cl/mc_develop/adm/SoapClaroChile/wservice.php";
$client           = new nusoap_client ($wsdl);



$result_convenios= $client->call('conveniosBeneficios', array('id_categoria'=>$id_categoria,'token'=>$token));
print_r($result);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>  </title>
	<!--css-->
	  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	  <link href="../css/bootstrap.css" rel="stylesheet"  type="text/css">
	  <link href="../css/sweetalert.css" rel="stylesheet" type="text/css">
	  <link rel="stylesheet" href="../css/jquery-ui.css">
	<!--fin css-->
	<!--js-->
		<script src="../js/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="../js/jquery-ui.js"></script>
		<script src="../js/general.js"></script>
	<!--fin js-->
  </head>
<body>
	<form class="form-horizontal" method="post" action="subir_imagenes.php" enctype="multipart/form-data">
		<div class="panel panel-fidelis">
			<div class="panel-heading"> 
				<div class="row">
					<div class="col-md-2">
						<img src="../images/logo-fidelis.png" alt="logo-fidelis">
					</div>
					<div class="col-md-8" style="vertical-align:middle; text-align:center;">
						<h3 class="panel-title">
							<strong>.</strong>
						</h3>
					</div>
					<div class="col-md-2"></div>
				</div>
			</div>
		</div>			
	</form>

	<table class="table table-bordered" >
		<thead>
			<tr>
				<th>Nº</th>
				<th>Id</th>
				<th>Nombre</th>
				<th>Url</th>
				<th>Logo WEB</th>
				<th>Logo APP</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>Nº</th>
				<th>Id</th>
				<th>Nombre</th>
				<th>Url</th>
				<th>Logo WEB</th>
				<th>Logo APP</th>
			</tr>
		</tfoot>
			<?
			$n_convenio = 1;
			$result_cat=$client->call('categoriasBeneficios', array('id_categoria'=>$id_categoria,'token'=>$token));
			foreach ($result_cat as $key_cat => $value) {
				$result_convenios=$client->call('conveniosBeneficios', array('id_categoria'=>$value["id"],'token'=>$token));
				foreach ($result_convenios as $key_convenio => $value_convenio) {
					?>
					<tr>
						<td><?=$n_convenio?></td>
						<td><?=$value_convenio["id"]?></td>
						<td><?=$value_convenio["nombre"]?></td>
						<td><a href="<?=$value_convenio["url"]?>" target="_blank"><?=$value_convenio["url"]?></a></td>
						<td><img src="<?=$value_convenio["src_imagen"]?>"></td>
						<td><img src="<?=$value_convenio["datos_direccion"][0]["url_imagen_marker"]?>"></td> 
					</tr>
					<?$n_convenio ++;
				}
			}
			?>
	</table>
</body>
</html>
