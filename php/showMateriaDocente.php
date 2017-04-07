<?php 
require ('docente.php');
$request    =   json_decode(file_get_contents("php://input")); 

$cedulaD	=	$_SESSION["cedula"];
$semestre	=	$request->semestre;

$bd	= new docente();
$result	=	$bd->showMateriaDocente($cedulaD,$semestre);
//echo $semestre;
print_r (json_encode($result));

?>