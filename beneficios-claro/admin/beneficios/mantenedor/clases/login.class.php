<?php
	class login
	{

		var $id;
		var $nombre;
		var $clave;
		var $status;

		var $link;

		function login($link){

			$this->link = $link;
		}

		function load(){

			$sql ="	SELECT 
						id,
						nombre,
						clave,
						status 
					FROM login 
					WHERE 
						nombre = '".$this->nombre."' 
						and clave='".$this->clave."' 
						and status = 1";

			//echo $sql;

			if($res=mysql_query($sql,$this->link))
			{	
				$numrow = mysql_num_rows($res);

				if($numrow  > 0)
				{ 
					$rs=mysql_fetch_assoc($res);


					return $rs["id"];
				}
				else
				{

				return 0;
				}	


			}
			else
			{
				// mysql_free_result($res);
				return -1;
			}

					
				
							

		}


	}
	
?>