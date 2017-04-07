<?php
require ('../bower_components/Fpdf/fpdf.php');

class pdf extends fpdf{
	
	private $docente	=	null;
	private $materia	=	null;
	private $seccion	=	null;
	private $cantEval	=	null;
	private $nota		=	null;
	
	function __construct($tipoHoja){
		parent::__construct($tipoHoja);		
	}
	
	public function header(){
		$this->SetFont('times','',12);
		$this->Text(10,20,'UNIVERSIDAD NACIONAL EXPERIMENTAL DE GUAYANA.');
		$this->Text(10,26,utf8_decode('COORDINACIÓN DE INGENIERÍA EN INFORMÁTICA.'));
		$this->Text(10,32,utf8_decode('ASIGNATURA:'.' '.$this->materia));
		$this->Text(250,32,utf8_decode('SECCIÓN:'.' '.$this->seccion));
		$this->Text(10,38,utf8_decode('PROFESOR:'.' '.$this->docente));
		$this->Text(250,38,utf8_decode('COD:'));
		$this->Ln(50);
	}
	
	public function footer(){
		$this->SetY(-15);
    
		$this->SetFont('Arial','I',8);
	
		$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'R');
	}
	
	public function AcceptPageBreak(){
		$this->AddPage();
		$this->SetX(10);
		$this->Cell(10,7,utf8_decode('N°'),1,0,'C');
		$this->SetX(20);
		$this->Cell(30,7,utf8_decode('CÉDULA'),1,0,'C');
		$this->SetX(50);
		$this->Cell(90,7,utf8_decode('APELLIDOS Y NOMBRES'),1,0,'C');
		
		$setX=140;
		for ($i=0; $i < count($this->cantEval);$i++){
			$this->SetX($setX);
			$this->Cell(45,7,utf8_decode($this->cantEval[$i]["fecha"]),1,0,'C');
			$setX=$setX+45;
		}
		$this->Ln();
	}
	
	public function setMateria ($materia){
		$this->materia	=	strtoupper($materia);
	}
	
	public function setSeccion ($seccion){
		$this->seccion	=	$seccion;
	}
	
	public function setDocente ($docente){
		$this->docente	=	strtoupper($docente);
	}
	
	public function setCantEval($cant){
		$this->cantEval	=	$cant;
	}
}

?>

