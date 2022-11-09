<?php
require_once("lib/nusoap.php");
include("clases/query.class.php");

	function validaCodigo($codigo,$token){

		include("includes/connSoap.php");

		$consulta = new query($link);

		$consulta->token= $token;
		$consulta->codigo = $codigo;

		return $consulta->validaCodigo();

	}

	function utilizaCodigo($codigo,$token,$comentario){

		include("includes/connSoap.php");

		$consulta = new query($link);

		$consulta->token= $token;
		$consulta->codigo = $codigo;
		$consulta->comentario = $comentario;

		return $consulta->utilizaCodigo();

	}	

	$server = new nusoap_server();
	$ns = "#";
	$server->configureWSDL('wservice','urn:wservicewsdl',$ns);
	$server->configureWSDL('BeneficiosClaroCodigosWS',$ns);
	$server->wsdl->schematargetnamespace=$ns;

	$server->wsdl->addComplexType('ArrayEnc','complexType','struct','all','',array('nombreE' => array('name' => 'nombreE', 'type' => 'xsd:string'),'claveE' => array('name' => 'claveE', 'type' => 'xsd:string')));

	
	$server->register('validaCodigo',
						array(	'codigo'=>'xsd:string',
								'token'=>'xsd:string'),
						array(  'return' =>'xsd:Array'),
						'urn:wservicewsdl','urn:wservicewsdl#validaCodigo','rpc','encoded','Valida Codigos Beneficio');

	$server->register('utilizaCodigo',
						array(	'codigo'=>'xsd:string',
								'token'=>'xsd:string',
								'comentario' => 'xsd:string'),
						array(  'return' =>'xsd:Array'),
						'urn:wservicewsdl','urn:wservicewsdl#validaCodigo','rpc','encoded','Utiliza Codigos Beneficio');

	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA: '';
	$server->service($HTTP_RAW_POST_DATA);
?>