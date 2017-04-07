<?php
require ('periodo.php');

$bd	=	new periodo();

echo json_encode($bd->showPeriodo());
unset($bd);
?>