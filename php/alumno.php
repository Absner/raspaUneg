<?php
include_once('conexion2.php');

class alumno extends conexion2{
    
	
	public function cargarAlumno($cedula,$nombres,$codMateria,$codSeccion,$semestre,$cedulaD){
		error_reporting(E_ALL & ~E_NOTICE);
		/* preparando la consulta Sql */
		$insert = parent::prepare("insert into alumno(cedula,nombre,sNombre,apellido,sApellido,correo) values(?,?,?,?,?,?)");
		
		$matricular	=	parent::prepare("insert into matricula (alumno_cedula,semestre_asignatura_codigo,semestre_seccion_codigo,semestre_docente_cedula,semestre_periodo_codigo) values (?,?,?,?,?)");
		
		$insert->bind_param("ssssss",$ci,$name,$sName,$apelli,$sApelli,$correo);
		$matricular->bind_param("siisi",$ci,$codMateria,$codSeccion,$cedulaD,$semestre);
		
		$i=0;
		while ( $i < count($cedula) ){
			
			/* separar nombres y apellidos*/
			list ($apellido,$nombre) = explode(",",$nombres[$i]);
			
			/* separar los apellidos*/
			list ($apell,$sApell,$aux) = explode(" ",$apellido);
			/* separar los nombres*/
			list ($nom,$sNom,$auxi) = explode(" ",substr($nombre,1));
			
			/* obteniendo los nombres y apellidos sepados finalmente */
			$a	=	$this->separacion($apell,$sApell,$aux);
			$n	=	$this->separacion($nom,$sNom,$auxi);
			
			/* cargando cada uno de los datos en las variables del bind param */
			$ci			=	$cedula[$i];
			$name		=	$n[0];
			$sName		=	$n[1];
			$apelli		=	$a[0];
			$sApelli	=	$a[1];
			$correo		=	null;
			
			
			$insert->execute();
			$matricular->execute();
			
			$i++;
		}
		$insert->close();
		return 1;
		
	}
	
	private function separacion($apell,$sApell,$aux){
		
		$datos	=	array();
		if ($aux != null){
			echo strlen($aux);
			
			if (strlen($apell) <= 4){
				$primerApellido		=	$apell." ".$sApell;
				$segundoApellido	=	$aux;
			}
			if (strlen($sApell) <= 4){
				$primerApellido		=	$apell;
				$segundoApellido	=	$sApell." ".$aux;
			}
		}else{
			$primerApellido		=	$apell;
			$segundoApellido	=	$sApell;
		}
		array_push($datos,$primerApellido,$segundoApellido);
		return $datos;
	}
	
	public function showAlumno(){
		$show	=	parent::query("select * from alumno order by apellido asc;");
		$data	=	array();
		
		while ($row	=	$show->fetch_array()){

				$data[]	=	array('cedula'		=>	$row["cedula"], 
								  'nombre'		=>	$row["nombre"],
								  'sNombre'		=>	$row["sNombre"],
								  'apellido'	=>	$row["apellido"],
								  'sApellido'	=>	$row["sApellido"],
								  'correo'		=>	$row["correo"]);

			
		}
		return $data;
	}
	
	public function updateCorreos($correoP,$correoO){
		$header		= 	$this->headerCorreo($correoP);
		$apellido	= 	$this->apellidoCorreo($header);
		$cedula		= 	$this->digitosCedula($header);
		
		$update		=	parent::prepare("update alumno set alumno.correo = ? where substring(alumno.cedula,7)=? and alumno.apellido=?");
		
		$update->bind_param("sss",$correo,$ci,$apel);
		$i=0;
		while ($i	<	count($cedula)){
			$correo	=	$correoP[$i];
			$ci		=	$cedula[$i];
			$apel	=	$apellido[$i];
			$update->execute();
			$i++;
		}
		
	}
	
	private function headerCorreo ($correoP){
		$i=0;
		$headerCorreo	= array();
		while ($i	<	count($correoP)){
			list($cabecera,$basura)	=	explode("@",$correoP[$i]);
			unset($basura);
			array_push($headerCorreo,$cabecera);
			$i++;
		}
		
		return $headerCorreo;
		
	}
	
