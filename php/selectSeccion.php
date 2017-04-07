<?php
require ('docente.php');

$request    =   json_decode(file_get_contents("php://input"));

$semestre	=	$request->semestre;

$bd		=	new docente();
//$dato	=	array();

$secciones	=	$bd->showSeccionAsig($_SESSION["cedula"],$request->codigoM,$semestre);
//array_push($dato,$secciones);

echo json_encode($secciones);

?>