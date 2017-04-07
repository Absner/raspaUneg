<?php
require ('cronograma.php');
$bd	=	new cronograma();
$inicioFin	=	$bd->showInicioFin();
print_r(json_encode($inicioFin));
unset($bd);
unset($inicioFin);


?>