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

    $fecha_hoy = date("Y-m-d");
  
    $consulta = "SELECT c.id, c.marca, cc.tagline, c.idcat, ci.name_imagen FROM convenio c, cliente_convenio cc, imagen_convenio ci WHERE c.id = cc.idconvenio AND  str_to_date('".$fecha_hoy."','%Y-%m-%d') BETWEEN c.fecha_contrato AND str_to_date(cc.vigencia,'%Y-%m-%d') AND ci.detalle=0 AND c.status=0 AND c.id = ci.idconvenio AND c.marca LIKE '%".$keyword."%' ORDER BY orden_home ASC";
    $rs = mysql_query($consulta, $con);
      $beneficios = array();
      while ($row = mysql_fetch_array($rs)) { 
        // var_dump($row);
        array_push($beneficios, array(
        "id"=> $row["id"],
        "marca"=> $row["marca"],
        "tagline"=> utf8_encode($row["tagline"]),
        "name_imagen"=> $row["name_imagen"],
        "idcat"=> $row["idcat"]
      ));
      }
      // var_dump($beneficios);
      echo json_encode($beneficios);
  } else {
    echo "no tienes permisos";
  }



