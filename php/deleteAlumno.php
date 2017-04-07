<?php
require ('materia.php');
$request    =   json_decode(file_get_contents("php://input")); 

$semestre	=	$request->semestre;
$materia	=	$request->materia;
$seccion	=	$request->seccion;
$cedula		=	$request->cedula;

$bd	=	new materia();

echo json_encode($bd->deleteAlumnoMateria($semestre,$materia,$seccion,$cedula));

$bd->close();
unset($bd);


?>