<?php
session_start();
if (isset($_SESSION["id"])){
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mantenedor Claro Chile</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="css/justified-nav.css" rel="stylesheet">
    <link rel="shorcut icon" href="img/favicon.ico">
    <script src="js/ie-emulation-modes-warning.js"></script>
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

      <style>
          #welcome {
              background-image: url(img/welcome.png);
              height: 425px;
              width: 871px;
              margin: 0 auto;
          }
      </style>
  </head>

  <body>

    <div class="container">
      <div class="masthead">
        <img src="img/logo_claro.png" width="120" height="41" class="img-rounded"><p align="right" ><strong>Usuario:</strong> <?=$_SESSION["usuario"];?><p><p align="right" style="margin-bottom: 25px"><a href="Login_out.php">Salir</a></p>
        <nav>
          <ul class="nav nav-justified">
            <li class="active"><a href="Mantenedor_Claro.php">Principal</a></li>
            <li class="active" style="border-right: 1px solid #d5d5d5;border-left: 1px solid #fff;">
                <div class="dropdown" style="text-align: center">
                    <span class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer;color: #777;font-weight: bold;">Convenios
                    <span class="caret"></span></span>
                    <ul class="dropdown-menu" style="min-width: 100%;">
                        <li><a href="Crear_Convenios.php">Crear</a></li>
                        <li><a href="Lista_Convenios.php">Lista de Convenios</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="Lista_Conv_EXC.php">Exportar Listas</a></li>
            <li><a href="reporte_claro.php">Reporte</a></li>
            <li><a href="Utilizar_Codigos.php">Utilizar C??digos</a></li>
          </ul>
        </nav>
      </div>
        <div class="row" style="margin-top: 50px">
            <div id="welcome"></div>
        </div>
      <!--<div class="row">
        <div class="col-lg-4">
          <h2  class="text-danger">Lista de Convenios</h2>
          <p>En esta secci??n podr??s ver un listado completo de todos los convenios, adem??s de generar c??digos para dichos convenios, filtr??ndolo por campa??a asociada a uno de estos.<p>En caso de no existir la campa??a que buscas te permitir?? crearla para posteriormente utilizarla.</p>
          <p><a class="btn btn-danger" href="Lista_Convenios.php" role="button">INGRESAR &raquo;</a></p>
        </div>
        <div class="col-lg-4">
          <h2 class="text-danger">Exportar Listas</h2>
          <p>Adem??s de ver el listado de los convenios, podr??s ver las Campa??as asociadas a dichos convenios, as?? como listar los c??digos asociados a estas campa??as.<p>Finalmente te permitir?? exportar a Excel una lista completa de todos los convenios, campa??as y c??digos que existen, incluyendo el filtro por convenio y campa??a.</p>
          <p><a class="btn btn-danger" href="Lista_Conv_EXC.php" role="button">INGRESAR &raquo;</a></p>
       </div>
        <div class="col-lg-4">
          <h2 class="text-danger">Utilizar Codigos</h2>
          <p>Aqu?? podr??s utilizar los c??digos que est??n registrados para cada campa??a y convenio.</p>
          <p><a class="btn btn-danger" href="Utilizar_Codigos.php" role="button">INGRESAR &raquo;</a></p>
        </div>
      </div>-->
      <footer class="footer"></footer>
    </div>
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
<?php
}else{

header ("Location: Login.php");

}
?>