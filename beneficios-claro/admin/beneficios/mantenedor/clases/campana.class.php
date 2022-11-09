<?php
	class campana
	{
		var $id;
		var $idconvenio;
		var $descripcion;
		var $estado;
		var $VigenciaCampana;
		var $stockCT;
		
		var $link;

	    function campana($link)
	    {
			$this->link=$link;
	    }

		function traeCampana()
		{
			$sql="	SELECT 
					    c.id_Campana,
					    c.Descripcion AS NombreCampana,
					    c.id_Convenio,
					    es.Descripcion,
					    c.Fecha_Vigencia,
					    c.Stock_Critico
					FROM
					    campana AS c
					        LEFT JOIN
					    estado AS es ON es.id_Estado = c.id_Estado
					WHERE
					    id_Convenio = '".$this->idconvenio."';";

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

		function insertarCampana()
		{
			$sql="INSERT INTO campana(Descripcion,id_Estado,id_Convenio,Fecha_Vigencia,Stock_Critico)VALUES('".$this->descripcion."','4','".$this->idconvenio."','".$this->VigenciaCampana."','".$this->stockCT."')";
            mysql_query($sql,$this->link);
			/*if(mysql_query($sql,$this->link))
			{
				echo "<script>alert('Se ha creado correctamente la Campaña')</script>";
			}
			else
			{
				echo "<script>prompt('Hubo un error al crear la Campaña','$sql')</script>";
			}*/
		}

		function traeDatosCampana()
		{
			$sql="SELECT * FROM campana WHERE id_Campana = '".$this->id."' ;";

			// echo $sql;
			$res=mysql_query($sql,$this->link);
			if($row=mysql_fetch_array($res))
			{
				$this->descripcion 	= $row["Descripcion"];
				$this->estado 	    = $row["id_Estado"];
				$this->stockCT 	    = $row["Stock_Critico"];
			}
			else
			{
				$this->descripcion  = "";
				$this->estado 	    = "";
				$this->stockCT 	    = "";
			}
		}
		
	}
?>