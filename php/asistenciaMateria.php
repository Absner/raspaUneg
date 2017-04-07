<?php
require ('cronograma.php');

$bd	=	new cronograma();

$inicioFinSe	=	$bd->showInicioFin();
$inicio			=	$inicioFinSe[0]["fecha"];
$fin			=	$inicioFinSe[1]["fecha"];


$fechaInicio	=	strtotime($inicio);strtotime($bd->dateFormat($inicio));
$fechaFin		=	strtotime($fin);strtotime($bd->dateFormat($fin));


$rango	=	array();
for ($i= $fechaInicio;	$i	<=	$fechaFin;	$i+=86400){
	
	//echo date('d-m-Y', $i)."</br>";
	//$rango[]	=	date('d-m-Y', $i);
	$rango[]	=	date('Y-m-d', $i);
}
//print_r(date('w',strtotime('2016-10-11')));

//print_r($rango);
$dias	=	array(1,2);
$separad= array();

for ($j=0; $j < count($dias); $j++){
	for ( $i=0;	$i < count($rango); $i++){

		$numDia	=	date('w',strtotime($rango[$i]));
		$sentencia=($numDia == $dias[$j]);



		if ($sentencia){
			$separad[]= date('d-m-Y', strtotime($rango[$i]))."</br>";
		}
		//$j++;
	}
}
print_r($separad);


//echo $fechaFin
?>