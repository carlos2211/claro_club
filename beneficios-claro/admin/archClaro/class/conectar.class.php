<?php

	class MySQL{


		public  $conexion; 
		private $total_consultas;
		private $pass;


		public function MySQL(){ 

			

   
		    if(!isset($this->conexion)){
		   
			  //$this->conexion = (mysql_connect("127.0.0.1","admin","26303238")) or die(mysql_error());
		      $this->conexion = (mysql_connect("localhost","mediacon_cluser","e68c58fed5")) or die(mysql_error());
		      mysql_select_db("claro_club",$this->conexion) or die(mysql_error());
		    }
		  }

		    public function consulta($consulta){

		    $this->total_consultas++; 
		    $resultado = mysql_query($consulta,$this->conexion);
		    
			    if(!$resultado){ 
			      echo 'MySQL Error: ' . mysql_error();
			      exit;
			    }
		    return $resultado;
		  	}

			 public function fetch_array($consulta){
			   return mysql_fetch_array($consulta);
			  }

			  public function num_rows($consulta){
			   return mysql_num_rows($consulta);
			  }

			  public function getTotalConsultas(){
			   return $this->total_consultas; 
			  }
			  
			  public function cerrarConexion(){
				 mysql_close($this->conexion); 
			  }
			  
			  public function affected_rows(){
			  	return mysql_affected_rows(); 
			  } 
			  
			 public function error(){
			 	return	mysql_errno();	
			 }

			  public function fetch_assoc($consulta){
			   return mysql_fetch_array($consulta);
			  }
			 
			 public function fetch_assoc_lis($consulta){
			 	$arreglo = array();
			 	while ($rx = mysql_fetch_assoc($consulta))
			 	{
			 		$arreglo[] = $rx;
			 	}
			   	return $arreglo; 
			  }

			  public function fetch_array_lis($consulta){
			   $arreglo = array();
			   while ($rx = mysql_fetch_array($consulta)){
			   		$arreglo[] = $rx;

			   }
			   return $arreglo;
			   
			  }
  

	}


?>

