<?php
	class control{

		public $club;
		public $id_categoria;
		public $id_producto;
		public $buscar;
		public $orden;
		public $id_convenio;
		public $padre;
		public $id_region;

		public $rut;
		public $nombre;
		public $apellido;
		public $email;
		public $fono;
		public $mensaje;


		public function descuentos_categorias(){
			
			$db = new MySQL();
				


					$consulta ="SELECT * FROM categoria_convenio  WHERE idcliente  = '".$this->club."' and padre = 0 and status = 0 ORDER BY posicion ASC";
					//echo $consulta;
				
					$sql=$db->consulta($consulta);
				
					$numRow=$db->num_rows($sql);

					
				
					if($numRow > 0)
					{ 
						$rs=$db->fetch_assoc_lis($sql);
						return $rs;
					}
					else
					{

					return false;
					}
		}

		public function descuentos_lista(){
			
			$db = new MySQL();
				


					$consulta ="SELECT 
									c.id as 'id',
									c.marca as 'nombre',
									ic.idarchivo as 'idarchivo_imagen',
									c.detalle as 'descripcion', 
									scc.nombre as 'clasificacion',
									cc.descuento as 'descuento'
								FROM
								    categoria_clienteconvenio ccc
								LEFT JOIN cliente_convenio cc ON ccc.idcliente_convenio = cc.id
								LEFT JOIN convenio c ON c.id = cc.idconvenio
								LEFT JOIN imagen_convenio ic ON ic.idconvenio = cc.idconvenio 
								LEFT JOIN subcat_convenio scc ON scc.id = cc.idsubcat
								WHERE 
									idcate_con in ('".$this->id_categoria."')
									and ic.idtipo_img = 1
									and c.status = 0
									and cc.status = 0 
									";
					//echo $consulta;
				
					$sql=$db->consulta($consulta);
				
					$numRow=$db->num_rows($sql);

					
				
					if($numRow > 0)
					{ 
						$rs=$db->fetch_assoc_lis($sql);
						return $rs;
					}
					else
					{

					return false;
					}
		}
		public function descuento_detalle(){
			
			$db = new MySQL();
				


					$consulta ="SELECT
										c.marca				as 'nombre',
										c.url				as 'url',
										c.facebook				as 'facebook',
										c.twiter				as 'twiter',
										c.youtube				as 'youtube',
										cc.mecanica 		as 'mecanica',
										cc.descuento 		as 'descuento',
										c.detalle			as 'detalle',
										cc.descripcionadi	as 'detalle_adi',
										cc.vigencia			as 'vigencia',
										c.importante 		as 'importante',
										cc.emite_codigo		as 'emite_codigo',
										cc.mensaje 			as 'mensaje'
										
								FROM 
									convenio c
								LEFT JOIN cliente_convenio cc ON c.id = cc.idconvenio
								WHERE 	
										c.id = '".$this->id_convenio."'
										and c.status = 0
										and cc.status = 0 
										and cc.idcliente = 35";
					//echo $consulta;
				
					$sql=$db->consulta($consulta);

					$numRow=$db->num_rows($sql);

					if($numRow > 0)
					{ 
						$rs=$db->fetch_assoc_lis($sql);

						$array_limpio= array(	'nombre'=>utf8_encode($rs[0]["nombre"]),
												'url'=>$rs[0]["url"],
												'facebook'=>$rs[0]["facebook"],
												'twiter'=>$rs[0]["twiter"],
												'youtube'=>$rs[0]["youtube"],
												'mecanica'=>utf8_encode($rs[0]["mecanica"]),
												//'detalle'=>$rs[0]["descuento"]." ".lcfirst(utf8_encode($rs[0]["detalle"])),
												'detalle'=>utf8_encode(str_replace("</p>","",str_replace("<p>","",$rs[0]["detalle"]))),
												'detalle_adi'=>utf8_encode($rs[0]["detalle_adi"]),
												'vigencia'=>$rs[0]["vigencia"],
												'importante'=>utf8_encode($rs[0]["importante"]),
												'emite_codigo'=>$rs[0]["emite_codigo"],
												'mensaje_convenio'=>utf8_encode($rs[0]["mensaje"]),
												'mensaje'=>'correcto'
							);

						return $array_limpio;
					}
					else
					{
						$array_limpio= array('mensaje'=>'error id');

					return $array_limpio;
					}
		}
		public function descuentos_direcciones(){
			
			$db = new MySQL();
				


					$consulta ="SELECT
									c.nombre as 'comuna',
									d.direccion as 'direccion',
									d.telefono as 'telefono'
								FROM
								    convenio_direccion d
								LEFT JOIN comuna c ON d.idcomuna = c.id 

								WHERE
								    idconvenio = '".$this->id_convenio."'";
					//echo $consulta;
				
					$sql=$db->consulta($consulta);

					$numRow=$db->num_rows($sql);

					if($numRow > 0)
					{ 
						$rs=$db->fetch_assoc_lis($sql);

						return $rs;
					}
					else
					{
						$array_limpio= array('mensaje'=>'error id');

					return false;
					}
		}
		public function descuentos_url(){
			
			$db = new MySQL();
				


					$consulta ="SELECT 
									c.id as 'id',
									c.marca as 'nombre',
									CONCAT('http://servicios.fidelis.cl/mc/adm/modsis/img_blob.php?id=',ic.idarchivo) as 'src_imagen',
									REPLACE(REPLACE(c.detalle,'<p>',''),'</p>','') as 'detalle', 
									catc.class as 'clasificacion',
									cc.descuento as 'descuento',
									CONCAT('http://www.beneficiosclarofidelis.cl/Beneficios/descuento_detalle.php?id=',c.id) as 'url',
									cc.mecanica as 'mecanica',
									'1' as 'codigo',
									'informacion desplegada correctamente.' as descripcion						
								FROM
								    categoria_clienteconvenio ccc
								LEFT JOIN cliente_convenio cc ON ccc.idcliente_convenio = cc.id
								LEFT JOIN convenio c ON c.id = cc.idconvenio
								LEFT JOIN imagen_convenio ic ON ic.idconvenio = cc.idconvenio 
								LEFT JOIN subcat_convenio scc ON scc.id = cc.idsubcat
								LEFT JOIN categoria_convenio catc ON ccc.idcate_con = catc.id
								WHERE 
									 c.status = 0
									and cc.status = 0 
									and cc.idcliente = 35
								GROUP BY c.id";
					//echo $consulta;
				
					$sql=$db->consulta($consulta);
				
					$numRow=$db->num_rows($sql);

					
				
					if($numRow > 0)
					{ 
						$rs=$db->fetch_assoc_lis($sql);
						return $rs;
					}
					else
					{

					return false;
					}
		}
		public function descuentos_mantenedor(){
			
			$db = new MySQL();
				


			$consulta ="SELECT idconvenio AS id, VIS_datos_convenio.marca AS nombre_convenio, orden_home, descuento AS descuento, vigencia AS vigencia, 
					CASE 
					WHEN constatus =0
					THEN  'Habilitado'
					ELSE  'Deshabilitado'
					END AS estado_convenio, 
					CASE 
					WHEN cliconstatus =0
					THEN  'Publicado'
					ELSE  'No Publicado'
					END AS publicacion
				FROM VIS_datos_convenio, convenio
				WHERE idcliente ='".$this->club."' AND VIS_datos_convenio.idconvenio = convenio.id
				GROUP BY idconvenio ORDER BY orden_home ASC; ";
					//echo $consulta;
				
					$sql=$db->consulta($consulta);
				
					$numRow=$db->num_rows($sql);

					
				
					if($numRow > 0)
					{ 
						$rs=$db->fetch_assoc_lis($sql);
						return $rs;
					}
					else
					{

					return false;
					}
		}

				public function descuento_detalle_mantenedor(){
					
					$db = new MySQL();
					$consulta ="SELECT
						c.marca				as 'nombre',
						c.url				as 'url',
						c.facebook			as 'facebook',
						c.twiter			as 'twiter',
						c.youtube			as 'youtube',
						cc.mecanica 		as 'mecanica',
						cc.descuento 		as 'descuento',
						c.detalle			as 'detalle',
						c.oferta			as 'oferta',
						c.alerta			as 'alerta',
						c.modouso			as 'modouso',
						c.sin_titulo		as 'sin_titulo',
						cc.descripcionadi	as 'detalle_adi',
						cc.vigencia			as 'vigencia',
						c.importante 		as 'importante',
						cc.emite_codigo		as 'emite_codigo',
						ic.name_imagen 		as 'imagen'									
					FROM 
						convenio c
							LEFT JOIN cliente_convenio cc ON c.id = cc.idconvenio
							LEFT JOIN imagen_convenio ic ON c.id = ic.idconvenio
					WHERE 	
						c.id = '".$this->id_convenio."'
						and cc.idcliente = 35 
						and ic.detalle=0";
							//echo $consulta;
						
					$sql=$db->consulta($consulta);

					$numRow=$db->num_rows($sql);

					if($numRow > 0){ 
						$rs=$db->fetch_assoc_lis($sql);

						$array_limpio= array(
							'nombre'=>utf8_encode($rs[0]["nombre"]),
							'url'=>$rs[0]["url"],
							'facebook'=>$rs[0]["facebook"],
							'twiter'=>$rs[0]["twiter"],
							'youtube'=>$rs[0]["youtube"],
							'mecanica'=>utf8_encode($rs[0]["mecanica"]),
                            'descuento'=>$rs[0]["descuento"],
							'detalle'=>utf8_encode($rs[0]["detalle"]),
							'detalle_adi'=>utf8_encode($rs[0]["detalle_adi"]),
							'vigencia'=>$rs[0]["vigencia"],
							'importante'=>utf8_encode($rs[0]["importante"]),
							'emite_codigo'=>$rs[0]["emite_codigo"],
							'imagen'=>$rs[0]["imagen"],
							'oferta'=>utf8_encode($rs[0]["oferta"]),
							'alerta'=>utf8_encode($rs[0]["alerta"]),
							'modouso'=>utf8_encode($rs[0]["modouso"]),
							'sin_titulo'=>utf8_encode($rs[0]["sin_titulo"]),
							'mensaje'=>'correcto'
						);
						$db = new MySQL();
						$consulta ="SELECT * FROM sucursales WHERE 	id_convenio=".$this->id_convenio;
							
							
						$sql=$db->consulta($consulta);

						$numRow=$db->num_rows($sql);
						if($numRow > 0){ 
							while ($rs =mysql_fetch_assoc($sql)) { 
							//$rs=$db->fetch_assoc_lis($sql);

								$array_limpio['sucursales'][]= array(
									'nombre'=>utf8_encode($rs["nombre"]),
									'latitud'=>$rs["latitud"],
									'longitud'=>$rs["longitud"],
									'mensaje'=>'correcto'
								);
							}

						
						}
						$db = new MySQL();
					
						$consulta ="SELECT name_imagen FROM imagen_convenio WHERE idconvenio=".$this->id_convenio." and detalle=1";
						$sql=$db->consulta($consulta);
						$numRow=$db->num_rows($sql);

						if($numRow > 0){ 

							$rs=$db->fetch_assoc_lis($sql);
							$array_limpio['imagen2']=$rs[0]["name_imagen"];
						}
						

						return $array_limpio;
					}
					else{
						$array_limpio= array('mensaje'=>'error id');

						return $array_limpio;
					}
				}


				

				
		public function sucursales_convenio(){
					
					$db = new MySQL();
					$consulta ="SELECT * FROM sucursales WHERE 	id_convenio=".$this->id_convenio;
						
						
					$sql=$db->consulta($consulta);

					$numRow=$db->num_rows($sql);
					$array_limpio= array();
					if($numRow > 0){ 
						while ($rs =mysql_fetch_assoc($sql)) { 
						//$rs=$db->fetch_assoc_lis($sql);

							$array_limpio[]= array(
								'nombre'=>utf8_encode($rs["nombre"]),
								'latitud'=>$rs["latitud"],
								'longitud'=>$rs["longitud"],
								'mensaje'=>'correcto'
							);
						}

						return $array_limpio;
					}
					else{
						$array_limpio= array('mensaje'=>'error id');

						return $array_limpio;
					}
				}													
	}			

?>