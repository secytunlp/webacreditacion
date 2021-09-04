<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';
ini_set("memory_limit","400M");
set_time_limit(1200);
$enviar = (isset($_GET['enviar']))?1:0;
$funcion = ($enviar)?"Enviar proyecto":"Ver proyecto";
if (PermisoQuery::permisosDeUsuario( $cd_usuario, $funcion )) {
	$err=array();
	$item=0;
	$oProyecto = new Proyecto ( );
	$oProyecto->setCd_proyecto ($_GET ['cd_proyecto']);
	ProyectoQuery::getProyectoPorid ( $oProyecto );
	$ds_unidadproy = '';	
	$nivel=$oProyecto->getNu_nivelunidad();
	$html = array();
	$oUnidad = new Unidad();
	$oUnidad->setCd_unidad($oProyecto->getCd_unidad());
	
	
	while($nivel>0){
		UnidadQuery::getUnidadPorId($oUnidad);
		$ds_direccionunidad = $oUnidad->getDs_direccion();
		$nu_telefonounidad = $oUnidad->getDs_telefono();
		$ds_mailunidad = $oUnidad->getDs_telefono();
		$html[$nivel]=$oUnidad->getDs_unidad();
		
		$oUnidad->setCd_unidad($oUnidad->getCd_padre());
		$nivel--;
	}
	UnidadQuery::getUnidadPorId($oUnidad);
	$ds_direccionunidad = $oUnidad->getDs_direccion();
	$nu_telefonounidad = $oUnidad->getDs_telefono();
	$ds_mailunidad = $oUnidad->getDs_telefono();
	$html[$nivel]=$oUnidad->getDs_unidad();
	$oTipounidad = new Tipounidad();
	$oTipounidad->setCd_tipounidad($oUnidad->getCd_tipounidad());
	TipounidadQuery::getTipounidadPorId($oTipounidad);
	$ds_unidadproy .= $oTipounidad->getDs_tipounidad();
	
	for ($i=0; $i < count($html); $i++){
		$ds_unidadproy .= ' - '.$html[$i];
	}

	$oIntegrante = new Integrante();
	$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
	$oIntegrante->setCd_tipoinvestigador(1);	
	$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
	$countp = count ( $integrantes );
	for($j = 0; $j < $countp; $j ++) {
		$nu_horasinvdir = $integrantes [$j]['nu_horasinv'];
		$oDocente = new Docente ( );
		$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
		DocenteQuery::getDocentePorid ( $oDocente );
		$cd_deddir = $oDocente->getCd_deddoc();
		$cd_carrerainvdir = $oDocente->getCd_carrerainv();
		$nivel=$oDocente->getNu_nivelunidad();
		$ds_maildir = $oDocente->getDs_mail();
		$ds_catdir = $oDocente->getDs_categoria();
		$ds_deddir = $oDocente->getDs_deddoc();
		$ds_cargodir = $oDocente->getDs_cargo();
		$ds_facultaddir = $oDocente->getDs_facultad();
		$ds_universidaddir = $oDocente->getDs_universidad();
		$ds_organismodir = $oDocente->getDs_organismo();
		$ds_unidaddir = '';	
		$nivel=$oDocente->getNu_nivelunidad();
		$html = array();
		$oUnidad = new Unidad();
		$oUnidad->setCd_unidad($oDocente->getCd_unidad());
		
		while($nivel>0){
			UnidadQuery::getUnidadPorId($oUnidad);
			$html[$nivel]=$oUnidad->getDs_unidad();
			
			$oUnidad->setCd_unidad($oUnidad->getCd_padre());
			$nivel--;
		}
		
		$oTipounidad = new Tipounidad();
		$oTipounidad->setCd_tipounidad($oUnidad->getCd_tipounidad());
		TipounidadQuery::getTipounidadPorId($oTipounidad);
		$ds_unidaddir .= $oTipounidad->getDs_tipounidad();
		//if ($oUnidad->getCd_tipounidad()){
			UnidadQuery::getUnidadPorId($oUnidad);
			$html[$nivel]=$oUnidad->getDs_unidad();
		//}
		for ($i=0; $i < count($html); $i++){
			$ds_unidaddir .= ' - '.$html[$i];
		}
		$cd_unidaddir = $oUnidad->getCd_unidad();
		$nu_cuildir = $oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil();
		$ds_titulodir = $oDocente->getDs_titulo();
		$ds_calledir = $oDocente->getDs_calle();
		$nu_nrodir = $oDocente->getNu_nro();
		$nu_pisodir = $oDocente->getNu_piso();
		$ds_deptodir = $oDocente->getDs_depto();
		$ds_localidaddir = $oDocente->getDs_localidad();
		$ds_provinciadir = $oDocente->getDs_provincia();
		$nu_cpdir = $oDocente->getNu_cp();
		$nu_telefonodir = $oDocente->getNu_telefono();
		
	}
	$oIntegrante = new Integrante();
	$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
	$oIntegrante->setCd_tipoinvestigador(2);	
	$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
	$countcodir = count ( $integrantes );
	$ds_codirector = array();
	$nu_horasinvcodir = array();
	$cd_dedcodir = array();
	$ds_dedcodir = array();
	$cd_carrerainvcodir = array();
	$cd_unidad0codir = array();
	$ds_codigocodir = array();
	$ds_catcodir[$j] = array();
	$ds_cargocodir[$j] = array();
	
	$ds_facultadcodir[$j] = array();
	$ds_universidadcodir[$j] = array();
	
	$ds_organismocodir[$j] = array();
	
	$ds_unidadcodir[$j] = array();
	
	
	$nu_cuilcodir[$j] = array();
	$ds_titulocodir[$j] = array();
	$ds_callecodir[$j] = array();
	$nu_nrocodir[$j] = array();
	$nu_pisocodir[$j] = array();
	$ds_deptocodir[$j] = array();
	$ds_localidadcodir[$j] = array();
	$ds_provinciacodir[$j] = array();
	$nu_cpcodir[$j] = array();
	$nu_telefonocodir[$j] = array();
	$ds_mailcodir[$j] = array();
	for($j = 0; $j < $countcodir; $j ++) {
		$nu_horasinvcodir[$j] = $integrantes [$j]['nu_horasinv'];
		$oDocente = new Docente ( );
		$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
		DocenteQuery::getDocentePorid ( $oDocente );
		$cd_dedcodir [$j]= $oDocente->getCd_deddoc();
		$ds_dedcodir [$j]= $oDocente->getDs_deddoc();
		$cd_carrerainvcodir [$j]= $oDocente->getCd_carrerainv();
		$nivel=$oDocente->getNu_nivelunidad();
		$ds_unidadcodir[$j] = '';	
		$nivel=$oDocente->getNu_nivelunidad();
		$html = array();
		$oUnidad = new Unidad();
		$oUnidad->setCd_unidad($oDocente->getCd_unidad());
		while($nivel>0){
			UnidadQuery::getUnidadPorId($oUnidad);
			$html[$nivel]=$oUnidad->getDs_unidad();
			
			$oUnidad->setCd_unidad($oUnidad->getCd_padre());
			$nivel--;
		}
		
		$oTipounidad = new Tipounidad();
		$oTipounidad->setCd_tipounidad($oUnidad->getCd_tipounidad());
		TipounidadQuery::getTipounidadPorId($oTipounidad);
		$ds_unidadcodir[$j] .= $oTipounidad->getDs_tipounidad();
		//if ($oUnidad->getCd_tipounidad()){
			UnidadQuery::getUnidadPorId($oUnidad);
			$html[$nivel]=$oUnidad->getDs_unidad();
		//}
		for ($i=0; $i < count($html); $i++){
			$ds_unidadcodir[$j] .= ' - '.$html[$i];
		}
		UnidadQuery::getUnidadPorId($oUnidad);	
		$cd_unidad0codir [$j]= $oUnidad->getCd_unidad();
		$ds_codirector[$j] = $oDocente->getDs_apellido().', '.$oDocente->getDs_nombre();
		$ds_catcodir[$j] = $oDocente->getDs_categoria();
		$ds_cargocodir[$j] = $oDocente->getDs_cargo();
		
		$ds_facultadcodir[$j] = $oDocente->getDs_facultad();
		$ds_universidadcodir[$j] = $oDocente->getDs_universidad();
		
		$ds_organismocodir[$j] = $oDocente->getDs_organismo();
		
		
		
		
		$nu_cuilcodir[$j] = $oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil();
		$ds_titulocodir[$j] = $oDocente->getDs_titulo();
		$ds_callecodir[$j] = $oDocente->getDs_calle();
		$nu_nrocodir[$j] = $oDocente->getNu_nro();
		$nu_pisocodir[$j] = $oDocente->getNu_piso();
		$ds_deptocodir[$j] = $oDocente->getDs_depto();
		$ds_localidadcodir[$j] = $oDocente->getDs_localidad();
		$ds_provinciacodir[$j] = $oDocente->getDs_provincia();
		$nu_cpcodir[$j] = $oDocente->getNu_cp();
		$nu_telefonocodir[$j] = $oDocente->getNu_telefono();
		$ds_mailcodir[$j] = $oDocente->getDs_mail();
				
	}
	if ($enviar){
		
		
			if ($cd_unidaddir!=1850){
				if (!in_array($oDocente->getDs_categoria(),$categoriasPermitidasEx)){
					$err[$item]='Director externo sin categoría I o II';
					$item++;
				}
				else{
					
					$err[$item]='Director externo sin Codirector/es con lugar de trabajo en la Unidad Acad&eacute;mica que se presenta el proyecto';
					$item++;
					for($j = 0; $j < $countcodir; $j ++) {
						if ($ds_codigocodir [$j] == $oProyecto->getCd_facultad()){
							$item--;
							break;
						}	
					}
										
				}
			}
			if (!in_array($cd_deddir, $mayordedicacion)){
				$err[$item]='Director y Codirector/es sin mayor dedicaci&oacute;n y lugar de trabajo en la U.N.L.P.';
				$item++;
				for($j = 0; $j < $countcodir; $j ++) {
					if ((in_array($cd_deddir [$j], $mayordedicacion))&&($cd_unidad0codir [$j]==1850)){
						$item--;
						break;
					}	
				}
			}
			if ($nu_horasinvdir<$minhsdircodir){
				$err[$item]='Director y Codirector/es con dedicaci&oacute;n menor a '.$minhsdircodir.' hs. semanales';
				$item++;
				for($j = 0; $j < $countcodir; $j ++) {
					if ($nu_horasinvcodir[$j]>=$minhsdircodir){
						$item--;
						break;
					}	
				}
			}
			$integrantes = IntegranteQuery::getIntegrantes( 'ds_investigador', 'ASC', '', 1, 25, $oProyecto->getCd_proyecto() );
			$countp = count ( $integrantes );
			$nu_horastotal=0;
			$nu_total=0;
			$nu_categorizados=0;
			$nu_mayordedicacion=0;
			for($j = 0; $j < $countp; $j ++) {
				$nu_total++;
				$nu_horastotal = $nu_horastotal+$integrantes [$j]['nu_horasinv'];
				$oDocente = new Docente ( );
				$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
				DocenteQuery::getDocentePorid ( $oDocente );
				$nivel=$oDocente->getNu_nivelunidad();
				$oUnidad = new Unidad();
				$oUnidad->setCd_unidad($oDocente->getCd_unidad());
				while($nivel>0){
					UnidadQuery::getUnidadPorId($oUnidad);
					$oUnidad->setCd_unidad($oUnidad->getCd_padre());
					if ($nivel==1){
						$ds_codigo= $oUnidad->getDs_codigo();
					}
					$nivel--;
				}
				UnidadQuery::getUnidadPorId($oUnidad);	
				
				if ((in_array($oDocente->getDs_categoria(),$categorias))&&($oUnidad->getCd_unidad()==1850)) $nu_categorizados++;	
				if ((in_array($oDocente->getCd_deddoc(),$mayordedicacion))&&($oProyecto->getCd_facultad()==$ds_codigo)) $nu_mayordedicacion++;		
				
			}
			if ($nu_total<$minintegrantes){
				$err[$item]='Proyecto con menos de '.$minintegrantes.' integrantes';
				$item++;
			}
			if ($nu_categorizados<$mincategorizados){
				$err[$item]='Proyecto con menos de '.$mincategorizados.' integrantes categorizados con lugar de trabajo en la U.N.L.P.';
				$item++;
			}
			if ($nu_mayordedicacion<$minmayordedicacion){
				$err[$item]='Proyecto con menos de '.$minmayordedicacion.' integrantes con mayor dedicaci&oacute;n en la Unidad Acad&eacute;mica que se presenta el proyecto';
				$item++;
			}
			if ($nu_horastotal<$minhstotales){
				$err[$item]='La suma de dedicaciones horarias de los miembros es menor a '.$minhstotales.' hs. semanales';
				$item++;
			}
			
			
		
	}	
	if (!$item){
		$filename='../pdfs/acred_2010_sol.rtf';
		$output=file_get_contents($filename);
		
		//Sustituimos los marcadores de posición en la plantilla por los datos
		
		$output=str_replace('<<year>>',Date("Y"),$output);
		$output=str_replace('<<ds_director>>',$oProyecto->getDs_director(),$output);
		$output=str_replace('<<ds_catdir>>',$ds_catdir,$output);
		$output=str_replace('<<ds_cargodir>>',$ds_cargodir,$output);
		$output=str_replace('<<ds_deddir>>',$ds_deddir,$output);
		$output=str_replace('<<ds_facultaddir>>',$ds_facultaddir,$output);
		$output=str_replace('<<ds_universidaddir>>',$ds_universidaddir,$output);
		$output=str_replace('<<ds_carrerainvdir>>',$ds_carrerainvdir,$output);
		$output=str_replace('<<ds_organismodir>>',$ds_organismodir,$output);
		$output=str_replace('<<ds_unidaddir>>',$ds_unidaddir,$output);
		$output=str_replace('<<nu_cuildir>>',$nu_cuildir,$output);
		$output=str_replace('<<ds_titulodir>>',$ds_titulodir,$output);
		$output=str_replace('<<ds_calledir>>',$ds_calledir,$output);
		$output=str_replace('<<nu_nrodir>>',$nu_nrodir,$output);
		$output=str_replace('<<nu_pisodir>>',$nu_pisodir,$output);
		$output=str_replace('<<ds_deptodir>>',$ds_deptodir,$output);
		$output=str_replace('<<nu_telefonodir>>',$nu_telefonodir,$output);
		$output=str_replace('<<ds_localidaddir>>',$ds_localidaddir,$output);
		$output=str_replace('<<ds_provinciadir>>',$ds_provinciadir,$output);
		$output=str_replace('<<nu_cpdir>>',$nu_cpdir,$output);
		$output=str_replace('<<ds_maildir>>',$ds_maildir,$output);
		
		$output=str_replace('<<ds_codirector>>',$ds_codirector[0],$output);
		$output=str_replace('<<ds_catcodir>>',$ds_catcodir[0],$output);
		$output=str_replace('<<ds_cargocodir>>',$ds_cargocodir[0],$output);
		$output=str_replace('<<ds_dedcodir>>',$ds_dedcodir[0],$output);
		$output=str_replace('<<ds_facultadcodir>>',$ds_facultadcodir[0],$output);
		$output=str_replace('<<ds_universidadcodir>>',$ds_universidadcodir[0],$output);
		$output=str_replace('<<ds_carrerainvcodir>>',$ds_carrerainvcodir[0],$output);
		$output=str_replace('<<ds_organismocodir>>',$ds_organismocodir[0],$output);
		$output=str_replace('<<ds_unidadcodir>>',$ds_unidadcodir[0],$output);
		$output=str_replace('<<nu_cuilcodir>>',$nu_cuilcodir[0],$output);
		$output=str_replace('<<ds_titulocodir>>',$ds_titulocodir[0],$output);
		$output=str_replace('<<ds_callecodir>>',$ds_callecodir[0],$output);
		$output=str_replace('<<nu_nrocodir>>',$nu_nrocodir[0],$output);
		$output=str_replace('<<nu_pisocodir>>',$nu_pisocodir[0],$output);
		$output=str_replace('<<ds_deptocodir>>',$ds_deptocodir[0],$output);
		$output=str_replace('<<nu_telefonocodir>>',$nu_telefonocodir[0],$output);
		$output=str_replace('<<ds_localidadcodir>>',$ds_localidadcodir[0],$output);
		$output=str_replace('<<ds_provinciacodir>>',$ds_provinciacodir[0],$output);
		$output=str_replace('<<nu_cpcodir>>',$nu_cpcodir[0],$output);
		$output=str_replace('<<ds_mailcodir>>',$ds_mailcodir[0],$output);
		$ds_codirectores = '';
		for($j = 1; $j < $countcodir; $j ++) {
			$ds_codirectores .= '{Apellido y Nombres: \\i '.$ds_codirector[$j].'}\\par ';
			$ds_codirectores .= '{Categoría de Docente Investigador: \\i '.$ds_catcodir[$j].'}\\par ';
			$ds_codirectores .= '{Cargo docente: \\i '.$ds_cargocodir[$j].'}{    Dedicación: \\i '.$ds_dedcodir[$j].'}\\par ';
			$ds_codirectores .= '{Unidad Académica: \\i '.$ds_facultadcodir[$j].'}{    Universidad: \\i '.$ds_universidadcodir[$j].'}\\par ';
			$ds_codirectores .= '{Cargo en la Carrera del Investigador (CIC - CONICET): \\i '.$ds_carrerainvcodir[$j].' - '.$ds_organismocodir[$j].'}\\par ';
			$ds_codirectores .= '{Lugar de trabajo: \\i '.$ds_unidadcodir[$j].'}\\par ';	
			$ds_codirectores .= '{C.U.I.L.: \\i '.$nu_cuilcodir[$j].'}{    Título: \\i '.$ds_titulocodir[$j].'}\\par ';
			$ds_codirectores .= '{Domicilio Part.: \\i '.$ds_callecodir[$j].' '.$nu_nrocodir[$j].' '.$nu_pisocodir[$j].' '.$ds_deptocodir[$j].'}{    Tel.: \\i '.$nu_telefonocodir[$j].'}\\par ';
			$ds_codirectores .= '{Localidad: \\i '.$ds_localidadcodir[$j].'}{    Pcia.: \\i '.$ds_provinciacodir[$j].'}{    C.P.: \\i '.$nu_cpcodir[$j].'}\\par ';
			$ds_codirectores .= '{Email: \\i '.$ds_mailcodir[$j].'}';



		}
		$output=str_replace('<<ds_codirectores>>',$ds_codirectores,$output);
		$output=str_replace('<<ds_facultad>>',$oProyecto->getDs_facultad(),$output);
		$output=str_replace('<<ds_unidad>>',$ds_unidadproy,$output);
		$output=str_replace('<<ds_direccionunidad>>',$ds_direccionunidad,$output);
		$output=str_replace('<<ds_telefonounidad>>',$nu_telefonounidad,$output);
		$output=str_replace('<<ds_mailunidad>>',$ds_mailunidad,$output);
		$output=str_replace('<<ds_titulo>>',$oProyecto->getDs_titulo(),$output);
		$output=str_replace('<<ds_abstract>>',$oProyecto->getDs_abstract1(),$output);
		$output=str_replace('<<ds_clave1>>',$oProyecto->getDs_clave1(),$output);
		$output=str_replace('<<ds_clave2>>',$oProyecto->getDs_clave2(),$output);
		$output=str_replace('<<ds_clave3>>',$oProyecto->getDs_clave3(),$output);
		$output=str_replace('<<ds_clave4>>',$oProyecto->getDs_clave4(),$output);
		$output=str_replace('<<ds_clave5>>',$oProyecto->getDs_clave5(),$output);
		$output=str_replace('<<ds_clave6>>',$oProyecto->getDs_clave6(),$output);
		if ($oProyecto->getNu_duracion()==2){		
			$output=str_replace('<<ds_duracion>>', 'BIANUAL', $output);
			
		}
		if ($oProyecto->getNu_duracion()==4){		
			$output=str_replace('<<ds_duracion>>', 'TETRA ANUAL', $output);
			
		}
		
		if ($oProyecto->getDs_tipo()=='B'){		
			$output=str_replace('<<ds_tipoinvestigacion>>', 'BASICA', $output);
		}
		
		if ($oProyecto->getDs_tipo()=='A'){		
			$output=str_replace('<<ds_tipoinvestigacion>>', 'APLICADA', $output);
		}
		
		if ($oProyecto->getDs_tipo()=='D'){		
			$output=str_replace('<<ds_tipoinvestigacion>>', 'DESARROLLO', $output);
		}
		
		if ($oProyecto->getDs_tipo()=='C'){		
			$output=str_replace('<<ds_tipoinvestigacion>>', 'CREACION', $output);
		}
		
		$output=str_replace('<<cd_disciplina>>', stripslashes( $oProyecto->getCd_disciplina()) , $output);
		$output=str_replace('<<ds_disciplina>>', stripslashes( $oProyecto->getDs_disciplina()) , $output);
		$output=str_replace('<<cd_especialidad>>', stripslashes( $oProyecto->getCd_especialidad()) , $output);
		$output=str_replace('<<ds_especialidad>>', stripslashes( $oProyecto->getDs_especialidad()) , $output);
		$output=str_replace('<<cd_campo>>', stripslashes( $oProyecto->getCd_campo()) , $output);
		$output=str_replace('<<ds_campo>>', stripslashes( $oProyecto->getDs_campo()) , $output);
		$output=str_replace('<<ds_linea>>', stripslashes( $oProyecto->getDs_linea()) , $output);
		if ($oProyecto->getBl_transferencia()==1){		
				$output=str_replace('<<ds_transferenciaprevista>>', 'SI', $output);
			}
		if ($oProyecto->getBl_transferencia()==0){		
			$output=str_replace('<<ds_transferenciaprevista>>', 'NO', $output);
		}
		require '../clases/phprtflite/lib/PHPRtfLite.php';

		// register PHPRtfLite class loader
		PHPRtfLite::registerAutoloader();
		
		$rtf = new PHPRtfLite();
		$sect = $rtf->addSection();
		$sect->writeText($oProyecto->getDs_marco());
		
		$rtf->sendRtf('HelloWorld');
		
		$output=str_replace('<<ds_marco>>', $oRtf->out , $output);
		$output=str_replace('<<ds_aporte>>', stripslashes( $oProyecto->getDs_aporte()) , $output);
		$output=str_replace('<<ds_objetivos>>', stripslashes( $oProyecto->getDs_objetivos()) , $output);
		$output=str_replace('<<ds_metodologia>>', stripslashes( $oProyecto->getDs_metodologia()) , $output);
		$output=str_replace('<<ds_antecedentes>>', stripslashes( $oProyecto->getDs_antecedentes()) , $output);
		$output=str_replace('<<ds_avance>>', stripslashes( $oProyecto->getDs_avance()) , $output);
		$output=str_replace('<<ds_formacion>>', stripslashes( $oProyecto->getDs_formacion()) , $output);
		$output=str_replace('<<ds_transferencia>>', stripslashes( $oProyecto->getDs_transferencia()) , $output);
		$output=str_replace('<<ds_plan>>', stripslashes( $oProyecto->getDs_plan()) , $output);
		$output=str_replace('<<ds_disponible>>', stripslashes( $oProyecto->getDs_disponible()) , $output);
		$output=str_replace('<<ds_necesario>>', stripslashes( $oProyecto->getDs_necesario()) , $output);
		$output=str_replace('<<ds_fuentes>>', stripslashes( $oProyecto->getDs_fuentes()) , $output);
		$output=str_replace('<<nu_ano1>>', number_format($oProyecto->getNu_ano1(),2) , $output);
		$output=str_replace('<<nu_ano2>>', number_format($oProyecto->getNu_ano2(),2) , $output);
		$output=str_replace('<<nu_ano3>>', number_format($oProyecto->getNu_ano3(),2) , $output);
		$output=str_replace('<<nu_ano4>>', number_format($oProyecto->getNu_ano4(),2) , $output);
		$nombre_archivo = "Solicitud_".$oProyecto->getCd_proyecto(). ".rtf";
	
		if ($enviar){
			$oProyecto->setCd_estado(2);
			$exito = ProyectoQuery::modificarProyecto ( $oProyecto );
			$oFuncion = new Funcion();
			$oFuncion -> setDs_funcion($funcion);
			FuncionQuery::getFuncionPorDs($oFuncion);
			$oMovimiento = new Movimiento();
			$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
			$oMovimiento->setCd_usuario($cd_usuario);
			$oMovimiento->setDs_movimiento('Proyecto: '.$oProyecto->getDs_titulo());
			MovimientoQuery::insertarMovimiento($oMovimiento);
			$oUsuario = new Usuario();
			$oUsuario->setCd_usuario($cd_usuario);
			UsuarioQuery::getUsuarioPorId($oUsuario);
			$cabeceras="From: ".$oProyecto->getDs_director()."<".$oUsuario->getDs_mail().">\nReply-To: ".$oProyecto->getDs_director()."<".$oUsuario->getDs_mail().">\n";
			$cabeceras .="BCC: ".$oProyecto->getDs_director()."<".$oUsuario->getDs_mail().">\n";
			if ($oDocente->getDs_mail()!=$oUsuario->getDs_mail())
				$cabeceras .="BCC: ".$oProyecto->getDs_director()."<".$oDocente->getDs_mail().">\n";
			$cabeceras .="X-Mailer:PHP/".phpversion()."\n";
			$cabeceras .="Mime-Version: 1.0\n";
			$cabeceras .= "Content-type: multipart/mixed; ";
			$cabeceras .= "boundary=\"Message-Boundary\"\n";
			$cabeceras .= "Content-transfer-encoding: 7BIT\n";
			//$cabeceras .= "X-attachments: ".$nombre_archivo;
			
			$body_top = "--Message-Boundary\n";
			$body_top .= "Content-type: text/html; charset=iso-8859-1\n";
			$body_top .= "Content-transfer-encoding: 7BIT\n";
			$body_top .= "Content-description: Mail message body\n\n";
			$dir = APP_PATH.'pdfs/'.$oProyecto->getCd_proyecto().'/';
			if (file_exists($dir)){
				
		      $adjuntos = '';
		     $handle=opendir($dir);
				while ($archivo = readdir($handle))
				{
			        if (is_file($dir.$archivo))
			         {
			         	$file = fopen($dir.$archivo, "r");
						$contenido = fread($file, filesize($dir.$archivo));
						$encoded_attach = chunk_split(base64_encode($contenido));
						fclose($file);
			         	
						//$cabeceras .= "X-attachments: ".$archivo;
			         	$adjuntos .= "\n\n--Message-Boundary\n";
						$adjuntos .= "Content-type: Binary; name=\"$archivo\"\n";
						$adjuntos .= "Content-Transfer-Encoding: BASE64\n";
						$adjuntos .= "Content-disposition: attachment; filename=\"$archivo\"\n\n";
						$adjuntos .= "$encoded_attach\n";
						//$adjuntos .= "--Message-Boundary--\n"; 
			         }
				}
			}
			
			closedir($handle);
			
			$shtml = $body_top."<html><body><div style='padding-left: 30px; padding-right: 30px; padding-top: 30px ; padding-bottom: 30px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #666666; background-color:#FFFFFF'><img src=\"".WEB_PATH."img/image002.gif\" alt=\"Logo\" longdesc=\"Logo\"><br>ACREDITACION DE PROYECTOS<hr style= 'color: #999999; text-decoration: none;'><p><strong>Solicitud de Acreditaci&oacute;n <br>Proyecto</strong>: ".$oProyecto->getCd_proyecto()."<br><strong>Título</strong>: ".$oProyecto->getDs_titulo()."<br><strong>Director</strong>: ".$oProyecto->getDs_director()."</p><hr style= 'color: #999999; text-decoration: none;'></body></html>";
			$shtml .= $adjuntos;

			
			
			//mail($mailReceptor,'Acreditación de Proyectos',$shtml,$cabeceras);
			
			header ( 'Location:index.php' );
		}
		else{
			$mi_pdf = '../pdfs/'.$oProyecto->getCd_proyecto().'/'.$nombre_archivo;
			/*header('Content-type: application/pdf');
			header('Content-Disposition: attachment; filename="'.$nombre_archivo.'"');
			readfile($mi_pdf);*/
		
			header("Content-Description: File Transfer"); 
			header("Content-Type: application/force-download");  
			header('Content-Disposition: attachment; filename="'.$nombre_archivo.'"');
			echo $output;

		}
		
	}
	else
		header ( 'Location:index.php?err='.FuncionesComunes::array_envia($err) );
} else
	header ( 'Location:../includes/accesodenegado.php' );
?>
