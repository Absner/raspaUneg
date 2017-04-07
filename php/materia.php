<?php
include_once ('conexion2.php');

class materia extends conexion2{
	
	
	public function addMateria ($cod,$nombre,$uc){
		$insert	=	parent::prepare("insert into asignatura(serial,nombre,uc) values(?,?,?)");
		$insert->bind_param("ssi",$cod,$nombre,$uc);
		
		if ($insert->execute()){
			return 1;
		}else{
			return 0;
		}
		
	}
	
	public function showMateria (){
		$consulta	=	parent::query("SELECT * FROM asignatura;");

		$data		=	array();
		
		while ($row =	$consulta->fetch_array()){
			

			$codigo	=	$row["codigo"];
			$serial	=	$row["serial"];
			$nombre	=	$row["nombre"];
			$uc		=	$row["uc"];
			
			$data[]	=	array('codigo'	=>	$codigo,	
						  	  'serial'	=>	$serial,
						      'nombre'	=>	$nombre,
						      'uc'		=>	$uc);

		}
		return $data;
	}
	
	public function showSeccion (){
		$consulta	=	parent::query("SELECT * FROM seccion;");
		$data		=	array();
		
		while ($row	=	$consulta->fetch_array()){
			$codigo	=	$row["codigo"];
			$data[]	=	array('codigo'	=>	$codigo);
		}
		return $data;
	}
	
	public function asignarMateria($docente,$materia,$seccion,$semestre){
		$insert	=	parent::prepare("insert into semestre(asignatura_codigo,seccion_codigo,docente_cedula,periodo_codigo) values(?,?,?,?);");
		$insert->bind_param("iisi",$materia,$seccion,$docente,$semestre);
		
		if ($insert->execute()){
			return "Asignatura agregada correctamente";
		}else{
			return "Fallo en agragdar asignatura";
		}
	}
	
	public function addContenido($materia,$titulo,$descripcion){
		$insert	=	parent::prepare("insert into contenido(asignatura_codigo,titulo,descripcion) 					 values(?,?,?)");
		
		$insert->bind_param("iss",$materia,$titulo,$descripcion);
		if ($insert->execute()){
			return "Contenido agragado correctamente";
		}else{
			return "Error al cargar nuevo contenido";
		}
	}
	
