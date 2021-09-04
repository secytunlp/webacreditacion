<?php

class PDF_Proyecto extends fpdfhtmlHelper {

	function Header() {
		global $cd_estado;

		if ($cd_estado==1){
			$this->SetY(0);
			$this->SetFont ( 'Arial', '', 10 );
				
			$this->Cell ( 185, 10, "Impresi�n preliminar - Impresi�n preliminar - Impresi�n preliminar - Impresi�n preliminar - Impresi�n preliminar", '',0,'L');
			$this->ln(20);
			$this->Image('../img/image002.gif',10,7,185,15);
				
		}
		else{
			$this->ln(15);
			$this->Image('../img/image002.gif',10,5,185,15);
		}

	}

	function Footer() {
		global $cd_estado;
		$this->SetY(-15);
		if ($cd_estado==1){
			$this->SetFont ( 'Arial', '', 10 );
				
			//	$this->Cell ( 15, 10, "", '',0,'L');
			$this->Cell ( 185, 10, "Impresi�n preliminar - Impresi�n preliminar - Impresi�n preliminar - Impresi�n preliminar - Impresi�n preliminar", '',0,'L');
		}
		$this->SetFont('Arial','I',8);

		$this->Cell(0,10,'P�gina '.$this->PageNo().' de {nb}',0,0,'C');
	}

	function Director($ds_investigador, $nu_cuil, $ds_categoria, $ds_cargo, $ds_deddoc, $ds_facultad, $ds_universidad, $ds_carrinv, $ds_organismo, $ds_unidad, $ds_titulogrado, $ds_titulopost, $ds_calle, $nu_nro, $nu_piso, $ds_depto, $nu_telefono, $ds_localidad, $ds_provincia, $nu_cp, $ds_mail, $reducido, $dt_cargo='') {

		$this->SetFont ( 'times', '', 12 );
		$this->Cell ( 125, 8, "Apellido y Nombres: ".stripslashes($ds_investigador));
		if (!$reducido){
			$this->ln(6);
			$this->Cell ( 90, 8, "C.U.I.L.: ".stripslashes($nu_cuil));
			$this->Cell ( 95, 8, "Tel�fono: ".stripslashes($nu_telefono));
			$this->ln(7);
			$this->MultiCell ( 185, 6, "Domicilio Part.: ".stripslashes($ds_calle)." ".stripslashes($nu_nro)." ".stripslashes($nu_piso)." ".stripslashes($ds_depto));
			$this->Cell ( 90, 8, "Localidad: ".stripslashes($ds_localidad));
			$this->Cell ( 50, 8, "Pcia.: ".stripslashes($ds_provincia));
			$this->Cell ( 30, 8, "C.P.: ".stripslashes($nu_cp));
			$this->ln(6);
			$this->Cell ( 185, 8, "E-mail: ".stripslashes($ds_mail));
			$this->ln(6);
			$this->Cell ( 185, 8, "Categor�a de Docente Investigador: ".stripslashes($ds_categoria));
			$this->ln(6);
			$this->Cell ( 90, 8, "Cargo docente: ".stripslashes($ds_cargo));
			if ($dt_cargo!='') {
				$this->Cell ( 40, 8, "Obtenci�n: ".stripslashes(FuncionesComunes::fechaMysqlaPHP($dt_cargo)));
				$this->Cell ( 45, 8, "Dedicaci�n: ".stripslashes($ds_deddoc));
			}
			else $this->Cell ( 95, 8, "Dedicaci�n: ".stripslashes($ds_deddoc));
			$this->ln(6);
			$this->Cell ( 185, 8, "Unidad Acad�mica: ".stripslashes($ds_facultad));
			$this->ln(6);
			$this->Cell ( 185, 8, "Universidad: ".stripslashes($ds_universidad));
			$this->ln(7);
			$this->MultiCell ( 185, 6, "Cargo en la Carrera del Investigador (CIC - CONICET): ".stripslashes($ds_carrinv)." - ".stripslashes($ds_organismo));
			//$this->ln(4);
			$this->MultiCell ( 185, 6, "Lugar de trabajo: ".stripslashes($ds_unidad));
			$this->MultiCell ( 185, 6, "T�tulo de grado: ".stripslashes($ds_titulogrado));
			$this->MultiCell ( 185, 6, "T�tulo de posgrado: ".stripslashes($ds_titulopost));
		}
		else
			$this->Cell ( 60, 8, "Firma: ______________________");
		$this->ln(10);
	}

