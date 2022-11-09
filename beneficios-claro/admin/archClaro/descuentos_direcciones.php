<?php ini_set('display_errors', 1); ?> 
<?php

$token = (isset($_GET["token"])) ? $_GET["token"] : "";
$id = (isset($_GET["id"])) ? $_GET["id"] : "";

if ( $token == "ZGVzY3VlbnRvX2RpcmVjY2lvbmVzLnBocA" && $id !="" ) {

include("class/conectar.class.php");
include("class/control.class.php");


$club = 35 ; //Club 


$control = new control();

$control->club=$club;
$control->id_convenio =$id;

	$result = $control->descuentos_direcciones();

?>
 <table>

    <thead>
        <tr>
            <th>Comuna</th>
            <th>Dirección</th>
            <th>Teléfono</th>
        </tr>
    </thead>
<?php
        if($result != false){

            foreach ($result as $key => $value) {       
?>   
        <tr>
            <td><?php echo utf8_encode($value["comuna"])?></td>
            <td><?php echo utf8_encode($value["direccion"])?></td>
            <td><?php echo $value["telefono"]?></td>
        </tr>        
<?php
            }

		}
?>
    </tbody>
</table>
<?php
}
?>         