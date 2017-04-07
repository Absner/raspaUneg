<?php
require ('../bower_components/PHPMailer-master/class.phpmailer.php');
require ('../bower_components/PHPMailer-master/class.smtp.php');
require ('examenNota.php');
$request    =   json_decode(file_get_contents("php://input"));

$bd	=	new examenNota();

$idExamen	=	$request->idExamen;
$semestre	=	$request->semestre;
$materia	=	$request->materia;
$seccion	=	$request->seccion;
$docente	=	$_SESSION["cedula"];




$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
$mail->Host = "smtp.gmail.com";
$mail->Port = 465;
//$mail->Port = 587;

//Nuestra cuenta
$mail->Username ='absrraniel@gmail.com';
//$mail->Username ='absrraniel_17@outlook.com';
$mail->Password = 'xandal019'; //Su password
//$mail->Password = 'lillo3030'; //Su password

$nota	=	$bd->selectNota($idExamen);
$notaFinal	=	$bd->showNotaFinal($semestre,$materia,$seccion,$docente);

$mail->AddAddress("absrraniel_17@outlook.com","Anaya Absner");
//$mail->AddAddress("absrraniel@gmail.com","Anaya Absner");
for ($i=0; $i	<	1;	$i++){
	$body  = "Hola, ".$nota[$i]["apellido"]." ".$nota[$i]["nombre"].", tu Calificacion fue: ".$nota[$i]["nota"]." y llevas un acumulado de: ".$notaFinal[$i]["notaFinal"];
	$mail->Subject = 'Nota Examen';
	$mail->FromName = "Ing. Absner Anaya.";
	$mail->Body = $body; 
	if ($mail->Send())
		echo true;
	else
		echo false;
}
$bd->close();
unset($bd);
/*$body  = "tu nota es: ";
$mail->Subject = 'Nota Examen';
$mail->FromName = "Ing. Absner Anaya.";
$mail->Body = $body; 
if ($mail->Send())
	echo true;
else
	echo false;
*/


?>