	function Unidad($ds_facultad, $ds_unidad, $ds_direccion, $nu_telefono, $ds_mail, $reducido){
		$this->ln(2);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 55, 8, "1.2 UNIDAD ACADEMICA: ");
		$this->SetFont ( 'times', '', 12 );
		$this->Cell ( 130, 8, stripslashes($ds_facultad));
		$this->ln(7);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 50, 8, "UNIDAD EJECUTORA: ");
		$this->SetFont ( 'times', '', 12 );
		$this->MultiCell ( 135, 6, stripslashes($ds_unidad));

		$this->Cell ( 120, 8, "Direcci�n: ".stripslashes($ds_direccion));
		$this->Cell ( 50, 8, "Tel/Fax: ".stripslashes($nu_telefono));

		$this->ln(6);
		$this->Cell ( 130, 8, "E-mail: ".stripslashes($ds_mail));
		if($reducido){
			$this->ln(5);
			$this->SetFont ( 'times', '', 12 );
				
			$this->Cell ( 10, 8);
			$this->Cell ( 60, 8, '', 'B');
				
			$this->Cell ( 30, 8);
			$this->Cell ( 60, 8, '', 'B');
			$this->ln(8);
			$this->Cell ( 10, 8);
			$this->Cell ( 60, 8, 'Firma del Director o Responsable de la U.E.', '', 0, 'C');
			$this->Cell ( 30, 8);
			$this->Cell ( 60, 8, 'Aclaraci�n y Cargo', '', 0, 'C');
		}
		$this->ln(5);


	}

	function Titulo($ds_titulo){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "1.3 DENOMINACION DEL PROYECTO: ");
		$this->SetFont ( 'times', '', 12 );
		$this->ln(7);
		$this->MultiCell ( 185, 6, stripslashes($ds_titulo));
		$this->ln(4);
	}

	function Resumen($ds_resumen, $ds_resumeneng){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "1.4 RESUMEN TECNICO: ");
		$this->SetFont ( 'times', '', 12 );
		$this->ln(7);
		$this->MultiCell ( 185, 6, stripslashes($ds_resumen));
		$this->ln(4);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "RESUMEN TECNICO EN INGLES: ");
		$this->SetFont ( 'times', '', 12 );
		$this->ln(7);
		$this->MultiCell ( 185, 6, stripslashes($ds_resumeneng));
		$this->ln(4);
	}

	function Claves($ds_clave1,$ds_clave2,$ds_clave3,$ds_clave4,$ds_clave5,$ds_clave6,$ds_claveeng1,$ds_claveeng2,$ds_claveeng3,$ds_claveeng4,$ds_claveeng5,$ds_claveeng6){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "1.5 PALABRAS CLAVES: ");
		$this->SetFont ( 'times', '', 12 );
		$ds_clave = $ds_clave1;
		$ds_clave .= ($ds_clave2)?', '.$ds_clave2:'';
		$ds_clave .= ($ds_clave3)?', '.$ds_clave3:'';
		$ds_clave .= ($ds_clave4)?', '.$ds_clave4:'';
		$ds_clave .= ($ds_clave5)?', '.$ds_clave5:'';
		$ds_clave .= ($ds_clave6)?', '.$ds_clave6:'';
		$this->ln(7);
		$this->MultiCell ( 185, 6, stripslashes($ds_clave));
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "KEY WORDS: ");
		$this->SetFont ( 'times', '', 12 );
		$ds_clave = $ds_claveeng1;
		$ds_clave .= ($ds_claveeng2)?', '.$ds_claveeng2:'';
		$ds_clave .= ($ds_claveeng3)?', '.$ds_claveeng3:'';
		$ds_clave .= ($ds_claveeng4)?', '.$ds_claveeng4:'';
		$ds_clave .= ($ds_claveeng5)?', '.$ds_claveeng5:'';
		$ds_clave .= ($ds_claveeng6)?', '.$ds_claveeng6:'';
		$this->ln(7);
		$this->MultiCell ( 185, 6, stripslashes($ds_clave));
		//$this->ln(4);
	}

	function Duracion($ds_duracion){
		//$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 70, 8, "1.6 DURACION DEL PROYECTO: ");
		$this->SetFont ( 'times', '', 12 );
		$this->Cell ( 115, 8, stripslashes($ds_duracion));
		$this->ln(8);
	}

	function Caracteristicas($ds_tipo, $ds_codigodisciplina, $ds_disciplina, $ds_codigoespecialidad, $ds_especialidad, $ds_codigocampo, $ds_campo, $ds_linea) {

		$this->SetFont ( 'times', '', 12 );
		$this->Cell ( 185, 8, "Tipo de Investigaci�n: ".stripslashes($ds_tipo));

		$this->ln(7);
		$this->MultiCell ( 185, 6, "Area: ".stripslashes($ds_codigodisciplina)." - ".stripslashes($ds_disciplina));
		$this->MultiCell ( 185, 6, "Disciplina: ".stripslashes($ds_codigoespecialidad)." - ".stripslashes($ds_especialidad));
		$this->MultiCell ( 185, 6, "Campo de Aplicaci�n: ".stripslashes($ds_codigocampo)." - ".stripslashes($ds_campo));
		$this->MultiCell ( 185, 6, "L�nea de Investigaci�n: ".stripslashes($ds_linea));
		$this->ln(10);
	}

	function Transferencia($ds_transferencia){
		//$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 110, 8, "1.8 TRANSFERENCIA DE RESULTADOS PREVISTA: ");
		$this->SetFont ( 'times', '', 12 );
		$this->Cell ( 75, 8, stripslashes($ds_transferencia));
		$this->ln(8);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "1.9 COMPROMISO DE COMUNICAR RESULTADOS PARA SU PROTECCION: ");
		$this->ln(8);
		$this->SetFont ( 'times', '', 12 );
		$this->MultiCell ( 185, 6, "Por la presente tomo conocimiento del Art. 11 Ord. 275/07 HCS. UNLP. (Informaci�n sobre los resultados de las investigaciones susceptibles de ser protegidas por los sistemas de propiedad intelectual)");
	}

	function Descripcion($ds_titulo){
		//$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 75, 8, "2. DESCRIPCION DEL PROYECTO: ");
		/*$this->SetFont ( 'times', '', 12 );
		 $this->Cell ( 110, 8, 'Desarrollar seg�n el esquema siguiente:');*/
		$this->ln(8);
		$this->SetFont ( 'times', 'B', 12 );
		$this->MultiCell ( 185, 6, "2.1 Denominaci�n: ".stripslashes($ds_titulo));

	}

	function Marco($ds_marco){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "2.2 Marco te�rico o estado actual del tema: ");
		$this->SetFont ( 'times', '', 12 );
		$this->ln(7);
		$this->WriteHTML(stripslashes( $ds_marco));
		$this->ln(4);
	}

	function AntecedentesDir($ds_antecedentes){
		//$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "Descripci�n de la actividad cient�fica, tecnol�gica y/o art�stica significativa y continua en los �ltimos 5 a�os");
		$this->ln(5);
		$this->Cell ( 185, 8, "Detallar los proyectos acreditados en los cuales ha participado, indicando t�tulo, director y per�odo de ejec.");
		
		$this->SetFont ( 'times', '', 12 );
		$this->ln(7);
		$this->WriteHTML(stripslashes( $ds_antecedentes));
		$this->ln(4);
	}
	
	function AntecedentesPPIDDir($ds_antecedentes,$ds_codigo,$ds_titulo,$ds_tipoinvestigador,$dt_ini, $dt_fin){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->MultiCell ( 185, 6, "Detalle de la labor realizada, metas alcanzadas y resultados obtenidos del Proyecto ".$ds_codigo.' '.$ds_titulo.' ('.FuncionesComunes::fechaMysqlaPHP($dt_ini).' - '.FuncionesComunes::fechaMysqlaPHP($dt_fin).') del cual fue '.$ds_tipoinvestigador);
		$this->SetFont ( 'times', '', 12 );
		//$this->ln(7);
		$this->WriteHTML(stripslashes( $ds_antecedentes));
		$this->ln(4);
	}

	function Aporte($ds_aporte){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "2.3 Aporte original al tema: ");
		$this->SetFont ( 'times', '', 12 );
		$this->ln(7);
		$this->WriteHTML(stripslashes( $ds_aporte));
		$this->ln(4);
	}

	function Objetivos($ds_objetivos){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "2.4 Objetivos: ");
		$this->SetFont ( 'times', '', 12 );
		$this->ln(7);
		$this->WriteHTML(stripslashes( $ds_objetivos));
		$this->ln(4);
	}

	function Metodologia($ds_metodologia){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "2.5 Metodolog�a: ");
		$this->SetFont ( 'times', '', 12 );
		$this->ln(7);
		$this->WriteHTML(stripslashes( $ds_metodologia));
		$this->ln(4);
	}

	function Metas($ds_metas){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "2.6 Metas / Resultado  esperados en el desarrollo del proyecto: ");
		$this->SetFont ( 'times', '', 12 );
		$this->ln(7);
		$this->WriteHTML(stripslashes( $ds_metas));
		$this->ln(4);
	}

	function Antecedentes($ds_antecedentes){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "3. ANTECEDENTES: ");
		$this->SetFont ( 'times', '', 12 );
		$this->ln(7);
		$this->WriteHTML(stripslashes( $ds_antecedentes));
		$this->ln(4);
	}

	function Avance($ds_avance){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "4.1 Contribuci�n al avance del conocimiento cient�fico y/o tecnol�gico y/o creativo: ");
		$this->SetFont ( 'times', '', 12 );
		$this->ln(7);
		$this->WriteHTML(stripslashes( $ds_avance));
		$this->ln(4);
	}

	function Formacion($ds_formacion){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "4.2 Contribuci�n a la formaci�n de recursos humanos: ");
		$this->SetFont ( 'times', '', 12 );
		$this->ln(7);
		$this->WriteHTML(stripslashes( $ds_formacion));
		$this->ln(4);
	}

	function Resultados($ds_transferencia){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "4.3 Transferencia prevista de los resultados, aplicaciones o conocimientos derivados del proyecto: ");
		$this->SetFont ( 'times', '', 12 );
		$this->ln(7);
		$this->WriteHTML(stripslashes( $ds_transferencia));
		$this->ln(4);
	}

	function Plan($ds_plan){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "5. PLAN DE TRABAJO: ");
		$this->SetFont ( 'times', '', 12 );
		$this->ln(7);
		$this->WriteHTML(stripslashes( $ds_plan));
		$this->ln(4);
	}

	function Cronograma($ds_cronograma){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "CRONOGRAMA: ");
		$this->SetFont ( 'times', '', 12 );
		$this->ln(7);
		$this->WriteHTML(stripslashes( $ds_cronograma));
		$this->ln(4);
	}

	function Integrante($ds_investigador, $nu_cuil, $ds_categoria, $ds_cargo, $ds_deddoc, $ds_facultad, $ds_universidad, $ds_carrinv, $ds_organismo, $ds_unidad, $ds_titulogrado, $ds_titulopost, $ds_tipobeca, $ds_orgbeca, $proyectos, $reducido) {

		$this->SetFont ( 'times', '', 12 );
		$this->Cell ( 125, 8, "Apellido y Nombres: ".stripslashes($ds_investigador));
		if (!$reducido){
			$this->ln(6);
			$this->Cell ( 90, 8, "C.U.I.L.: ".stripslashes($nu_cuil));
				
			$this->ln(6);
			$this->Cell ( 185, 8, "Categor�a de Docente Investigador: ".stripslashes($ds_categoria));
			$this->ln(6);
			$this->Cell ( 90, 8, "Cargo docente: ".stripslashes($ds_cargo));
			$this->Cell ( 95, 8, "Dedicaci�n: ".stripslashes($ds_deddoc));
			$this->ln(6);
			$this->Cell ( 185, 8, "Unidad Acad�mica: ".stripslashes($ds_facultad));
			$this->ln(6);
			$this->Cell ( 185, 8, "Universidad: ".stripslashes($ds_universidad));
			$this->ln(7);
			$this->MultiCell ( 185, 6, "Cargo en la Carrera del Investigador (CIC - CONICET): ".stripslashes($ds_carrinv)." - ".stripslashes($ds_organismo));
			//$this->ln(4);
			$this->MultiCell ( 185, 6, "Lugar de trabajo: ".stripslashes($ds_unidad));
			$this->MultiCell ( 185, 6, "Becario (Tipo de Beca, Instituci�n): ".stripslashes($ds_tipobeca)." - ".stripslashes($ds_orgbeca));
			$this->MultiCell ( 185, 6, "T�tulo de grado: ".stripslashes($ds_titulogrado));
			$this->MultiCell ( 185, 6, "T�tulo de postgrado: ".stripslashes($ds_titulopost));
			$this->MultiCell ( 185, 6, "Participaci�n en proyectos: ");
			$this->SetFont ( 'times', 'B', 10 );
			$this->SetWidths(array(15, 75, 40, 20, 25, 15));
			$this->SetAligns(array('C', 'C','C','C','C','C'));
			$this->row(array('C�digo','T�tulo','Director','Tipo','Per�odo','Hs. x Sem.'));
			$this->SetFont ( 'times', '', 8 );
			$this->SetAligns(array('L', 'L','L','L','L','C'));
			$count = count ( $proyectos );
			for($i = 0; $i < $count; $i ++) {
				$this->row(array($proyectos[$i]['ds_codigo'],$proyectos[$i]['ds_titulo'],$proyectos[$i]['ds_director'],$proyectos[$i]['ds_tipoinvestigador'],FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini']).' - '.FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin']),$proyectos[$i]['nu_horasinv']));
			}
			$this->SetFont ( 'times', '', 12 );
		}
		else
			$this->Cell ( 60, 8, "Firma: ______________________");
		$this->ln(10);
	}
	function ProyectoPPID($proyectos){
		$count = count ( $proyectos );
		if ($count){
			$this->ln(10);
			$this->MultiCell ( 185, 6, "Participaci�n en proyecto de incentivos:");
			$this->SetFont ( 'times', 'B', 10 );
			$this->SetWidths(array(15, 75, 40, 20, 25, 15));
			$this->SetAligns(array('C', 'C','C','C','C','C'));
			$this->row(array('C�digo','T�tulo','Director','Tipo','Per�odo','Hs. x Sem.'));
			$this->SetFont ( 'times', '', 8 );
			$this->SetAligns(array('L', 'L','L','L','L','C'));
			$count = count ( $proyectos );
			for($i = 0; $i < $count; $i ++) {
				$this->row(array($proyectos[$i]['ds_codigo'],$proyectos[$i]['ds_titulo'],$proyectos[$i]['ds_director'],$proyectos[$i]['ds_tipoinvestigador'],FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini']).' - '.FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin']),$proyectos[$i]['nu_horasinv']));
			}
			$this->ln(15);
				
			$this->SetFont ( 'times', '', 12 );
			$this->Cell ( 10, 8);
			$this->Cell ( 60, 8, '', 'B');
			$this->Cell ( 30, 8);
			$this->Cell ( 60, 8, '', 'B');
			$this->ln(8);
			$this->Cell ( 10, 8);
			$this->Cell ( 60, 8, 'Firma del Director del Proyecto', '', 0, 'C');
			$this->Cell ( 30, 8);
			$this->Cell ( 60, 8, 'Aclarac�on', '', 0, 'C');
		}
	}
	function Disponible($ds_disponible){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "7.1 Disponible: ");
		$this->SetFont ( 'times', '', 12 );
		$this->ln(7);
		$this->WriteHTML(stripslashes( $ds_disponible));
		$this->ln(4);
	}

	function Necesario($ds_necesario){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "7.2 Necesario: ");
		$this->SetFont ( 'times', '', 12 );
		$this->ln(7);
		$this->WriteHTML(stripslashes( $ds_necesario));
		$this->ln(4);
	}

	function Fuentes($ds_fuentes){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "7.3 Fuentes de informaci�n disponible y/o necesaria: ");
		$this->SetFont ( 'times', '', 12 );
		$this->ln(7);
		$this->WriteHTML(stripslashes( $ds_fuentes));
		$this->ln(4);
	}

	function Costo($nu_ano1,$nu_ano2,$nu_ano3,$nu_ano4,$nu_duracion){
		//$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "8.1 Costo m�nimo global necesario para llevar a cabo el proyecto : ");
		/*$this->SetFont ( 'times', '', 12 );
		 $this->Cell ( 110, 8, 'Desarrollar seg�n el esquema siguiente:');*/
		$this->ln(8);
		$this->SetFont ( 'times', '', 12 );
		$this->Cell(20,8,'');
		$this->Cell(40,8,'Primer a�o:');
		$this->Cell(125,8,FuncionesComunes::Format_toMoney($nu_ano1));
		$this->ln(6);
		$this->Cell(20,8,'');
		$this->Cell(40,8,'Segundo a�o:');
		$this->Cell(125,8,FuncionesComunes::Format_toMoney($nu_ano2));
		$this->ln(6);
		if($nu_duracion==4){
			$this->Cell(20,8,'');
			$this->Cell(40,8,'Tercer a�o:');
			$this->Cell(125,8,FuncionesComunes::Format_toMoney($nu_ano3));
			$this->ln(6);
			$this->Cell(20,8,'');
			$this->Cell(40,8,'Cuarto a�o:');
			$this->Cell(125,8,FuncionesComunes::Format_toMoney($nu_ano4));
			$this->ln(6);
		}
	}

	function Fondos($fondos){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "8.2 Fondos/Recursos disponibles: ");
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 10 );
		$this->SetWidths(array(30, 100, 55));
		$this->SetAligns(array('C', 'C','C'));
		$this->row(array('Monto','Fuente','Resoluci�n'));
		$this->SetAligns(array('L', 'L','L'));
		$this->SetFont ( 'times', '', 10 );
		$count = count ( $fondos );
		for($i = 0; $i < $count; $i ++) {
			$this->row(array(FuncionesComunes::Format_toMoney($fondos[$i]['nu_monto']),$fondos[$i]['ds_fuente'],$fondos[$i]['ds_resolucion']));
		}
		$this->SetFont ( 'times', '', 12 );
	}

	function Tramite($ds_fondotramite){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 8, "8.3 Fondos/Recursos en tr�mite: ");
		$this->SetFont ( 'times', '', 12 );
		$this->ln(7);
		$this->WriteHTML(stripslashes( $ds_fondotramite));
		$this->ln(4);
	}
	
	function Financiamientoanterior($financiamientoanterior){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$item=($year)?'8.5 ':'8.4';
		$this->MultiCell( 185, 4, "8.4 Financiamiento recibido en a�os anteriores para el tema propuesto: ");
		$this->SetFont ( 'times', '', 12 );
		$this->ln(1);
		$this->WriteHTML(stripslashes( $financiamientoanterior));
		$this->ln(4);
	}

	function Factibilidad($ds_factibilidad, $year=0){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$item=($year)?'8.5 ':'8.4';
		$this->MultiCell( 185, 4, $item." Explicitar la factibilidad del plan de trabajo propuesto con los recursos disponibles, en caso de no recibir financiamiento: ");
		$this->SetFont ( 'times', '', 12 );
		$this->ln(7);
		$this->WriteHTML(stripslashes( $ds_factibilidad));
		$this->ln(4);
	}

	function TituloEvaluadores($ds_titulo, $ds_director,$ds_directores, $ds_unidad, $ds_facultad, $ds_area, $ds_disciplina){
		$this->ln(15);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 185, 2, '','T');
		$this->ln(2);
		$this->Cell ( 55, 8, 'Denominaci�n del Proyecto: ');
		$this->SetFont ( 'times', '', 12 );
		$this->MultiCell( 130, 4, $ds_titulo);
		$this->Cell ( 185, 2, '','B');
		$this->ln(2);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 20, 8, 'Director: ');
		$this->SetFont ( 'times', '', 12 );
		$this->Cell ( 165, 8, $ds_director);
		$this->ln(8);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 30, 8, 'Codirector/es: ');
		$this->SetFont ( 'times', '', 12 );
		$this->Cell ( 155, 8, $ds_directores);
		$this->ln(8);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 40, 8, 'Unidad Ejecutora: ');
		$this->SetFont ( 'times', '', 12 );
		$this->MultiCell( 145, 4, $ds_unidad);
		$this->ln(2);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 40, 8, 'Unidad Acad�mica: ');
		$this->SetFont ( 'times', '', 12 );
		$this->Cell ( 145, 8, $ds_facultad);
		$this->ln(8);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 15, 8, 'Area: ');
		$this->SetFont ( 'times', '', 12 );
		$this->Cell ( 70, 8, $ds_area);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 25, 8, 'Disciplina: ');
		$this->SetFont ( 'times', '', 12 );
		$this->Cell ( 75, 8, $ds_disciplina);
		$this->ln(8);

	}

	function Evaluadores($proyectoevaluadors){
		$this->ln(5);
		$count = count ( $proyectoevaluadors );
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 35, 8, '1. Por excusaci�n ');
		$this->SetFont ( 'times', '', 12 );
		$this->MultiCell( 150, 4, '(Listar los nombres y apellidos de investigadores, que no deber�an evaluar el proyecto por haber colaborado estrechamente, durante los �ltimos cinco a�os, con los integrantes del mismo)');

		$ds_excusado='';
		for($i = 0; $i < $count; $i ++) {
				
			if ($proyectoevaluadors[$i]['cd_tipoevaluador']==1){

				$ds_excusado .= $proyectoevaluadors[$i]['ds_evaluador'].' - ';

			}
				
		}
		$this->ln(5);
		$ds_excusado = substr($ds_excusado,0,strlen($ds_excusado)-3);
		$this->MultiCell( 185, 4, $ds_excusado,'LBTR');
		$this->ln(5);
		$this->SetFont ( 'times', 'B', 12 );
		$this->Cell ( 35, 8, '2. Por recusaci�n ');
		$this->SetFont ( 'times', '', 12 );
		$this->MultiCell( 150, 4, '(Listar los nombres y apellidos de investigadores, que a criterio del titular del proyecto no deben ser convocados como evaluadores)');
		$ds_recusado='';
		for($i = 0; $i < $count; $i ++) {
			if ($proyectoevaluadors[$i]['cd_tipoevaluador']==2){
				$ds_recusado .= $proyectoevaluadors[$i]['ds_evaluador'].' - ';

			}
				
		}
		$this->ln(5);
		$ds_recusado = substr($ds_recusado,0,strlen($ds_recusado)-3);
		$this->MultiCell( 185, 4, $ds_recusado,'LBTR');
		$this->ln(10);
		$this->SetFont ( 'times', 'B', 12 );
		$this->MultiCell( 185, 4, 'Evaluadores a quienes se sugiere convocar para analizar el proyecto. (Listar  nombres y apellidos de investigadores externos a la UNLP)','T');
		$this->SetFont ( 'times', 'B', 10 );
		$this->ln(5);
		$this->SetWidths(array(50, 50, 35, 50));
		$this->SetAligns(array('C', 'C','C','C'));
		$this->row(array('Evaluador','Universidad','Disciplina','Datos'));
		$this->SetFont ( 'times', '', 10 );
		$this->SetAligns(array('L', 'L','L','L'));
		for($i = 0; $i < $count; $i ++) {
				
			if ($proyectoevaluadors[$i]['cd_tipoevaluador']==3){
				$oEvaluador = new Evaluador();
				$oEvaluador->setCd_evaluador($proyectoevaluadors[$i]['cd_evaluador']);
				EvaluadorQuery::getEvaluadorPorId($oEvaluador);
				$ds_direccion='';
				if (trim($oEvaluador->getDs_calle())!='') {
					$ds_direccion .= $oEvaluador->getDs_calle().' - ';
				}
				if (trim($oEvaluador->getNu_nro())!='') {
					$ds_direccion .= $oEvaluador->getNu_nro().' - ';
				}
				if (trim($oEvaluador->getNu_piso())!='') {
					$ds_direccion .= $oEvaluador->getNu_piso().' - ';
				}
				if (trim($oEvaluador->getDs_depto())!='') {
					$ds_direccion .= $oEvaluador->getDs_depto().' - ';
				}
				if (trim($oEvaluador->getDs_localidad())!='') {
					$ds_direccion .= $oEvaluador->getDs_localidad().' - ';
				}
				if (trim($oEvaluador->getNu_cp())!='') {
					$ds_direccion .= ' ('.$oEvaluador->getNu_cp().') - ';
				}
				if (trim($oEvaluador->getNu_telefono())!='') {
					$ds_direccion .= $oEvaluador->getNu_telefono();
				}


				$this->row(array($oEvaluador->getDs_evaluador(),$oEvaluador->getDs_universidad(),$oEvaluador->getDs_disciplina(),$oEvaluador->getDs_mail().' - '.$ds_direccion));
			}
				
		}
	}

	function Presupuesto($nu_consumo1,$nu_consumo2,$nu_consumo3,$nu_consumo4,$nu_servicios1,$nu_servicios2,$nu_servicios3,$nu_servicios4,$nu_bibliografia1,$nu_bibliografia2,$nu_bibliografia3,$nu_bibliografia4,$nu_cientifico1,$nu_cientifico2,$nu_cientifico3,$nu_cientifico4,$nu_computacion1,$nu_computacion2,$nu_computacion3,$nu_computacion4,$nu_otros1,$nu_otros2,$nu_otros3,$nu_otros4,$year,$nu_duracion){
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 12 );
		$titulo = ($year>2013)?"9. PRESUPUESTO ESTIMADO PRELIMINAR - UNLP: ":"9. PRESUPUESTO ESTIMADO PRELIMINAR (SUBSIDIO EROGACIONES CORRIENTES - UNLP): ";
		$titulo .= ($year>2013)?"
		Indicar el monto anual en pesos
		Los fondos que puedan asignarse al presente proyecto ser�n exclusivamente utilizados para su realizaci�n de acuerdo con los objetivos y el plan que constan en la presente solicitud.
		Una vez otorgado el subsidio se deber� respetar el porcentaje de los incisos solicitados. Podr�n transferirse entre incisos hasta un 15%.
		El concepto vi�ticos y pasajes no podr� superar el 30% del monto total otorgado al proyecto.":"";
		$this->MultiCell( 185, 4, $titulo);
		$this->ln(6);
		$this->SetFont ( 'times', 'B', 10 );
		if($nu_duracion==4){
			
			$this->SetWidths(array(85, 20, 20, 20, 20, 20));
			$this->SetAligns(array('C', 'C','C','C','C','C'));
			$this->row(array('','Importe '.$year,'Importe '.($year+1),'Importe '.($year+2),'Importe '.($year+3), 'Total'));
			$this->SetFont ( 'times', '', 10 );
			$this->SetAligns(array('L', 'R','R','R','R', 'R'));
			
			$titulo = ($year>2013)?"Inciso 2 - Bienes de consumo (papeler�a, insumos de computaci�n o laboratorio, etc.)":"Bienes de consumo";
			$this->row(array($titulo,FuncionesComunes::Format_toMoney($nu_consumo1),FuncionesComunes::Format_toMoney($nu_consumo2),FuncionesComunes::Format_toMoney($nu_consumo3),FuncionesComunes::Format_toMoney($nu_consumo4),FuncionesComunes::Format_toMoney($nu_consumo1+$nu_consumo2+$nu_consumo3+$nu_consumo4)));
			
			$this->row(array('Inciso 3 - Servicios no personales (vi�ticos, pasajes, etc.)',FuncionesComunes::Format_toMoney($nu_servicios1),FuncionesComunes::Format_toMoney($nu_servicios2),FuncionesComunes::Format_toMoney($nu_servicios3),FuncionesComunes::Format_toMoney($nu_servicios4),FuncionesComunes::Format_toMoney($nu_servicios1+$nu_servicios2+$nu_servicios3+$nu_servicios4)));
			$titulo = ($year>2013)?"Inciso 4 - Bienes de uso (equipamiento, bibliograf�a, etc.)":"Equipamiento y bibliograf�a";
			$this->row(array($titulo,FuncionesComunes::Format_toMoney($nu_bibliografia1),FuncionesComunes::Format_toMoney($nu_bibliografia2),FuncionesComunes::Format_toMoney($nu_bibliografia3),FuncionesComunes::Format_toMoney($nu_bibliografia4),FuncionesComunes::Format_toMoney($nu_bibliografia1+$nu_bibliografia2+$nu_bibliografia3+$nu_bibliografia4)));
			if ($year<=2013) {
				$this->row(array('Equipamiento cient�fico espec�ficos',FuncionesComunes::Format_toMoney($nu_cientifico1),FuncionesComunes::Format_toMoney($nu_cientifico2),FuncionesComunes::Format_toMoney($nu_cientifico3),FuncionesComunes::Format_toMoney($nu_cientifico4),FuncionesComunes::Format_toMoney($nu_cientifico1+$nu_cientifico2+$nu_cientifico3+$nu_cientifico4)));
			$this->row(array('Equipo de computaci�n',FuncionesComunes::Format_toMoney($nu_computacion1),FuncionesComunes::Format_toMoney($nu_computacion2),FuncionesComunes::Format_toMoney($nu_computacion3),FuncionesComunes::Format_toMoney($nu_computacion4),FuncionesComunes::Format_toMoney($nu_computacion1+$nu_computacion2+$nu_computacion3+$nu_computacion4)));
			$this->row(array('Otros',FuncionesComunes::Format_toMoney($nu_otros1),FuncionesComunes::Format_toMoney($nu_otros2),FuncionesComunes::Format_toMoney($nu_otros3),FuncionesComunes::Format_toMoney($nu_otros4),FuncionesComunes::Format_toMoney($nu_otros1+$nu_otros2+$nu_otros3+$nu_otros4)));
			}
			
			$this->SetFont ( 'times', 'B', 10 );
			$this->SetAligns(array('R', 'R','R','R','R','R'));
			$this->row(array('Totales',FuncionesComunes::Format_toMoney($nu_consumo1+$nu_servicios1+$nu_bibliografia1+$nu_cientifico1+$nu_computacion1+$nu_otros1),FuncionesComunes::Format_toMoney($nu_consumo2+$nu_servicios2+$nu_bibliografia2+$nu_cientifico2+$nu_computacion2+$nu_otros2),FuncionesComunes::Format_toMoney($nu_consumo3+$nu_servicios3+$nu_bibliografia3+$nu_cientifico3+$nu_computacion3+$nu_otros3),FuncionesComunes::Format_toMoney($nu_consumo4+$nu_servicios4+$nu_bibliografia4+$nu_cientifico4+$nu_computacion4+$nu_otros4),FuncionesComunes::Format_toMoney($nu_consumo1+$nu_servicios1+$nu_bibliografia1+$nu_cientifico1+$nu_computacion1+$nu_otros1+$nu_consumo2+$nu_servicios2+$nu_bibliografia2+$nu_cientifico2+$nu_computacion2+$nu_otros2+$nu_consumo3+$nu_servicios3+$nu_bibliografia3+$nu_cientifico3+$nu_computacion3+$nu_otros3+$nu_consumo4+$nu_servicios4+$nu_bibliografia4+$nu_cientifico4+$nu_computacion4+$nu_otros4)));
		}
		else{
			$this->SetWidths(array(105, 30, 30, 20));
			$this->SetAligns(array('C', 'C','C','C'));
			$this->row(array('','Importe '.$year,'Importe '.($year+1), 'Total'));
			$this->SetFont ( 'times', '', 10 );
			$this->SetAligns(array('L', 'R','R','R'));
			$titulo = ($year>2013)?"Inciso 2 - Bienes de consumo (papeler�a, insumos de computaci�n o laboratorio, etc.)":"Bienes de consumo";
			$this->row(array($titulo,FuncionesComunes::Format_toMoney($nu_consumo1),FuncionesComunes::Format_toMoney($nu_consumo2),FuncionesComunes::Format_toMoney($nu_consumo1+$nu_consumo2)));
			$this->row(array('Inciso 2 - Servicios no personales (vi�ticos, pasajes, etc.)',FuncionesComunes::Format_toMoney($nu_servicios1),FuncionesComunes::Format_toMoney($nu_servicios2),FuncionesComunes::Format_toMoney($nu_servicios1+$nu_servicios2)));
			$titulo = ($year>2013)?"Inciso 2 - Bienes de uso (equipamiento, bibliograf�a, etc.)":"Equipamiento y bibliograf�a";
			$this->row(array($titulo,FuncionesComunes::Format_toMoney($nu_bibliografia1),FuncionesComunes::Format_toMoney($nu_bibliografia2),FuncionesComunes::Format_toMoney($nu_bibliografia1+$nu_bibliografia2)));
			if ($year<=2013) {
				$this->row(array('Equipamiento cient�fico espec�ficos',FuncionesComunes::Format_toMoney($nu_cientifico1),FuncionesComunes::Format_toMoney($nu_cientifico2),FuncionesComunes::Format_toMoney($nu_cientifico1+$nu_cientifico2)));
				$this->row(array('Equipo de computaci�n',FuncionesComunes::Format_toMoney($nu_computacion1),FuncionesComunes::Format_toMoney($nu_computacion2),FuncionesComunes::Format_toMoney($nu_computacion1+$nu_computacion2)));
				$this->row(array('Otros',FuncionesComunes::Format_toMoney($nu_otros1),FuncionesComunes::Format_toMoney($nu_otros2),FuncionesComunes::Format_toMoney($nu_otros1+$nu_otros2)));
			}
			$this->SetFont ( 'times', 'B', 10 );
			$this->SetAligns(array('R', 'R','R'));
			$this->row(array('Totales',FuncionesComunes::Format_toMoney($nu_consumo1+$nu_servicios1+$nu_bibliografia1+$nu_cientifico1+$nu_computacion1+$nu_otros1),FuncionesComunes::Format_toMoney($nu_consumo2+$nu_servicios2+$nu_bibliografia2+$nu_cientifico2+$nu_computacion2+$nu_otros2),FuncionesComunes::Format_toMoney($nu_consumo1+$nu_servicios1+$nu_bibliografia1+$nu_cientifico1+$nu_computacion1+$nu_otros1+$nu_consumo2+$nu_servicios2+$nu_bibliografia2+$nu_cientifico2+$nu_computacion2+$nu_otros2)));
		}
		$this->SetFont ( 'times', '', 12 );
	}

	function separador() {
		$this->Cell(185,4,'','B');
		$this->ln(6);
	}


	function firma1($ds_facultad, $ds_publicar, $ds_notificacion) {
		$this->SetFont ( 'times', 'B', 12 );
		$this->MultiCell( 185, 4, "Autorizo a la U.N.L.P. a trav�s de Secretar�a de Ciencia y T�cnica a difundir los datos relativos al presente proyecto: ".$ds_publicar);
		if ($ds_notificacion) {
			$this->MultiCell( 185, 4, $ds_notificacion);
		}

		$this->separador();
		$this->MultiCell( 185, 4, "La informaci�n que detallo en esta solicitud es exacta y tiene car�cter de DECLARACION JURADA");
		$this->ln(15);
		$this->SetFont ( 'times', '', 12 );
		$this->Cell ( 10, 8);
		$this->Cell ( 60, 8, '', 'B');
		$this->Cell ( 30, 8);
		$this->Cell ( 60, 8, '', 'B');
		$this->ln(8);
		$this->Cell ( 10, 8);
		$this->Cell ( 60, 8, 'Fecha', '', 0, 'C');
		$this->Cell ( 30, 8);
		$this->Cell ( 60, 8, 'Firma del Director del Proyecto', '', 0, 'C');
		$this->ln(10);
		$this->separador();
		$this->SetFont ( 'times', 'B', 12 );
		$this->MultiCell( 185, 4, "10. AVAL DE ".$ds_facultad.": De ser acreditado el presente proyecto se deja constancia que esta Unidad Acad�mica otorga su conformidad para su realizaci�n en el �mbito de la misma");
		$this->ln(15);
		$this->SetFont ( 'times', '', 12 );
		$this->Cell ( 10, 8);
		$this->Cell ( 60, 8, '', 'B');
		$this->Cell ( 30, 8);
		$this->Cell ( 60, 8, '', 'B');
		$this->ln(8);
		$this->Cell ( 10, 8);
		$this->Cell ( 60, 8, 'Fecha', '', 0, 'C');
		$this->Cell ( 30, 8);
		$this->Cell ( 60, 8, 'Firma y sello', '', 0, 'C');
	}

	function firma2() {
		$this->ln(30);

		$this->SetFont ( 'times', '', 12 );
		$this->Cell ( 10, 8);
		$this->Cell ( 60, 8, '', 'B');
		$this->Cell ( 30, 8);
		$this->Cell ( 60, 8, '', 'B');
		$this->ln(8);
		$this->Cell ( 10, 8);
		$this->Cell ( 60, 8, 'Fecha', '', 0, 'C');
		$this->Cell ( 30, 8);
		$this->Cell ( 60, 8, 'Firma del Director del Proyecto', '', 0, 'C');


	}





}
?>