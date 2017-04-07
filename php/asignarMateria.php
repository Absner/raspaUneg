<?php
require('materia.php');
$request    =   json_decode(file_get_contents("php://input"));

$codigoM	=	$request->codMateria;
$codigoS	=	$request->codSeccion;
$semestre	=	$request->semestre;
$cedulaD	=	$_SESSION["cedula"];

$bd			=	new materia();
$result		=	$bd->asignarMateria($cedulaD,$codigoM,$codigoS,$semestre);
echo json_encode($result);

$bd->close();
unset($bd);
?>