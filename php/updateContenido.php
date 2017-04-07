<?php
require ('materia.php');
$request    =   json_decode(file_get_contents("php://input")); 

$codigo			=	$request->codigo;
$titulo			=	$request->titulo;
$descripcion	=	$request->descripcion;

$bd		=	new materia();

echo $bd->updateContenido($codigo,$titulo,$descripcion);


?>