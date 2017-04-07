<?php
include_once ('alumno.php'); include_once ('examenNota.php');

$request    =   json_decode(file_get_contents("php://input")); 


$bd	=	new alumno();
$i=0;

$materia	=	$request->materia;
$seccion	=	$request->seccion;
$semestre	=	$request->semestre;
$docente	=	$_SESSION["cedula"];
$numAlumno	=	$request->cant;
$data	=	array();

while($i < $request->cant){
    $cedula		=	$request->cedula->{$i};
    $nombre		=	$request->nombre->{$i};
	$sNombre	=	$request->sNombre->{$i};
	$apellido	=	$request->apellido->{$i};
	$sApellido	=	$request->sApellido->{$i};
    $correo		=	$request->correo->{$i};
	$data[]	=	array("cedula"		=>	$cedula,
					  "nombre"		=>	$nombre,
					  "sNombre"		=>	$sNombre,
					  "apellido"	=>	$apellido,
					  "sApellido"	=>	$sApellido,
					  "correo"		=>	$correo
					 );
    $i++;
}




$examen	=	new examenNota();


$alumno = $bd->cargaManualAlumno($semestre,$materia,$seccion,$docente,$numAlumno,$data);
$idExamen	=	$examen->idExamens($semestre,$materia,$seccion,$docente);
$nota	= $bd->cargarAlumnoNota($idExamen,$semestre,$materia,$seccion,$docente,$data);


$bd->close();
$examen->close();

if ($nota==true)
	echo 1;
else
	echo 0;

?>
