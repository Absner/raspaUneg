<?php 
require ('Alumno.php');
$request    =   json_decode(file_get_contents("php://input")); 

$cedula		=	$request->cedula;

$bd	= new alumno();

echo json_encode($bd->dataAlumno($cedula));

?>