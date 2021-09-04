<?php
//include '../fpdf/fpdf.php';
include '../fpdf/fpdfhtml.php';
include '../includes/include.php';
include '../includes/datosSession.php';
$enviar = (isset($_GET['enviar']))?1:0;
$reducido = (isset($_GET['reducido']))?1:0;
$enviarE = (isset($_GET['enviarE']))?1:0;
$funcion = ($enviar)?"Enviar proyecto":"Ver proyecto";

if (PermisoQuery::permisosDeUsuario( $cd_usuario, $funcion )) {
	$err=array();
	$item=0;
	$oProyecto = new Proyecto ( );
	$oProyecto->setCd_proyecto ($_GET ['id']);
	//if (file_exists($dir)){
		$oPDF_Proyecto = new PDF_Proyecto ( );
		$oPDF_Proyecto->AliasNbPages();
		//Header Fijo para todos los estados de cuenta
		//$year = $_SESSION ["nu_yearSession"];
		ProyectoQuery::getProyectoPorid ( $oProyecto );
		$nuevaFecha = explode ( "-", $oProyecto->getDt_ini() );
		
		$year = $nuevaFecha [0];
		$dir = APP_PATH.'pdfs/'.$year.'/'.$oProyecto->getCd_proyecto().'/';
		$path = WEB_PATH.'pdfs/'.$year.'/'.$oProyecto->getCd_proyecto().'/';
	
		$cd_estado = $oProyecto->getCd_estado();
		if ($enviar){
			$cd_estado = 2;
		}
		$oPDF_Proyecto->AddPage();
		
		$oPDF_Proyecto->SetFont ( 'times', 'B', 14 );
		 $oPDF_Proyecto->SetFillColor(255,255,255);
		$ppititulo = ($oProyecto->getCd_tipoacreditacion()==1)?' ':' PROMOCIONALES ';
		$tituloCabecera = ($year<2013)?"SOLICITUD DE ACREDITACION DE PROYECTOS".$ppititulo."DE INVESTIGACION  Y/O DESARROLLO PARA EL AÑO ".$year." - ".strtoupper($oProyecto->getDs_tipoacreditacion()):"SOLICITUD DE ACREDITACION DE PROYECTOS".$ppititulo."DE INVESTIGACION  Y DESARROLLO PARA EL AÑO ".$year;
		$oPDF_Proyecto->MultiCell ( 185, 6, $tituloCabecera);
		$oPDF_Proyecto->ln(1);
		$oPDF_Proyecto->separador();
		$oPDF_Proyecto->SetFont ( 'times', 'B', 12 );
		$oPDF_Proyecto->Cell(185,8,'1. IDENTIFICACION DEL PROYECTO');
		$oPDF_Proyecto->ln(8);
		$oPDF_Proyecto->Cell(185,8,'1.1 DIRECTOR:');
		$oPDF_Proyecto->ln(6);
		$minhsdircodir = ($oProyecto->getCd_tipoacreditacion()==1)?$minhsdircodir:$minhsdircodir+5;
		$mincategorizados=($oProyecto->getCd_tipoacreditacion()==1)?$mincategorizados:0;
		$minmayordedicacion=($oProyecto->getCd_tipoacreditacion()==1)?$minmayordedicacion:$minmayordedicacion-1;
		
		$minintegrantes=($oProyecto->getCd_tipoacreditacion()==1)?$minintegrantes:$minintegrantes+1;
		$oIntegrante = new Integrante();
		$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
		$oIntegrante->setCd_tipoinvestigador(1);
		$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
		$countp = count ( $integrantes );
		for($j = 0; $j < $countp; $j ++) {
			$oIntegrante->setCd_docente($integrantes [$j]['cd_docente']);
			IntegranteQuery::getIntegrantePorId($oIntegrante);
			if (!$oIntegrante->getDs_curriculum()){
				$err[$item]='Falta el CV del director';
				$item++;
			}
			
			$nu_horasinvdir = $integrantes [$j]['nu_horasinv'];
			$oDocente = new Docente ( );
			$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
			DocenteQuery::getDocentePorid ( $oDocente );
			//$max = (($oDocente->getCd_docente())&&((in_array($oDocente->getCd_deddoc(), $mayordedicacion))||(in_array($oDocente->getCd_carrerainv(), $carrerainvs))||($oDocente->getBl_becario())))?2:1;	
			$max = (($oDocente->getCd_docente())&&((in_array($oDocente->getCd_deddoc(), $mayordedicacion))||(in_array($oDocente->getCd_carrerainv(), $carrerainvs))))?2:1;
			if(IntegranteQuery::masDeUnProyecto($oDocente->getCd_docente(),$max)){
				$err[$item]='El director del proyecto es integrante de 2 proyectos en ejecuci&oacute;n o no tiene dedicaci&oacute;n suficiente para ser integrante de m&aacute;s de un proyecto ';
				$item++;
			}
			$cd_deddir = ($oDocente->getBl_becario())?1:$oDocente->getCd_deddoc();
			$cd_carrerainvdir = $oDocente->getCd_carrerainv();
			$ds_maildir = $oDocente->getDs_mail();
			$nu_documentoDir = $oDocente->getNu_documento();
			$ds_unidad = '';	
			$nivel=$oDocente->getNu_nivelunidad();
			$html = array();
			$oUnidad = new Unidad();
			$oUnidad->setCd_unidad($oDocente->getCd_unidad());
			UnidadQuery::getUnidadPorId($oUnidad);
			//$ds_unidad=$oUnidad->getDs_unidad();
			$ds_unidad = ($oUnidad->getDs_sigla())?trim($oUnidad->getDs_unidad()).' ('.trim($oUnidad->getDs_sigla()).')':trim($oUnidad->getDs_unidad());
			$cd_padreunlp=0;
			$insertar=0;
			$cd_facultad=0;
			while($nivel>0){
				UnidadQuery::getUnidadPorId($oUnidad);
				$html[$nivel]=$oUnidad->getDs_unidad();
				if (!$cd_facultad){
					$cd_facultad= $oUnidad->getCd_facultad();
				}
				$oUnidad->setCd_unidad($oUnidad->getCd_padre());
				if((!$insertar)&&(($oUnidad->getCd_padre()==1850)||($oUnidad->getCd_padre()==20419))){
					$cd_padreunlp=1;
					$insertar=1;
				}
				if ($oUnidad->getCd_unidad()) {
					$nivel--;
				}
				else $nivel = 0;
				
			}
			//if (((!in_array($oDocente->getCd_deddoc(),$mayordedicacion))||((in_array($oDocente->getCd_deddoc(),$mayordedicacion))&&($oProyecto->getCd_facultad()!=$cd_facultad)))&&((!in_array($oDocente->getCd_carrerainv(), $carrerainvs))||((in_array($oDocente->getCd_carrerainv(), $carrerainvs))&&($oProyecto->getCd_facultad()!=$cd_facultad))||$oDocente->getBl_becario())&&($oProyecto->getCd_tipoacreditacion()==2)) {
			if (((!in_array($oDocente->getCd_deddoc(),$mayordedicacion))||((in_array($oDocente->getCd_deddoc(),$mayordedicacion))&&($oProyecto->getCd_facultad()!=$cd_facultad)))&&((!in_array($oDocente->getCd_carrerainv(), $carrerainvs))||((in_array($oDocente->getCd_carrerainv(), $carrerainvs))&&($oProyecto->getCd_facultad()!=$cd_facultad)))&&($oProyecto->getCd_tipoacreditacion()==2)) {	
			
				$err[$item]='Director sin mayor dedicaci&oacute;n y lugar de trabajo en la U.N.L.P.';
				$item++;
			}	
			if ((!in_array($oDocente->getDs_categoria(),$categoriasPermitidas))&&($oProyecto->getCd_tipoacreditacion()==1)){
				$err[$item]='Director sin categoría I, II o III';
				$item++;
			}
			$directorExterno=0;
			if ($oDocente->getCd_universidad()!=11){
				if ((!in_array($oDocente->getDs_categoria(),$categoriasPermitidasEx))&&($oProyecto->getCd_tipoacreditacion()==1)){
					$err[$item]='Director externo sin categoría I o II';
					$item++;
					$directorExterno=1;
				}
			}
			/*if ((FuncionesComunes::edad($oDocente->getDt_nacimiento())>40)&&($oProyecto->getCd_tipoacreditacion()==2)){
				$err[$item]='Director con edad mayor a 40 años';
				$item++;
			}*/
			/*if (($oDocente->getDs_categoria()=='V')&&($oProyecto->getCd_tipoacreditacion()==2)){
				$err[$item]='Director no puede ser categoría V';
				$item++;
			}*/
			
			if (($oDocente->getBl_director())&&($oProyecto->getCd_tipoacreditacion()==2)){
				$err[$item]='El director es o ha sido director y/o codirector de proyectos';
				$item++;
			}
			
			if ((!$oIntegrante->getDs_antecedentes())&&($oProyecto->getCd_tipoacreditacion()==2)){
				$err[$item]='Falta indicar la actividad cient&iacute;fica, tecnol&oacute;gica y/o art&iacute;stica significativa y continua en los &uacute;ltimos 5 a&ntilde;os';
				$item++;
			}
			if (($oProyecto->getCd_tipoacreditacion()==2)) {
				$proyectoPPID = IntegranteQuery::fueDirCodirPPID($oDocente->getCd_docente(),$oProyecto->getCd_proyecto());
	   		 	if (count($proyectoPPID)>0) {
					if ((!$oIntegrante->getDs_antecedentesPPIDDIR())){
						$err[$item]='Falta indicar el resumen del PPID anterior';
						$item++;
					}
	   		 	}
	   		 	if (!$oDocente->getDt_cargo()) {
	   		 		$err[$item]='Falta completar la fecha deobtenci&oacute;n del cargo del director';
					$item++;
	   		 	}
	   		 	
			}
			
			
			/*if (($oDocente->getCd_titulopost()==9999)&&($oProyecto->getCd_tipoacreditacion()==2)){
				$err[$item]='Director sin título de posgrado';
				$item++;
			}*/
			/*$oTipounidad = new Tipounidad();
			$oTipounidad->setCd_tipounidad($oUnidad->getCd_tipounidad());
			TipounidadQuery::getTipounidadPorId($oTipounidad);
			$ds_unidad .= $oTipounidad->getDs_tipounidad();
			
				UnidadQuery::getUnidadPorId($oUnidad);
				$html[$nivel]=$oUnidad->getDs_unidad();
			
			for ($i=0; $i < count($html); $i++){
				$ds_unidad .= ' - '.$html[$i];
			}*/
			
			$oTitulopost = new Titulo();
			$oTitulopost->setCd_titulo($oDocente->getCd_titulopost());
			TituloQuery::getTituloPorId($oTitulopost);		
			$cd_dir=$oDocente->getCd_docente();
			$oPDF_Proyecto->Director($oProyecto->getDs_director(),$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil(),$oDocente->getDs_categoria(),$oDocente->getDs_cargo(),$oDocente->getDs_deddoc(),$oDocente->getDs_facultad(),$oDocente->getDs_universidad(),$oDocente->getDs_carrerainv(),$oDocente->getDs_organismo(),$ds_unidad,$oDocente->getDs_titulo(),$oTitulopost->getDs_titulo(),$oDocente->getDs_calle(),$oDocente->getNu_nro(),$oDocente->getNu_piso(),$oDocente->getDs_depto(),$oDocente->getNu_telefono(),$oDocente->getDs_localidad(),$oDocente->getDs_provincia(),$oDocente->getNu_cp(),$oDocente->getDs_mail(), $reducido,$oDocente->getDt_cargo());
		}
		if ($oProyecto->getCd_tipoacreditacion()==2){
			$oPDF_Proyecto->AntecedentesDir($oIntegrante->getDs_antecedentes());
			if (count($proyectoPPID)>0) {
				$oPDF_Proyecto->AntecedentesPPIDDir($oIntegrante->getDs_antecedentesPPIDDIR(), $proyectoPPID[0]['ds_codigo'], $proyectoPPID[0]['ds_titulo'], $proyectoPPID[0]['ds_tipoinvestigador'], $proyectoPPID[0]['dt_ini'], $proyectoPPID[0]['dt_fin']);
			}
		}
		
		$oIntegrante = new Integrante();
		$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
		$oIntegrante->setCd_tipoinvestigador(2);
		$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
		$countp = count ( $integrantes );
		if ($countp){
			$oPDF_Proyecto->ln(2);
			$oPDF_Proyecto->SetFont ( 'times', 'B', 12 );
			$oPDF_Proyecto->Cell(185,8,'CODIRECTOR:');
			$oPDF_Proyecto->ln(6);
			$nu_horasinvcodir = array();
			$cd_dedcodir = array();
			$cd_carrerainvcodir = array();
			$cd_unidad0codir = array();
			$cd_facultadcodir = array();
		}
		$ds_directores='';
		for($j = 0; $j < $countp; $j ++) {
			$oDocente = new Docente ( );
			$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
			DocenteQuery::getDocentePorid ( $oDocente );
			//$max = (($oDocente->getCd_docente())&&((in_array($oDocente->getCd_deddoc(), $mayordedicacion))||(in_array($oDocente->getCd_carrerainv(), $carrerainvs))||($oDocente->getBl_becario())))?2:1;	
			$max = (($oDocente->getCd_docente())&&((in_array($oDocente->getCd_deddoc(), $mayordedicacion))||(in_array($oDocente->getCd_carrerainv(), $carrerainvs))))?2:1;
			if(IntegranteQuery::masDeUnProyecto($oDocente->getCd_docente(),$max)){
				$err[$item]=$oDocente->getDs_apellido().' es integrante de 2 proyectos en ejecuci&oacute;n o no tiene dedicaci&oacute;n suficiente para ser integrante de m&aacute;s de un proyecto ';
				$item++;
			}
			$cd_dedcodir [$j]= ($oDocente->getBl_becario())?1:$oDocente->getCd_deddoc();
			$cd_carrerainvcodir [$j]= $oDocente->getCd_carrerainv();
			$ds_unidad = '';	
			$nivel=$oDocente->getNu_nivelunidad();
			$nu_horasinvcodir[$j] = $integrantes [$j]['nu_horasinv'];
			$html = array();
			$oUnidad = new Unidad();
			$oUnidad->setCd_unidad($oDocente->getCd_unidad());
			UnidadQuery::getUnidadPorId($oUnidad);
			$ds_unidad = ($oUnidad->getDs_sigla())?trim($oUnidad->getDs_unidad()).' ('.trim($oUnidad->getDs_sigla()).')':trim($oUnidad->getDs_unidad());
			$cd_padreunlp=0;
			$insertar=0;
			$cd_facultadcodir [$j]=0;
			while($nivel>0){
				UnidadQuery::getUnidadPorId($oUnidad);
				$html[$nivel]=$oUnidad->getDs_unidad();
				
				$oUnidad->setCd_unidad($oUnidad->getCd_padre());
				
				if (!$cd_facultadcodir [$j]){
					$cd_facultadcodir [$j]= $oUnidad->getCd_facultad();
				}
				if((!$insertar)&&(($oUnidad->getCd_padre()==1850)||($oUnidad->getCd_padre()==20419))){
					$cd_padreunlp=1;
					$insertar=1;
				}
				if ($oUnidad->getCd_unidad()) {
					$nivel--;
				}
				else $nivel = 0;
			}
			$cd_unidad0codir [$j]= $cd_padreunlp;
			/*$oTipounidad = new Tipounidad();
			$oTipounidad->setCd_tipounidad($oUnidad->getCd_tipounidad());
			TipounidadQuery::getTipounidadPorId($oTipounidad);
			$ds_unidad .= $oTipounidad->getDs_tipounidad();
			//if ($oUnidad->getCd_tipounidad()){
				UnidadQuery::getUnidadPorId($oUnidad);
				$html[$nivel]=$oUnidad->getDs_unidad();
			//}
			for ($i=0; $i < count($html); $i++){
				$ds_unidad .= ' - '.$html[$i];
			}*/
			
			$oTitulopost = new Titulo();
			$oTitulopost->setCd_titulo($oDocente->getCd_titulopost());
			TituloQuery::getTituloPorId($oTitulopost);	
			$ds_directores .=$oDocente->getDs_apellido().', '.$oDocente->getDs_nombre().' - ';	
			$oPDF_Proyecto->Director($oDocente->getDs_apellido().', '.$oDocente->getDs_nombre(),$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil(),$oDocente->getDs_categoria(),$oDocente->getDs_cargo(),$oDocente->getDs_deddoc(),$oDocente->getDs_facultad(),$oDocente->getDs_universidad(),$oDocente->getDs_carrerainv(),$oDocente->getDs_organismo(),$ds_unidad,$oDocente->getDs_titulo(),$oTitulopost->getDs_titulo(),$oDocente->getDs_calle(),$oDocente->getNu_nro(),$oDocente->getNu_piso(),$oDocente->getDs_depto(),$oDocente->getNu_telefono(),$oDocente->getDs_localidad(),$oDocente->getDs_provincia(),$oDocente->getNu_cp(),$oDocente->getDs_mail(),$reducido);
		}
		$ds_directores = substr($ds_directores,0,strlen($ds_directores)-3);
		if(($oProyecto->getCd_tipoacreditacion()==1)&&($directorExterno)){
			$err[$item]='Director externo sin Codirector/es con lugar de trabajo en la Unidad Acad&eacute;mica que se presenta el proyecto';
			$item++;
		
			for($j = 0; $j < $countp; $j ++) {
				if (($cd_facultadcodir[$j] == $oProyecto->getCd_facultad())||($oProyecto->getCd_tipoacreditacion()==2)){
					$item--;
					break;
				}	
			}
		}
		if ((!in_array($cd_deddir, $mayordedicacion))&&(!in_array($cd_carrerainvdir, $carrerainvs))){
			$err[$item]='Director y Codirector/es sin mayor dedicaci&oacute;n y lugar de trabajo en la U.N.L.P.';
			$item++;
			for($j = 0; $j < $countp; $j ++) {
				if (((in_array($cd_dedcodir [$j], $mayordedicacion))||(in_array($cd_carrerainvcodir [$j], $carrerainvs)))&&($cd_unidad0codir [$j])){
					$item--;
					break;
				}	
			}
		}
		if ($nu_horasinvdir<$minhsdircodir){
			$hscodir=($oProyecto->getCd_tipoacreditacion()==1)?' y Codirector/es ':'';
			$speech = 'Director '.$hscodir.'con dedicaci&oacute;n menor a '.$minhsdircodir.' hs. semanales';
			if ($oProyecto->getCd_tipoacreditacion()==2) {
				$speech .=' o Director y Codirector con menos de '.($minhsdircodir-6).' hs. semanales';
			}
			$err[$item]=$speech;
			$item++;
			for($j = 0; $j < $countp; $j ++) {
				if ($oProyecto->getCd_tipoacreditacion()==1) {
					if ($nu_horasinvcodir[$j]>=$minhsdircodir){
						$item--;
						break;
					}
				}
				elseif ($nu_horasinvdir>=$minhsdircodir-6) {
					if ($nu_horasinvcodir[$j]>=$minhsdircodir-6){
						$item--;
						break;
					}
				} 
					
			}
		}
		$oPDF_Proyecto->separador();
		$ds_unidadP = '';	
		$nivel=$oProyecto->getNu_nivelunidad();
		$html = array();
		$oUnidad = new Unidad();
		$oUnidad->setCd_unidad($oProyecto->getCd_unidad());
		UnidadQuery::getUnidadPorId($oUnidad);
		//$ds_unidadP = $oUnidad->getDs_unidad();
		$ds_unidadP = ($oUnidad->getDs_sigla())?trim($oUnidad->getDs_unidad()).' ('.trim($oUnidad->getDs_sigla()).')':trim($oUnidad->getDs_unidad());
		$ds_direccionunidad = $oUnidad->getDs_direccion();
		$ds_mailunidad = $oUnidad->getDs_mail();
		$nu_telefonounidad = $oUnidad->getDs_telefono();
		/*$i=0;
		while($nivel>0){
			UnidadQuery::getUnidadPorId($oUnidad);
			if ($i==0){
				$ds_direccionunidad = $oUnidad->getDs_direccion();
				$ds_mailunidad = $oUnidad->getDs_mail();
				$nu_telefonounidad = $oUnidad->getDs_telefono();
			}
		
			$i++;
			$html[$nivel]=$oUnidad->getDs_unidad();
			
			$oUnidad->setCd_unidad($oUnidad->getCd_padre());
			$nivel--;
		}
		UnidadQuery::getUnidadPorId($oUnidad);
			$html[$nivel]=$oUnidad->getDs_unidad();
			
		$oTipounidad = new Tipounidad();
		$oTipounidad->setCd_tipounidad($oUnidad->getCd_tipounidad());
		TipounidadQuery::getTipounidadPorId($oTipounidad);
		$ds_unidadP .= $oTipounidad->getDs_tipounidad();
		
		for ($i=0; $i < count($html); $i++){
			$ds_unidadP .= ' - '.$html[$i];
		}*/
		
		$oPDF_Proyecto->unidad($oProyecto->getDs_facultad(),$ds_unidadP,$ds_direccionunidad,$nu_telefonounidad,$ds_mailunidad,$reducido);
		$oPDF_Proyecto->separador();
		$oPDF_Proyecto->Titulo($oProyecto->getDs_titulo());
		$oPDF_Proyecto->separador();
		if(!$reducido){
			$oPDF_Proyecto->Resumen($oProyecto->getDs_abstract1(), $oProyecto->getDs_abstracteng());
			$oPDF_Proyecto->separador();
			$oPDF_Proyecto->Claves($oProyecto->getDs_clave1(),$oProyecto->getDs_clave2(),$oProyecto->getDs_clave3(),$oProyecto->getDs_clave4(),$oProyecto->getDs_clave5(),$oProyecto->getDs_clave6(),$oProyecto->getDs_claveeng1(),$oProyecto->getDs_claveeng2(),$oProyecto->getDs_claveeng3(),$oProyecto->getDs_claveeng4(),$oProyecto->getDs_claveeng5(),$oProyecto->getDs_claveeng6());
		}
		if ($oProyecto->getNu_duracion()==2){		
			$ds_duracion =  "BIENAL";
			
		}
		if ($oProyecto->getNu_duracion()==4){	
			$ds_duracion =  "TETRA ANUAL";	
			
			
		}
		$oPDF_Proyecto->Duracion($ds_duracion);
		if(!$reducido){
			$oPDF_Proyecto->SetFont ( 'times', 'B', 12 );
			$oPDF_Proyecto->Cell(185,8,'1.7 CARACTERISTICAS:');
			$oPDF_Proyecto->ln(6);
			if ($oProyecto->getDs_tipo()=='B'){		
				$ds_tipo =  "BASICA";
			}
			
			if ($oProyecto->getDs_tipo()=='A'){		
				$ds_tipo =  "APLICADA" ;
			}
			
			if ($oProyecto->getDs_tipo()=='D'){		
				$ds_tipo =  "DESARROLLO" ;
			}
			
			if ($oProyecto->getDs_tipo()=='C'){		
				$ds_tipo =  "CREACION" ;
			}
			$oPDF_Proyecto->Caracteristicas($ds_tipo,$oProyecto->getDs_codigodisciplina(),$oProyecto->getDs_disciplina(),$oProyecto->getDs_codigoespecialidad(),$oProyecto->getDs_especialidad(),$oProyecto->getDs_codigocampo(),$oProyecto->getDs_campo(),$oProyecto->getDs_linea());
			$oPDF_Proyecto->separador();
			if ($oProyecto->getBl_transferencia()==1){		
					$ds_transferencia =  "SI" ;
				}
			if ($oProyecto->getBl_transferencia()==0){		
				$ds_transferencia =  "NO" ;
			}
			$oPDF_Proyecto->Transferencia($ds_transferencia);
			$oPDF_Proyecto->separador();
			$oPDF_Proyecto->Descripcion($oProyecto->getDs_titulo());
			/*$oRtf = new rtf($oProyecto->getDs_marco());
			$oRtf->output('html');
			$oRtf->parse();*/
		
			
			$oPDF_Proyecto->Marco($oProyecto->getDs_marco());
			$oPDF_Proyecto->Aporte($oProyecto->getDs_aporte());
			$oPDF_Proyecto->Objetivos($oProyecto->getDs_objetivos());
			$oPDF_Proyecto->Metodologia($oProyecto->getDs_metodologia());
			$oPDF_Proyecto->Metas($oProyecto->getDs_metas());
			$oPDF_Proyecto->separador();
			$oPDF_Proyecto->Antecedentes($oProyecto->getDs_antecedentes());
			$oPDF_Proyecto->separador();
			$oPDF_Proyecto->SetFont ( 'times', 'B', 12 );
			$oPDF_Proyecto->Cell ( 185, 8, "4. APORTES POTENCIALES: ");
			$oPDF_Proyecto->Avance($oProyecto->getDs_avance());
			$oPDF_Proyecto->Formacion($oProyecto->getDs_formacion());
			$oPDF_Proyecto->Resultados($oProyecto->getDs_transferencia());
			$oPDF_Proyecto->separador();
			$oPDF_Proyecto->Plan($oProyecto->getDs_plan());
			//$oPDF_Proyecto->separador();
			if ($year > 2013 ) {
				$tablaCronograma = '';
				for ($i = 1; $i <= $oProyecto->getNu_duracion(); $i++) {
					$oCronograma = new Cronograma();
					$oCronograma->setCd_proyecto($oProyecto->getCd_proyecto());
					$oCronograma->setNu_year($i);
					$cronogramas = CronogramaQuery::getCronogramas($oCronograma);
					$tablaCronograma .= '<b>Año '.$i.'</b><table width="100%" border="1" cellpadding="0" cellspacing="0"><thead><tr><td width="100px" rowspan="2" align="center" bgcolor="#CCCCCC">Actividad</td><td colspan="12" align="center" bgcolor="#CCCCCC">Meses</td></tr><tr>
					
				<td bgcolor="#CCCCCC">1</td>	
                <td bgcolor="#CCCCCC">2</td>
                <td bgcolor="#CCCCCC">3</td>
                <td bgcolor="#CCCCCC">4</td>
                <td bgcolor="#CCCCCC">5</td>
                <td bgcolor="#CCCCCC">6</td>
                <td bgcolor="#CCCCCC">7</td>
                <td bgcolor="#CCCCCC">8</td>
                <td bgcolor="#CCCCCC">9</td>
                <td bgcolor="#CCCCCC">10</td>
                <td bgcolor="#CCCCCC">11</td>
                <td bgcolor="#CCCCCC">12</td></tr></thead><tbody>';
					
					$count = count ( $cronogramas );
					for($j = 0; $j < $count; $j ++) {
						$tablaCronograma .= '<tr><td>'.utf8_decode($cronogramas[$j]['ds_actividad']).'</td>';
						$bgcolor= ($cronogramas[$j]['bl_mes1'])?'bgcolor="#333333"':'';
						$tablaCronograma .= '<td '.$bgcolor.'></td>';
						$bgcolor= ($cronogramas[$j]['bl_mes2'])?'bgcolor="#333333"':'';
						$tablaCronograma .= '<td '.$bgcolor.'></td>';
						$bgcolor= ($cronogramas[$j]['bl_mes3'])?'bgcolor="#333333"':'';
						$tablaCronograma .= '<td '.$bgcolor.'></td>';
						$bgcolor= ($cronogramas[$j]['bl_mes4'])?'bgcolor="#333333"':'';
						$tablaCronograma .= '<td '.$bgcolor.'></td>';
						$bgcolor= ($cronogramas[$j]['bl_mes5'])?'bgcolor="#333333"':'';
						$tablaCronograma .= '<td '.$bgcolor.'></td>';
						$bgcolor= ($cronogramas[$j]['bl_mes6'])?'bgcolor="#333333"':'';
						$tablaCronograma .= '<td '.$bgcolor.'></td>';
						$bgcolor= ($cronogramas[$j]['bl_mes7'])?'bgcolor="#333333"':'';
						$tablaCronograma .= '<td '.$bgcolor.'></td>';
						$bgcolor= ($cronogramas[$j]['bl_mes8'])?'bgcolor="#333333"':'';
						$tablaCronograma .= '<td '.$bgcolor.'></td>';
						$bgcolor= ($cronogramas[$j]['bl_mes9'])?'bgcolor="#333333"':'';
						$tablaCronograma .= '<td '.$bgcolor.'></td>';
						$bgcolor= ($cronogramas[$j]['bl_mes10'])?'bgcolor="#333333"':'';
						$tablaCronograma .= '<td '.$bgcolor.'></td>';
						$bgcolor= ($cronogramas[$j]['bl_mes11'])?'bgcolor="#333333"':'';
						$tablaCronograma .= '<td '.$bgcolor.'></td>';
						$bgcolor= ($cronogramas[$j]['bl_mes12'])?'bgcolor="#333333"':'';
						$tablaCronograma .= '<td '.$bgcolor.'></td></tr>';
					}
					$tablaCronograma .= '</tbody></table><p></p>';
				}
				$oProyecto->setDs_cronograma($tablaCronograma);
			}
			
			$oPDF_Proyecto->Cronograma($oProyecto->getDs_cronograma());
		}
		$oPDF_Proyecto->separador();
		$oPDF_Proyecto->SetFont ( 'times', 'B', 12 );
		$oPDF_Proyecto->Cell(185,8,'6. RECURSOS HUMANOS INTERVINIENTES:');
		$oPDF_Proyecto->ln(6);
		if(!$reducido){
			$oPDF_Proyecto->Cell(185,8,'6.1 DIRECTOR:');
			$oPDF_Proyecto->ln(6);
			$oIntegrante = new Integrante();
			$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
			$oIntegrante->setCd_tipoinvestigador(1);
			$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
			$countp = count ( $integrantes );
			for($j = 0; $j < $countp; $j ++) {
				$oDocente = new Docente ( );
				$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
				DocenteQuery::getDocentePorid ( $oDocente );
				$ds_unidad = '';	
				$nivel=$oDocente->getNu_nivelunidad();
				$html = array();
				$oUnidad = new Unidad();
				$oUnidad->setCd_unidad($oDocente->getCd_unidad());
				UnidadQuery::getUnidadPorId($oUnidad);
				$ds_unidad = ($oUnidad->getDs_sigla())?trim($oUnidad->getDs_unidad()).' ('.trim($oUnidad->getDs_sigla()).')':trim($oUnidad->getDs_unidad());
				/*while($nivel>0){
					UnidadQuery::getUnidadPorId($oUnidad);
					$html[$nivel]=$oUnidad->getDs_unidad();
					
					$oUnidad->setCd_unidad($oUnidad->getCd_padre());
					$nivel--;
				}
				
				$oTipounidad = new Tipounidad();
				$oTipounidad->setCd_tipounidad($oUnidad->getCd_tipounidad());
				TipounidadQuery::getTipounidadPorId($oTipounidad);
				$ds_unidad .= $oTipounidad->getDs_tipounidad();
				
					UnidadQuery::getUnidadPorId($oUnidad);
					$html[$nivel]=$oUnidad->getDs_unidad();
				
				for ($i=0; $i < count($html); $i++){
					$ds_unidad .= ' - '.$html[$i];
				}*/
				
				$oTitulopost = new Titulo();
				$oTitulopost->setCd_titulo($oDocente->getCd_titulopost());
				TituloQuery::getTituloPorId($oTitulopost);		
				
				$proyectosdir = ProyectoQuery::getProyectosDocentes($oDocente->getCd_docente() );
				$oPDF_Proyecto->Integrante($oProyecto->getDs_director(),$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil(),$oDocente->getDs_categoria(),$oDocente->getDs_cargo(),$oDocente->getDs_deddoc(),$oDocente->getDs_facultad(),$oDocente->getDs_universidad(),$oDocente->getDs_carrerainv(),$oDocente->getDs_organismo(),$ds_unidad,$oDocente->getDs_titulo(),$oTitulopost->getDs_titulo(), $oDocente->getDs_tipobeca(), $oDocente->getDs_orgbeca(),$proyectosdir,$reducido);
			}
			
			$oIntegrante = new Integrante();
			$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
			$oIntegrante->setCd_tipoinvestigador(2);
			$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
			$countp = count ( $integrantes );
			//if ($countp){
				//$oPDF_Proyecto->ln(2);
			if($oProyecto->getCd_tipoacreditacion()==1){
				$oPDF_Proyecto->SetFont ( 'times', 'B', 12 );
				$oPDF_Proyecto->Cell(185,8,'6.2 CODIRECTOR:');
				$oPDF_Proyecto->ln(6);
			}
			//}
			for($j = 0; $j < $countp; $j ++) {
				$oDocente = new Docente ( );
				$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
				DocenteQuery::getDocentePorid ( $oDocente );
				$ds_unidad = '';	
				$nivel=$oDocente->getNu_nivelunidad();
				$html = array();
				$oUnidad = new Unidad();
				$oUnidad->setCd_unidad($oDocente->getCd_unidad());
				UnidadQuery::getUnidadPorId($oUnidad);
				$ds_unidad = ($oUnidad->getDs_sigla())?trim($oUnidad->getDs_unidad()).' ('.trim($oUnidad->getDs_sigla()).')':trim($oUnidad->getDs_unidad());
				/*while($nivel>0){
					UnidadQuery::getUnidadPorId($oUnidad);
					$html[$nivel]=$oUnidad->getDs_unidad();
					
					$oUnidad->setCd_unidad($oUnidad->getCd_padre());
					$nivel--;
				}
				
				$oTipounidad = new Tipounidad();
				$oTipounidad->setCd_tipounidad($oUnidad->getCd_tipounidad());
				TipounidadQuery::getTipounidadPorId($oTipounidad);
				$ds_unidad .= $oTipounidad->getDs_tipounidad();
				
					UnidadQuery::getUnidadPorId($oUnidad);
					$html[$nivel]=$oUnidad->getDs_unidad();
				
				for ($i=0; $i < count($html); $i++){
					$ds_unidad .= ' - '.$html[$i];
				}*/
				
				$oTitulopost = new Titulo();
				$oTitulopost->setCd_titulo($oDocente->getCd_titulopost());
				TituloQuery::getTituloPorId($oTitulopost);		
				$proyectos = ProyectoQuery::getProyectosDocentes($oDocente->getCd_docente() );
				$oPDF_Proyecto->Integrante($oDocente->getDs_apellido().', '.$oDocente->getDs_nombre(),$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil(),$oDocente->getDs_categoria(),$oDocente->getDs_cargo(),$oDocente->getDs_deddoc(),$oDocente->getDs_facultad(),$oDocente->getDs_universidad(),$oDocente->getDs_carrerainv(),$oDocente->getDs_organismo(),$ds_unidad,$oDocente->getDs_titulo(),$oTitulopost->getDs_titulo(), $oDocente->getDs_tipobeca(), $oDocente->getDs_orgbeca(),$proyectos,$reducido);
			}
		}
		$oPDF_Proyecto->SetFont ( 'times', 'B', 12 );
		$oPDF_Proyecto->Cell(185,8,'6.3 INTEGRANTES:');
		$oPDF_Proyecto->ln(6);
		$oIntegrante = new Integrante();
		$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
		$oIntegrante->setCd_tipoinvestigador(3);
		$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
		$countp = count ( $integrantes );
		//if ($countp){
			//$oPDF_Proyecto->ln(2);
			$oPDF_Proyecto->SetFont ( 'times', 'B', 12 );
			$oPDF_Proyecto->Cell(185,8,'6.3.a INVESTIGADORES FORMADOS:');
			$oPDF_Proyecto->ln(6);
		//}
		for($j = 0; $j < $countp; $j ++) {
			$oDocente = new Docente ( );
			$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
			DocenteQuery::getDocentePorid ( $oDocente );
			//$max = (($oDocente->getCd_docente())&&((in_array($oDocente->getCd_deddoc(), $mayordedicacion))||(in_array($oDocente->getCd_carrerainv(), $carrerainvs))||($oDocente->getBl_becario())))?2:1;	
			$max = (($oDocente->getCd_docente())&&((in_array($oDocente->getCd_deddoc(), $mayordedicacion))||(in_array($oDocente->getCd_carrerainv(), $carrerainvs))))?2:1;
			if(IntegranteQuery::masDeUnProyecto($oDocente->getCd_docente(),$max)){
				$err[$item]=$oDocente->getDs_apellido().' es integrante de 2 proyectos en ejecuci&oacute;n o no tiene dedicaci&oacute;n suficiente para ser integrante de m&aacute;s de un proyecto ';
				$item++;
			}
			$ds_unidad = '';	
			$nivel=$oDocente->getNu_nivelunidad();
			$html = array();
			$oUnidad = new Unidad();
			$oUnidad->setCd_unidad($oDocente->getCd_unidad());
			UnidadQuery::getUnidadPorId($oUnidad);
			$ds_unidad = ($oUnidad->getDs_sigla())?trim($oUnidad->getDs_unidad()).' ('.trim($oUnidad->getDs_sigla()).')':trim($oUnidad->getDs_unidad());
			/*while($nivel>0){
				UnidadQuery::getUnidadPorId($oUnidad);
				$html[$nivel]=$oUnidad->getDs_unidad();
				
				$oUnidad->setCd_unidad($oUnidad->getCd_padre());
				$nivel--;
			}
			
			$oTipounidad = new Tipounidad();
			$oTipounidad->setCd_tipounidad($oUnidad->getCd_tipounidad());
			TipounidadQuery::getTipounidadPorId($oTipounidad);
			$ds_unidad .= $oTipounidad->getDs_tipounidad();
			
				UnidadQuery::getUnidadPorId($oUnidad);
				$html[$nivel]=$oUnidad->getDs_unidad();
			
			for ($i=0; $i < count($html); $i++){
				$ds_unidad .= ' - '.$html[$i];
			}*/
			
			$oTitulopost = new Titulo();
			$oTitulopost->setCd_titulo($oDocente->getCd_titulopost());
			TituloQuery::getTituloPorId($oTitulopost);		
			$proyectos = ProyectoQuery::getProyectosDocentes($oDocente->getCd_docente() );
			$oPDF_Proyecto->Integrante($oDocente->getDs_apellido().', '.$oDocente->getDs_nombre(),$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil(),$oDocente->getDs_categoria(),$oDocente->getDs_cargo(),$oDocente->getDs_deddoc(),$oDocente->getDs_facultad(),$oDocente->getDs_universidad(),$oDocente->getDs_carrerainv(),$oDocente->getDs_organismo(),$ds_unidad,$oDocente->getDs_titulo(),$oTitulopost->getDs_titulo(), $oDocente->getDs_tipobeca(), $oDocente->getDs_orgbeca(),$proyectos,$reducido);
		}
		$oIntegrante = new Integrante();
		$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
		$oIntegrante->setCd_tipoinvestigador(4);
		$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
		$countp = count ( $integrantes );
		//if ($countp){
			//$oPDF_Proyecto->ln(2);
			$oPDF_Proyecto->SetFont ( 'times', 'B', 12 );
			$oPDF_Proyecto->Cell(185,8,'6.3.b INVESTIGADORES EN FORMACIÓN:');
			$oPDF_Proyecto->ln(6);
		//}
		for($j = 0; $j < $countp; $j ++) {
			$oDocente = new Docente ( );
			$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
			DocenteQuery::getDocentePorid ( $oDocente );
			//$max = (($oDocente->getCd_docente())&&((in_array($oDocente->getCd_deddoc(), $mayordedicacion))||(in_array($oDocente->getCd_carrerainv(), $carrerainvs))||($oDocente->getBl_becario())))?2:1;	
			$max = (($oDocente->getCd_docente())&&((in_array($oDocente->getCd_deddoc(), $mayordedicacion))||(in_array($oDocente->getCd_carrerainv(), $carrerainvs))))?2:1;
			if(IntegranteQuery::masDeUnProyecto($oDocente->getCd_docente(),$max)){
				$err[$item]=$oDocente->getDs_apellido().' es integrante de 2 proyectos en ejecuci&oacute;n o no tiene dedicaci&oacute;n suficiente para ser integrante de m&aacute;s de un proyecto ';
				$item++;
			}
			$ds_unidad = '';	
			$nivel=$oDocente->getNu_nivelunidad();
			$html = array();
			$oUnidad = new Unidad();
			$oUnidad->setCd_unidad($oDocente->getCd_unidad());
			UnidadQuery::getUnidadPorId($oUnidad);
			$ds_unidad = ($oUnidad->getDs_sigla())?trim($oUnidad->getDs_unidad()).' ('.trim($oUnidad->getDs_sigla()).')':trim($oUnidad->getDs_unidad());
			/*while($nivel>0){
				UnidadQuery::getUnidadPorId($oUnidad);
				$html[$nivel]=$oUnidad->getDs_unidad();
				
				$oUnidad->setCd_unidad($oUnidad->getCd_padre());
				$nivel--;
			}
			
			$oTipounidad = new Tipounidad();
			$oTipounidad->setCd_tipounidad($oUnidad->getCd_tipounidad());
			TipounidadQuery::getTipounidadPorId($oTipounidad);
			$ds_unidad .= $oTipounidad->getDs_tipounidad();
			
				UnidadQuery::getUnidadPorId($oUnidad);
				$html[$nivel]=$oUnidad->getDs_unidad();
			
			for ($i=0; $i < count($html); $i++){
				$ds_unidad .= ' - '.$html[$i];
			}*/
			
			$oTitulopost = new Titulo();
			$oTitulopost->setCd_titulo($oDocente->getCd_titulopost());
			TituloQuery::getTituloPorId($oTitulopost);		
			$proyectos = ProyectoQuery::getProyectosDocentes($oDocente->getCd_docente() );
			$oPDF_Proyecto->Integrante($oDocente->getDs_apellido().', '.$oDocente->getDs_nombre(),$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil(),$oDocente->getDs_categoria(),$oDocente->getDs_cargo(),$oDocente->getDs_deddoc(),$oDocente->getDs_facultad(),$oDocente->getDs_universidad(),$oDocente->getDs_carrerainv(),$oDocente->getDs_organismo(),$ds_unidad,$oDocente->getDs_titulo(),$oTitulopost->getDs_titulo(), $oDocente->getDs_tipobeca(), $oDocente->getDs_orgbeca(),$proyectos,$reducido);
		}
		$oIntegrante = new Integrante();
		$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
		$oIntegrante->setCd_tipoinvestigador(5);
		$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
		$countp = count ( $integrantes );
		//if ($countp){
			//$oPDF_Proyecto->ln(2);
			$oPDF_Proyecto->SetFont ( 'times', 'B', 12 );
			$oPDF_Proyecto->Cell(185,8,'6.3.c TESISTAS, BECARIOS:');
			$oPDF_Proyecto->ln(6);
		//}
		for($j = 0; $j < $countp; $j ++) {
			$oDocente = new Docente ( );
			$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
			DocenteQuery::getDocentePorid ( $oDocente );
			//$max = (($oDocente->getCd_docente())&&((in_array($oDocente->getCd_deddoc(), $mayordedicacion))||(in_array($oDocente->getCd_carrerainv(), $carrerainvs))||($oDocente->getBl_becario())))?2:1;	
			$max = (($oDocente->getCd_docente())&&((in_array($oDocente->getCd_deddoc(), $mayordedicacion))||(in_array($oDocente->getCd_carrerainv(), $carrerainvs))))?2:1;
			if(IntegranteQuery::masDeUnProyecto($oDocente->getCd_docente(),$max)){
				$err[$item]=$oDocente->getDs_apellido().' es integrante de 2 proyectos en ejecuci&oacute;n o no tiene dedicaci&oacute;n suficiente para ser integrante de m&aacute;s de un proyecto ';
				$item++;
			}
			$ds_unidad = '';	
			$nivel=$oDocente->getNu_nivelunidad();
			$html = array();
			$oUnidad = new Unidad();
			$oUnidad->setCd_unidad($oDocente->getCd_unidad());
			UnidadQuery::getUnidadPorId($oUnidad);
			$ds_unidad = ($oUnidad->getDs_sigla())?trim($oUnidad->getDs_unidad()).' ('.trim($oUnidad->getDs_sigla()).')':trim($oUnidad->getDs_unidad());
			/*while($nivel>0){
				UnidadQuery::getUnidadPorId($oUnidad);
				$html[$nivel]=$oUnidad->getDs_unidad();
				
				$oUnidad->setCd_unidad($oUnidad->getCd_padre());
				$nivel--;
			}
			
			$oTipounidad = new Tipounidad();
			$oTipounidad->setCd_tipounidad($oUnidad->getCd_tipounidad());
			TipounidadQuery::getTipounidadPorId($oTipounidad);
			$ds_unidad .= $oTipounidad->getDs_tipounidad();
			
				UnidadQuery::getUnidadPorId($oUnidad);
				$html[$nivel]=$oUnidad->getDs_unidad();
			
			for ($i=0; $i < count($html); $i++){
				$ds_unidad .= ' - '.$html[$i];
			}*/
			
			$oTitulopost = new Titulo();
			$oTitulopost->setCd_titulo($oDocente->getCd_titulopost());
			TituloQuery::getTituloPorId($oTitulopost);		
			$proyectos = ProyectoQuery::getProyectosDocentes($oDocente->getCd_docente() );
			$oPDF_Proyecto->Integrante($oDocente->getDs_apellido().', '.$oDocente->getDs_nombre(),$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil(),$oDocente->getDs_categoria(),$oDocente->getDs_cargo(),$oDocente->getDs_deddoc(),$oDocente->getDs_facultad(),$oDocente->getDs_universidad(),$oDocente->getDs_carrerainv(),$oDocente->getDs_organismo(),$ds_unidad,$oDocente->getDs_titulo(),$oTitulopost->getDs_titulo(), $oDocente->getDs_tipobeca(), $oDocente->getDs_orgbeca(),$proyectos,$reducido);
		}
		$oIntegrante = new Integrante();
		$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
		$oIntegrante->setCd_tipoinvestigador(6);
		$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
		$countp = count ( $integrantes );
		//if ($countp){
			//$oPDF_Proyecto->ln(2);
			$oPDF_Proyecto->SetFont ( 'times', 'B', 12 );
			$oPDF_Proyecto->Cell(185,8,'6.4 COLABORADORES:');
			$oPDF_Proyecto->ln(6);
		//}
		for($j = 0; $j < $countp; $j ++) {
			$oDocente = new Docente ( );
			$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
			DocenteQuery::getDocentePorid ( $oDocente );
			$ds_unidad = '';	
			$nivel=$oDocente->getNu_nivelunidad();
			$html = array();
			$oUnidad = new Unidad();
			$oUnidad->setCd_unidad($oDocente->getCd_unidad());
			UnidadQuery::getUnidadPorId($oUnidad);
				$ds_unidad = ($oUnidad->getDs_sigla())?trim($oUnidad->getDs_unidad()).' ('.trim($oUnidad->getDs_sigla()).')':trim($oUnidad->getDs_unidad());
			/*while($nivel>0){
				UnidadQuery::getUnidadPorId($oUnidad);
				$html[$nivel]=$oUnidad->getDs_unidad();
				
				$oUnidad->setCd_unidad($oUnidad->getCd_padre());
				$nivel--;
			}
			
			$oTipounidad = new Tipounidad();
			$oTipounidad->setCd_tipounidad($oUnidad->getCd_tipounidad());
			TipounidadQuery::getTipounidadPorId($oTipounidad);
			$ds_unidad .= $oTipounidad->getDs_tipounidad();
			
				UnidadQuery::getUnidadPorId($oUnidad);
				$html[$nivel]=$oUnidad->getDs_unidad();
			
			for ($i=0; $i < count($html); $i++){
				$ds_unidad .= ' - '.$html[$i];
			}*/
			
			$oTitulopost = new Titulo();
			$oTitulopost->setCd_titulo($oDocente->getCd_titulopost());
			TituloQuery::getTituloPorId($oTitulopost);		
			$proyectos = ProyectoQuery::getProyectosDocentes($oDocente->getCd_docente() );
			$oPDF_Proyecto->Integrante($oDocente->getDs_apellido().', '.$oDocente->getDs_nombre(),$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil(),$oDocente->getDs_categoria(),$oDocente->getDs_cargo(),$oDocente->getDs_deddoc(),$oDocente->getDs_facultad(),$oDocente->getDs_universidad(),$oDocente->getDs_carrerainv(),$oDocente->getDs_organismo(),$ds_unidad,$oDocente->getDs_titulo(),$oTitulopost->getDs_titulo(), $oDocente->getDs_tipobeca(), $oDocente->getDs_orgbeca(),$proyectos,$reducido);
		}
		if(!$reducido){
			$oPDF_Proyecto->separador();
			$oPDF_Proyecto->SetFont ( 'times', 'B', 12 );
			$oPDF_Proyecto->Cell(185,8,'7. EQUIPAMIENTO Y/O BIBLIOGRAFIA:');
			$oPDF_Proyecto->ln(6);
			
			
			$oPDF_Proyecto->Disponible($oProyecto->getDs_disponible());
			$oPDF_Proyecto->Necesario($oProyecto->getDs_necesario());
			$oPDF_Proyecto->Fuentes($oProyecto->getDs_fuentes());
		
			$oPDF_Proyecto->separador();
			$oPDF_Proyecto->SetFont ( 'times', 'B', 12 );
			$oPDF_Proyecto->Cell(185,8,'8. PRESUPUESTO DEL PROYECTO:');
			$oPDF_Proyecto->ln(6);
			$oPDF_Proyecto->Costo($oProyecto->getNu_ano1(),$oProyecto->getNu_ano2(),$oProyecto->getNu_ano3(),$oProyecto->getNu_ano4(), $oProyecto->getNu_duracion());
			$oFondo = new Fondo();
			$oFondo->setCd_proyecto($oProyecto->getCd_proyecto());
			$oFondo->setBl_tramite(0);
			$fondos = ($oProyecto->getFondos())?$oProyecto->getFondos():FondoQuery::getFondo($oFondo);
			$oPDF_Proyecto->Fondos($fondos);
			$oPDF_Proyecto->Tramite($oProyecto->getDs_fondotramite());
			if ($year > 2013 ) {
				$tablaFinanciamientoanterior = '';
				
				$oFinanciamientoanterior = new Financiamientoanterior();
				$oFinanciamientoanterior->setCd_proyecto($oProyecto->getCd_proyecto());
				
				$financiamientoanteriores = FinanciamientoanteriorQuery::getFinanciamientoanteriors($oFinanciamientoanterior);
				$tablaFinanciamientoanterior .= '<table width="100%" border="1" cellpadding="0" cellspacing="0"><thead><tr><td bgcolor="#CCCCCC">A&ntilde;o</td>
                <td bgcolor="#CCCCCC">U.N.L.P.</td>
                <td bgcolor="#CCCCCC">Instituciones Nacionales</td>
                <td bgcolor="#CCCCCC">Instituciones Extranjeras</td>
                <td bgcolor="#CCCCCC">Total</td></tr></thead><tbody>';
				
				
				$count = count ( $financiamientoanteriores );
				for($j = 0; $j < $count; $j ++) {
					$tablaFinanciamientoanterior .= '<tr><td>'.($financiamientoanteriores[$j]['nu_year']).'</td>';
					$tablaFinanciamientoanterior .= '<td>'.FuncionesComunes::Format_toMoney($financiamientoanteriores[$j]['nu_unlp']).'</td>';
					$tablaFinanciamientoanterior .= '<td>'.FuncionesComunes::Format_toMoney($financiamientoanteriores[$j]['nu_nacionales']).'</td>';
					$tablaFinanciamientoanterior .= '<td>'.FuncionesComunes::Format_toMoney($financiamientoanteriores[$j]['nu_extranjeras']).'</td>';
					$total = $financiamientoanteriores[$j]['nu_unlp']+$financiamientoanteriores[$j]['nu_nacionales']+$financiamientoanteriores[$j]['nu_extranjeras'];
					$tablaFinanciamientoanterior .= '<td>'.FuncionesComunes::Format_toMoney($total).'</td></tr>';
				}
				$tablaFinanciamientoanterior .= '</tbody></table>';
				$oPDF_Proyecto->Financiamientoanterior($tablaFinanciamientoanterior);
				
			}
			$oPDF_Proyecto->Factibilidad($oProyecto->getDs_factibilidad(), $year);
			
		}
		$oPDF_Proyecto->separador();
			$oPDF_Proyecto->Presupuesto($oProyecto->getNu_consumo1(),$oProyecto->getNu_consumo2(),$oProyecto->getNu_consumo3(),$oProyecto->getNu_consumo4(),$oProyecto->getNu_servicios1(),$oProyecto->getNu_servicios2(),$oProyecto->getNu_servicios3(),$oProyecto->getNu_servicios4(),$oProyecto->getNu_bibliografia1(),$oProyecto->getNu_bibliografia2(),$oProyecto->getNu_bibliografia3(),$oProyecto->getNu_bibliografia4(),$oProyecto->getNu_cientifico1(),$oProyecto->getNu_cientifico2(),$oProyecto->getNu_cientifico3(),$oProyecto->getNu_cientifico4(),$oProyecto->getNu_computacion1(),$oProyecto->getNu_computacion2(),$oProyecto->getNu_computacion3(),$oProyecto->getNu_computacion4(),$oProyecto->getNu_otros1(),$oProyecto->getNu_otros2(),$oProyecto->getNu_otros3(),$oProyecto->getNu_otros4(),$year, $oProyecto->getNu_duracion());
		//}
		if ($year > 2013 ) {
			
			$arrayYear = array();
			for ($i = 0; $i < $oProyecto->getNu_duracion(); $i++) {
				$arrayYear[$i+1]=$year+$i;
			}
			$oPDF_Proyecto->separador();
			$oPDF_Proyecto->SetFont ( 'times', 'B', 12 );
			$oPDF_Proyecto->MultiCell( 185, 4, "9.1 DETALLE DE GASTOS PREVISTOS. 
			Detallar los conceptos y montos en pesos discriminado por año de acuerdo a los incisos 2, 3 y 4 especificados en el presupuesto preliminar.
			");
			$oPDF_Proyecto->SetFont ( 'times', '', 12 );
			$arrayFinanciamiento = array("Inciso 2 - Bienes de consumo","Inciso 3 - Servicios no personales","Inciso 4 - Bienes de uso");
			for ($m = 1; $m < 4; $m++) {
				$tablaFinanciamientoitem = '';
				$tablaFinanciamientoitem .= '<b>'.$arrayFinanciamiento[$m-1].'</b><table width="100%" border="1" cellpadding="0" cellspacing="0"><thead><tr>
				<td bgcolor="#CCCCCC">A&ntilde;o</td>	
				<td bgcolor="#CCCCCC">Concepto</td>	
                
                <td bgcolor="#CCCCCC">Monto</td></tr></thead><tbody>';
				$nu_total=0;
				for ($i = 1; $i <= $oProyecto->getNu_duracion(); $i++) {
					$oFinanciamientoitem = new Financiamientoitem();
					$oFinanciamientoitem->setCd_proyecto($oProyecto->getCd_proyecto());
					$oFinanciamientoitem->setNu_year($i);
					$oFinanciamientoitem->setCd_tipo($m);
					$financiamientoitems = FinanciamientoitemQuery::getFinanciamientoitems($oFinanciamientoitem);
					
					
					$count = count ( $financiamientoitems );
					for($j = 0; $j < $count; $j ++) {
						$tablaFinanciamientoitem .= '<tr><td>'.($arrayYear[$financiamientoitems[$j]['nu_year']]).'</td>';
						$tablaFinanciamientoitem .= '<td>'.utf8_decode($financiamientoitems[$j]['ds_concepto']).'</td>';
						$tablaFinanciamientoitem .= '<td>'.FuncionesComunes::Format_toMoney($financiamientoitems[$j]['nu_monto']).'</td>';
						$tablaFinanciamientoitem .= '</tr>';
						$nu_total +=$financiamientoitems[$j]['nu_monto'];
					}
					//$tablaFinanciamientoitem .= '<tr><td colspan="2">Total</td><td>'.FuncionesComunes::Format_toMoney($nu_total).'</td></tr>';
				}
				$tablaFinanciamientoitem .= '<tr><td colspan="2">Total</td><td>'.FuncionesComunes::Format_toMoney($nu_total).'</td></tr></tbody></table><p></p>';
				
				$oPDF_Proyecto->WriteHTML($tablaFinanciamientoitem);
				
				
			}
		}
		$oPDF_Proyecto->separador();
		if ($reducido){
			if ($oProyecto->getBl_publicar()==1){		
					$ds_publicar =  "SI" ;
				}
			if ($oProyecto->getBl_publicar()==0){		
				$ds_publicar =  "NO" ;
			}
			if ($year > 2012 ) {
				
				if ($oProyecto->getBl_notificacion()==1){		
						$ds_notificacion =  "SI" ;
					}
				if ($oProyecto->getBl_notificacion()==0){		
					$ds_notificacion =  "NO" ;
				}
				$oUsuario = new Usuario();
				$oUsuario->setNu_documento($nu_documentoDir);
				UsuarioQuery::getUsuarioPorDocumento($oUsuario);
				$ds_notificacion = 'Acepto recibir toda notificación relativa al presente proyecto a la dirección de correo electrónico '.$oUsuario->getDs_mail().' : '.$ds_notificacion;
			}
			$oPDF_Proyecto->firma1($oProyecto->getDs_facultad(),$ds_publicar, $ds_notificacion);
			if($oProyecto->getCd_tipoacreditacion()==2){
				
				$proyectosdir = ProyectoQuery::getProyectosDocentes($cd_dir,1);
				$oPDF_Proyecto->ProyectoPPID($proyectosdir);
			}
		
		}
		//Imprimo el PDF
		
		
		if ($enviar){
			$integrantes = IntegranteQuery::getIntegrantes( 'ds_investigador', 'ASC', '', 1, 50, $oProyecto->getCd_proyecto() );
			$countp = count ( $integrantes );
			$nu_horastotal=0;
			$nu_total=0;
			$nu_categorizados=0;
			$nu_mayordedicacion=0;
			for($j = 0; $j < $countp; $j ++) {
				if ($integrantes [$j]['cd_tipoinvestigador']!=6)
					$nu_total++;
				$nu_horastotal = $nu_horastotal+$integrantes [$j]['nu_horasinv'];
				$oDocente = new Docente ( );
				$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
				DocenteQuery::getDocentePorid ( $oDocente );
				$nivel=$oDocente->getNu_nivelunidad();
				$oUnidad = new Unidad();
				$oUnidad->setCd_unidad($oDocente->getCd_unidad());
				$cd_padreunlp=0;
				$insertar=0;
				$cd_facultad=0;
				while($nivel>0){
					UnidadQuery::getUnidadPorId($oUnidad);
					$oUnidad->setCd_unidad($oUnidad->getCd_padre());
					if (!$cd_facultad){
						$cd_facultad= $oUnidad->getCd_facultad();
					}
					if((!$insertar)&&(($oUnidad->getCd_padre()==1850)||($oUnidad->getCd_padre()==20419))){
						$cd_padreunlp=1;
						$insertar=1;
					}
					if ($oUnidad->getCd_unidad()) {
						$nivel--;
					}
					else $nivel = 0;
				}
				UnidadQuery::getUnidadPorId($oUnidad);	
				if ($integrantes [$j]['cd_tipoinvestigador']!=6){
					if ((in_array($oDocente->getDs_categoria(),$categorias))&&($cd_padreunlp)) $nu_categorizados++;	
					//if (((in_array($oDocente->getCd_deddoc(),$mayordedicacion))||(in_array($oDocente->getCd_carrerainv(), $carrerainvs)) ||($oDocente->getBl_becario()))&&($oProyecto->getCd_facultad()==$cd_facultad)) {
					if (((in_array($oDocente->getCd_deddoc(),$mayordedicacion))||(in_array($oDocente->getCd_carrerainv(), $carrerainvs)))&&($oProyecto->getCd_facultad()==$cd_facultad)) {
						if ($oProyecto->getCd_tipoacreditacion()==1) {
							$nu_mayordedicacion++;	
						}
						elseif ($integrantes [$j]['cd_tipoinvestigador']!=1){
							$nu_mayordedicacion++;
						}
						
					}
				}	
				
			}
			if ($nu_total<$minintegrantes){
				$err[$item]='Proyecto con menos de '.$minintegrantes.' integrantes';
				$item++;
			}
			if ($nu_mayordedicacion<$minmayordedicacion){
					$err[$item]='Proyecto con menos de '.$minmayordedicacion.' integrantes con mayor dedicaci&oacute;n en la Unidad Acad&eacute;mica que se presenta el proyecto';
					$item++;
			}
			if ($oProyecto->getCd_tipoacreditacion()==1){
				if ($nu_categorizados<$mincategorizados){
					$err[$item]='Proyecto con menos de '.$mincategorizados.' integrantes categorizados con lugar de trabajo en la U.N.L.P.';
					$item++;
				}
				
			}
			/*else{
				if ($nu_categorizados+$nu_mayordedicacion<$mincategorizados){//controlado en primer PPID
					$err[$item]='Proyecto con menos de '.$mincategorizados.' integrantes categorizados con lugar de trabajo en la U.N.L.P. ó con menos de '.$minmayordedicacion.' integrantes con mayor dedicaci&oacute;n en la Unidad Acad&eacute;mica que se presenta el proyecto';
					$item++;
				}

			}*/
		
			if ($nu_horastotal<$minhstotales){
				$err[$item]='La suma de dedicaciones horarias de los miembros es menor a '.$minhstotales.' hs. semanales';
				$item++;
			}
			if ($item<=0){
			
			//$dir = APP_PATH.'pdfs/'.$oProyecto->getCd_proyecto().'/';
			//$ds_apellido = stripslashes(str_replace("'","_",$oDocente->getDs_apellido()));
			$fileName = "SOLICITUD_".$oProyecto->getCd_proyecto().".pdf";
			$nombreArchivo = $dir . $fileName;
			//el output se hace en el llamador porque depende de quien lo llame
			$oPDF_Proyecto->Output ( $nombreArchivo, 'F');
			
			$oPDF_Evaluador = new PDF_Proyecto ( );
			$oPDF_Evaluador->AliasNbPages();
			$oPDF_Evaluador->AddPage();
			$oPDF_Evaluador->SetFont( 'times', 'BU', 12 );
			$oPDF_Evaluador->Cell(185,8,'ACREDITACION '.$_SESSION ["nu_yearSession"].' - PLANILLA DE EVALUADORES',0,0,'C');
			$oPDF_Evaluador->TituloEvaluadores($oProyecto->getDs_titulo(),$oProyecto->getDs_director(),$ds_directores,$ds_unidadP, $oProyecto->getDs_facultad(),$oProyecto->getDs_codigodisciplina().' - '.$oProyecto->getDs_disciplina(),$oProyecto->getDs_codigoespecialidad().' - '.$oProyecto->getDs_especialidad());
			$oPDF_Evaluador->SetFont( 'times', 'B', 12 );
			$oPDF_Evaluador->Ln(5);
			$oPDF_Evaluador->MultiCell(185,4,'Evaluadores que no deben ser convocados para analizar el proyecto.');
			$oProyectoevaluador = new Proyectoevaluador();
			$oProyectoevaluador->setCd_proyecto($oProyecto->getCd_proyecto());
			$proyectoevaluadors = ProyectoevaluadorQuery::getProyectoevaluador($oProyectoevaluador);
			$oPDF_Evaluador->Evaluadores($proyectoevaluadors);
			$oPDF_Evaluador->firma2();
			$fileName = "EVALUADORES_".$oProyecto->getCd_proyecto().".pdf";
			$nombreArchivo1 = $dir . $fileName;
			//el output se hace en el llamador porque depende de quien lo llame
			$oPDF_Evaluador->Output ( $nombreArchivo1, 'F');
			/*$file = fopen($nombreArchivo, "r");
			$contenidoA = fread($file, filesize($nombreArchivo));
			$encoded_attach = chunk_split(base64_encode($contenidoA));
			fclose($file);*/
			$oProyecto->setCd_estado(2);
			$exito = ProyectoQuery::modificarProyecto ( $oProyecto );
			if ($exito){
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
				$ds_investigador = str_replace(',','',$oProyecto->getDs_director());
				$cabeceras="From: ".$ds_investigador."<".$oUsuario->getDs_mail().">\nReply-To: ".$oUsuario->getDs_mail()."\nReturn-path: ".$oUsuario->getDs_mail()."\n";
	                       
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
				
				if (file_exists($dir)){
					
			      $adjuntos = '';
			     $handle=opendir($dir);
					while ($archivo = readdir($handle))
					{
				        if (is_file($dir.$archivo))
				         {
				         	//if (!in_array($archivo,$archivosNoEnv)){
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
				         	}
							//$adjuntos .= "--Message-Boundary--\n"; 
				        // }
					}
				}
				
				closedir($handle);
				
				$shtml = $body_top."<html><body><div style='padding-left: 30px; padding-right: 30px; padding-top: 30px ; padding-bottom: 30px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #666666; background-color:#FFFFFF'><img src=\"".WEB_PATH."img/image002.gif\" alt=\"Logo\" longdesc=\"Logo\"><br>ACREDITACION DE PROYECTOS<hr style= 'color: #999999; text-decoration: none;'><p><strong>Solicitud de Acreditaci&oacute;n <br>Proyecto</strong>: ".$oProyecto->getCd_proyecto()."<br><strong>Título</strong>: ".$oProyecto->getDs_titulo()."<br><strong>Director</strong>: ".$oProyecto->getDs_director()."</p><hr style= 'color: #999999; text-decoration: none;'></body></html>";
				$shtml .= $adjuntos;
								
				if (!$test) {
					mail($mailReceptor,'Solicitud de Acreditacion de Proyectos',$shtml,$cabeceras);
				}
				$cabeceras="From: ".$mailFrom."<".$nameFrom.">\nReply-To: ".$mailFrom."\nReturn-path: ".$mailFrom."\n";
	                        
				$cabeceras .="X-Mailer:PHP/".phpversion()."\n";
				$cabeceras .="Mime-Version: 1.0\n";
				$cabeceras .= "Content-type: multipart/mixed; ";
				$cabeceras .= "boundary=\"Message-Boundary\"\n";
				$cabeceras .= "Content-transfer-encoding: 7BIT\n";
				if ($ds_maildir!=$oUsuario->getDs_mail())	$cabeceras .="BCC: ".$ds_maildir."\n";
				$oUsuarioF = new Usuario();
				$oUsuarioF->setCd_facultad($oUsuario->getCd_facultad());
				$usuarios = UsuarioQuery::getUsuariosPorFac($oUsuarioF);
				$count = count ( $usuarios );
				for($i = 0; $i < $count; $i ++) {
					$cabeceras .="BCC: ".$usuarios [$i]['ds_mail']."\n";
				}
				
				$shtml = $body_top."<html><body><div style='padding-left: 30px; padding-right: 30px; padding-top: 30px ; padding-bottom: 30px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #666666; background-color:#FFFFFF'><img src=\"".WEB_PATH."img/image002.gif\" alt=\"Logo\" longdesc=\"Logo\"><br>ACREDITACION DE PROYECTOS<hr style= 'color: #999999; text-decoration: none;'><p><strong>Solicitud de Acreditaci&oacute;n <br><strong>Título</strong>: ".$oProyecto->getDs_titulo()."<br><strong>Director</strong>: ".$oProyecto->getDs_director()."<br>La solicitud fue recepcionada por la Secretaría de Ciencia y Técnica</p><hr style= 'color: #999999; text-decoration: none;'></body></html>";
				$shtml .= $adjuntos;
				if (!$test) {
					mail($oUsuario->getDs_mail(),'Recepción de solicitud de Acreditacion de Proyectos',$shtml,$cabeceras);
				}
				
				$err[$item]='Se envió la solicitud por mail, ud. recibirá una copia';
				header ( 'Location:index.php?err='.FuncionesComunes::array_envia($err) );	
			}
			else 
				header ( 'Location: index.php?er=2' );
			}
			else 
				header ( 'Location:index.php?err='.FuncionesComunes::array_envia($err) );
		}
		elseif ($enviarE){
			$oEvaluacion = new Evaluacion();
			$oEvaluacion->setCd_proyecto($oProyecto->getCd_proyecto());
			$evaluaciones = EvaluacionQuery::getEvaluacionPorProyecto($oEvaluacion);
			if (count($evaluaciones)>=1){
			
			$fileName = "SOLICITUD_".$oProyecto->getCd_proyecto().".pdf";
			$nombreArchivo = $dir . $fileName;
			//el output se hace en el llamador porque depende de quien lo llame
			
			$oPDF_Proyecto->Output ( $nombreArchivo, 'F');
			
			$file = fopen($nombreArchivo, "r");
			$contenidoA = fread($file, filesize($nombreArchivo));
			$encoded_attach = chunk_split(base64_encode($contenidoA));
			fclose($file);
			$oProyecto->setCd_estado(6);
			$exito = ProyectoQuery::modificarProyecto ( $oProyecto );
			if ($exito){
				$oEvaluacion = new Evaluacion();
				$oEvaluacion->setCd_evaluacion($evaluaciones[0]['cd_evaluacion']);
				EvaluacionQuery::getEvaluacionPorId($oEvaluacion);
				if ($oEvaluacion->getCd_estado()==1){
					$oEvaluacion->setCd_estado(6);
					$oEvaluacion->setDt_fecha(date('YmdHis'));
					EvaluacionQuery::modificarEvaluacion($oEvaluacion);
					$oUsuario = new Usuario();
					$oUsuario->setCd_usuario($evaluaciones[0]['cd_usuario']);
					UsuarioQuery::getUsuarioPorId($oUsuario);
					$oFuncion = new Funcion();
					$oFuncion -> setDs_funcion('Enviar a evaluador');
					FuncionQuery::getFuncionPorDs($oFuncion);
					$oMovimiento = new Movimiento();
					$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
					$oMovimiento->setCd_usuario($cd_usuario);
					$oMovimiento->setDs_movimiento('Envío del proyecto  '.$oProyecto->getDs_titulo().' al evaluador '.$oUsuario->getDs_apynom());
					$agregarCuil="<br>CUIL: ".$oUsuario->getNu_precuil().'-'.$oUsuario->getNu_documento().'-'.$oUsuario->getNu_postcuil()."<br>Clave: 123 (la clave puede ser cambiada una vez ingresado/a al SITE)</p><hr style= 'color: #999999; text-decoration: none;'></body></html>";
					MovimientoQuery::insertarMovimiento($oMovimiento);
				}
				
				$cabeceras="From: ".$nameFrom."<".$mailFrom.">\nReply-To: ".$mailFrom."\n";
	                        
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
				
				if (file_exists($dir)){
					
			      $adjuntos = '';
			     $handle=opendir($dir);
					while ($archivo = readdir($handle))
					{
				        if ((is_file($dir.$archivo))&&(!strchr($archivo,'Evaluacion_'))&&(!strchr($archivo,'EVALUADORES_')))
				        
				         {
				         	//if (!in_array($archivo,$archivosNoEnv)){
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
				         	}
							//$adjuntos .= "--Message-Boundary--\n"; 
				        // }
					}
				}
				
				closedir($handle);
				
				$shtml = $body_top."<html><body><div style='padding-left: 30px; padding-right: 30px; padding-top: 30px ; padding-bottom: 30px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #666666; background-color:#FFFFFF'><img src=\"".WEB_PATH."img/image002.gif\" alt=\"Logo\" longdesc=\"Logo\"><br>ACREDITACION DE PROYECTOS<hr style= 'color: #999999; text-decoration: none;'><p><strong>Evaluación de Proyecto de Acreditaci&oacute;n <br><strong>Título</strong>: ".$oProyecto->getDs_titulo()."<br><strong>Director</strong>: ".$oProyecto->getDs_director()."<br>Para evaluar ingrese <a href='".WEB_PATH."'> aquí</a>";
				$shtmlAdj = $adjuntos;
								
				if ($oEvaluacion->getCd_estado()==1){
					if (!$test) {
						mail($oUsuario->getDs_mail(),'Solicitud de Acreditacion de Proyectos para evaluar',$shtml.$agregarCuil.$shtmlAdj,$cabeceras);
					}
				}
				$oUsuario = new Usuario();
				$oEvaluacion = new Evaluacion();
				$oEvaluacion->setCd_evaluacion($evaluaciones[1]['cd_evaluacion']);
				EvaluacionQuery::getEvaluacionPorId($oEvaluacion);
				if ($oEvaluacion->getCd_estado()==1){
					$oEvaluacion->setCd_estado(6);
					$oEvaluacion->setDt_fecha(date('YmdHis'));
					EvaluacionQuery::modificarEvaluacion($oEvaluacion);
					$oUsuario->setCd_usuario($evaluaciones[1]['cd_usuario']);
					UsuarioQuery::getUsuarioPorId($oUsuario);
					$oFuncion = new Funcion();
					$oFuncion -> setDs_funcion('Enviar a evaluador');
					FuncionQuery::getFuncionPorDs($oFuncion);
					$oMovimiento = new Movimiento();
					$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
					$oMovimiento->setCd_usuario($cd_usuario);
					$oMovimiento->setDs_movimiento('Envío del proyecto '.$oProyecto->getDs_titulo().' al evaluador '.$oUsuario->getDs_apynom());
					$agregarCuil="<br>CUIL: ".$oUsuario->getNu_precuil().'-'.$oUsuario->getNu_documento().'-'.$oUsuario->getNu_postcuil()."<br>Clave: 123 (la clave puede ser cambiada una vez ingresado/a al SITE)</p><hr style= 'color: #999999; text-decoration: none;'></body></html>";
					MovimientoQuery::insertarMovimiento($oMovimiento);
				
					if (!$test) {
						mail($oUsuario->getDs_mail(),'Solicitud de Acreditacion de Proyectos para evaluar',$shtml.$agregarCuil.$shtmlAdj,$cabeceras);
					}
				}
				$oUsuario = new Usuario();
				$oEvaluacion = new Evaluacion();
				$oEvaluacion->setCd_evaluacion($evaluaciones[2]['cd_evaluacion']);
				EvaluacionQuery::getEvaluacionPorId($oEvaluacion);
				if ($oEvaluacion->getCd_estado()==1){
					$oEvaluacion->setCd_estado(6);
					$oEvaluacion->setDt_fecha(date('YmdHis'));
					EvaluacionQuery::modificarEvaluacion($oEvaluacion);
					$oUsuario->setCd_usuario($evaluaciones[2]['cd_usuario']);
					UsuarioQuery::getUsuarioPorId($oUsuario);
					$oFuncion = new Funcion();
					$oFuncion -> setDs_funcion('Enviar a evaluador');
					FuncionQuery::getFuncionPorDs($oFuncion);
					$oMovimiento = new Movimiento();
					$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
					$oMovimiento->setCd_usuario($cd_usuario);
					$oMovimiento->setDs_movimiento('Envío del proyecto '.$oProyecto->getDs_titulo().' al evaluador '.$oUsuario->getDs_apynom());
					$agregarCuil="<br>CUIL: ".$oUsuario->getNu_precuil().'-'.$oUsuario->getNu_documento().'-'.$oUsuario->getNu_postcuil()."<br>Clave: 123 (la clave puede ser cambiada una vez ingresado/a al SITE)</p><hr style= 'color: #999999; text-decoration: none;'></body></html>";
					MovimientoQuery::insertarMovimiento($oMovimiento);
					if (!$test) {
						mail($oUsuario->getDs_mail(),'Solicitud de Acreditacion de Proyectos para evaluar',$shtml.$agregarCuil.$shtmlAdj,$cabeceras);
					}
				}
				header ( 'Location: index.php?er=6' );
			}
			else 
				header ( 'Location: index.php?er=2' );
			}
			else 
				header ( 'Location: index.php?er=5' );
		}
		else{
			if (!PermisoQuery::permisosDeUsuario( $cd_usuario, 'Evaluar proyecto' )) {
				$oPDF_Proyecto->AddPage();
				$oPDF_Proyecto->SetFont( 'times', 'BU', 12 );
				$oPDF_Proyecto->Cell(185,8,'ACREDITACION '.$_SESSION ["nu_yearSession"].' - PLANILLA DE EVALUADORES',0,0,'C');
				$oPDF_Proyecto->TituloEvaluadores($oProyecto->getDs_titulo(),$oProyecto->getDs_director(),$ds_directores,$ds_unidadP, $oProyecto->getDs_facultad(),$oProyecto->getDs_codigodisciplina().' - '.$oProyecto->getDs_disciplina(),$oProyecto->getDs_codigoespecialidad().' - '.$oProyecto->getDs_especialidad());
				$oPDF_Proyecto->SetFont( 'times', 'B', 12 );
				$oPDF_Proyecto->Ln(5);
				$oPDF_Proyecto->MultiCell(185,4,'Evaluadores que no deben ser convocados para analizar el proyecto.');
				$oProyectoevaluador = new Proyectoevaluador();
				$oProyectoevaluador->setCd_proyecto($oProyecto->getCd_proyecto());
				$proyectoevaluadors = ProyectoevaluadorQuery::getProyectoevaluador($oProyectoevaluador);
				$oPDF_Proyecto->Evaluadores($proyectoevaluadors);
				$oPDF_Proyecto->firma2();
			
			}
			$oPDF_Proyecto->Output();
		}
	/*}
	else{
		$err[$item]='Proyecto anterior al 2010';
		header ( 'Location:index.php?err='.FuncionesComunes::array_envia($err) );	
	}*/
} else
	header ( 'Location:../includes/finsolicitud.php' );

?>