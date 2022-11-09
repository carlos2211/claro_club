<?php
class globales
{
	
/*-------------- Estas son las variables globales ------------------*/
		
		//$local = "localhost:8080/adm/arch_finning/";
		var $local = "http://clarofans.clarochile.cl/admin/archClaro/";
		//var $local = "http://localhost/MC13%20AUG/adm/archClaro/";
		var $localh= "http://localhost";
		var $ws_codigos= "http://clarofans.clarochile.cl/admin/beneficios/Soap_Codigos/wservice.php";

/*------------------------------------------------------------------*/
  
  function trae_datos($arch){
  	
    $file = file_get_contents($arch, true);
    return $file;
  }

}
?>