<?php
require ('materia.php');
$request    =   json_decode(file_get_contents("php://input"));
$materia	=	$request->materia;


$bd	=	new materia();



echo json_encode($bd->showContenido($materia));


?>