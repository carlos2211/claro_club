<?php
class query{

	public $id_categoria;
	public $token;
	public $club;
	

	public function query($link){

			$this->link=$link;
	}

	public function validaCodigo(){

	$arreglo = array();



	switch ($this->token) {

    case "Y2xhcm9iYXRhZmlkZWxpczIwMTY=": // clarobatafidelis2016
    	//$idconvenio = 0001;
    	$token_valido = true;
        break;
    case "Y2xhcm9zYWt1cmFmaWRlbGlzMjAxNg==": //clarosakurafidelis2016
        //$idconvenio = 0002;
        $token_valido = true;
        break;
    default;
        //$idconvenio = 0000;
        $token_valido = false;
        break;
	}
	

	if ($token_valido){ // VALIDA TOKEN 

		if ($this->codigo != ""){ //VALIDA CODIGO DISTINTO A VACIO

			$sql="SELECT * FROM codigo WHERE codigo = '".$this->codigo."' ";

			//echo $sql;

			$res = mysql_query($sql,$this->link);

			$numrow=mysql_num_rows($res);

			if ($numrow >= 1 ){

				while($rs = mysql_fetch_assoc($res))
			    {

			    	if ($rs["id_Estado"] == 3) {

			    		$arreglo = array('codigo'=>'-4','descripcion'=>'El codigo ya se encuentra utilizado.');
			    	
			    	}else{

			    		$arreglo = array('codigo'=>'1','descripcion'=>'El codigo se encuentra disponible.');


			    	}

			    		
			    }

			}else{

				$arreglo = array('codigo'=>'-3','descripcion'=>'Error en Codigo SQL');
			}



		}else{

			$arreglo = array('codigo'=>'-2','descripcion'=>'Error en Codigo');
		}


    }else{

    	$arreglo = array('codigo'=>'-1','descripcion'=>'Error en Token');

    }

   	return $arreglo;

	}
	public function utilizaCodigo(){

	$arreglo = array();
	

	switch ($this->token) {

    case "Y2xhcm9iYXRhZmlkZWxpczIwMTY=": // clarobatafidelis2016
    	//$idconvenio = 0001;
    	$token_valido = true;
        break;
    case "Y2xhcm9zYWt1cmFmaWRlbGlzMjAxNg==": //clarosakurafidelis2016
        //$idconvenio = 0002;
        $token_valido = true;
        break;
    default;
        //$idconvenio = 0000;
        $token_valido = false;
        break;
	}
	

	if ($token_valido){ // VALIDA TOKEN 

		if ($this->codigo != ""){ //VALIDA CODIGO DISTINTO A VACIO

			$sql="SELECT * FROM codigo WHERE codigo = '".$this->codigo."' ";

			//echo $sql;

			$res = mysql_query($sql,$this->link);

			$numrow=mysql_num_rows($res);

			if ($numrow >= 1 ){

				while($rs = mysql_fetch_assoc($res))
			    {

			    	if ($rs["id_Estado"] == 3) {

			    		$arreglo = array('codigo'=>'-4','descripcion'=>'El codigo ya se encuentra utilizado.');
			    	
			    	}else{

			    		
			    		$sql="UPDATE codigo SET id_Estado = 3, comentario = '".$this->comentario."', Fecha_Uso = now() WHERE codigo = '".$this->codigo."' ";

			    		//echo $sql;

			    		if (mysql_query($sql,$this->link)){


			    		$arreglo = array('codigo'=>'1','descripcion'=>'El codigo se actualizo correctamente.');


			    		}else{


			    		$arreglo = array('codigo'=>'-5','descripcion'=>'El codigo no se pudo actualizar correctamente.');


			    		}


			    	}

			    		
			    }

			}else{

				$arreglo = array('codigo'=>'-3','descripcion'=>'Error en Codigo SQL');
			}



		}else{

			$arreglo = array('codigo'=>'-2','descripcion'=>'Error en Codigo');
		}


    }else{

    	$arreglo = array('codigo'=>'-1','descripcion'=>'Error en Token');

    }

   	return $arreglo;

	}			

}
?>