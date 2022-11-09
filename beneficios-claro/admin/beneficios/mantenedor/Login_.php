<?php
 session_start();

include("includes/connLocal.php");
include("clases/login.class.php");

$objLogin=new login($link_local);

$email=limpiarCadena($_POST["email"]);
$passwords = limpiarCadena($_POST["passwords"]);

$objLogin->nombre	=$email;
$objLogin->clave 	=$passwords;

$res=$objLogin->load();

if ($res > 0){

	

	$_SESSION["id"] = $res;
	$_SESSION["usuario"] = $email;

	header ("Location: Mantenedor_Claro.php");

}
else
{ 
    ?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mantenedor Claro Chile</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="css/justified-nav.css" rel="stylesheet">
    <link rel="shorcut icon" href="img/favicon.ico">
    <script src="js/ie-emulation-modes-warning.js"></script>
    <link href="css/signin.css" rel="stylesheet">
  </head>

  <body>

<div class="container">

	

      <form class="form-signin">
      	<p>Lo sentimos, usuario o contraseña incorrecta. </p>
        <button class="btn btn-lg btn-primary btn-block" type="button" onclick="window.location.href='Login.php'" >Volver</button>
      </form>


    <script src="js/ie10-viewport-bug-workaround.js"></script>
    </div>
  </body>
</html>



<?php
}


function limpiarCadena($valor)
{
    $valor = str_ireplace("SELECT","",$valor);
    $valor = str_ireplace("COPY","",$valor);
    $valor = str_ireplace("DELETE","",$valor);
    $valor = str_ireplace("DROP","",$valor);
    $valor = str_ireplace("DUMP","",$valor);
    $valor = str_ireplace(" OR ","",$valor);
    $valor = str_ireplace("%","",$valor);
    $valor = str_ireplace("LIKE","",$valor);
    $valor = str_ireplace("--","",$valor);
    $valor = str_ireplace("^","",$valor);
    $valor = str_ireplace("[","",$valor);
    $valor = str_ireplace("]","",$valor);
    $valor = str_ireplace("!","",$valor);
    $valor = str_ireplace("¡","",$valor);
    $valor = str_ireplace("?","",$valor);
    $valor = str_ireplace("=","",$valor);
    $valor = str_ireplace("&","",$valor);
    $valor = str_ireplace("-","",$valor);
    return $valor;
}
?>