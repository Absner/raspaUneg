<?php 
include_once ('conexion2.php');

class periodo extends conexion2{
	
	
	public function showPeriodo(){
		$select	=	parent::query("select * from periodo");
		
		$data	=	array();
		
		while ($row	=	$select->fetch_array()){
			$data[]	=	array("codigo"			=>	$row["codigo"],
							  "descripcion"		=>	$row["descripcion"]
							 );
		}
		
		return $data;
	}
	
	
}


?>