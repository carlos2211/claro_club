<?php
session_start();
if (isset($_SESSION["id"])){
  include("includes/connLocal.php");
  include("clases/convenio.class.php");
  include("clases/campana.class.php");
  include("clases/codigo.class.php");


  $idconvenio=$_GET["idconvenio"];

  $file = file_get_contents("http://clarofans.clarochile.cl/admin/archClaro/descuento_detalle.php?token=ZGVzY3VlbnRvX2RldGFsbGUucGhw&id=".$idconvenio, true);
  $detalle_convenio=json_decode($file, true);

  $objCamp=new campana($link_local);
  $objCamp->idconvenio=$_GET["idconvenio"];
  $res=$objCamp->traeCampana();

?>

<!doctype html>

<html lang="en">

  <head>
    <title>Listado de Convenios Claro</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css" >
    <link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="shorcut icon" href="img/favicon.ico">
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js" ></script>
    <script src="js/jquery-dataTables.js" ></script>

    <script>
      function VerCampanas(id)
      { 
        var t=document.Listado_Camp_EXC;
        var envia=true;

        if(envia)
          {
            $("#descarga_campanas").text("Obteniendo Campañas...");
            window.open('Excel_CampanaXid.php?idconvenio='+id);
            $("#descarga_campanas").text("");
          }
        
      }

      function VerAllCodigos(id)
      {
          var t=document.Listado_Camp_EXC;
          var envia=true;

          if(envia)
          {
              $("#descarga_codigos").text("Obteniendo Códigos...");
              window.open('Excel_AllCodigos.php?idconvenio='+id);
              $("#descarga_codigos").text("");
          }

      }
    </script>
  </head>

  <body>
    <div class="container">
      <br><br>
        <div class="panel panel-danger">
          <div class="panel-heading">
            <strong>
              <img src="img/logo_claro.png" width="120" height="41" class="img-rounded"><p align="right" ><strong>Usuario:</strong> <?=$_SESSION["usuario"];?><p><p align="right" ><a href="Login_out.php">Salir</a></p>
              <h4 align="center">Listado de Campañas por Convenio</h4>
              <a href="Lista_Conv_EXC.php" class="button green "><span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span>Volver</a>
            </strong>
          </div>
          <div class="panel-body">
            <form class="form-horizontal" method="POST" action="" role="form" id="Listado_Camp_EXC">
              <div class="form-group has-error">
                <label class="col-sm-5 control-label" for="idconvenio">Id Convenio</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="idconvenio" value="<?=$idconvenio?>" readonly>
                </div>
              </div>
              <div class="form-group has-error">
                <label class="col-sm-5 control-label" for="marca">Nombre Convenio</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="marca" value="<?=$detalle_convenio['nombre']?>" readonly>
                </div>
              </div>
              <div class="form-group has-error">
                <label class="col-sm-5 control-label" for="vigencia">Vigencia</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="vigencia" value="<?=$detalle_convenio['vigencia']?>" readonly>
                </div>
              </div>
              <div class="panel-body responsive">
              <table class="table table-hover table-condensed table-responsive" align="center" id="listado_campañas">
              <thead>
                  <tr class="active" align="center">
                    <td><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>  Id Campaña</td>
                    <td><span class="glyphicon glyphicon-gift" aria-hidden="true"></span>  Descripcion</td>
                    <td><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>  Estado</td>
                    <td><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>  Fecha de Vigencia</td>
                    <td></td>
                  </tr>
              </thead>
              <tbody>
              <?php
              while($row = mysql_fetch_assoc($res))
              {
              ?>
                  <tr>
                    <td align="center"><?php echo $row["id_Campana"];?></td>
                    <td align="center"><?php echo $row["NombreCampana"];?></td>
                    <td align="center"><?php echo $row["Descripcion"];?></td>
                    <td align="center"><?php echo $row["Fecha_Vigencia"];?></td>
                    <td>
                      <a href="Listado_Cod_EXC.php?idconvenio=<?=$idconvenio?>&id_Campana=<?=$row["id_Campana"]?>"><button type="button" class="btn btn-danger btn-sm" ></span>Listar Codigo</button></a>
                    </td>
                  </tr>
              <?php
              }  
              ?>
              </tbody>
            </table>
              <tr align='center'>
                  <td colspan=1  style="border-color: white;" align='center'></td>
                  <td><span><button type="button" name="button" id="button" value="Excel_Convenios" onclick="javascript:VerCampanas(<?=$idconvenio?>)" class="btn btn-danger btn-sm" ></span>Excel Campañas</button></a></td>
              </tr>

              <tr align='center'>
                  <td colspan=1  style="border-color: white;" align='center'></td>
                  <td><span><button type="button" name="button" id="button" value="Excel_Campanas" onclick="javascript:VerAllCodigos(<?=$idconvenio?>)" class="btn btn-danger btn-sm" ></span>Excel Códigos</button></a></td>
              </tr>
              <input type="hidden" class="form-control" id="idconvenio" name="idconvenio" value="<?=$idconvenio?>">
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
    $(document).ready(function()
    {
        $('#listado_campañas').DataTable();

    });
</script>