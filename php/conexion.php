<?php
$request    =   json_decode(file_get_contents("php://input")); 

list ($fecha,$basura)	= explode("T",$request->fecha);
echo json_encode($fecha);

?>