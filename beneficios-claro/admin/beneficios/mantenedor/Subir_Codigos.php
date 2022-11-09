<link rel="stylesheet" href="css/jquery-ui.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
<link rel="shorcut icon" href="img/favicon.ico">
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js" ></script>

<?php
include("includes/connLocal.php");

if($_POST["idconvenio"]!="")
    $objCod=$_POST["idconvenio"];
else
    $msg.="Falta ID Convenio<br>";
if($_POST["cbCampana"]!="")
    $cbCampana=$_POST["cbCampana"];
else
    $msg.="Seleccione Campaña<br>";
if($_POST["VigenciaCod"]!="")
    $VigenciaCod=$_POST["VigenciaCod"];
else
    $msg.="Ingrese Vigencia<br>";
if($_FILES['filename']['tmp_name'] == "")
    $msg.="Seleccione archivo con los códigos a subir<br>";

if($msg=="")
{
    //Upload File
    if (isset($_POST['subir'])) {
        //Import uploaded file to Database
        $handle = fopen($_FILES['filename']['tmp_name'], "r");

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $rut = "";
            $estado = 2;
            $uso = "";
            $canje = "";
            $sql="insert into codigo (Rut,id_Estado,id_Convenio,id_Campana,Codigo,Fecha_Canje,Fecha_Uso,Fecha_Vigencia,comentario) values ('".$rut."','".$estado."','".$objCod."','".$cbCampana."','".$data[0]."','".$uso."','".$canje."','".$VigenciaCod."','')";
            mysql_query($sql,$link_local);
        }

        fclose($handle);
        //view upload form
    } ?>

    <body>
    <div align="center">
        <br><br>
        <div class="container">
            <div class="jumbotron">
                <h2>Codigos Ingresados con Exito!</h2>
                <h4>Presione el boton para regresar al listado de Convenios</h4>
                <p><button type="button" class="btn btn-primary btn-md" onClick="self.location.href='Lista_Convenios.php'">Volver Atras</button><br><br></p>
            </div>
        </div>
    </div>
    </body>

<?php }else{ ?>
    <body>
    <div align="center">
        <br><br>
        <div class="container">
            <div class="jumbotron">
                <h2>Error!</h2>
                <h4><?php echo $msg ?></h4>
                <p><button type="button" class="btn btn-primary btn-md" onClick="self.location.href='Cargar_Codigos.php?idconvenio=<?php echo $objCod ?>'">Volver Atras</button><br><br></p>
            </div>
        </div>
    </div>
    </body>
<?php }
?>