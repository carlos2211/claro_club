<?php
class convenio
{

	var $id;
	var $marca;
	var $importante;
	var $url;
	var $status;
	var $detalle;
	var $ciudad;
	var $idcat;
	var $vigencia;
	var $stringClubes;
	var $stringClubesVig;
	var $orden_home;
	var $idclietne;
	
	var $link;
	
	function convenio($link)
	{
		$this->link=$link;
	}
	
	function load()
	{
		$sql="select * from convenio where id='".$this->id."'";
		//echo $sql;
		$res=mysql_query($sql,$this->link);
		if($row=mysql_fetch_array($res))
		{
			$this->marca=$row["marca"];
			$this->importante=$row["importante"];
			$this->url=$row["url"];
			$this->status=$row["status"];
			$this->detalle=$row["detalle"];
			$this->ciudad=$row["ciudad"];
			$this->idcat=$row["idcat"];
		}
		else
		{
			$this->marca="";
			$this->importante="";
			$this->url="";
			$this->status="";
			$this->detalle="";
			$this->ciudad="";
			$this->idcat="";
		}
	}
	
	function loadClubes()
	{
		$sql="select nombre, descuento, cl.status, cl.vigencia
		FROM  cliente_convenio cl
		INNER JOIN cliente cli ON cl.idcliente = cli.id
		WHERE cl.idconvenio ='".$this->id."' ORDER BY nombre";
		//echo $sql;

		
		$res=mysql_query($sql,$this->link);
		while($row=mysql_fetch_array($res))
		{
			if($row["status"] == "0")
			{
				$status = "A";
			}else
			{
				$status = "I";
			}
			$str = $str.$row["nombre"]."-".$row["descuento"]."-".$status."<br>";
			
			$str1 = $str1.$row["nombre"]."-<strong>".$row["vigencia"]."</strong><br>";
		}
			$this->stringClubes = $str;
			$this->stringClubesVig = $str1;
	}
	
	function update()
	{
		$sql="update convenio set marca='".$this->marca."',importante='".$this->importante."',url='".$this->url."',status='".$this->status."',detalle='".$this->detalle."',ciudad='".$this->ciudad."', idcat='".$this->idcat."'";
		$sql.="where id='".$this->id."'";
		
		if(mysql_query($sql,$this->link))
		{
			return 'ACTUALIZACION CORRECTA';
		}
		else
		{
			return 'ERROR.NO ACTUALIZADA';
		}
	}	

	function update_orden($id, $orden)
	{
		$sql="update convenio set orden_home='".$orden."' ";
		$sql.="where id='".$id."'";
		
		if(mysql_query($sql))
		{
		    return 'ACTUALIZACION CORRECTA';
		}
		else
		{
			return 'ERROR.NO ACTUALIZADA';
		}
	}	

	function listado()
	{
		$sql="select * from convenio where status='0' order by id";
		$res=mysql_query($sql,$this->link);
		$aux="";
		while($row=mysql_fetch_array($res))
		{
			$aux.=",".$row["id"];
		}
		return substr($aux,1);
	}
	/*function listado_p($x){
		$sql="select a.* from album as a,permiso as b where a.status='0' and a.id=b.idtipo and ";
		$sql.=" b.tipo='g' and b.iddepto='$x' order by a.posicion";
		//echo $sql;
		$res=mysql_query($sql,$this->link);
		$aux="";
		while($row=mysql_fetch_array($res)){
			$aux.=",".$row["id"];
		}
		return substr($aux,1);
	}*/

	function listado_total()
	{
		$sql="select * from convenio order by id";
		$res=mysql_query($sql,$this->link);
		$aux="";
		while($row=mysql_fetch_array($res))
		{
			$aux.=",".$row["id"];
		}
		return substr($aux,1);
	}

