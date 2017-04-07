<?php
include_once ('conexion2.php');

class usuario extends conexion2{
	
	
	public function selectUser($cedula){
		$select	=	parent::prepare("SELECT 
						docente.cedula,
						docente.nombre,
						docente.apellido,
						docente.correo,
						seguridad.clave
					FROM
						docente
							INNER JOIN
						seguridad ON seguridad.docente_cedula = docente.cedula
					WHERE
						docente.cedula = ?");
		
		$select->bind_param("s",$cedula);
		$data	=	array();
		
		if ($select->execute()){
			$select->bind_result($cedula,$nombre,$apellido,$correo,$clave);
			$select->fetch();
			
			$data[]	=	array("cedula"	=>	$cedula,
							  "nombre"	=>	$nombre,
							  "apellido"=>	$apellido,
							  "correo"	=>	$correo,
							  "clave"	=>	$clave
							 );
		}
		return $data;
	}
	
	public function updateUsuario($cedula,$apellido,$nombre,$correo,$clave){
		$updateUsuario	=	parent::prepare("UPDATE docente 
							SET 
								docente.cedula = ?,
								docente.apellido = ?,
								docente.nombre = ?,
								docente.correo = ?
							WHERE
								docente.cedula = ?");
		
		$updateSeguridad	=	parent::prepare("UPDATE seguridad 
								SET 
									seguridad.clave = ?
								WHERE
									seguridad.docente_cedula = ?");
		

		$updateUsuario->bind_param("sssss",$cedula,$apellido,$nombre,$correo,$_SESSION["cedula"]);
		$updateSeguridad->bind_param("ss",$clave,$cedula);
		
		if ($updateUsuario->execute()){
			$_SESSION["cedula"]=$cedula;
			//return "Se han actualizado los datos correctamente.";
			
			if ($updateSeguridad->execute()){
				return "Se han actualizado los datos correctamente.";
			}else{
				return "Ocurrió un problema, fallo en la actualización de la clave.";
			}
			
		}else{
			return "Ocurrió un problema, fallo en la actualización.";
		}
		
	}
	
}

?>