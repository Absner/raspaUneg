<?php
require ('materia.php');
$request    =   json_decode(file_get_contents("php://input")); 

$materia	=	$request->materia;
$seccion	=	$request->seccion;
$semestre	=	$request->semestre;
$docente	=	$_SESSION["cedula"];

$bd			=	new materia();

//$semestre	=	$request->;
echo $bd->deleteMateria($materia,$seccion,$docente,$semestre);
//echo $docente;

$bd->close();
unset($bd);

?>