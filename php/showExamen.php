<?php
require ('cronograma.php');
$bd	=	 new cronograma();

echo json_encode($bd->showExamen($_SESSION["cedula"]));

?>