<?php
include_once ('conexion2.php');

class docente extends conexion2{
	
	public function showMateriasAsig($cedula,$semestre){
		$consulta	=	parent::query("SELECT DISTINCT
							semestre.asignatura_codigo, asignatura.nombre
						FROM
							semestre,
							asignatura
						WHERE
							semestre.docente_cedula = '".$cedula."'
								AND semestre.asignatura_codigo =  asignatura.codigo
								AND semestre.periodo_codigo	= '".$semestre."'");
		
		$data	=	array();
		
		while ($row	=	$consulta->fetch_array()){
			
			$codigoM	=	$row["asignatura_codigo"];
			$nombreM	=	$row["nombre"];
			
			$data[]		=	array("codigoM"	=>	$codigoM, "nombreM"	=>	$nombreM);
		}
		return $data;
		
	}
	
	public  function showSeccionAsig($cedula,$codMateria,$semestre){
		$consulta	=	parent::query("SELECT 
    semestre.seccion_codigo
FROM
    semestre
WHERE
    semestre.asignatura_codigo = '.$codMateria.'
        AND semestre.docente_cedula = '".$cedula."'
		AND semestre.periodo_codigo='".$semestre."'");
		
		$data	=	array();
		
		while ($row	=	$consulta->fetch_array()){
			$codigoS	=	$row["seccion_codigo"];
			$data[]		=	array("codigoS"	=>	$codigoS);
		}
		return $data;
	}
	
	public function showMateriaDocente($cedula,$semestre){
		$select	=	parent::prepare("SELECT
					semestre.asignatura_codigo,
					asignatura.serial,
					asignatura.nombre,
					asignatura.uc,
					semestre.seccion_codigo,
                    semestre.periodo_codigo
				FROM
					semestre
				INNER JOIN asignatura ON semestre.asignatura_codigo = asignatura.codigo
				WHERE
					semestre.docente_cedula = ?
				AND semestre.periodo_codigo = ?");
		$select->bind_param("si",$cedula,$semestre);
		$select->execute();
		$select->bind_result($codigo,$serial,$nombre,$uc,$seccion,$periodo);
		$data	=	array();
		while ($select->fetch()){
			$data[]	=	array("codigo"	=>	$codigo,
							  "serial"	=>	$serial,
							  "materia"	=>	strtoupper($nombre),
							  "uc"		=>	$uc,
							  "seccion"	=>	$seccion,
							  "semestre"=>	$periodo
							 );
		}
		
		return $data;
		
		
	}
}

?>