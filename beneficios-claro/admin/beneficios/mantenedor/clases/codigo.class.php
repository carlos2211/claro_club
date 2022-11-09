<?php
	class codigo
	{
		var $idcodigo;
		var $rut;
		var $id_estado;
		var $id_convenio;
		var $id_campana;
		var $fecha_creacion;
		var $fecha_canje;
		var $fecha_uso;
		var $inputValue;

		var $link;

	    function codigo($link)
	    {
			$this->link=$link;
	    }

		function traecodigo()
		{
			$sql="	SELECT 
					    c.id_Codigo,
					    c.Codigo,
					    es.Descripcion AS 'Estado',
					    c.Fecha_Creacion,
					    c.Fecha_Canje,
					    c.Fecha_Uso,
					    c.Fecha_Vigencia
					FROM
					    codigo AS c
					LEFT JOIN
					    estado AS es ON es.id_Estado = c.id_Estado
					WHERE
					    c.id_Campana = '".$this->id_campana."';";


			// echo $sql;
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

		function traecodigo2()
		{
            $rut = "";
			$sql="SELECT * FROM codigo WHERE Rut = '$rut' ORDER BY Fecha_Vigencia DESC LIMIT 5000";
			// echo $sql;
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

        function search_codigos($campaña)
        {
            $res_campaña = "";
            $sql="SELECT id_Campana FROM campana WHERE UPPER(Descripcion) = '$campaña'";
            if($res=mysql_query($sql,$this->link)) {
                while($row = mysql_fetch_assoc($res)) {
                    $res_campaña = $row["id_Campana"];
                }
                $sql="SELECT * FROM codigo WHERE id_Campana = '$res_campaña' AND Rut = '' LIMIT 500";
                if($res_codigos=mysql_query($sql,$this->link)) {
                    return $res_codigos;
                } else {
                    return "error al ejecutar la consulta ".mysql_errno();
                }
            } else {
                return "error al ejecutar la consulta ".mysql_errno();
            }
        }

		function traecodigoXCodigo()
		{
			$sql="	SELECT 
					    c.id_Codigo,
					    c.Codigo,
					    es.Descripcion AS 'Estado',
					    c.Fecha_Creacion,
					    c.Fecha_Canje,
					    c.Fecha_Uso,
					    c.Fecha_Vigencia
					FROM
					    codigo AS c
					LEFT JOIN
					    estado AS es ON es.id_Estado = c.id_Estado
					WHERE
					    c.id_Campana = '".$this->id_campana."';";


			// echo $sql;
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

		function insertarcodigo($cantidad,$id_Campana,$contar,$VigenciaCod)
		{
			$z = $contar + 1;
			$y = $cantidad + $contar;
			for ($i = $z; $i <= $y; $i++)
			{	
				$codigo=str_pad($this->id_convenio,4,"0", STR_PAD_LEFT).str_pad($id_Campana,4,"0", STR_PAD_LEFT).str_pad($i,4,"0", STR_PAD_LEFT);
				$sql="INSERT INTO codigo (id_Estado,id_Convenio,id_Campana,Codigo,Fecha_Canje,Fecha_Uso,Fecha_Vigencia)VALUES(2,'".$this->id_convenio."','".$id_Campana."',".$codigo.",now(),now(),'".$VigenciaCod."');";
				//echo "</br>".$sql."</br>";
				mysql_query($sql,$this->link);
				
			}	
		}

		function cuentacodigo()
		{
			$sql="SELECT count(id_codigo) as contar FROM codigo WHERE id_Campana ='".$this->id_campana."'";
			//echo $sql;
			if($res=mysql_query($sql,$this->link))
			{
				$result  = mysql_fetch_array($res);

    			return (int)$result["contar"];
			}
			else
			{
				// mysql_free_result($res);
				return "error al ejecutar la consulta ".mysql_errno();
			}
		}

		function utilizacodigo()
		{
			$sql="UPDATE codigo SET Rut = '".$this->rut."',id_Estado = '1' WHERE id_Codigo = '".$this->codigo."' ";
			echo $sql;
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
		
	}
?>