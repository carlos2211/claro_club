<?php
session_start();
include("lib/nusoap.php");

$rut=limpiarCadena($_POST["rut"]);
$celular=limpiarCadena($_POST["celular"]);
$idconvenio =limpiarCadena($_POST["idconvenio"]);



//$rut="13232655K";

$dth_paso = false;
$hfc_paso = false;
$pina_paso = false;


if($rut != ""){

/*VALIDA SERVICIO SOAP */
    /*WSDL AUTOCONSULTA*/
        //$wsdl= "https://legadoautoconsulta.clarochile.cl/TiendaAutoconsultaWSEJB/services/TiendaAutoconsulta";
        $wsdl= "http://legadoautoconsulta.clarochile.cl/TiendaAutoconsultaWSEJB/services/TiendaAutoconsulta";
        $client= new nusoap_client ($wsdl);
        
        /*VALIDA RUT DTH*/
            $result= $client->call('tvirtualConsultaClienteDTH', array('tvirtualConsultaClienteDTHParamIn'=> array('rut'=>$rut)));
            //print_r($result);
            //echo "paso ".$rut;
            /*ASIGNO RESPUESTA A VARIABLES*/
                $dth_paso = false;
                $dth_codigo=$result["codigo"];


                if($dth_codigo == "0" ){
                    $dth_cliente=$result["cliente"];
                    $dth_estado=$result["estado"];
                    $dth_deuda=$result["deuda"];

                    //if($dth_codigo == 0 && $dth_cliente == 0  && $dth_estado == 0  && $dth_deuda == 0 ){
                    if($dth_codigo == 0 && $dth_cliente == 0 ){
                        $dth_paso = true;
                    }    
                }

            /*FIN ASIGNO RESPUESTA A VARIABLES*/
        /*FIN VALIDA RUT DTH*/

        /*VALIDA RUT HFC*/
            $result= $client->call('tvirtualConsultaClienteHFC', array('tvirtualConsultaClienteHFCParamIn'=> array('rut'=>$rut)));
            //print_r($result);
            /*ASIGNO RESPUESTA A VARIABLES*/
                $hfc_paso = false;
                $hfc_codigo=$result["codigo"];

                if($hfc_codigo == "0" ){
                    $hfc_cliente=$result["cliente"];
                    $hfc_estado=$result["estado"];
                    $hfc_deuda=$result["deuda"];

                   // if($hfc_codigo == 0 && $hfc_cliente == 0  && $hfc_estado == 0  && $hfc_deuda == 0 ){
                    if($hfc_codigo == 0 && $hfc_cliente == 0 ){
                        $hfc_paso = true;
                    }    
                }
            /*FIN ASIGNO RESPUESTA A VARIABLES*/
        /*FIN VALIDA RUT HFC*/
    unset($wsd,$client,$result);

    /*FIN WSDL AUTOCONSULTA*/

}

if($celular != ""){
    /*WSDL PINA*/

        $pcs = "56".$celular;
        /*VALIDA PCS PINA TEST*/
            /*$wsdl= "http://directo.clarochile.cl:80/PinaWSEJB/services/Pina"; //TEMP
            $client= new nusoap_client ($wsdl); 
            $result= $client->call('consultaAbonado', array('consultaAbonadoParamIn'=> array('pcs'=>$pcs)));*/
            //print_r($result);
            /*ASIGNO RESPUESTA A VARIABLES*/
/*
                $pina_paso = false;
                $pina_codigo=$result["codigo"];

                if($pina_codigo == 0 ){
                    $pina_tipoRed=$result["tipoRed"];
                    $pina_tipoAbonado=$result["tipoAbonado"];
                    $pina_descripcion=$result["descripcion"];

                    if($pina_codigo == 0 && ($pina_tipoAbonado == 1 || $pina_tipoAbonado == 2 || $pina_tipoAbonado == 3)){
                        $pina_paso = true;

                    }    
                }*/
            /*FIN ASIGNO RESPUESTA A VARIABLES*/
        /*FIN VALIDA PCS PINA TEST*/
        /*VALIDA PCS PINA*/

            $wsdl= "https://smspremium.clarochile.cl/PinaWS/services/Pina/PinaService?wsdl"; // PROD
            $client= new nusoap_client ($wsdl,true); //
            $result= $client->call('consultaAbonado', array('consultaAbonadoParamIn'=> array('pcs'=>$pcs)));
            //print_r($result);
            /*ASIGNO RESPUESTA A VARIABLES*/
            
                $pina_paso = false;
                $pina_codigo=$result["consultaAbonadoParamOut"]["codigo"];

                if($pina_codigo == "0" ){
                    $pina_tipoRed=$result["consultaAbonadoParamOut"]["tipoRed"];
                    $pina_tipoAbonado=$result["consultaAbonadoParamOut"]["tipoAbonado"];
                    $pina_descripcion=$result["consultaAbonadoParamOut"]["descripcion"];

                    if($pina_codigo == 0 && ($pina_tipoAbonado == 1 || $pina_tipoAbonado == 2 || $pina_tipoAbonado == 3)){
                        $pina_paso = true;

                    }    
                }

            /*FIN ASIGNO RESPUESTA A VARIABLES*/
        /*FIN VALIDA PCS PINA*/               
    /*FIN WSDL PINA*/
}




    /*VALIDACION MENSAJE*/
    //echo "DTH:".$dth_paso."</br>HFC:".$hfc_paso."</br>PINA:".$pina_paso;
    //if (($dth_paso || $hfc_paso) && $pina_paso){
    if ($dth_paso || $hfc_paso || $pina_paso){
    //if ($dth_paso || $hfc_paso){
        session_unset();
        $_SESSION["rut"] = $rut;
        $_SESSION["celular"] = $celular;
        $_SESSION["idconvenio"] = $idconvenio;
        $_SESSION["mensaje"] = 1;

        header("Location: mensaje_exito.php");
    }else{

        $paso_temp=true;   


        if ($celular == "" && $rut =="" && $paso_temp){

            //echo "error en rut y celular";
             $paso_temp=false;  
             $mensaje_error="1";

        }

        if($celular=="" && $pina_paso == false && $paso_temp){

            //echo "Rut no valido";
            $paso_temp=false; 
            $mensaje_error="2"; 
        }
        if ($rut == "" && $dth_paso == false && $hfc_paso == false && $paso_temp ){

            //echo "celular no valido";
            $paso_temp=false;
            $mensaje_error="3";  
        }

        if ($dth_paso == false && $hfc_paso == false && $pina_paso == false && $paso_temp){

            //echo "error en rut y celular  2";
            $paso_temp=false;
            $mensaje_error="4";  
        }


        header("Location: mensaje_error.php?n=".$mensaje_error);
    }

    /*VALIDACION MENSAJE FINAL*/


/*FIN VALIDA SERVICIO SOAP */



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
    $valor = str_ireplace(".","",$valor);
    $valor = str_ireplace("-","",$valor);
    return $valor;
}
?>