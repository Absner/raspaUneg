<?php
require ('materia.php');

$bd			=	new materia();
$materias	=	$bd->showMateria();
$secciones	=	$bd->showSeccion();
$arreglo	=array();
array_push($arreglo,$materias,$secciones);
echo json_encode($arreglo);
?>
