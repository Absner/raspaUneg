<?php
require ('examenNota.php');

$bd	=	new examenNota();


echo json_encode($bd->showTipoExamen());
unset($bd);


?>