	function insert($nombreConvenio,$breveDes,$promocion,$descuento,$url,$detalle,$legal,$vigenciaDesde,$vigenciaHasta,$sucursal,$categoria,$name,$tmp_name,$name2,$tmp_name2,$regiones,$cat_name,$alerta,$oferta,$modousono,$latitud,$longitud,$nombre_sucursal,$sin_titulo)
	{
		$cat_name="orden_cat_".$cat_name;
	    $status = 0;
		$sql="insert into convenio (marca,importante,url,status,detalle,ciudad,idcat,fecha_contrato,regiones,orden_home,".$cat_name.",alerta,oferta,modouso,sin_titulo) values ('".$nombreConvenio."','".$legal."','".$url."','".$status."','".$detalle."','".$sucursal."','".$categoria."','".$vigenciaDesde."','".$regiones."',1,1,'".$alerta."','".$oferta."','".$modousono."','".$sin_titulo."')";
		
		if(mysql_query($sql,$this->link))
		{
            $idconvenio =  mysql_insert_id();
            $idcliente = 35;
            $idmenu = 0;
            $idsubcategoria = 0;
            $destacado = 0;
            $descripcionadi = "";
            $mecanica = "";
            $emitecodigo = 0;

            foreach ($nombre_sucursal as $key => $value) {
		        $sql="INSERT INTO sucursales (id_convenio,nombre,latitud,longitud) VALUES('".$idconvenio."','".$value."','".$latitud[$key]."','".$longitud[$key]."')";
		        mysql_query($sql,$this->link);

		    }


            $sql="insert into cliente_convenio (idconvenio,idcliente,idmenu,idsubcat,descuento,vigencia,destacado,status,descripcionadi,mecanica,emite_codigo,tagline,mensaje) values ('".$idconvenio."','".$idcliente."','".$idmenu."','".$idsubcategoria."','".$descuento."','".$vigenciaHasta."','".$destacado."','".$status."','".$descripcionadi."','".$mecanica."','".$emitecodigo."','".$breveDes."','".$promocion."')";
            mysql_query($sql,$this->link);
            $idcomuna = 0;
            $idprovincia = 0;
            $idregion = 0;
            $telefono = "";
            $cordx = "";
            $cordy = "";
            $sql="insert into convenio_direccion (idconvenio,direccion,idcomuna,idprovincia,idregion,telefono,cordx,cordy,status,direccion_mapa) values ('".$idconvenio."','".$sucursal."','".$idcomuna."','".$idprovincia."','".$idregion."','".$telefono."','".$cordx."','".$cordy."','".$status."','".$sucursal."')";
            mysql_query($sql,$this->link);
            $sql="select max(idarchivo) from imagen_convenio";
            $res=mysql_query($sql,$this->link);
            while($row=mysql_fetch_array($res))
            {
                $idarchivo = $row["max(idarchivo)"] + 1;
            }
            $idtipo_img = 0;
            $fecha = date('dmY');
            $name = $idconvenio.$fecha.$name;
            $sql="insert into imagen_convenio (idarchivo,status,idtipo_img,idconvenio,name_imagen,detalle) values ('".$idarchivo."','".$status."','".$idtipo_img."','".$idconvenio."','".$name."',0)";
            mysql_query($sql,$this->link);
            $nuevo_path="upload/".$name;
            move_uploaded_file($tmp_name,$nuevo_path);
            $idarchivo++;
            $name2 = $idconvenio.$fecha.$name2;
            $sql="insert into imagen_convenio (idarchivo,status,idtipo_img,idconvenio,name_imagen,detalle) values ('".$idarchivo."','".$status."','".$idtipo_img."','".$idconvenio."','".$name2."',1)";
            mysql_query($sql,$this->link);
            $nuevo_path="upload/".$name2;
            move_uploaded_file($tmp_name2,$nuevo_path);
            return $idconvenio;
		}
		else
		{
			return $sql;
		}
	}

    function update_convenio($nombreConvenio,$breveDes,$descuento,$url,$detalle,$legal,$vigenciaDesde,$vigenciaHasta,$sucursal,$categoria,$name,$tmp_name,$img_BD,$name2,$tmp_name2,$img_BD2,$id_conv,$regiones,$alerta,$oferta,$modouso,$latitud,$longitud,$nombre_sucursal,$sin_titulo)
    {
        $sql="update convenio set marca='".$nombreConvenio."',url='".$url."',detalle='".$detalle."',importante='".$legal."',fecha_contrato='".$vigenciaDesde."',ciudad='".$sucursal."', idcat='".$categoria."', regiones='".$regiones."', alerta='".$alerta."', oferta='".$oferta."', modouso='".$modouso."', sin_titulo='".$sin_titulo."'";
        $sql.="where id='".$id_conv."'";
        mysql_query($sql,$this->link);

        $sql= "DELETE FROM sucursales WHERE id_convenio=$id_conv";
        mysql_query($sql,$this->link);
        foreach ($nombre_sucursal as $key => $value) {
		    $sql="INSERT INTO sucursales (id_convenio,nombre,latitud,longitud) VALUES('".$id_conv."','".$value."','".$latitud[$key]."','".$longitud[$key]."')";
		    mysql_query($sql,$this->link);

		}

        $sql2="update cliente_convenio set tagline='".$breveDes."',descuento='".$descuento."',vigencia='".$vigenciaHasta."'";
        $sql2.="where idconvenio='".$id_conv."'";
        mysql_query($sql2,$this->link);

        $sql_img = "SELECT id FROM imagen_convenio WHERE name_imagen = '$img_BD' and detalle=0";
        $result=mysql_query($sql_img,$this->link);
        $id_img = mysql_fetch_assoc($result);
        if($name == '' && $tmp_name == ''){
            $sql3="update imagen_convenio set name_imagen='".$img_BD."'";
            $sql3.="where idconvenio='".$id_img."' and detalle=0";
            mysql_query($sql3,$this->link);
        }else{
            $name_img = $id_conv.$name;
            $sql3="update imagen_convenio set name_imagen='".$name_img."'";
            $sql3.="where id = '".$id_img['id']."' and detalle=0";
            $nuevo_path="upload/".$name_img;
            move_uploaded_file($tmp_name,$nuevo_path);
            mysql_query($sql3,$this->link);
        }

        $sql_img = "SELECT id FROM imagen_convenio WHERE name_imagen = '$img_BD2' and detalle=1";
        $result=mysql_query($sql_img,$this->link);
        $id_img = mysql_fetch_assoc($result);
        if(!$id_img){
        	if($name2!=""){
                $fecha = date('dmY');
        		$name2 = $id_conv.$fecha.$name2;
	        	$nuevo_path="upload/".$name2;
	        	$sql="select max(idarchivo) from imagen_convenio";
	            $res=mysql_query($sql,$this->link);
	            while($row=mysql_fetch_array($res))
            {
                $idarchivo = $row["max(idarchivo)"] + 1;
            }
            $idtipo_img = 0;
            
            $sql="insert into imagen_convenio (idarchivo,status,idtipo_img,idconvenio,name_imagen,detalle) values ('".$idarchivo."','".$status."','".$idtipo_img."','".$id_conv."','".$name2."',1)";
            mysql_query($sql,$this->link);
            move_uploaded_file($tmp_name2,$nuevo_path);
        	}
        	
        }
        else{
	        if($name2 == '' && $tmp_name2 == ''){
	            $sql3="update imagen_convenio set name_imagen='".$img_BD2."'";
	            $sql3.="where idconvenio='".$id_img."' and detalle=1";
	            mysql_query($sql3,$this->link);
	        }else{
                $fecha = date('dmY');
	            $name_img = $id_conv.$fecha.$name2;
	            $sql3="update imagen_convenio set name_imagen='".$name_img."'";
	            $sql3.="where id = '".$id_img['id']."' and detalle=1";
	            $nuevo_path="upload/".$name_img;
	            move_uploaded_file($tmp_name2,$nuevo_path);
	            mysql_query($sql3,$this->link);
	        }
	    }
    }

