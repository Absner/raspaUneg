<?php
require ('cronograma.php');

$bd	=	new cronograma();

$feriado	=	$bd->showFeriados();
print_r(json_encode($feriado));
unset($bd);
unset($feriado);

?>