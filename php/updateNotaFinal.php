<?php
require ('materia.php');
$request    =   json_decode(file_get_contents("php://input"));

$semestre	=	$request->semestre;
$materia	=	$request->materia;
$seccion	=	$request->seccion;
$docente	=	$_SESSION["cedula"];

$bd	=	new materia();

$data	=	$bd->showAlumnosMateria($semestre,$materia,$seccion,$docente);

$notas	=	$bd->calcularNotaFinal($semestre,$materia,$seccion,$docente,$data);

echo json_encode($bd->updateNotaFinal($semestre,$materia,$seccion,$docente,$notas));

?>