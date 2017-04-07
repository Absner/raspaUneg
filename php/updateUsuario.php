<?php
require ('usuario.php');
$request    =   json_decode(file_get_contents("php://input"));

$cedula		=	$request->cedula;
$apellido	=	$request->apellido;
$nombre		=	$request->nombre;
$correo		=	$request->correo;
$clave		=	$request->clave;

$bd	=	new usuario();

echo $bd->updateUsuario($cedula,$apellido,$nombre,$correo,$clave);

?>