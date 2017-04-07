<?php
require ('alumno.php');

$request    =   json_decode(file_get_contents("php://input"));

$correos	=	$request->correo;

$correo		=	explode(";",$correos);
$bd			=	new alumno();

print_r($bd->updateCorreos($correo,$correo));
$bd->close();
unset ($bd);


?>