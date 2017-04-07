<?php
require ('examenNota.php');
$request    =   json_decode(file_get_contents("php://input"));

$nota		=	$request->nota;
$cedula		=	$request->cedula;
$idExamen	=	$request->idExamen;

$bd			=	new examenNota();
echo $bd->updateNota($idExamen,$cedula,$nota);

$bd->close();
unset($bd);
?>