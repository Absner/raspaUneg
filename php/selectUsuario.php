<?php
require ('usuario.php');

$bd	=	 new usuario();

echo json_encode($bd->selectUser($_SESSION["cedula"]));

?>