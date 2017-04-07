<?php
require('materia.php');
$request    =   json_decode(file_get_contents("php://input"));

$serial		=	$request->serial;
$nombre		=	$request->nombre;
$uc			=	$request->uc;

$bd			= 	new materia();
$result		=	$bd->addMateria($serial,$nombre,$uc);
return json_encode(printf($request->serial));
$bd->close();

?>