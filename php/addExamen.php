<?php
require ('cronograma.php'); require ('alumno.php'); require ('examenNota.php');require ('materia.php');

$request    =   json_decode(file_get_contents("php://input")); 

$codMateria		=	$request->codMateria;
$codSeccion		=	$request->codSeccion;
$porcentaje		=	$request->porcentaje;
$descripcion	=	$request->descripcion;
$fecha			=	$request->fecha;
$semestre		=	$request->semestre;
$tipoEval		=	$request->tipoEval;
$cedulaD		=	$_SESSION["cedula"];

$bd		=	new cronograma();
$id_exa	=	$bd->addExamen($fecha,$porcentaje,$descripcion,$codMateria,$codSeccion,$semestre,$cedulaD,$tipoEval);

//$alumno	=	new alumno();
$alumno	=	new materia();
//$datos	=	$alumno->showAlumno();
$datos	=	$alumno->showAlumnosMateria($semestre,$codMateria,$codSeccion,$cedulaD);
//echo json_encode($datos);
$examen	=	new examenNota();

echo $examen->addNota($id_exa,$cedulaD,$datos,$semestre,$codMateria,$codSeccion);
//echo $cedulaD;
$bd->close();
$alumno->close();
$examen->close();
unset($bd);
unset($alumno);
unset($examen);



?>