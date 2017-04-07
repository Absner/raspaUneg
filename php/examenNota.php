<?php
include_once ('conexion2.php');

class examenNota extends conexion2{
	
	public function cantExamen($docente,$semestre,$materia,$seccion){
		$consulta	=	parent::query("SELECT 
    examen.fecha, examen.codigo
FROM
    examen
WHERE
    examen.semestre_docente_cedula = '".$docente."'
        AND semestre_periodo_codigo = '".$semestre."'
        AND examen.semestre_asignatura_codigo = '".$materia."'
        AND examen.semestre_seccion_codigo = '".$seccion."';");
		
		$dato		=	array();
		
		while ($row	=	$consulta->fetch_array()){
			
			$dato[]	=	array("codigo"	=>	$row["codigo"],
							  "fecha"	=>	$row["fecha"]);
		}
		return $dato;
		
	}
	
	public function addNota($id_examen,$docente,$datos,$semestre,$materia,$seccion){
		
		$insert	=	parent::prepare("insert into nota(examen_codigo,
		matricula_alumno_cedula,matricula_semestre_asignatura_codigo,matricula_semestre_seccion_codigo, matricula_semestre_docente_cedula,matricula_semestre_periodo_Codigo) values(?,?,?,?,?,?)");
		
		$insert->bind_param("isiisi",$id_examen,$cedulaA,$materia,$seccion,$docente,$semestre);
		$i=0;
		$ban="";
		while ($i	<	count($datos)){
			$cedulaA	=	$datos[$i]["cedula"];
			if ($insert->execute()){
				$ban = "Evaluacion programada correctamente";
			}else{
				$ban = "Problemas al programar la evaluacion";
			}
			$i++;
		}
		
		return $ban;
	}
	
	public function showNotas($codexamen,$materia,$seccion){
		$consulta	=	parent::query("SELECT 
						nota.matricula_alumno_cedula,
						nota.nota,
						alumno.apellido,
						alumno.sApellido,
						alumno.nombre,
						alumno.sNombre
						FROM
						nota
						INNER JOIN alumno ON alumno.cedula = nota.matricula_alumno_cedula
						INNER JOIN examen ON nota.examen_codigo = examen.codigo
						WHERE
						examen.codigo= '".$codexamen."' AND nota.matricula_semestre_asignatura_codigo= '".$materia."' AND nota.matricula_semestre_seccion_codigo= '".$seccion."'
						ORDER BY alumno.apellido ASC;");
		
		$dato	=	array();
		
		while ($row	=	$consulta->fetch_array()){
			
			$dato[]	=	array("cedula"		=>		$row["matricula_alumno_cedula"],
							  "nota"		=>		intval($row["nota"]),
							  "apellido"	=>		$row["apellido"],
							  "sApellido"	=>		$row["sApellido"],
							  "nombre"		=>		$row["nombre"],
							  "sNombre"		=>		$row["sNombre"]);
		}
		return $dato;
	}
	
	public function updateNota($idExamen,$cedula,$nota){
		$update	=	parent::prepare("update nota set nota = ? 
					where nota.examen_codigo=? and 
					nota.matricula_alumno_cedula=?;");
		$update->bind_param("iis",$nota,$idExamen,$cedula);
		
		if ($update->execute())
			return 1;
		else
			return 0;
	}
	
	public function resumenNotas($idEval){
		$select	=	parent::prepare("SELECT 
										nota.examen_codigo,
										nota.matricula_alumno_cedula,
										alumno.apellido,
										alumno.sApellido,
										alumno.nombre,
										alumno.sNombre,
										nota.nota
									FROM
										nota,
										alumno
									WHERE
										nota.examen_codigo = ?
											AND nota.matricula_alumno_cedula = alumno.cedula
									ORDER BY alumno.apellido ASC");
		$select->bind_param("i",$codNota);
		$notas	=	array(array());
		
		for ($i=0; $i < count($idEval); $i++){
			
			$codNota	=	$idEval[$i]["codigo"];
			//echo $codNota;
			
			if ($select->execute()){
				
				$select->bind_result($codExa,$alumnoCi,$apellido,$sApellido,$nombre,$sNombre,$nota);
				$j=0;
				while ($row=$select->fetch()){
					//$nota	=	printf("%d",$nota);
					//array_push($notas[$i][$j],$nota[$i]);
					//printf("%d",$nota);
					$notas[$i][$j]=array("nota"			=> 	$nota,
										 "cedula"		=> 	$alumnoCi,
										 "apellido"		=>	$apellido,
										 "sApellido"	=>	$sApellido,
										 "nombre"		=>	$nombre,
										 "sNombre"		=>	$sNombre,
										 "codExa"		=>	$codExa);
					$j++;
				}
				
				
			}else{
				return 0;
			}
			
		}
		return $notas;
		
	}
	
	public function showTipoExamen(){
		$select	=	parent::query("select * from tipoexamen;");
		
		$dato	=	array();
		
		while ($row	=	$select->fetch_array()){
			
			$dato[]	=	array("codigo"		=>	$row["codigo"],
							  "descripcion"	=>	$row["descripcion"]
							 );
		}
		
		return $dato;
	}
	
	public function selectTipoExamen($docente,$semestre,$materia,$seccion,$tipoExamen){
		$select	=	parent::prepare("SELECT 
						examen.codigo, examen.fecha
					FROM
						examen
					WHERE
						examen.semestre_docente_cedula = ?
							AND semestre_periodo_codigo = ?
							AND examen.semestre_asignatura_codigo = ?
							AND examen.semestre_seccion_codigo = ?
									AND examen.tipoExamen_codigo = ?");
		
		$select->bind_param("siiii",$docente,$semestre,$materia,$seccion,$tipoExamen);
		$data	=	array();
		if ($select->execute()){
			$select->bind_result($codigo,$fecha);
			while ($row	=	$select->fetch()){
				$data[]	=	array("codigo"	=>	$codigo,
								  "fecha"	=>	$fecha
								 );
			}
		}else{
			return false;
		}
		
		return $data;
	}
	
	public function idExamens($semestre,$materia,$seccion,$docente){
		
		$select	=	parent::prepare("SELECT 
						examen.codigo,
						examen.semestre_docente_cedula
					FROM
						examen
					WHERE
						examen.semestre_asignatura_codigo = ?
							AND examen.semestre_seccion_codigo = ?
							AND examen.semestre_periodo_codigo = ?
							AND examen.semestre_docente_cedula = ?");
		
		$select->bind_param("iiis",$materia,$seccion,$semestre,$docente);
		
		$data	=	array();
		
		if ($select->execute()){
			
			$select->bind_result($codigo,$docente);
			
			while ($row	=	$select->fetch()){
				$data[]	=	array("codigo"	=>	$codigo,
								  "docente"	=>	$docente
								 );
			}
		}else{
			return 0;
		}
		
		return $data;

	}
	
	public function showNotaFinal($semestre,$materia,$seccion,$docente){
		$select	=	parent::prepare("SELECT 
						matricula.alumno_cedula,
						alumno.apellido,
						alumno.sApellido,
						matricula.notafinal
					FROM
						matricula
							INNER JOIN
						alumno ON matricula.alumno_cedula = alumno.cedula
					WHERE
						matricula.semestre_periodo_codigo = ?
							AND matricula.semestre_asignatura_codigo = ?
							AND matricula.semestre_seccion_codigo = ?
							AND matricula.semestre_docente_cedula = ?
					ORDER BY alumno.apellido ASC");
		
		$select->bind_param("iiis",$semestre,$materia,$seccion,$docente);
		$data	=	array();
		
		if ($select->execute()){
			$select->bind_result($cedula,$apellido,$sApellido,$notaFinal);
			
			while ($select->fetch()){
				$data[]	=	array("cedula"		=>	$cedula,
								  "apellido"	=>	$apellido,
								  "sApellido"	=>	$sApellido,
								  "notaFinal"	=>	$notaFinal
								 );
			}
		}
		
		return $data;
	}
	
	public function selectNota($idExamen){
		$select	=	parent::prepare("SELECT 
						matricula.alumno_cedula,
						alumno.apellido,
						alumno.nombre,
						alumno.correo,
						nota.nota
					FROM
						matricula
							INNER JOIN
						nota ON nota.matricula_alumno_cedula = matricula.alumno_cedula
							AND nota.matricula_semestre_asignatura_codigo = matricula.semestre_asignatura_codigo
							AND nota.matricula_semestre_seccion_codigo = matricula.semestre_seccion_codigo
							AND nota.matricula_semestre_docente_cedula = matricula.semestre_docente_cedula
							AND nota.matricula_semestre_periodo_codigo = matricula.semestre_periodo_codigo
							INNER JOIN
						alumno ON matricula.alumno_cedula = alumno.cedula
					WHERE
						nota.examen_codigo = ?
					ORDER BY alumno.apellido ASC");
		
		$select->bind_param("i",$idExamen);
		
		$data	=	array();
		if ($select->execute()){
			$select->bind_result($cedula,$apellido,$nombre,$correo,$nota);
			while ($select->fetch()){
				$data[]	=	array("cedula"	=>	$cedula,
								  "apellido"=>	$apellido,
								  "nombre"	=>	$nombre,
								  "correo"	=>	$correo,
								  "nota"	=>	$nota
								 );
			}
		}
		
		return $data;
	}
	
	
}//fin de la clase

//$bd =	new examenNota();

//print_r($bd->idExamens(1,1,1,"19910973"));

?>