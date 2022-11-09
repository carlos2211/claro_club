<?php
session_start();
if (isset($_SESSION["id"])){
$fecha_actual=date('d-m-Y');
?>
<html>
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	 	<title>Reportes Beneficios Claro Chile. </title>


		<link href="css/bootstrap.min.css" rel="stylesheet"  type="text/css">
        <link href="css/sweetalert.css" rel="stylesheet"  type="text/css">
		<link rel="stylesheet" href="css/jquery-ui.css">
        <link rel="shorcut icon" href="img/favicon.ico">

		
	    <script src="js/jquery.min.js"></script>
	    <script src="js/bootstrap.min.js"></script>
	    <script src="js/jquery-dataTables.js"></script>
	    <script src="js/sweetalert.min.js"></script>
	    <script src="js/jquery-ui.js"></script>
		<script>
			$( function() {
        $('#fecha_desde').datepicker({ dateFormat: 'dd-mm-yy' }).val();
        $('#fecha_hasta').datepicker({ dateFormat: 'dd-mm-yy' }).val();
			} );
		</script>
    <script>
        $(document).ready(function() {
            $("#boton_guardar").click(function(){
                paso=true;
                /*if($("#fecha_desde").val() > $("#fecha_hasta").val()){
                  paso=false;
                  swal("Oops...", "Favor ingrese una fecha correcta.", "error");
                }*/
                if(paso){
                    $("#formulario").submit();
                }
            });

            $("#boton_utilizados").click(function(){
                paso=true;
                /*if($("#fecha_desde").val() > $("#fecha_hasta").val()){
                    paso=false;
                    swal("Oops...", "Favor ingrese una fecha correcta.", "error");
                }*/
                if(paso){
                    $("#formulario").submit();
                }
            });
        } );
    </script>    

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    </head>
    <body>
    <div class="panel panel-danger">
        <div class="panel-heading">
            <strong>
                <img src="img/logo_claro.png" width="120" height="41" class="img-rounded"><p align="right" ><strong>Usuario:</strong> <?=$_SESSION["usuario"];?><p><p align="right" ><a href="Login_out.php">Salir</a></p>
                <h4 align="center">Reporte Beneficios</h4>
                <a href="Mantenedor_Claro.php" class="button green "><span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span>    Volver</a>
            </strong>
        </div>
        <div class="container">
            <div class="panel-body">
                <form id="formulario"
                      name="formulario"
                      class="form-horizontal"
                      method="GET"
                      action="">
                    <div class="form-group">
                        <label for="fecha_desde"
                               class="col-sm-5 control-label">Fecha Desde:</label>
                        <div class="col-sm-3">
                            <input type="text"
                                   class="form-control"
                                   id="fecha_desde"
                                   name="fecha_desde"
                                   placeholder="Favor ingresa una Fecha"
                                   value=<?= $fecha_actual ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fecha_hasta"
                               class="col-sm-5 control-label">Fecha Hasta:</label>
                        <div class="col-sm-3">
                            <input type="text"
                                   class="form-control"
                                   id="fecha_hasta"
                                   name="fecha_hasta"
                                   placeholder="Favor ingresa una Fecha"
                                   value=<?= $fecha_actual ?>>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-3">
                            <input type="button"
                                   id="boton_guardar"
                                   name="boton_guardar"
                                   value="Cantidad Solicitudes"
                                   class="btn btn-danger pull-right col-md-10"
                                   style="margin-bottom: 10px">
                            <input type="button"
                                   id="boton_utilizados"
                                   name="boton_utilizados"
                                   value="Convenios Utilizados"
                                   class="btn btn-primary pull-right col-md-10"
                                   style="background-color: #1F97AE; border-color: #1F97AE">
                        </div>
                    </div>
                </form>
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
    $('#boton_guardar').click(function(){
        $('#formulario').attr('action', 'reporte_claro_.php');
    });

    $('#boton_utilizados').click(function(){
        $('#formulario').attr('action', 'reporte_claro_utilizados.php');
    });
</script>
