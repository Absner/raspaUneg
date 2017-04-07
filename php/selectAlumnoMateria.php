<?php
require ('materia.php');
$request    =   json_decode(file_get_contents("php://input")); 

$semestre	=	$request->semestre;
$materia	=	$request->materia;
$seccion	=	$request->seccion;
$docente	=	$_SESSION["cedula"];

$bd	=	new materia();

echo json_encode($bd->showAlumnosMateria($semestre,$materia,$seccion,$docente));



?>