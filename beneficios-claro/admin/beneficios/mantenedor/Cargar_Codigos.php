<?php
session_start();
if (isset($_SESSION["id"])){

    include("includes/connLocal.php");
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
        <title>Cargar Códigos</title>
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
    </head>

    <body>
    <div class="container">
        <br><br>
        <div class="panel panel-danger">
            <div class="panel-heading">
                <strong>
                    <img src="img/logo_claro.png" width="120" height="41" class="img-rounded"><p align="right" ><strong>Usuario:</strong> <?=$_SESSION["usuario"];?><p><p align="right" ><a href="Login_out.php">Salir</a></p>
                    <h4 align="center">Cargar Códigos Externos</h4>
                    <a href="Lista_Convenios.php" class="button green "><span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span>    Volver</a>
                </strong>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal" enctype='multipart/form-data' action='Subir_Codigos.php' method='post' id="form-id-subir">
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
                                        <option value ='' selected>Seleccione Campaña</option>
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
                                <label class="col-sm-5 control-label" for="VigenciaCod">Fecha de Vigencia</label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="VigenciaCod" name="VigenciaCod"/>
                                        <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-error">
                                <label class="col-sm-5 control-label" for="VigenciaCod">Fichero a importar</label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input size='50' type='file' name='filename'><br />
                                        <input type="hidden" name="subir" value="admin1">
                                        <button type="button" class="btn btn-danger" id="descargarA" onclick="$('#form-id-subir').submit();">Subir TXT</button>
                                    </div>
                                </div>
                            </div>
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

<script>
    var form = document.getElementById("form-id-subir");
    document.getElementById("descargarA").addEventListener("click", function () {
        form.submit();
    });
</script>
