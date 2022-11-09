<?php
  require 'includes/conn.php';
  header('Content-Type: application/json; charset=utf-8');
  header("Access-Control-Allow-Origin: https://foo.bar.org");
  header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
  header("Access-Control-Allow-Headers: Content-Type, x-requested-with");
  
  
  $request_domain = ($_SERVER["HTTP_REFERER"]);
  // var_dump($_SERVER);
  $allowed_domains = array("https://digital.clarochile.cl/beneficios-claro/dist/");
  if (in_array($request_domain, $allowed_domains)){
      $sql = "SELECT DISTINCT (c.idcat), cc.nombre FROM convenio c, categoria_convenio cc WHERE c.idcat = cc.id AND cc.status = 0";
      $rs = mysql_query($sql, $con);
      $categorias = array();
      while ($row = mysql_fetch_array($rs)) { 
      array_push($categorias, array("idcat" => $row["idcat"], "nombre" => utf8_encode($row["nombre"])) );}
      echo json_encode($categorias);
  } else {
    echo "No tienes permisos";
  }

