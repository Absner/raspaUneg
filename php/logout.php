<?php
require ('login.php');

session_destroy();
$_SESSION["nombre"];
if ( !isset($_SESSION["cedula"])){
	
	header("location: ../index.html");
}
unset($_SESSION["nombre"]);
unset($_SESSION["cedula"]);
?>
