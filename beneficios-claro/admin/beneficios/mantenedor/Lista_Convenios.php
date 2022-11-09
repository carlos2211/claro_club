<?php
session_start();
if (isset($_SESSION["id"])){
?>
<!doctype html>

<html lang="en">

  <head>
    <title>Listado de Convenios Claro</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css" >
    <link rel="stylesheet" href="css/fontawesome-all.css" rel="stylesheet">

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
    <script src="js/jquery-ui-1.9.2.custom.js"></script>
    <script src="js/jquery-dataTables.js" ></script>
  
  </head>

  <body>

      <div class="container">
        <br><br>
        <div class="panel panel-danger">
          <div class="panel-heading">
            <strong>
              <img src="img/logo_claro.png" width="120" height="41" class="img-rounded"><p align="right" ><strong>Usuario:</strong> <?=$_SESSION["usuario"];?><p><p align="right" ><a href="Login_out.php">Salir</a></p>
              <h4 align="center">Listado de Convenios de Claro</h4>
              <a href="Mantenedor_Claro.php" class="button green "><span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span>    Volver</a>
              
            </strong>
          </div>
          <div class="panel-body table-responsive">
          <form class="form-horizontal" method="POST" action="" role="form" id="Formulario_ListaConvenios">
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
              <tbody id="sortable">
                
                <?php

                  $file = file_get_contents("http://clarofans.clarochile.cl/admin/archClaro/descuentos_mantenedor.php?tipo=1", true);
                  echo $file;
                ?>
                
              </tbody>

            </table>

          </div>
        </div>
      </div>
    </form>
    <form id="form_sort">
    </form>
  </body>
  <script>


    $( function() {
      var orden_activo=false;
      var tabla_conv= $('#example').DataTable( {
        
        "bDestroy": true,
        "aaSorting": []

      } );
      $("#sortable").sortable({                
        stop: function(event, ui) {
          var indicesElementos    = "";
          var value               = "";
          var index               = "";
          var info = tabla_conv.page.info();
          $("#sortable>tr").each(
            function (index, element) {
              index=index+(info.page*info.length)+1;         
              value = $(element).attr("value");
              indicesElementos += "<input type='hidden' name='"+value+"' value='"+index+"'>";
            }
          );
          $("#form_sort").append(indicesElementos);
          guardarOrden();
        }
      });
       $("#sortable").sortable("disable");
        var content='';
      $("#ordenar_btn").click(function(){
        if(!orden_activo ){     
           $('#example').dataTable().fnDestroy();
          tabla_conv= $('#example').DataTable( {
            "bSort" : false,
            "searching": false,
            "bDestroy": true,
            "aaSorting": []

          } );
          $("#sortable").sortable("enable");
          /*content= $("#sortable").html();
          $('#example').DataTable().clear();
          $("#sortable").html(content);*/
          $("#ordenar_btn").val('Terminar de ordenar');
          orden_activo=true;
        }
        else{
          content= $("#sortable").html();
          $('#example').dataTable().fnDestroy();
           $("#sortable").html(content);
          tabla_conv= $('#example').DataTable( {
            
            "bDestroy": true,
            "aaSorting": []

          } );
            $("#sortable").sortable("disable");
          $("#ordenar_btn").val('Ordenar');

          orden_activo=false;

        }

      })

    });

    function guardarOrden() {
    $.ajax(
    {
        type: 'post',
        url: 'http://clarofans.clarochile.cl/admin/archClaro/guardar_orden.php',
        dataType: 'json',
        data: $("#form_sort").serialize()+"&action=1",
        success: function (data)
        {
            console.log(data);
        },
        error: function(data)
        {
          console.log(data.responseText);
          console.log(data);
        },
        complete: function () 
        {
            indicesElementos = "";
            $("#form_sort>input:hidden").remove();
        }
    }
    );
}
  </script>
</html>
<?php
}else{

header ("Location: Login.php");

}
?>
