<?php
session_start();
if (isset($_SESSION["id"])){

  include("includes/connLocal.php");
  include("clases/campana.class.php");
  include("clases/codigo.class.php");


  $idconvenio=$_GET["idconvenio"];

  $file = file_get_contents("http://claro.mobext.cl/dev/claro/claro_club/archClaro/descuento_detalle.php?token=ZGVzY3VlbnRvX2RldGFsbGUucGhw&id=".$idconvenio, true);
  $detalle_convenio=json_decode($file, true);
  
  $objCamp=new campana($link_local);
  $objCamp->idconvenio=$_GET["idconvenio"];
  $res=$objCamp->traeCampana();

?>

<!doctype html>

<html lang="en">

<head>
<title>Generar Codigos para Convenios</title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/jquery-ui.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
<link rel="shorcut icon" href="img/favicon.ico">
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js" ></script>

<script src="js/sweetalert.min.js"></script> 
<link rel="stylesheet" type="text/css" href="css/sweetalert.css">

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<script language="javascript">
  function isCampana(e)
  {
    k = (document.all) ? e.keyCode : e.which;
    if (k==8 || k==0 || k==32) return true;
    patron = /[a-zA-ZñÑ0-9_.,-]/;
    n = String.fromCharCode(k);
    return patron.test(n);
  }
</script>

<script language="javascript">
  function isNumber(e)
  {
    k = (document.all) ? e.keyCode : e.which;
    if (k==8 || k==0) return true;
    patron = /\d/;
    n = String.fromCharCode(k);
    return patron.test(n);
  }
</script>

</head>

<script language="javascript"> 
  function prueba()
  {
      var paso;
      paso = true

      if ($("#cbCampana option:selected").val()== 0 && paso){
        // alert("Por favor Seleccione una Campaña");
        swal("Seleccione una Campaña")
        paso=false;
        $("#cbCampana").focus();
      }

      if (($("#cantidad").val()== 0 || $("#cantidad").val()== "" ) && paso){
        // alert("favor ingresar cantidad");
        swal("Ingrese una Cantidad")
        paso=false;
        $("#cantidad").focus();
      }

      if (($("#VigenciaCod").val()== 0 || $("#VigenciaCod").val()== "" ) && paso){
        // alert("favor ingresar la vigencia");
        swal("Ingrese una Vigencia para el Codigo")
        paso=false;
        $("#VigenciaCod").focus();
      }

      if(paso){
         $("#Agregar_Codigo").submit();
      }
  }

</script>

<script language="javascript"> 
  function prueba2()
  {
      var paso2;
      paso2 = true

      
      if (($("#descripcion").val()== 0 || $("#descripcion").val()== "" ) && paso2){
        // alert("favor ingresar cantidad");
        swal("Ingrese el nombre de la Campaña")
        paso2=false;
        $("#descripcion").focus();
      }

      if (($("#VigenciaCampana").val()== 0 || $("#VigenciaCampana").val()== "" ) && paso2){
        // alert("favor ingresar la vigencia");
        swal("Ingrese una Vigencia para la Campaña")
        paso2=false;
        $("#VigenciaCampana").focus();
      }

      if (($("#stockCT").val()== 0 || $("#stockCT").val()== "" ) && paso2){
        // alert("favor ingresar stock critico");
        swal("Ingrese un Stock Critico para la Campaña")
        paso2=false;
        $("#stockCT").focus();
      }

      if(paso2){
         $("#Agregar_Campana").submit();
      }
  }

</script>

  <body>
    <div class="container">
      <br><br>
      <div class="panel panel-danger">
        <div class="panel-heading">
          <strong>
          <img src="img/logo_claro.png" width="120" height="41" class="img-rounded"><p align="right" ><strong>Usuario:</strong> <?=$_SESSION["usuario"];?><p><p align="right" ><a href="Login_out.php">Salir</a></p>
          <h4 align="center">Generar Codigos para Convenios</h4>
          <a href="Lista_Convenios.php" class="button green "><span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span>    Volver</a>
          </strong>
        </div>
        <div class="panel-body">
        <div class="row">
        <div class="col-md-7">
          <form class="form-horizontal" method="POST" action="Agregar_Codigo.php " role="form" id="Agregar_Codigo">
            <div class="form-group has-error">
              <label class="col-sm-5 control-label" for="idconvenio">ID Convenio</label>
              <div class="col-sm-4">
              <input type="text" class="form-control" id="idconvenio" name="idconvenio" placeholder="" value="<?=$idconvenio?>" readonly>
              </div>
            </div>
            <div class="form-group has-error">
              <label class="col-sm-5 control-label" for="marca">Nombre Convenio</label>
              <div class="col-sm-4">
              <input type="text" class="form-control" id="marca" name="marca" placeholder="" value="<?=$detalle_convenio['nombre']?>" readonly>
              </div>
            </div>
            <div class="form-group has-error">
              <label class="col-sm-5 control-label" for="CampanaExistente">Campaña Existente</label>
              <div class="col-sm-4">
                <select class="form-control" id="cbCampana" name="cbCampana">
                  <option value = 0 selected>Seleccione Campaña</option>
                  <?php
                  while($row = mysql_fetch_assoc($res))
                  {
                  ?>
                  <option value="<?=$row["id_Campana"];?>"><?=$row["NombreCampana"];?></option>
                  <?php
                  }  
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group has-error">
              <label class="col-sm-5 control-label" for="cantidad">Cantidad de Codigos</label>
              <div class="col-sm-4">
              <input type="text" class="form-control" id="cantidad" onkeypress="return isNumber(event);" maxlength="4" name="cantidad" placeholder="Total de Codigos">
              </div>
            </div>
            <div class="form-group has-error">
            <label class="col-sm-5 control-label" for="VigenciaCod">Fecha de Vigencia</label>
              <div class="col-sm-4">
              <div class="input-group">
                <input type="date" class="form-control" id="VigenciaCod" name="VigenciaCod"/>
                <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-5 col-sm-9">
              <button type="button" class="btn btn-danger" value="Generar"  onclick="prueba();">Generar Codigos</button>
              </div>
            </div>
          </form>
          </div>
          <div class="col-md-4">
          <form class="form-horizontal" method="POST" action="Agregar_Campana.php" role="form" id="Agregar_Campana">
            <div class="form-group has-error">
              <label class="col-sm-5 control-label" for="descripcion">Campaña Nueva</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="descripcion" name="descripcion" maxlength="45" onkeypress="return isCampana(event);" placeholder="Nombre de la Campaña">
              </div>
            </div>
            <div class="form-group has-error">
            <label class="col-sm-5 control-label" for="VigenciaCampana">Fecha de Vigencia</label>
              <div class="col-sm-4">
              <div class="input-group">
                <input type="date" class="form-control" id="VigenciaCampana" name="VigenciaCampana"/>
                <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                </div>
              </div>
            </div>
            <div class="form-group has-error">
              <label class="col-sm-5 control-label" for="stockCT">Stock Critico</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="stockCT" name="stockCT" placeholder="Stock Critico">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-5 col-sm-9">
                <button type="button" class="btn btn-danger" value="Crear" onclick="prueba2();">Crear Campaña</button>
              </div>
            </div>
            <input type="hidden" class="form-control" id="idconvenio" name="idconvenio"  value="<?=$idconvenio?>">
          </form>
          </div>
          </div>
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

