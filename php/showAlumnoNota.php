<?php
require ('examenNota.php');
$request    =   json_decode(file_get_contents("php://input")); 

$semestre	=	$request->semestre;
$materia	=	$request->materia;
$seccion	=	$request->seccion;
$codExa		=	$request->fechaE;
$cedulaD	=	$_SESSION["cedula"];

$bd	=	new examenNota();
echo json_encode($bd->showNotas($codExa,$materia,$seccion));
$bd->close();
//unset($bd);

?>