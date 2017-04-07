<?php
require ('examenNota.php');
$request    =   json_decode(file_get_contents("php://input")); 

$semestre	=	$request->semestre;
$materia	=	$request->materia;
$seccion	=	$request->seccion;
$docente	=	"19910973";


/* consultas para las notas como la cantidad de evaluaciones y la notas de las evaluaciones*/
$nota		=	new examenNota();
$cantEval	=	$nota->cantExamen($docente,$semestre,$materia,$seccion);
echo json_encode($nota->resumenNotas($cantEval));
?>