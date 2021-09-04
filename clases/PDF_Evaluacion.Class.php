<?php

class PDF_Evaluacion extends fpdfhtmlHelper {

	function Header() {
		global $ds_motivo;
		global $ds_titulo;
		global $ds_director;

		global $year;
		global $cd_estado;
		global $tipo;
		$this->SetFont ( 'Arial', '', 11 );
		$this->SetY(2);
		if ($cd_estado!=8){
			$this->Cell ( 15, 10, "", '',0,'L');
				
			$this->Cell ( 170, 10, "Evaluación preliminar - Evaluación preliminar - Evaluación preliminar - Evaluación preliminar", '',0,'L');
				
		}
		$ppititulo = ($tipo==1)?' ':' PROMOCIONALES ';
		$tituloCabecera = "SISTEMA DE EVALUACION DE PROYECTOS".$ppititulo."DE INVESTIGACION  Y DESARROLLO ";
		$this->ln(7);
		$this->Cell ( 20, 10, "", '',0,'L');
		$this->MultiCell ( 160, 4, $tituloCabecera);
		//$this->Cell ( 160, 10, $tituloCabecera, '',0,'L');


		//$this->ln(4);
		$this->Cell ( 20, 10, "", '',0,'L');
		$this->Cell ( 160, 10, "ACREDITACION ".$year, '',0,'L');

		$this->ln(4);
		$this->Cell ( 20, 10, "", '',0,'L');
		$this->Cell ( 160, 10, "PLANILLA DE EVALUACION", '',0,'L');

		$this->Image('../img/unlp.jpg',12,12,15,15);
		$this->ln(13);
		$this->Proyecto($ds_titulo, $ds_director);
		$this->ln(10);
	}

	function Footer() {
		global $cd_estado;
		if ($cd_estado!=8){
			$this->SetFont ( 'Arial', '', 11 );
			$this->SetY(-15);
			$this->Cell ( 15, 10, "", '',0,'L');
				
			$this->Cell ( 170, 10, "Evaluación preliminar - Evaluación preliminar - Evaluación preliminar - Evaluación preliminar", '',0,'L');
		}
	}

	function Proyecto($ds_titulo, $ds_director) {
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 10 );
		$this->MultiCell( 190, 8, "Denominación del Proyecto: ".stripslashes($ds_titulo), 'LTBR');
		$this->ln(4);
		$this->Cell ( 190, 8, "Director del Proyecto: ".stripslashes($ds_director), 'LTBR',0,'L',1);

	}

	function Item($ds_item){
		//$this->ln(2);
		$this->SetFont ( 'Arial', '', 8 );
		$this->WriteHTML(stripslashes(str_replace('<img','<span', $ds_item)));
		//$this->ln(2);
	}

	function separarcant() {
		$this->SetFillColor(255,255,255);


		$this->cell ( 156, 2, "", 'TBR',0,'L',1);

		$this->SetFont ( 'Arial', '', 8 );
		$this->cell ( 10, 2, 'Cant.', 'LTBR',0,'R',1);


		$this->Cell ( 20, 2, '', 'LTBR',0,'C',1);
		$this->ln();
	}








	function separadorNegro($ds_texto1, $ds_texto2, $ds_texto3) {

		//	$this->SetTextColor(255,255,255);
		//$this->SetFillColor(175,175,175);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 40, 6, $ds_texto1,0,0,'C',1);
		$this->Cell ( 106, 6, $ds_texto2,0,0,'C',1);
		$this->Cell ( 44, 6, $ds_texto3,0,0,'C',1);
		$this->ln(6);
		//	$this->SetTextColor(0,0,0);
	}







	function firma2($ds_evaluador) {
		$this->ln(15);

		$this->SetFillColor(255,255,255);

		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 10, 8);
		$this->Cell ( 60, 8, '', 'B');
		$this->Cell ( 30, 8);
		$this->Cell ( 60, 8, $ds_evaluador, 'B', 0, 'C');
		$this->ln(8);
		$this->Cell ( 10, 8);
		$this->Cell ( 60, 8, 'Firma Evaluador', '', 0, 'C');
		$this->Cell ( 30, 8);
		$this->Cell ( 60, 8, 'Aclaración', '', 0, 'C');


	}





}
?>