<?php
require('alumno.php');
require("../bower_components/PHPExcel/Classes/PHPExcel.php");
require_once("../bower_components/PHPExcel/Classes/PHPExcel/IOFactory.php");

$semestre	=	$_POST["semestre"];
$materia	=	$_POST["materia"];
$seccion	=	$_POST["seccion"];
$cedulaD	=	$_SESSION["cedula"];

$file = $_FILES["file"]["name"];

if(!is_dir("../files/"))
	mkdir("../files/", 0777);

if($file && move_uploaded_file($_FILES["file"]["tmp_name"], "../files/".$file))
{
	
}
$i=13;
$objPhpExcel = PHPExcel_IOFactory::load("../files/".$file);
$cedula	=	array();
$nombre	=	array();
$bandera=true;

while ($bandera){
	if ($objPhpExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue() == null){
		$bandera=false;
	}else{
		$cellValue = $objPhpExcel->getActiveSheet()->getCell('B'.$i)->getValue();
		$name = $objPhpExcel->getActiveSheet()->getCell('C'.$i)->getValue();
		array_push($cedula,$cellValue);
		array_push($nombre,$name);
		$i++;
	}
}

/*instanciamos un objeto alumno para cargarlo a la BD */
$bd= new alumno();
$bd->cargarAlumno($cedula,$nombre,$materia,$seccion,$semestre,$cedulaD)
//print_r($bd->cargarAlumno($cedula,$nombre,$materia,$seccion,null));

/*$objPhpExcel = PHPExcel_IOFactory::load("../files/".$file);
$objWriter	 = PHPExcel_IOFactory::createWriter($objPhpExcel, 'Excel2007');
$objWriter->save("convertido.xlsx");*/


?>
