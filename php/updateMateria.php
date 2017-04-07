<?php
require ('materia.php');
$request    =   json_decode(file_get_contents("php://input")); 

$idMateria	=	$request->codigo;
$serial		=	$request->serial;
$materia	=	$request->materia;
$uc			=	$request->uc;

$bd		=	new materia();

echo $bd->updateMateria($idMateria,$serial,$materia,$uc);
unset ($bd);

?>