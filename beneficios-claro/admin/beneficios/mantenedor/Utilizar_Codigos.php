<?php
session_start();
if (isset($_SESSION["id"])){

  include("includes/connLocal.php");

?>

<!doctype html>

<html lang="en">

  <head>
    <title>Códigos Promocionales</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css" >

    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.css">
    <link rel="shorcut icon" href="img/favicon.ico">

    <script src="js/sweetalert.min.js"></script> 
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js" ></script>

    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/jquery-dataTables.js" ></script>

  </head>

  <body>
      <div class="container">
        <br><br>
        <div class="panel panel-danger">
          <div class="panel-heading">
            <strong>
              <img src="img/logo_claro.png" width="120" height="41" class="img-rounded"><p align="right" ><strong>Usuario:</strong> <?=$_SESSION["usuario"];?><p><p align="right" ><a href="Login_out.php">Salir</a></p>
              <h4 align="center">Buscar Códigos Promocionales Relacionados a una Campaña</h4>
              <a href="Mantenedor_Claro.php" class="button green "><span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span>    Volver</a>
            </strong>
          </div>
          <div class="panel-body table-responsive">
            <form class="form-horizontal" method="POST" action="Buscar_Campanas.php" role="form" id="Buscar_Campañas">
                <div class="form-group">
                    <label for="campaña" class="col-sm-5 control-label">Campaña:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="campaña" name="campaña" placeholder="Nombre Campaña">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-2">
                        <input type="submit" id="boton_buscar" name="boton_buscar" value="Obtener Codigos" class="btn btn-danger pull-right col-md-10">
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