<?php
include_once ("conexion2.php");

class cronograma extends conexion2{
	
	public function addEvento ($fecha,$descripcion,$actividad,$docente){
		$date	=	$this->formFecha($fecha);
		$insert	=	parent::prepare("insert into cronograma(actividad_codigo,descripcion,fecha,docente_cedula) values(?,?,?,?);");
		$insert->bind_param("isss",$actividad,$descripcion,$date,$docente);
		
		if ($insert->execute()){
			return "Evento agregado correctamente";
		}else{
			return "Fallo en cargar el evento";
		}
	}
	
	public function addExamen($fecha,$porcentaje,$descripcion,$materia,$seccion,$semestre,$docente,$tipoEval){
		$date	=	$this->formFecha($fecha);
		$insert	=	parent::prepare("insert into examen(fecha,porcentaje,descripcion,semestre_asignatura_codigo,semestre_seccion_codigo,semestre_docente_cedula,semestre_periodo_codigo,tipoExamen_codigo) values(?,?,?,?,?,?,?,?);");
		$insert->bind_param("sisiisii",$date,$porcentaje,$descripcion,$materia,$seccion,$docente,$semestre,$tipoEval);
		
		if ($insert->execute()){
			return $insert->insert_id;
		}else{
			return 0;
		}
	}
	
	public function showExamen($cedulaDocente){
		$consulta	=	parent::query("SELECT 
    examen.codigo,
    examen.fecha,
    examen.porcentaje,
    examen.semestre_periodo_codigo,
    examen.semestre_asignatura_codigo,
    asignatura.nombre,
	examen.semestre_seccion_codigo
FROM
    examen,
    asignatura
WHERE
    examen.semestre_docente_cedula = '".$cedulaDocente."'
        AND examen.semestre_asignatura_codigo = asignatura.codigo ORDER BY examen.fecha ASC");
		
		$datos	=	array();
		
		while ($row=$consulta->fetch_array()){
			
			$datos[] = array("codigo"				=>	$row["codigo"],
							 "fecha"				=>	$row["fecha"],
							 "procentaje"			=>	$row["porcentaje"],
							 "semestre"				=>	$row["semestre_periodo_codigo"],
							 "asignatura_codigo"	=>	$row["semestre_asignatura_codigo"],
							 "nombre"				=>	$row["nombre"],
							 "seccion"				=>	$row["semestre_seccion_codigo"]);
			
		}
		return $datos;
	}
	
	private function formFecha($fecha){
		list ($fecha,$basura)	= explode("T",$fecha);
		unset($basura);
		return $fecha;
	}
	
	public function showActividad(){
		$consulta	=	parent::query("SELECT * FROM actividad");
		
		$data		=	array();
		
		while($row	=	$consulta->fetch_array()){
			$data[]	=	array("codigo"		=>	$row["codigo"],
							  "descripcion"	=>	$row["descripcion"]);
		}
		return $data;
	}
	
	public function ultimo_id(){
		
		$id	=	parent::insert_id;
		return $id;
	}
	
	public function showFeriados(){
		$select	=	parent::query("SELECT 
						cronograma.id, cronograma.descripcion, cronograma.fecha
					FROM
						cronograma
					WHERE
						cronograma.actividad_codigo = 3");
		
		$data	=	array();
		
		while ($row	=	$select->fetch_array()){
			
			$data[]	=	array("id"			=>	$row["id"],
							  "descripcion"	=>	$row["descripcion"],
							  "fecha"		=>	$row["fecha"]
							 );
		}
		return $data;
	}
	
	public function showInicioFin(){
		$select	=	parent::query("SELECT
					cronograma.id,
					cronograma.actividad_codigo,
					actividad.descripcion,
					cronograma.fecha
					FROM
					cronograma
					INNER JOIN actividad ON cronograma.actividad_codigo = actividad.codigo
					WHERE cronograma.actividad_codigo=1 OR cronograma.actividad_codigo=2 ORDER BY cronograma.actividad_codigo ASC");
		$data	=	array();
		
		while ($row	=	$select->fetch_array()){
			$data[]	=	array("id"			=>	$row["id"],
							  "actividadID"	=>	$row["actividad_codigo"],
							  "descripcion"	=>	$row["descripcion"],
							  "fecha"		=>	$row["fecha"]
							 );
		}
		
		return $data;
	}
	
	public function dateFormat($fecha){
		$date = new DateTime($fecha);
		
		return $date->format('d-m-Y');
	}

	
}//fin de la clase


?>