	public function showContenido($materia){
		$select	=	parent::prepare("SELECT 
						*
					FROM
						contenido
					WHERE
						contenido.asignatura_codigo = ?");
		
		$select->bind_param("i",$materia);
		$data	=	array();
		
		if ($select->execute()){
			
			$select->bind_result($cod,$asignatura,$titulo,$descripcion);
			
			while ($select->fetch()){
				$data[]	=	array("cod"			=>	$cod,
								  "materia"		=>	$asignatura,
								  "titulo"		=>	$titulo,
								  "descripcion"	=>	$descripcion
								 );
			}
			

			
		}else{
			return 0;
		}
		
		return $data;
	}
	
	public function deleteContenido($codContenido,$codMateria){
		$delete	=	parent::prepare("DELETE FROM contenido 
					WHERE
						contenido.codigo = ?
						AND contenido.asignatura_codigo = ?");
		
		$delete->bind_param("ii",$codContenido,$codMateria);
		
		if ($delete->execute()){
			return "Solicitud procesada correctamente";
		}else{
			return "hubo un error al completar su solicitud";
		}
		
	}
	
	public function deleteMateria($materia,$seccion,$docente,$semestre){
		$delete	=	parent::prepare("DELETE FROM semestre 
					WHERE
						semestre.asignatura_codigo = ?
						AND semestre.seccion_codigo = ?
						AND semestre.docente_cedula = ?
						AND semestre.periodo_codigo = ?");
		
		$delete->bind_param("iisi",$materia,$seccion,$docente,$semestre);
		
		if ($delete->execute()){
			return "Asignatura eliminada correctamente";
		}else{
			return "Fallo en eliminar asignatura";
		}
	}
	
	public function updateMateria($codigo,$serial,$materia,$uc){
		$update	=	parent::prepare("UPDATE asignatura 
					SET 
						asignatura.serial = ?,
						asignatura.nombre = ?,
						asignatura.uc = ?
					WHERE
						asignatura.codigo = ?");
		
		$update->bind_param("ssii",$serial,$materia,$uc,$codigo);
		
		if ($update->execute()){
			return 1;
		}else{
			return 0;
		}
	}
	
	public function updateContenido($codigo,$titulo,$descripcion){
		$update	=	parent::prepare("UPDATE contenido 
					SET 
						contenido.titulo = ?,
						contenido.descripcion = ?
					WHERE
						contenido.codigo = ?");
		
		$update->bind_param("ssi",$titulo,$descripcion,$codigo);
		
		if ($update->execute()){
			return 1;
		}else{
			return 0;
		}
	}
	
	public function showAlumnosMateria($semestre,$materia,$seccion,$docente){
		$select	=	parent::prepare("SELECT 
					matricula.alumno_cedula,
					alumno.nombre,
					alumno.sNombre,
					alumno.apellido,
					alumno.sApellido,
					alumno.correo,
					matricula.semestre_asignatura_codigo,
					matricula.semestre_seccion_codigo,
					matricula.semestre_periodo_codigo
				FROM
					alumno
						INNER JOIN
					matricula ON matricula.alumno_cedula = alumno.cedula
				WHERE
					matricula.semestre_asignatura_codigo = ?
						AND matricula.semestre_seccion_codigo = ?
						AND matricula.semestre_periodo_codigo = ?
						AND matricula.semestre_docente_cedula = ? 
				ORDER BY alumno.apellido ASC");
		
		$select->bind_param("iiis",$semestre,$materia,$seccion,$docente);
		$data	=	array();
		
		if ($select->execute()){
			$select->bind_result($cedula,$nombre,$sNombre,$apellido,$sApellido,$correo,$mateia,$seccion,$semestre);
			
			while($row	=	$select->fetch()){
				
				$data[]	=	array("cedula"		=>	$cedula,
								  "apellido"	=>	$apellido,
								  "sApellido"	=>	$sApellido,
								  "nombre"		=>	$nombre,
								  "sNombre"		=>	$sNombre,
								  "correo"		=>	$correo,
								  "materia"		=>	$materia,
								  "seccion"		=>	$seccion,
								  "semestre"	=>	$semestre
								 );
			}
		}else{
			return 0;
		}
		
		return $data;
		
	}
	
	public function deleteAlumnoMateria($semestre,$materia,$seccion,$cedulaAlumno){
		$delete	=	parent::prepare("DELETE FROM matricula 
					WHERE 
						matricula.semestre_asignatura_codigo = 	?
						AND	matricula.semestre_seccion_codigo = ?
						AND	matricula.semestre_periodo_codigo =	?
						AND matricula.alumno_cedula = ?");
		
		$delete->bind_param("iiis",$materia,$seccion,$semestre,$cedulaAlumno);
		
		if ($delete->execute()){
			return 1;
		}else{
			return 0;
		}
	}
	
	/* funciones para los datos estadisticos por materia y semestre */
	
	public function countAlumnosInscritos($semestre,$materia,$seccion,$docente){
		
		$count	=	parent::prepare("SELECT 
						COUNT(*) AS cantidad
					FROM
						matricula
					WHERE
						matricula.semestre_periodo_codigo = ?
							AND matricula.semestre_asignatura_codigo = ?
							AND matricula.semestre_seccion_codigo = ?
							AND matricula.semestre_docente_cedula = ?");
		
		$count->bind_param("iiis",$semestre,$materia,$seccion,$docente);
		//$data;
		if ($count->execute()){
			$count->bind_result($cantidad);
			
			return $cantidad;
		}
		
		
		
	}
	
	public function countAlumnosAprobados($semestre,$materia,$seccion,$docente){
		$count	=	parent::prepare("SELECT 
						COUNT(*) AS aprobados
					FROM
						matricula
					WHERE
						matricula.semestre_periodo_codigo = ?
							AND matricula.semestre_asignatura_codigo = ?
							AND matricula.semestre_seccion_codigo = ?
							AND matricula.semestre_docente_cedula = ?
							AND matricula.notafinal >= 55");
		
		$count->bind_param("iiis",$semestre,$materia,$seccion,$docente);
		
		if ($count->execute()){
			$count->bind_result($aprobados);
			$select->fetch();
			return $aprobados;
		}
	}
	
	public function countAlumnosAplazados($semestre,$materia,$seccion,$docente){
		$count	=	parent::prepare("SELECT 
						COUNT(*) AS aplazados
					FROM
						matricula
					WHERE
						matricula.semestre_periodo_codigo = ?
							AND matricula.semestre_asignatura_codigo = ?
							AND matricula.semestre_seccion_codigo = ?
							AND matricula.semestre_docente_cedula = ?
							AND matricula.notafinal < 55");
		
		$count->bind_param("iiis",$semestre,$materia,$seccion,$docente);
		
		if ($count->execute()){
			$count->bind_result($aplazados);
			$select->fetch();
			return $aplazados;
		}
	}
	
	public function notaAlta($semestre,$materia,$seccion,$docente){
		$select	=	parent::prepare("SELECT 
						MAX(matricula.notafinal) AS maxima
					FROM
						matricula
					WHERE
						matricula.semestre_periodo_codigo = ?
							AND matricula.semestre_asignatura_codigo = ?
							AND matricula.semestre_seccion_codigo = ?
							AND matricula.semestre_docente_cedula = ?");
		
		$select->bind_param("iiis",$semestre,$materia,$seccion,$docente);
		
		if ($select->execute()){
			$select->bind_result($maxima);
			$select->fetch();
			return $maxima;
		}
	}
	
	public function notaBaja($semestre,$materia,$seccion,$docente){
		$select	=	parent::prepare("SELECT 
						MIN(matricula.notafinal) AS maxima
					FROM
						matricula
					WHERE
						matricula.semestre_periodo_codigo = ?
							AND matricula.semestre_asignatura_codigo = ?
							AND matricula.semestre_seccion_codigo = ?
							AND matricula.semestre_docente_cedula = ?");
		
		$select->bind_param("iiis",$semestre,$materia,$seccion,$docente);
		
		if ($select->execute()){
			$select->bind_result($minima);
			$select->fetch();
			return $minima;
		}
	}
	
	public function promedioMateria($semestre,$materia,$seccion,$docente){
		$select	=	parent::prepare("SELECT 
						AVG(matricula.notafinal)
					FROM
						matricula
					WHERE
						matricula.semestre_periodo_codigo = ?
							AND matricula.semestre_asignatura_codigo = ?
							AND matricula.semestre_seccion_codigo = ?
							AND matricula.semestre_docente_cedula = ?");
		
		$select->bind_param("iiis",$semestre,$materia,$seccion,$docente);
		
		if ($select->execute()){
			$select->bind_result($promedio);
			$select->fetch();
			return $promedio;
		}
	}
	
	public function calcularNotaFinal($semestre,$materia,$seccion,$docente,$data){
		$update	=	parent::prepare("SELECT 
						nota.matricula_alumno_cedula, SUM(nota.nota) AS total
					FROM
						nota
					WHERE
						nota.matricula_semestre_asignatura_codigo = ?
							AND nota.matricula_semestre_seccion_codigo = ?
							AND nota.matricula_semestre_periodo_codigo = ?
							AND nota.matricula_semestre_docente_cedula = ?
							AND nota.matricula_alumno_cedula = ?");
		
		$update->bind_param("iiiss",$materia,$seccion,$semestre,$docente,$alumno);
		
		$notas	=	array();
		
		for ($i=0;	$i	<	count($data);	$i++){
			$alumno	=	$data[$i]["cedula"];
			if ($update->execute()){
				$update->bind_result($cedula,$notaFinal);
				$update->fetch();
				$notas[]	=	array("cedula"		=>	$cedula,
									  "notaFinal"	=>	$notaFinal
									 );
			}
		}
		
		return $notas;
	}
	
	public function updateNotaFinal($semestre,$materia,$seccion,$docente,$notas){
		$update	=	parent::prepare("UPDATE matricula 
					SET 
						matricula.notafinal = ?
					WHERE
						matricula.semestre_periodo_codigo = ?
							AND matricula.semestre_asignatura_codigo = ?
							AND matricula.semestre_seccion_codigo = ?
							AND matricula.semestre_docente_cedula = ?
							AND matricula.alumno_cedula = ?");
		
		$update->bind_param("iiiiss",$nota,$semestre,$materia,$seccion,$docente,$alumno);
		$ban=true;
		for ($i=0;	$i	<	count($notas);	$i++){
			$alumno	=	$notas[$i]["cedula"];
			$nota	=	$notas[$i]["notaFinal"];
			if ($update->execute()){
				$ban=true;
			}else{
				$ban=false;
			}
		}
	}
	
}//fin de la clase

//$bd = new materia();
//echo $bd->notaBaja(1,1,1,"19910973");
?>