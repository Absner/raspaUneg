<?php
require ('cronograma.php');
$request    =   json_decode(file_get_contents("php://input")); 

$bd	=	new cronograma();

$actividad			=	$request->actividad;
$descripcion		=	$request->descripcion;
$fecha				=	$request->fecha;

$docente			=	$_SESSION["cedula"];

echo $bd->addEvento($fecha,$descripcion,$actividad,$docente);

$bd->close();
unset($bd);





?>