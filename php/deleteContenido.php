<?php
require ('materia.php');
$request    =   json_decode(file_get_contents("php://input"));

$codContenido	=	$request->codContenido;
$materia		=	$request->materia;

$bd		=	new materia();

//echo $codContenido;

echo json_encode($bd->deleteContenido($codContenido,$materia));

$bd->close();
unset($bd);



?>