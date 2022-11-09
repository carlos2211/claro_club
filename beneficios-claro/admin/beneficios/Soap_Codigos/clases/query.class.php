<?php
	class query
	{

		public $rut;
		public $idconvenio;
		public $codigo;
		public $idcodigo;
		public $idestado;
		public $idcampana;
		public $email;
		public $fono;
		public $stock_critico;
		public $stock_actual;

		public $nombreconvenio;
		public $codigoemitido;
		public $tipocodigo;
		public $comentario;

		function query($link)
		{
			$this->link=$link;
		}

		function guardar_track($rut,$fono,$cod,$id_convenio,$estado)
		{
			$sql = "INSERT INTO track_cupon( id, rut_cliente, fono, cod, fecha_solicitud, id_convenio, estado )";
			$sql = $sql." VALUES (NULL, '".$rut."', '".$fono."', '".$cod."', CURRENT_DATE(), '".$id_convenio."',".$estado.");";

			mysql_query($sql,$this->link);

			return "$sql";
		}

		function consume_bata()
		{

			$url = "http://medios.bataclub.cl/api/api.php?action=get_code&data={%22rut%22:%22" . $this->rut . "%22,%22telefono%22:%22" . $this->fono;
			$url = $url . "%22,%22email%22:%22" . $this->email . "%22,%22convenio%22:%22001%22,%22cadena%22:%22001%22}";

			$respuesta = file_get_contents($url);

			$res_json = json_decode($respuesta, true);
			$mensaje = "No encontro mensaje";
			$result = "";
			$code = "";

			$result = $res_json["result"][status];
			$mensaje = $res_json["error"][msg];

			if ($result == "Success") {
				$code = $res_json["result"];
				$resQuery = $this->guardar_track($this->rut, $this->fono, $code, $this->idconvenio,1);
			} else {
				$code = "-1";
				$resQuery = $this->guardar_track($this->rut, $this->fono, "-1", $this->idconvenio,0);
			}

			$arreglo = array('mensaje' => $mensaje, 'idmensaje' => $code);

			return $arreglo;
		}

		function obtener_codigo()
		{
			$paso=true;
			$mensaje="";

			if(($this->idconvenio == "" || $this->rut == "")&& $paso)
			{
				$paso = false;
				$mensaje = "Lo sentimos, los datos ingresados no han sido encontrados o no son validos, intente nuevamente .";
				$arreglo = array('mensaje'=>$mensaje ,'idmensaje'=>'-3');
			}

			/*Obtener campaña vigente asociada al idconvenio*/

			$sql="	SELECT 
					    id_Campana
					FROM
					    campana 
					WHERE
					    id_Convenio = ".$this->idconvenio."
					    AND id_Estado = 4
					ORDER BY id_Campana DESC
					LIMIT 1;";
			// echo $sql;

			$res=mysql_query($sql,$this->link);
			//echo mysql_num_rows($res);
			$idcampana="";

			if (mysql_num_rows($res)>0)
			{

				$row=mysql_fetch_array($res);

				$idcampana = $row["id_Campana"];
				//print_r($row);

				/*if (($idcampana == 0 || $idcampana =="") && $paso)
				{
					$paso = false;
					$mensaje = "Lo sentimos, no se encontraron campanas disponibles.";
					$arreglo = array('mensaje'=>$mensaje ,'idmensaje'=>'-2');
				}*/
			}
			else
			{
				$paso = false;
				$mensaje = "Lo sentimos, los datos ingresados no han sido encontrados o no se encontraron campanas disponibles, intente nuevamente.";
				$arreglo = array('mensaje'=>$mensaje ,'idmensaje'=>'-2');
			}

			/*Obtener codigo disponible asociada a la campaña*/

			if ($idcampana != ""){

			$sql_2 = "	SELECT 
							id_Codigo
						FROM 
							codigo
						WHERE 
							id_Campana  = ".$idcampana."
							and id_Estado = 2
						    and Rut = ''
						ORDER BY id_Codigo ASC
						LIMIT 1;";
			 //echo $sql_2;

			$res_2=mysql_query($sql_2,$this->link);
			//echo mysql_num_rows($res_2);

			if(mysql_num_rows($res_2) > 0 && $paso)
			{
				$row_2=mysql_fetch_array($res_2);

				$idcodigo = $row_2["id_Codigo"];

				// if (($idcodigo == 0 || $idcodigo =="") && $paso)
				// {
				// 	$paso = false;
				// 	$mensaje = "Lo sentimos, no existen codigos disponibles.";
				// 	$arreglo = array('mensaje'=>$mensaje ,'idmensaje'=>'-1');
				// }


			}
			elseif($paso)
			{
				$paso = false;
				$mensaje = "Lo sentimos, los datos ingresados no han sido encontrados o no existen codigos disponibles, intente nuevamente 2.";
				$arreglo = array('mensaje'=>$mensaje ,'idmensaje'=>'-1');
			}

			}


			/*Actualizo codigo con rut y fecha de uso*/

			$sql_3 = "	UPDATE 
							codigo
						SET 
							Rut = '".$this->rut."',
						    Fecha_Canje = now(),
						    id_Estado = 1
						WHERE 
							id_Codigo = ".$idcodigo.";";
			//echo $sql_3;

			$res_3=mysql_query($sql_3,$this->link);

			/*Mostrar informacion codigo,vigencia,idcampaña*/



			if($paso == true)
			{
				$sql_4 = "	SELECT
								Codigo,
							    adddate(now(),interval 2 month)as Vigencia,
							    id_Campana,
							    Rut,
							    'Se llevo acabo la operacion correctamente.' as mensaje,
							    '0' as idmensaje
							FROM 
								codigo 
							WHERE 
								id_Codigo = ".$idcodigo.";";
			    // echo $sql_4;

				if($res_4=mysql_query($sql_4,$this->link))
				{

				while($row_4 = mysql_fetch_assoc($res_4))
				{
					$arreglo[]=$row_4;
				}					


				}
				 	
			}

			return $arreglo;
		}

		function quemar_codigo()
		{

			$paso=true;
			$mensaje="";

			if($this->codigo == "")
			{
				$paso = false;
				$mensaje = "Lo sentimos, el codigo ingresado no ha sido encontrado o no es valido, intente nuevamente.";
				$arreglo = array('mensaje'=>$mensaje ,'idmensaje'=>'-4');
			}

			/*Obtener Campaña vigente asociada al Codigo*/
			$sql="	SELECT 
					    co.id_Campana AS 'id_Campana',
					    ca.Fecha_Vigencia AS 'Fecha_Vigencia'
					FROM
					    codigo AS co
							LEFT JOIN
						campana AS ca ON ca.id_Campana = co.id_Campana
					WHERE
					    co.Codigo = '".$this->codigo."'
					AND
						ca.Fecha_Vigencia > NOW()
					LIMIT 1	;";
			//echo $sql;

			$res=mysql_query($sql,$this->link);
			//echo "numero de filas:".mysql_num_rows($res)."<br>";

			if (mysql_num_rows($res)>0)
			{
				$row=mysql_fetch_array($res);

				$idcampana = $row["id_Campana"];
				$fechavigencia = $row["Fecha_Vigencia"];

				if (($idcampana == 0 || $idcampana =="") && $paso)
				{
					$paso = false;
					$mensaje = "Lo sentimos, la capana no se encuentra vigente";
					$arreglo = array('mensaje'=>$mensaje ,'idmensaje'=>'-2');
				}
			}
			else
			{
				$paso = false;
				$mensaje = "Lo sentimos, el codigo ingresado no ha sido encontrado o no es valido, intente nuevamente.";
				$arreglo = array('mensaje'=>$mensaje ,'idmensaje'=>'-4');
			}


			/*Obtener Codigo disponible asociado a la Campaña*/

			$sql_2="SELECT 
					    id_Codigo AS 'id_Codigo',
					    Fecha_Vigencia AS 'Fecha_Vigencia',
					    id_Estado AS 'id_Estado'
					FROM
					    codigo 
					WHERE
					    Codigo = '".$this->codigo."'
					AND
							Fecha_Vigencia > NOW();";
			//echo $sql_2;

			$res_2=mysql_query($sql_2,$this->link);

			if(mysql_num_rows($res_2)>0)
			{
				$row_2=mysql_fetch_array($res_2);

				$idcodigo = $row_2["id_Codigo"];
				$fechavigencia = $row_2["Fecha_Vigencia"];
				$id_estado= $row_2["id_Estado"];

				if (($idcodigo == 0 || $idcodigo =="") && $paso)
				{
					$paso = false;
					$mensaje = "Lo sentimos, el codigo no se encuentra vigente.";
					$arreglo = array('mensaje'=>$mensaje ,'idmensaje'=>'-1');
				}

				if ($id_estado == 3 && $paso)
				{
					$paso = false;
					$mensaje = "Lo sentimos, el codigo  ya se encuentra utilizado.";
					$arreglo = array('mensaje'=>$mensaje ,'idmensaje'=>'-3');
				}

			}
			else
			{
				$paso = false;
				$mensaje = "Lo sentimos, el codigo ingresado no ha sido encontrado o no es valido, intente nuevamente.";
				$arreglo = array('mensaje'=>$mensaje ,'idmensaje'=>'-4');
			}

			/*Actualizo el Codigo a Estado Usado*/

			if($paso)
			{
				$sql_3="UPDATE 
							codigo 
						SET 
						    id_Estado = 3 ,Fecha_Uso = NOW()
						WHERE
						    Codigo = ".$this->codigo.";";
				//echo $sql_3;

				if (mysql_query($sql_3,$this->link))
				{
					$arreglo = array('mensaje'=>'El codigo se utilizo correctamente.','idmensaje'=>'0');
				}
			}

			return $arreglo;
		}

		function tipo_mensaje()
		{
			$paso=true;
			

			if(($this->idconvenio == "")&& $paso)
			{
				$paso = false;
				$mensaje = "Lo sentimos, los datos ingresados no han sido encontrados o no son validos, intente nuevamente.";
				$arreglo = array('mensaje'=>$mensaje ,'idmensaje'=>'-3');
			}

			/*Obtener campaña vigente asociada al idconvenio*/

			$sql="	SELECT 
					    *
					FROM
					    mensaje 
					WHERE
					    id_Convenio = ".$this->idconvenio."
					ORDER BY id_mensaje DESC
					LIMIT 1;";
			 //echo $sql;



			if($res=mysql_query($sql,$this->link)){

				while($row = mysql_fetch_assoc($res))
				{
					$arreglo[]=$row;
				}					

			}
			//echo mysql_num_rows($res);
		return $arreglo;
		}

		function valida_stock(){

			$paso=true;

			/*trae stock critico*/
			$sql="	SELECT 
						id_Campana,
					    stock_Critico
					FROM
					    campana
					WHERE
					    id_Convenio = ".$this->idconvenio."
					ORDER BY id_Campana DESC
					LIMIT 1;";

			 //echo $sql;


			if($res=mysql_query($sql,$this->link)){

				while($row = mysql_fetch_assoc($res))
				{
					
					$this->stock_critico = $row["stock_Critico"];
					$id_Campana = $row["id_Campana"];

				}					

			}
			/*fin trae stock critico*/

			/*trae stock actual*/
			$sql="	SELECT COUNT( id_Codigo ) as stock_Actual
					FROM  `codigo` 
					WHERE id_Estado =2
					AND id_Campana =".$id_Campana;

			// echo $sql;


			if($res=mysql_query($sql,$this->link)){

				while($row = mysql_fetch_assoc($res))
				{
					
					$this->stock_actual= $row["stock_Actual"];

				}					

			}

			if ($this->stock_actual == $this->stock_critico){

				return 1;


			}else{

				return 0;

			}

			


			/*fin trae stock actual*/


		
		}
		function uso_convenio(){

			$paso=true;
			$arreglo = array();

			if(($this->idconvenio == "")&& $paso)
			{
				$paso = false;
				$mensaje = "Lo sentimos, los datos ingresados no han sido encontrados o no son validos, intente nuevamente.";
				$arreglo = array('mensaje'=>$mensaje ,'idmensaje'=>'-3');
			}

			/*Obtener campaña vigente asociada al idconvenio*/

			$sql="	INSERT INTO uso_convenio(id_convenio,nombre_convenio,tipo_codigo,codigo_emitido,comentario) VALUES('".$this->idconvenio."','".$this->nombreconvenio."','".$this->tipocodigo."','".$this->codigoemitido."','".$this->comentario."');";
			//echo $sql;



			if($res=mysql_query($sql,$this->link)){

				/*while($row = mysql_fetch_assoc($res))
				{
					$arreglo[]=$row;
				}	*/
				$mensaje = "Se inserto registro correctamente.";
				$arreglo = array('mensaje'=>$mensaje ,'idmensaje'=>'1');				

			}
			//echo mysql_num_rows($res);
		return $arreglo;


		}


	}
?>