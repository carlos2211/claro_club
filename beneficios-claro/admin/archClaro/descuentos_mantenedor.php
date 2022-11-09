<?php ini_set('display_errors', 1); ?> 
<?php

include("class/conectar.class.php");
include("class/control.class.php");


$tipo =  $_GET["tipo"];

$control = new control();

$control->club = 35;

  $result = $control->descuentos_mantenedor();


    foreach ($result as $key => $value) {  


    switch ($tipo) {
    case 1: // LISTADO DESCUENTO GENERA CODIGOS
?>
              <tr>
                <td align="center"><?php echo $value["id"];?></td>
                <td align="center"><?php echo utf8_encode($value["nombre_convenio"]);?></td>
                <td align="center"><?php echo utf8_encode($value["descuento"]);?></td>
                <td align="center"><?php echo $value["vigencia"];?></td>
                <td align="center"><?php echo $value["estado_convenio"];?></td>
                <td align="left"><?php echo $value["publicacion"];?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;              <a href="Generar_Codigos.php?idconvenio=<?=$value["id"]?>" style="display: block;"><i class="fas fa-plus-square"></i> Generar Código</a>
                    <a href="Cargar_Codigos.php?idconvenio=<?=$value["id"]?>" style="display: block;"><i class="fas fa-upload"></i> Cargar Códigos</a>
                    <a href="Modificar_Convenio.php?idconvenio=<?=$value["id"]?>" style="display: block;"><i class="fas fa-edit"></i> Modificar</a>
                    <?php
                        if($value["estado_convenio"] == 'Deshabilitado'){ ?>
                            <a href="Enable.php?idconvenio=<?=$value["id"]?>" style="display: block;"><i class="fas fa-check-circle"></i> Habilitar</a></td>
                       <?php }else{ ?>
                           <a href="Delete.php?idconvenio=<?=$value["id"]?>" style="display: block;"><i class="fas fa-trash-alt"></i> Deshabilitar</a></td>
                      <?php }
                    ?>
              </tr>

<?php
        break;
    case 2: //LISTADO DESCUENTOS PARA LISTA EXCELL
?>

              <tr>
                <td align="center"><?php echo $value["id"];?></td>
                <td align="center"><?php echo utf8_encode($value["nombre_convenio"]);?></td>
                <td align="center"><?php echo utf8_encode($value["descuento"]);?></td>
                <td align="center"><?php echo $value["vigencia"];?></td>
                <td align="center"><?php echo $value["estado_convenio"];?></td>
                <td align="center"><?php echo $value["publicacion"];?>
                <a href="Listado_Camp_EXC.php?idconvenio=<?=$value["id"]?>"><button type="button" class="btn btn-danger btn-sm" ></span> Listar Campaña</button></a></td>
              </tr>



<?php
        break;
    case 3:
        echo "i es igual a 2";
        break;
}
        
?>   



<?php
    }
?>