	function select($name="idmarca")
	{
		$sql="select * from marca where status=0";
		//echo $sql;
		$res=mysql_query($sql,$this->link);
		$aux=chr(13)." <select name='$name' id='$name'>";
		$aux.="<option value='0'>Selecciona una Opcion</option>".chr(13);
		while($row=mysql_fetch_array($res))
		{
			if($this->id==$row["id"])
				$txt=" selected";
			else
				$txt="";
			$aux.="<option value='".$row["id"]."'$txt>".$row["nombre"]."</option>".chr(13);
		}
			$aux.="</select>".chr(13);
			return $aux;
	}

	function delete()
	{
		$aux="";
		$sql="delete from convenio where id='".$this->id."'";
		if(mysql_query($sql,$this->link)) 
			$aux.="ELIMINACION CORRECTA<br>";
		else
			$aux.="ERROR.ELIMINACION FALLIDA<br>";	
		return $aux;
	}

	/*function aleatorio($x){
		$sql="SELECT * FROM album ORDER BY RAND();";
		$sql="select a.* from album as a,permiso as b where a.status='0' and a.id=b.idtipo and ";
		$sql.=" b.tipo='g' and b.iddepto='$x' order BY RAND();";
		$res=mysql_query($sql,$this->link);
		if($row=mysql_fetch_array($res)) 
			$aux=$row["id"];
		else
			$aux=0;
		return $aux;
	}*/

	function select_cat()
	{
		$sql="select * from cat3 where estado=0";
		//echo $sql;
		$res=mysql_query($sql,$this->link);
		$aux=chr(13)." <select name='cat3' id='cat3'>";
		$aux.="<option value='0'>Selecciona una Opcion</option>".chr(13);
		while($row=mysql_fetch_array($res))
		{
			if($this->idcat==$row["id"])
				$txt=" selected";
			else
				$txt="";
			    $aux.="<option value='".$row["id"]."'$txt>".$row["nombre"]."</option>".chr(13);
		}
			$aux.="</select>".chr(13);
			return $aux;
	}

	function cargarConvenios()
	{

		$sql="SELECT 	idconvenio as id ,
						marca as nombre_convenio,
						descuento as descuento,
						vigencia as vigencia,
						case 
								when constatus = 0 then 'Habilitado' 
								else 'Deshabilitado' end  as estado_convenio,
						case 
								when cliconstatus = 0  then 'Publicado' 
								else 'No Publicado' end as publicacion
			  FROM VIS_datos_convenio 
		      WHERE idcliente = '".$this->idcliente."'
		      GROUP BY idconvenio;";
		//echo $sql;
		if($res=mysql_query($sql,$this->link))
		{
			return $res;
		}
		else
		{
			// mysql_free_result($res);
			return "error al ejecutar la consulta ".mysql_errno();
		}
	}

	function cargaDatosConvenio()
		{
			$sql="select idconvenio,marca,vigencia from VIS_datos_convenio where idcliente=".$this->idcliente." and idconvenio = ".$this->id.";";

			//echo $sql;
			$res=mysql_query($sql,$this->link);
			if($row=mysql_fetch_array($res))
			{
				$this->idconvenio 	= $row["idconvenio"];
				$this->marca 	    = $row["marca"];
				$this->vigencia     = $row["vigencia"];
			}
			else
			{
				$this->idconvenio = "";
				$this->marca 	  = "";
				$this->vigencia   = "";
			}
		}
}
?>