	private function digitosCedula($headerCorreo){
		$i=0;
		$digitosCedula	=	array();
		while ($i	<	count($headerCorreo)){
			array_push($digitosCedula,substr($headerCorreo[$i],-3));
			$i++;
		}
		
		return $digitosCedula;
	}
	
	
	private function apellidoCorreo($headerCorreo){
		
		$i=0;
		$apellidos	=	array();
		while ($i	<	count($headerCorreo)){
			
			array_push($apellidos,(substr(trim(substr($headerCorreo[$i],1),"_"),0,-3)));
			$i++;
			
		}
		return $apellidos;
	}
	
	public function dataAlumno($cedula){
		
		$select	=	parent::prepare("SELECT 
					alumno.cedula,
					alumno.nombre,
					alumno.sNombre,
					alumno.apellido,
					alumno.sApellido,
					alumno.correo
				FROM
					alumno
				WHERE
					alumno.cedula = ?");
		
		$select->bind_param("s",$cedula);
		
		$data	=	array();
		
		if ($select->execute()){
			$select->bind_result($cedula,$nombre,$sNombre,$apellido,$sApellido,$correo);
			
			while ($row	=	$select->fetch()){
				$data[]	=	array("cedula"		=>	$cedula,
								  "nombre"		=>	$nombre,
								  "sNombre"		=>	$sNombre,
								  "apellido"	=>	$apellido,
								  "sApellido"	=>	$sApellido,
								  "correo"		=>	$correo
								 );
			}
		}else{
			return 0;
		}
		
		return $data;
		
	}
	
	public function	updateAlumno($cedula,$nombre,$sNombre,$apellido,$sApellido,$correo,$origenCedula){
		
		$update	=	parent::prepare("update alumno set 
						alumno.cedula=?,
						alumno.nombre=?,
						alumno.sNombre=?,
						alumno.apellido=?,
						alumno.sApellido=?,
						alumno.correo=?
					WHERE alumno.cedula=?");
		
		$update->bind_param("sssssss",$cedula,$nombre,$sNombre,$apellido,$sApellido,$correo,$origenCedula);
		
		if ($update->execute()){
			return 1;
		}else{
			return 0;
		}
	}
	
	public function cargaManualAlumno($semestre,$materia,$seccion,$docente,$numAlumno,$data){
		
		$insertAlumnos	=	parent::prepare("insert into alumno(cedula,nombre,sNombre,apellido,sApellido,correo) values(?,?,?,?,?,?)");
		
		$insertMatricula=	parent::prepare("insert into matricula (alumno_cedula,semestre_asignatura_codigo,semestre_seccion_codigo,semestre_docente_cedula,semestre_periodo_codigo) values (?,?,?,?,?)");
		
		$insertAlumnos->bind_param('ssssss',$cedula,$nombre,$sNombre,$apellido,$sApellido,$correo);
		$insertMatricula->bind_param("siisi",$cedula,$materia,$seccion,$docente,$semestre);
		
		$ban=1;
		for ($i=0;	$i	<	count($data);	$i++){
			$cedula		=	$data[$i]["cedula"];
			$nombre		=	$data[$i]["nombre"];
			$sNombre	=	$data[$i]["sNombre"];
			$apellido	=	$data[$i]["apellido"];
			$sApellido	=	$data[$i]["sApellido"];
			$correo		=	$data[$i]["correo"];
			
			$insertAlumnos->execute();
			$insertMatricula->execute();
		}
			
	
	}
	
	public function cargarAlumnoNota($idEx,$semestre,$materia,$seccion,$docente,$data){
		$insert	=	parent::prepare("insert into nota(
						nota.examen_codigo,
						nota.matricula_alumno_cedula,
						nota.matricula_semestre_asignatura_codigo,
						nota.matricula_semestre_seccion_codigo,
						nota.matricula_semestre_docente_cedula,
						nota.matricula_semestre_periodo_codigo)
						VALUES (?,?,?,?,?,?)");
		
		$insert->bind_param("isiisi",$examenId,$cedula,$materia,$seccion,$docente,$semestre);
		
		$i=0; $ban=true;
		while ($i	<	count($data)){
			for ($j=0; $j	<	count($idEx); $j++){
				
				$cedula		=	$data[$i]["cedula"];
				$examenId	=	$idEx[$j]["codigo"];
				//$insert->execute();
				
				if ($insert->execute()){
					$ban =true;
				}else{
					$ban= false;
				}
				
			}
			$i++;
		}
		
		return $ban;
	}
	
	
	

	
	
    
}//fin de la clase

?>


