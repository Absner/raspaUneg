<?php
require ('alumno.php');
$request    =   json_decode(file_get_contents("php://input")); 

$cedula			=	$request->cedula;
$nombre			=	$request->nombre;
$sNombre		=	$request->sNombre;
$apellido		=	$request->apellido;
$sApellido		=	$request->sApellido;
$correo			=	$request->correo;
$origenCedula	=	$request->origenCedula;

$bd	=	new alumno();

echo  json_encode($bd->updateAlumno($cedula,$nombre,$sNombre,$apellido,$sApellido,$correo,$origenCedula));



?>