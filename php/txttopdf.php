<?php

/* PHP ERRORS */
ini_set('display_errors','On');
require_once 'fpdf/fpdf.php';



class PDF extends FPDF
{
	// Page header
	function Header()
	{
	    // Arial bold 15
	    $this->SetFont('Courier','B',17); //(familia, B:bold/I:italic/u:underline, tamaño)
	    // Move to the right
	    $this->Cell(80);
	    // Title
	    $this->Cell(30,10,'Listado de Noticias',0,0,'C');//(width, height, text, borde, line next, alineacion del texto, opcional: celdra transparent or not)
	    // Line break
	    $this->Ln(20);
	}

	// Page footer
	function Footer()
	{
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		
		//
		$x = $this->GetX();
		$y = $this->GetY();

		//letras del pide pagina
		$col1="UBICACION ".$GLOBALS['ubi'];
		$this->MultiCell(90, 10, $col1, 0,'C');
		$this->SetXY($x + 90, $y);
		$col2="Fecha  ".$GLOBALS['fecha'];
		$this->MultiCell(90, 10, $col2, 0,'C');
	}
}


if( isset($_POST['pdf']) ){
	
	$nombre_archivo = '/var/www/html/TFG/dump/downloadfile.pdf'; 
	$json = $_POST['pdf'];

	/*if(!file_exists($nombre_archivo)){	
		$fp = fopen($nombre_archivo,"w+");
	}else{
		$fp = fopen($nombre_archivo,"w");
	}*/

	// Instanciation of inherited class
	$pdf 	= new PDF();
	$ubi 	= $json[0]['UBICACION'];
	$fecha 	= $json[0]['FECHA'];
	
	foreach($json as $r){
		$pdf->AddPage();
		$pdf->SetFont('Helvetica','B',14);
		$col1="PERIODICO";
		$pdf->Cell(80, 10, $col1, 0);
		$pdf->Ln(10);
		$pdf->SetFont('Helvetica','',12);
		$col2=$r['PERIODICO'];
		$pdf->Cell(80, 10, $col2, 0);

		$pdf->Ln(20);//salto de 5 lineas

		$pdf->SetFont('Helvetica','B',14);
		$col3="TITULAR";
		$pdf->Cell(80, 10, $col3, 0);
		$pdf->Ln(10);
		$pdf->SetFont('Helvetica','',12);
		$col4=$r['TITULO'];
		$pdf->MultiCell(190, 7, $col4, 0);

		$pdf->Ln(20);//salto de 5 lineas

		$pdf->SetFont('Helvetica','B',14);
		$col5="DESCRIPCION";
		$pdf->Cell(80, 10, $col5, 0);
		$pdf->Ln(10);
		$pdf->SetFont('Helvetica','',12);
		$col6=$r['DESCRIPCION'];
		$pdf->MultiCell(190, 7, $col6, 0);

		$pdf->Ln(20);//salto de 5 lineas

		$pdf->SetFont('Helvetica','B',14);
		$col5="LINK";
		$pdf->Cell(80, 10, $col5, 0);
		$pdf->Ln(10);
		$pdf->SetFont('Helvetica','',12);
		$col6=$r['LINK'];
		$pdf->MultiCell(190, 7, $col6, 0);
	}	

	header("Content-type:application/pdf");
	header('Content-type: application/force-download');
	header('Content-Disposition: attachment; filename="downloadfile.pdf"');
	header('Content-Length: '.filesize('/var/www/html/TFG/dump/downloadfile.pdf'));

	$pdf->Output($nombre_archivo, 'F'); // Save file locally

}
?>
