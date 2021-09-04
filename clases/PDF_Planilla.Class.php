<?php

class PDF_Planilla extends fpdfhtmlHelper {

	function Header() {
		global $ds_titulo;
		global $ds_facultad;
		global $year;
		$this->SetY(3);
		$this->SetFont ( 'Arial', 'B', 8 );
		$this->SetFillColor(0,0,0);
		$this->SetTextColor(255,255,255);
		$this->Cell ( 130, 6, 'UNLP - ACREDITACION '.$year.' - Control Admisibilidad', '',0,'L',1);
		$this->Cell ( 140, 6, 'FACULTAD: '.$ds_facultad, '',0,'R',1);
		
		$this->SetTextColor(0,0,0);
		$this->SetFillColor(255,255,255);
		$this->ln(8);
	
		$this->SetFont ( 'Arial', 'B', 10 );		
		
		$this->Cell ( 65, 4, "DENOMINACION DEL PROYECTO: ");
		$this->SetFont ( 'Arial', '', 10 );
		$this->MultiCell( 205, 4, $ds_titulo,'LRTB');
		
	}
	
	function cabecera($ds_unidad, $ds_duracion){
		$this->ln(8);
	
		$this->SetFont ( 'Arial', 'B', 10 );		
		
		$this->Cell ( 65, 4, "LUGAR DE EJECUCION: ");
		$this->SetFont ( 'Arial', '', 10 );
		$this->MultiCell( 205, 4, $ds_unidad,'LRTB');
		
		$this->ln(4);
	
		$this->SetFont ( 'Arial', 'B', 10 );		
		$this->Cell ( 15, 8, "AVAL: ");
		
		$this->Cell( 15, 8, '','LRTB');
		$this->Cell( 10, 8, '','');
		
		$this->Cell ( 20, 8, "RESUMEN: ");
		
		$this->Cell( 15, 8, '','LRTB');
		$this->Cell( 10, 8, '','');
		
		$this->Cell ( 20, 8, "R. INGLES: ");
		
		$this->Cell( 15, 8, '','LRTB');
		$this->Cell( 10, 8, '','');
		$this->Cell ( 22, 8, "P. CLAVES: ");
		
		$this->Cell( 15, 8, '','LRTB');
		$this->Cell( 10, 8, '','');
		
		$this->Cell ( 22, 8, "V. DIGITAL: ");
		
		$this->Cell( 15, 8, '','LRTB');
		$this->Cell( 8, 8, '','');
		
		$this->Cell ( 22, 8, "DURACION: ");
		
		$this->Cell( 26, 8, $ds_duracion,'LRTB');
		$this->ln(8);
	}
	
	function integrante($integrantes,$cd_proyecto){
		$this->ln(8);
	
		$this->SetFont ( 'Arial', 'B', 10 );	
		$this->SetFillColor(0,0,0);
		$this->SetTextColor(255,255,255);
		$this->Cell ( 270, 6, $integrantes[0]['ds_tipoinvestigador'], '',0,'L',1);
		
		$this->ln(8);
		$this->SetTextColor(0,0,0);
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'times', 'B', 10 );
		$this->SetWidths(array(32, 17, 30, 20, 45, 40, 40,12,25,8));
		$this->SetAligns(array('C', 'C','C','C','C','C','C','C','C','C'));
		$this->row(array('Apellido y Nombre','Categoría','Cargo','Dedicación','U. Académica','Cargo CIC CONICET', 'Lugar Trabajo UNLP', 'Horas','Proyectos','CV'));
		$this->SetFont ( 'times', '', 8 );
		$this->SetAligns(array('L', 'L','L','L','L','L','L','L','L'));
		$countp = count ( $integrantes );
		for($j = 0; $j < $countp; $j ++) {
			$oDocente = new Docente ( );
			$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
			DocenteQuery::getDocentePorid ( $oDocente );
			
			$oUnidad = new Unidad();
			$oUnidad->setCd_unidad($oDocente->getCd_unidad());
			UnidadQuery::getUnidadPorId($oUnidad);
			$ds_unidad = ($oUnidad->getDs_sigla())?trim($oUnidad->getDs_unidad()).' ('.trim($oUnidad->getDs_sigla()).')':trim($oUnidad->getDs_unidad());
			
			$proyectos = ProyectoQuery::getProyectosDocentes($oDocente->getCd_docente() );
			$count = count ( $proyectos );
			$ds_proyectos='';
			for($i = 0; $i < $count; $i ++) {
				if (($proyectos[$i]['cd_proyecto']!=$cd_proyecto)&&($proyectos[$i]['cd_tipoinvestigador']!=6)) {
					$ds_proyectos .=$proyectos[$i]['ds_codigo'].' ('.$proyectos[$i]['ds_director'].') - ';
				}
			}
			$ds_proyectos = substr($ds_proyectos,0,strlen($ds_proyectos)-3);
			$this->row(array($oDocente->getDs_apellido().', '.$oDocente->getDs_nombre(),$oDocente->getDs_categoria(),$oDocente->getDs_cargo(),$oDocente->getDs_deddoc(),$oDocente->getDs_facultad(),$oDocente->getDs_carrerainv().' - '.$oDocente->getDs_organismo(),$ds_unidad,$integrantes [$j]['nu_horasinv'],$ds_proyectos,''));
		}
	}
	
	function Footer() {
		
	}

	





}
?>