<?php
require ('docente.php');
$request    =   json_decode(file_get_contents("php://input")); 

$bd			=	new docente();

$cedulaD	=	$_SESSION["cedula"];
$semestre	=	$request->semestre;

//$materia=	$bd->showMateriasAsig($cedulaD);
echo json_encode($bd->showMateriasAsig($cedulaD,$semestre));

?>