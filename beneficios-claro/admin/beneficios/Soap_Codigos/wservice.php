<?php

  
	require_once("lib/nusoap.php");
	include("clases/query.class.php"); 

	function obtener_codigo($rut,$idconvenio,$email,$fono)
	{

    include("include/connSoap.php");

	$consulta = new query($link);

	if($rut == ""){
		$rut ="c:".$fono;	
	}


	$consulta->rut = $rut;
	$consulta->idconvenio = $idconvenio;
	$consulta->email = "";
	$consulta->fono	 = "";

	/*Validacion Stock Critico para envio MAIL*/

		if ($consulta->valida_stock() == 1){

			require 'clases/PHPMailer/PHPMailerAutoload.php';

					$cuerpo = file_get_contents("mail/alerta_stock.html", true);
					$cuerpo = str_replace("%idconvenio%",$idconvenio,$cuerpo);
					$cuerpo = str_replace("%stock%",$consulta->stock_critico,$cuerpo);


					$mail = new PHPMailer;
					
					//$mail->SMTPDebug = 3;                               // Enable verbose debug output
					
					$mail->isSMTP();                                      	// Set mailer to use SMTP
					$mail->Host = 'mail.beneficioscfidelis.cl';  		// Specify main and backup SMTP servers
					$mail->SMTPAuth = true;                              	// Enable SMTP authentication
					$mail->Username = 'stock@beneficioscfidelis.cl';    // SMTP username
					$mail->Password = 'fidelis.,3170';                      // SMTP password
					$mail->SMTPSecure = '567';                            	// Enable TLS encryption, `ssl` also accepted
					$mail->Port = 587;                                    	// TCP port to connect to
					
					$mail->setFrom('stock@beneficioscfidelis.cl', 'Stock Beneficios Claro');
					$mail->addAddress("sistemas@fidelis.cl", 'Sistemas');
					$mail->addAddress("imadrid@fidelis.cl", 'Ivonne Madrid');
					$mail->addAddress("byanine@fidelis.cl", 'Belen Yanine');
					$mail->addAddress("adelita.bacarreza@clarochile.cl", 'Adelita Bacarreza');
					$mail->addAddress("claudia.figueroal@clarochile.cl", 'Claudia Figueroa');

					
					$mail->isHTML(true);                                  	// Set email format to HTML
					
					$mail->Subject = '[Claro] Alerta, Stock Critico Convenio '.$idconvenio;
					$mail->Body    = $cuerpo;
					
					$mail->send();


		}
	/*Fin Validacion Stock Critico para envio MAIL*/

		if($idconvenio == 1750)
		{
			$consulta->email = $email;
			$consulta->fono	 = $fono;
			return $consulta->consume_bata();
		}else{
			return $consulta->obtener_codigo();
		}
	}

	function quemar_codigo($codigo)
	{

    include("include/connSoap.php");

	$consulta = new query($link);

	$consulta->codigo= $codigo;

	return $consulta->quemar_codigo();


	}

	function tipo_mensaje($idconvenio)
	{

    include("include/connSoap.php");

	$consulta = new query($link);

	$consulta->idconvenio= $idconvenio;

	return $consulta->tipo_mensaje();


	}


	function uso_convenio($idconvenio,$nombreconvenio,$tipocodigo,$codigoemitido,$comentario)
	{

    include("include/connSoap.php");

	$consulta = new query($link);

	$consulta->idconvenio= $idconvenio;
	$consulta->nombreconvenio=$nombreconvenio;
	$consulta->tipocodigo=$tipocodigo;
	$consulta->codigoemitido=$codigoemitido;
	$consulta->comentario=$comentario;

	return $consulta->uso_convenio();
	//$test=array('mensaje'=>'prueba');
	return $test;

	}	

	$server = new nusoap_server();
	$ns="#";

	$server->configureWSDL('wservice','urn:wservicewsdl',$ns);
	$server->configureWSDL('Servicios Claro Chile Codigos',$ns);
	$server->wsdl->schematargetnamespace=$ns;

	$server->wsdl->addComplexType('ArrayEnc','complexType','struct','all','',array('nombreE' => array('name' => 'nombreE', 'type' => 'xsd:string'),'claveE' => array('name' => 'claveE', 'type' => 'xsd:string')));

	$server->register('obtener_codigo', array(	'rut'=>'xsd:string',
												'idconvenio'=>'xsd:string',
												'email'=>'xsd:string',
												'fono'=>'xsd:string'
												),
										array('return' => 'xsd:Array'),
												'urn:wservicewsdl','urn:wservicewsdl#obtener_codigo','rpc','encoded','Obtiene codigos disponible segun idconvenio');
	$server->register('quemar_codigo', array(	'codigo'=>'xsd:string'
												),
										array('return' => 'xsd:Array'),
												'urn:wservicewsdl','urn:wservicewsdl#quemar_codigo','rpc','encoded','Quema los codigos disponibles');

	$server->register('tipo_mensaje', array('idconvenio'=>'xsd:string'),
									   array('return'=>'xsd:Array'),
									   'urn:wservicewsdl','urn:wservicewsdl#quemar_codigo','rpc','encoded','Obtiene Tipo Mensaje');
	$server->register('uso_convenio', array('idconvenio'=>'xsd:string',
											'nombreconvenio'=>'xsd:string',
											'tipocodigo'=>'xsd:string',
											'codigoemitido'=>'xsd:string',
											'comentario'=>'xsd:string'),
									array('return'=>'xsd:Array'),
									'urn:wservicewsdl','urn:wservicewsdl#quemar_codigo','rpc','encoded','Obtiene Tipo Mensaje');


	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA: '';
	$server->service($HTTP_RAW_POST_DATA);    
?>	