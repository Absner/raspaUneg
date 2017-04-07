<?php
require ('materia.php');
$request    =   json_decode(file_get_contents("php://input")); 

$bd	=	new materia();
$materia		=	$request->materia;
$titulo			=	$request->titulo;
$descripcion	=	$request->descripcion;	

echo $bd->addContenido($materia,$titulo,$descripcion);

$bd->close();
unset($bd);
//echo $materia;

?>