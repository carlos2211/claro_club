<?php
class fecha{

function to_sql($fecha){
 $txt="";
 if ($fecha!=""){
   $dia=substr($fecha,0,2);
   $mes=substr($fecha,3,2);
   $agno=substr($fecha,6);
   $txt=$agno."-".$mes."-".$dia;
 }
   return $txt;   
}
function to_normal($fecha){
 $txt="";
 if ($fecha!=""){
   $dia=substr($fecha,8);
   $mes=substr($fecha,5,2);
   $agno=substr($fecha,0,4);
   $txt=$dia."/".$mes."/".$agno;
  }
   return $txt;   
}

function mes_espanol($no_mes){
$aux="";
 switch($no_mes){
		case 1:
       	   $aux="Enero";
		   break;
		case 2:
       	   $aux="Febrero";
		   break;
 	    case 3:
       	   $aux="Marzo";
		   break;
		case 4:
       	   $aux="Abril";
		   break;
		case 5:
       	   $aux="Mayo";
		   break;
		case 6:
       	   $aux="Junio";
		   break;
		case 7:
       	   $aux="Julio";
		   break;
		case 8:
       	   $aux="Agosto";  
		   break;
		case 9:
       	   $aux="Septiembre";
		   break;
		case 10:
       	   $aux="Octubre";
		   break;
		case 11:
       	   $aux="Noviembre";
		   break;
		case 12:
       	   $aux="Diciembre";  
	break;
	}
	return $aux;
}
}
?>