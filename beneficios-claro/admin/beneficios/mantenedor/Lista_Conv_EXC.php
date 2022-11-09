<?php
session_start();
if (isset($_SESSION["id"])){
?>
<!doctype html>

<html lang="en">

  <head>
    <title>Listado Completo de Convenios</title>
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
    <script src="js/app.js"></script>

    <script>
      function VerSoloConvenios()
      { 
        var t=document.Lista_Conv_EXC;
        var envia=true; 

        if(envia)
          {
            
            $("#descarga_solo_convenios").text("Obteniendo Convenios...");
            window.open('Excel_Convenios.php');
            $("#descarga_solo_convenios").text("");
            //alert("ok");  
          }
        
      }
      function VerSoloCampanas()
      { 
        var t=document.Lista_Conv_EXC;
        var envia=true; 

        if(envia)
          {
            
            $("#descarga_solo_campanas").text("Obteniendo Campañas...");
            window.open('Excel_Campanas.php');
            $("#descarga_solo_campanas").text("");
            //alert("ok");  
          }
        
      }
      function VerSoloCodigos()
      { 
        var t=document.Lista_Conv_EXC;
        var envia=true; 

        if(envia)
          {
            
            $("#descarga_solo_codigos").text("Obteniendo Codigos...");
            window.open('Excel_Codigos.php');
            $("#descarga_solo_codigos").text("");
            //alert("ok");  
          }
        
      }
    </script>
  </head>

  <body>
    <form>
      <div class="container">
        <br><br>
        <div class="panel panel-danger">
          <div class="panel-heading">
            <strong>
              <img src="img/logo_claro.png" width="120" height="41" class="img-rounded"><p align="right" ><strong>Usuario:</strong> <?=$_SESSION["usuario"];?><p><p align="right" ><a href="Login_out.php">Salir</a></p>
              <h4 align="center">Listado Completo de Convenios</h4>
              <a href="Mantenedor_Claro.php" class="button green "><span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span>    Volver</a>
            </strong>
          </div>
          <div class="panel-body responsive">
          <form class="form-horizontal" method="POST" action="" role="form" id="Lista_Conv_EXC">
            <table class="display" id="example" cellspacing="0" width="100%">
            <thead>
              <tr class="active" align="center">
                <th><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>  ID</th>
                <th><span class="glyphicon glyphicon-gift" aria-hidden="true"></span>  NOMBRE CONVENIO</th>
                <th><span class="glyphicon glyphicon-download" aria-hidden="true"></span>  DESCUENTO</th>
                <th><span class="glyphicon glyphicon-time" aria-hidden="true"></span>  VIGENCIA</th>
                <th><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>  ESTADO CONVENIO</th>
                <th><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>  PUBLICACIÓN</th>
              </tr>
              </thead>
              <tbody>
                <?php

                  $file = file_get_contents("http://clarofans.clarochile.cl/admin/archClaro/descuentos_mantenedor.php?tipo=2", true);
                  echo $file;
                ?>              
              </tbody>
            </table>
              <tr align='center'>
                  <td colspan=1  style="border-color: white;" align='center'></td>
                  <td><span><button type="button" name="button" id="button" value="Excel_Convenios" onclick="VerSoloConvenios()"class="btn btn-danger btn-sm" ></span>Excel Convenios</button></a></td>
              </tr>

              <tr align='center'>
                  <td colspan=1  style="border-color: white;" align='center'></td>
                  <td><span><button type="button" name="button" id="button" value="Excel_Campanas" onclick="VerSoloCampanas()"class="btn btn-danger btn-sm" ></span>Excel Campañas</button></a></td>
              </tr>
              <!--<tr align='center'>
                  <td colspan=1  style="border-color: white;" align='center'></td>
                  <td><span><button type="button" name="button" id="button" value="Excel_Codigos" onclick="VerSoloCodigos()"class="btn btn-danger btn-sm" ></span>Excel Codigos</button></a></td>
              </tr>-->
                <tr>
                  <td style="border-color: white;"><div id="descarga_solo_convenios"></div></td>
              </tr>
              <tr>
                  <td style="border-color: white;"><div id="descarga_solo_campanas"></div></td>
              </tr>
              <tr>
                  <td style="border-color: white;"><div id="descarga_solo_codigos"></div></td>
              </tr>
          </div>
        </div>
      </div>
    </form>
  </body>
</html>
<?php
}else{

header ("Location: Login.php");

}
?>

