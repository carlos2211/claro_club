<?php
session_start();
if (isset($_SESSION["id"])){

  include("includes/connLocal.php");
  include("clases/campana.class.php");
  include("clases/codigo.class.php");

  $idconvenio=$_GET["idconvenio"];

  $file = file_get_contents("http://clarofans.clarochile.cl/admin/claro_club/archClaro/descuento_detalle.php?token=ZGVzY3VlbnRvX2RldGFsbGUucGhw&id=".$idconvenio, true);
  $detalle_convenio=json_decode($file, true);

  $objCamp=new campana($link_local);
  $objCamp->id=$_GET["id_Campana"];
  $res=$objCamp->traeDatosCampana();

  $objCod=new codigo($link_local);
  $objCod->id_campana=$_GET["id_Campana"];
  $res=$objCod->traecodigo();

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
      function VerCodigos(idcampana)
      { 
        var t=document.Formulario_ListaConvenios;
        var envia=true;


        if(envia)
          {
            
            $("#descarga_codigos").text("Obteniendo Campañas...");
            window.open('Excel_CodigosXid.php?id_Campana='+idcampana);
            $("#descarga_codigos").text("");
            //alert("ok");  
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
              <h4 align="center">Listado de Codigos de la Campaña Seleccionada</h4>
              <a href="Listado_Camp_EXC.php?idconvenio=<?=$idconvenio?>" class="button green "><span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span>    Volver</a>
            </strong>
          </div>
          <div class="panel-body">
            <form class="form-horizontal" method="POST" action="" role="form" id="Formulario_ListaConvenios">
              <div class="form-group has-error">
                <label class="col-sm-5 control-label" for="idconvenio">Id Convenio</label>
                <div class="col-sm-4">
                  <input type="email" class="form-control" id="idconvenio" value="<?=$idconvenio?>" readonly>
                </div>
              </div>
              <div class="form-group has-error">
                <label class="col-sm-5 control-label" for="marca">Nombre Convenio</label>
                <div class="col-sm-4">
                  <input type="email" class="form-control" id="marca" value="<?=$detalle_convenio['nombre']?>" readonly>
                </div>
              </div>
              <div class="form-group has-error">
                <label class="col-sm-5 control-label" for="vigencia">Vigencia</label>
                <div class="col-sm-4">
                  <input type="email" class="form-control" id="vigencia" value="<?=$detalle_convenio['vigencia']?>" readonly>
                </div>
              </div>
              <div class="form-group has-error">
                <label class="col-sm-5 control-label" for="id_Campana">Id Campaña</label>
                <div class="col-sm-4">
                  <input type="email" class="form-control" id="id_Campana" value="<?=$objCamp->id?>" readonly>
                </div>
              </div>
              <div class="form-group has-error">
                <label class="col-sm-5 control-label" for="Descripcion">Descripción</label>
                <div class="col-sm-4">
                  <input type="email" class="form-control" id="Descripcion" value="<?=$objCamp->descripcion?>" readonly>
                </div>
              </div>
              <div class="form-group has-error">
                <label class="col-sm-5 control-label" for="id_Estado">Estado</label>
                <div class="col-sm-4">
                  <input type="email" class="form-control" id="id_Estado" value="<?=$objCamp->estado?>" readonly>
                </div>
              </div>
              <div class="panel-body responsive">
              <table class="table table-hover table-condensed table-responsive" align="center" id="listado_codigos">
              <thead>
                  <tr class="active" align="center">
                    <td><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>  Id Codigo</td>
                    <td><span class="glyphicon glyphicon-barcode" aria-hidden="true"></span>  Codigo</td>
                    <td><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>  Estado</td>
                    <td><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>  Fecha de Creación</td>
                    <!--<td><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>  Fecha de Canje</td>
                    <td><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>  Fecha de Uso</td>-->
                    <td><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>  Fecha de Vigencia</td>
                  </tr>
              </thead>
              <tbody>
              <?php
              while($row = mysql_fetch_assoc($res))
              {
              ?>

                  <tr>
                    <td align="center"><?php echo $row["id_Codigo"];?></td>
                    <td align="center"><?php echo $row["Codigo"];?></td>
                    <td align="center"><?php echo $row["Estado"];?></td>
                    <td align="center"><?php echo $row["Fecha_Creacion"];?></td>
                    <!--<td align="center"><?php echo $row["Fecha_Canje"];?></td>
                    <td align="center"><?php echo $row["Fecha_Uso"];?></td>-->
                    <td align="center"><?php echo $row["Fecha_Vigencia"];?></td>
                  </tr>
              <?php
              }  
              ?>
              </tbody>
            </table>
              <tr align='center'>
                  <td colspan=1  style="border-color: white;" align='center'></td>
                  <td><span><button type="button" name="button" id="button" value="Excel_Convenios" onclick="javascript:VerCodigos(<?=$objCamp->id?>)" class="btn btn-danger btn-sm" ></span>Excel Códigos de Campaña</button></a></td>
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
        $('#listado_codigos').DataTable();

    });
</script>
