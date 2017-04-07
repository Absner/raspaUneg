<?php
session_start();
class conexion2 extends mysqli{
    
    function __construct(){
        parent::__construct('localhost','root','','raspauneg');
        //parent::__construct('mysql.hostinger.es','u956317953_anaya','absrra019','u956317953_uneg');
		$this->query("SET NAMES 'utf8';");
		$this->connect_errno ? die('error en la conexion') : $x='conectado';
		//echo $x;
		unset($x);
    }
}
?>