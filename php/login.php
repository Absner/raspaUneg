<?php
require('conexion2.php');
$request    =   json_decode(file_get_contents("php://input"));

$bd	= new conexion2();
$email	=	$request->email;
$pass	=	$request->password;

$select	=	$bd->prepare("SELECT
				docente.cedula,
				docente.nombre,
				docente.apellido,
				seguridad.clave,
				docente.correo
				FROM
				docente
				INNER JOIN seguridad ON seguridad.docente_cedula = docente.cedula
				where docente.correo = ? AND seguridad.clave=?");

$select->bind_param("ss",$email,$pass);

if ($select->execute()){
	$select->bind_result($cedula,$nombre,$apellido,$clave,$usuario);
	$select->fetch();
	//session_start();
	if ($email == $usuario and $pass == $clave){
		//session_start();
		$_SESSION["nombre"]		=	$nombre;
		$_SESSION["cedula"]		=	$cedula;
		$_SESSION["apellido"]	=	$apellido;
		echo 1;
	}else{
		echo "Verifique el usuario y/o password suministrado";
	}
}

?>