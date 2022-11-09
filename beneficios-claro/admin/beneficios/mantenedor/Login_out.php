<?php
 session_start();

 unset($_SESSION["id"],$_SESSION["usuario"]);

header ("Location: Mantenedor_Claro.php");
?>