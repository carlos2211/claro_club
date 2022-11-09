<?php
session_start();
if (isset($_SESSION["id"])) {

    include("includes/connLocal.php");
    include("clases/codigo.class.php");

    $objCod=new codigo($link_local);
    $msg="";
    if($_POST["campaña"]!="")
        $campaña=strtoupper($_POST["campaña"]);
    else
        $msg.="Ingrese nombre de campaña<BR>";

    if($msg=="")
    {
        $msg = $objCod->search_codigos($campaña); ?>

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
            <link rel="stylesheet" href="css/jquery-ui.css">

            <script src="js/jquery-1.10.2.js"></script>
            <script src="js/jquery-ui.js"></script>
            <script src="js/jquery.min.js"></script>
            <script src="js/bootstrap.min.js" ></script>

            <script src="js/jquery-2.1.1.min.js"></script>
            <script src="js/jquery-dataTables.js" ></script>
            <script>
                $(document).ready(function()
                {
                    $('#example').DataTable();

                });
            </script>
        </head>

        <body>
        <div class="container">
            <br><br>
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <strong>
                        <img src="img/logo_claro.png" width="120" height="41" class="img-rounded"><p align="right" ><strong>Usuario:</strong> <?=$_SESSION["usuario"];?><p><p align="right" ><a href="Login_out.php">Salir</a></p>
                        <h4 align="center">Utilizar Códigos</h4>
                        <h4 align="center"><?php echo $campaña ?></h4>
                        <a href="Mantenedor_Claro.php" class="button green "><span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span>    Volver</a>
                    </strong>
                </div>
                <div class="panel-body table-responsive">
                    <form class="form-horizontal" method="POST" action="" role="form" id="Buscar_Campañas">
                        <table class="display" id="example" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>  Id Codigo</th>
                                <th><span class="glyphicon glyphicon-barcode" aria-hidden="true"></span>  Codigo</th>
                                <th><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>  Id Convenio</th>
                                <th><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>  Id Campaña</th>
                                <th><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>  Fecha de Vigencia</th>
                                <th><span class="glyphicon glyphicon-user" aria-hidden="true"></span>  Rut</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while($row = mysql_fetch_assoc($msg))
                            {
                                ?>
                                <tr>
                                    <td align="center"><?php echo $row["id_Codigo"];?></td>
                                    <td align="center"><?php echo $row["Codigo"];?></td>
                                    <td align="center"><?php echo $row["id_Convenio"];?></td>
                                    <td align="center"><?php echo $row["id_Campana"];?></td>
                                    <td align="center"><?php echo $row["Fecha_Vigencia"];?></td>
                                    <td align="center">
                                        <?php
                                        if($row["Rut"] != "")
                                        {
                                            echo $row["Rut"];
                                        }
                                        if($row["Rut"] == "")
                                        {
                                        ?>
                                        <button type="button" onclick="prueba(<?=$row["id_Codigo"]?>);" class="btn btn-danger btn-sm" ></span> Utilizar Codigo</button></a></td>
                                    <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        </body>
        </html>

    <?php }else{ ?>
        <link rel="stylesheet" href="css/jquery-ui.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css" >
        <script src="js/jquery-1.10.2.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js" ></script>

        <body>
        <div align="center">
            <br><br>
            <br><br>
            <div class="container">
                <div class="jumbotron">
                    <h2>ERROR!</h2>
                    <h4><?php echo $msg ?></h4>
                    <p><button type="button" class="btn btn-primary btn-lg" onClick="self.location.href='Utilizar_Codigos.php'">Volver</button><br><br></p>
                </div>
            </div>
        </div>
        </body>
    <?php }
}else{
    header ("Location: Login.php");
}
?>

<script>
    function prueba(idcodigo)
    {

        swal({   title: "Utilizar Codigo",
                text: "Por favor ingrese un RUT a utilizar",
                type: "input" ,
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "RUT ej.123456789"
            },
            function(inputValue)
            {
                if (inputValue === false) return false;
                if (inputValue === "")
                {
                    swal.showInputError("Por favor, ingrese un RUT para continuar");
                    return false
                }
                $.ajax({
                    url: "act_rut.php",
                    type: "POST",
                    data: {rut: inputValue,codigo:idcodigo},
                    dataType: "html",
                    success: function () {
                        //swal("Bien Hecho!", "El RUT utilizado es: " + inputValue, "success");
                        location.reload();
                    }
                });
            }

        );
    }
</script>
