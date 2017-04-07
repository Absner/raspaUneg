<?php
require ('pdf.php'); require ('examenNota.php');
//$request    =   json_decode(file_get_contents("php://input")); 

$semestre	=	$_GET["semestre"];
$materia	=	$_GET["materia"];
$seccion	=	$_GET["seccion"];
$docente	=	$_SESSION["cedula"];


/* consultas para las notas como la cantidad de evaluaciones y la notas de las evaluaciones*/
$nota		=	new examenNota();
$cantEval	=	$nota->cantExamen($docente,$semestre,$materia,$seccion);
$calificacion	=	$nota->resumenNotas($cantEval);
$notaFinal	=	$nota->showNotaFinal($semestre,$materia,$seccion,$docente);

/* instancia de la clase pdf para crear y formatear el documento pdf que será el reporte*/
$report	=	new pdf('l');
$report->SetMargins(10,10,10,10);
$report->SetTitle("Resumen de notas");
$report->AliasNbPages();
$report->setMateria("Base de datos");
$report->setSeccion("1");
$report->setDocente($_SESSION["apellido"]." ".$_SESSION["nombre"]);
$report->setCantEval($cantEval);

$report->AddPage();
//$report->Ln(30);

$report->SetX(10);
$report->Cell(10,7,utf8_decode('N°'),1,0,'C');
$report->SetX(20);
$report->Cell(30,7,utf8_decode('CÉDULA'),1,0,'C');
$report->SetX(50);
$report->Cell(90,7,utf8_decode('APELLIDOS Y NOMBRES'),1,0,'C');

$setX=140;
for ($i=0; $i < count($cantEval);$i++){
	$report->SetX($setX);
	$report->Cell(22,7,utf8_decode($cantEval[$i]["fecha"]),1,0,'C');
	$setX=$setX+22;
}
$report->SetX($setX);
$report->Cell(22,7,utf8_decode("Final"),1,0,'C');
$report->Ln();
$report->SetFont('times','',11);

for ($i=0; $i < count($calificacion[0]); $i++){
	
	$nombres	=	$calificacion[0][$i]["apellido"]." ";
	$nombres	.=	$calificacion[0][$i]["sApellido"].", ";
	$nombres	.=	$calificacion[0][$i]["nombre"]." ";
	$nombres	.=	$calificacion[0][$i]["sNombre"];
	$report->SetX(10);
	$report->Cell(10,5,utf8_decode($i+1),1,0,'C');
	$report->SetX(20);
	$report->Cell(30,5,utf8_decode($calificacion[0][$i]["cedula"]),1,0,'C');
	$report->SetX(50);
	$report->Cell(90,5,utf8_decode($nombres),1,0,'C');
	$setX=140;
	for ($j=0; $j < count($calificacion);$j++){
		$report->SetX($setX);
		$report->Cell(22,5,utf8_decode($calificacion[$j][$i]["nota"]),1,0,'C');
		$setX=$setX+22;
		
	}
	$report->SetX($setX);
	$report->Cell(22,5,$notaFinal[$i]["notaFinal"],1,0,'C');
	$report->Ln();
}


$report->Output();
unset ($report);
?>

