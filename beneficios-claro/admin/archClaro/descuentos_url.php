<?php ini_set('display_errors', 1); ?> 
<?php

include("class/conectar.class.php");
include("class/control.class.php");


$control = new control();

  $result = $control->descuentos_url();


?>
<div class="center-block">
<table class="table table-bordered table-striped ">
    <tbody>
    <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Url</th>
    </tr>
<?php
    foreach ($result as $key => $value) {  
?>   

    <tr>
        <td><?=$value["id"]?></td>
        <td><?=$value["nombre"]?></td>
        <td><a href="<?=$value["url"]?>" target="_blank"><?=$value["url"]?></td>
    </tr>
<?php
    }
?>

    <tbody>    
</table>
</div>