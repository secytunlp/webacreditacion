<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';


if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Ver proyecto" )) {
	
	$xtpl = new XTemplate ( 'verproyectoPDF.html' );
	$xtpl->assign ( 'nu_year',  $_SESSION ["nu_yearSession"] );
	$cd_proyecto = $_GET ['cd_proyecto'];
		
	
	$oProyecto = new Proyecto ( );
	$oProyecto->setCd_proyecto ( $cd_proyecto );
	ProyectoQuery::getProyectoPorid ( $oProyecto );
	$xtpl->assign ( 'ds_director',  stripslashes( $oProyecto->getDs_director() ) );
	$xtpl->assign ( 'ds_titulo',  stripslashes( $oProyecto->getDs_titulo () ) );
	$xtpl->assign ( 'ds_abstract',  stripslashes( nl2br($oProyecto->getDs_abstract1()) ) );
	$xtpl->assign ( 'ds_clave1',  stripslashes( $oProyecto->getDs_clave1() ) );
	$xtpl->assign ( 'ds_clave2',  stripslashes( $oProyecto->getDs_clave2() ) );
	$xtpl->assign ( 'ds_clave3',  stripslashes( $oProyecto->getDs_clave3() ) );
	$xtpl->assign ( 'ds_clave4',  stripslashes( $oProyecto->getDs_clave4() ) );
	$xtpl->assign ( 'ds_clave5',  stripslashes( $oProyecto->getDs_clave5() ) );
	$xtpl->assign ( 'ds_clave6',  stripslashes( $oProyecto->getDs_clave6() ) );
	
	if ($oProyecto->getNu_duracion()==2){		
			$xtpl->assign ( 'ds_duracion',  "BIANUAL" );
			
		}
	if ($oProyecto->getNu_duracion()==4){		
		$xtpl->assign ( 'ds_duracion',  "TETRA ANUAL" );
		
	}
	
	if ($oProyecto->getDs_tipo()=='B'){		
		$xtpl->assign ( 'ds_tipoinvestigacion',  "BASICA" );
	}
	
	if ($oProyecto->getDs_tipo()=='A'){		
		$xtpl->assign ( 'ds_tipoinvestigacion',  "APLICADA" );
	}
	
	if ($oProyecto->getDs_tipo()=='D'){		
		$xtpl->assign ( 'ds_tipoinvestigacion',  "DESARROLLO" );
	}
	
	if ($oProyecto->getDs_tipo()=='C'){		
		$xtpl->assign ( 'ds_tipoinvestigacion',  "CREACION" );
	}
	
	$xtpl->assign ( 'ds_codigodisciplina',  stripslashes( $oProyecto->getDs_codigodisciplina()) );
	$xtpl->assign ( 'ds_disciplina',  stripslashes( $oProyecto->getDs_disciplina()) );
	$xtpl->assign ( 'ds_codigoespecialidad',  stripslashes( $oProyecto->getDs_codigoespecialidad()) );
	$xtpl->assign ( 'ds_especialidad',  stripslashes( $oProyecto->getDs_especialidad()) );
	$xtpl->assign ( 'ds_codigocampo',  stripslashes( $oProyecto->getDs_codigocampo()) );
	$xtpl->assign ( 'ds_campo',  stripslashes( $oProyecto->getDs_campo()) );
	$xtpl->assign ( 'ds_linea',  stripslashes( $oProyecto->getDs_linea()) );
	if ($oProyecto->getBl_transferencia()==1){		
			$xtpl->assign ( 'ds_transferenciaprevista',  "SI" );
		}
	if ($oProyecto->getBl_transferencia()==0){		
		$xtpl->assign ( 'ds_transferenciaprevista',  "NO" );
	}
	$xtpl->assign ( 'ds_marco',  stripslashes( $oProyecto->getDs_marco()) );
	$xtpl->assign ( 'ds_aporte',  stripslashes( $oProyecto->getDs_aporte()) );
	$xtpl->assign ( 'ds_objetivos',  stripslashes( $oProyecto->getDs_objetivos()) );
	$xtpl->assign ( 'ds_metodologia',  stripslashes( $oProyecto->getDs_metodologia()) );
	$xtpl->assign ( 'ds_antecedentes',  stripslashes( $oProyecto->getDs_antecedentes()) );
	$xtpl->assign ( 'ds_avance',  stripslashes( $oProyecto->getDs_avance()) );
	$xtpl->assign ( 'ds_formacion',  stripslashes( $oProyecto->getDs_formacion()) );
	$xtpl->assign ( 'ds_transferencia',  stripslashes( $oProyecto->getDs_transferencia()) );
	$xtpl->assign ( 'ds_plan',  stripslashes( $oProyecto->getDs_plan()) );
	$xtpl->assign ( 'ds_disponible',  stripslashes( $oProyecto->getDs_disponible()) );
	$xtpl->assign ( 'ds_necesario',  stripslashes( $oProyecto->getDs_necesario()) );
	$xtpl->assign ( 'ds_fuentes',  stripslashes( $oProyecto->getDs_fuentes) );
	$xtpl->assign ( 'nu_ano1',  number_format($oProyecto->getNu_ano1(),2) );
	$xtpl->assign ( 'nu_ano2',  number_format($oProyecto->getNu_ano2(),2) );
	$xtpl->assign ( 'nu_ano3',  number_format($oProyecto->getNu_ano3(),2) );
	$xtpl->assign ( 'nu_ano4',  number_format($oProyecto->getNu_ano4(),2) );
	$xtpl->assign ( 'ds_factibilidad',  stripslashes( $oProyecto->getDs_factibilidad()) );
	$xtpl->assign ( 'ds_fondotramite',  stripslashes( $oProyecto->getDs_fondotramite()) );
	$oFondo = new Fondo();
	$oFondo->setCd_proyecto($oProyecto->getCd_proyecto());
	$oFondo->setBl_tramite(0);
	$fondos = ($oProyecto->getFondos())?$oProyecto->getFondos():FondoQuery::getFondo($oFondo);
	$count = count ( $fondos );
	for($i = 0; $i < $count; $i ++) {
		if (!$fondos[$i]['bl_tramite']){
			$fondos [$i]['nu_monto']='$'.number_format($fondos [$i]['nu_monto'],2);
			
			$xtpl->assign ( 'DATOS', $fondos [$i] );
			$xtpl->parse ( 'main.rowdisp' );
		}
		
	}
	$oFondo = new Fondo();
	$oFondo->setCd_proyecto($oProyecto->getCd_proyecto());
	$oFondo->setBl_tramite(1);
	$fondos = ($oProyecto->getFondos())?$oProyecto->getFondos():FondoQuery::getFondo($oFondo);
	$count = count ( $fondos );
	for($i = 0; $i < $count; $i ++) {
		if ($fondos[$i]['bl_tramite']){
			$fondos [$i]['nu_monto']='$'.number_format($fondos [$i]['nu_monto'],2);
			
			$xtpl->assign ( 'DATOS', $fondos [$i] );
			$xtpl->parse ( 'main.rownece' );
		}
		
	}
	$year = $_SESSION ["nu_yearSession"];
		
	$xtpl->assign ( 'nu_year1',  $year );
	$xtpl->assign ( 'nu_year2',  $year+1 );
	$xtpl->assign ( 'nu_year3',  $year+2 );
	$xtpl->assign ( 'nu_year4',  $year+3 );
	$xtpl->assign ( 'nu_consumo1',  '$'.number_format($oProyecto->getNu_consumo1(), 2) );
	$xtpl->assign ( 'nu_consumo2',  '$'.number_format($oProyecto->getNu_consumo2(), 2) );
	$xtpl->assign ( 'nu_consumo3',  '$'.number_format($oProyecto->getNu_consumo3(), 2) );
	$xtpl->assign ( 'nu_consumo4',  '$'.number_format($oProyecto->getNu_consumo4(), 2) );
	$xtpl->assign ( 'nu_servicios1',  '$'.number_format($oProyecto->getNu_servicios1(), 2) );
	$xtpl->assign ( 'nu_servicios2',  '$'.number_format($oProyecto->getNu_servicios2(), 2) );
	$xtpl->assign ( 'nu_servicios3',  '$'.number_format($oProyecto->getNu_servicios3(), 2) );
	$xtpl->assign ( 'nu_servicios4',  '$'.number_format($oProyecto->getNu_servicios4(), 2) );
	$xtpl->assign ( 'nu_bibliografia1',  '$'.number_format($oProyecto->getNu_bibliografia1(), 2) );
	$xtpl->assign ( 'nu_bibliografia2',  '$'.number_format($oProyecto->getNu_bibliografia2(), 2) );
	$xtpl->assign ( 'nu_bibliografia3',  '$'.number_format($oProyecto->getNu_bibliografia3(), 2) );
	$xtpl->assign ( 'nu_bibliografia4',  '$'.number_format($oProyecto->getNu_bibliografia4(), 2) );
	$xtpl->assign ( 'nu_cientifico1',  '$'.number_format($oProyecto->getNu_cientifico1(), 2) );
	$xtpl->assign ( 'nu_cientifico2',  '$'.number_format($oProyecto->getNu_cientifico2(), 2) );
	$xtpl->assign ( 'nu_cientifico3',  '$'.number_format($oProyecto->getNu_cientifico3(), 2) );
	$xtpl->assign ( 'nu_cientifico4',  '$'.number_format($oProyecto->getNu_cientifico4(), 2) );
	$xtpl->assign ( 'nu_computacion1',  '$'.number_format($oProyecto->getNu_computacion1(), 2) );
	$xtpl->assign ( 'nu_computacion2',  '$'.number_format($oProyecto->getNu_computacion2(), 2) );
	$xtpl->assign ( 'nu_computacion3',  '$'.number_format($oProyecto->getNu_computacion3(), 2) );
	$xtpl->assign ( 'nu_computacion4',  '$'.number_format($oProyecto->getNu_computacion4(), 2) );
	$xtpl->assign ( 'nu_otros1',  '$'.number_format($oProyecto->getNu_otros1(), 2) );
	$xtpl->assign ( 'nu_otros2',  '$'.number_format($oProyecto->getNu_otros2(), 2) );
	$xtpl->assign ( 'nu_otros3',  '$'.number_format($oProyecto->getNu_otros3(), 2) );
	$xtpl->assign ( 'nu_otros4',  '$'.number_format($oProyecto->getNu_otros4(), 2) );
	$xtpl->assign ( 'nu_total1',  '$'.number_format($oProyecto->getNu_consumo1()+$oProyecto->getNu_servicios1()+$oProyecto->getNu_bibliografia1()+$oProyecto->getNu_cientifico1()+$oProyecto->getNu_computacion1()+$oProyecto->getNu_otros1(), 2) );
	$xtpl->assign ( 'nu_total2',  '$'.number_format($oProyecto->getNu_consumo2()+$oProyecto->getNu_servicios2()+$oProyecto->getNu_bibliografia2()+$oProyecto->getNu_cientifico2()+$oProyecto->getNu_computacion2()+$oProyecto->getNu_otros2(), 2) );
	$xtpl->assign ( 'nu_total3',  '$'.number_format($oProyecto->getNu_consumo3()+$oProyecto->getNu_servicios3()+$oProyecto->getNu_bibliografia3()+$oProyecto->getNu_cientifico3()+$oProyecto->getNu_computacion3()+$oProyecto->getNu_otros3(), 2) );
	$xtpl->assign ( 'nu_total4',  '$'.number_format($oProyecto->getNu_consumo4()+$oProyecto->getNu_servicios4()+$oProyecto->getNu_bibliografia4()+$oProyecto->getNu_cientifico4()+$oProyecto->getNu_computacion4()+$oProyecto->getNu_otros4(), 2) );
	$oIntegrante = new Integrante();
	$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
	$oIntegrante->setCd_tipoinvestigador(1);
	$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
	$countp = count ( $integrantes );
	for($j = 0; $j < $countp; $j ++) {
		$oDocente = new Docente ( );
		$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
		DocenteQuery::getDocentePorid ( $oDocente );
		$xtpl->assign ( 'ds_catdir',  ( $oDocente->getDs_categoria()) );
		$xtpl->assign ( 'ds_cargodir',  ( $oDocente->getDs_cargo() ) );
		$xtpl->assign ( 'ds_deddir',  ( $oDocente->getDs_deddoc()) );
		$xtpl->assign ( 'ds_facultaddir',  ( $oDocente->getDs_facultad() ) );
		$xtpl->assign ( 'ds_universidaddir',  ( $oDocente->getDs_universidad() ) );
		$xtpl->assign ( 'ds_carrerainvdir',  ( $oDocente->getDs_carrerainv()) );
		$xtpl->assign ( 'ds_organismodir',  ( $oDocente->getDs_organismo()) );
		
		$ds_unidad = '';	
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
		$ds_unidad .= $oTipounidad->getDs_tipounidad();
		//if ($oUnidad->getCd_tipounidad()){
			UnidadQuery::getUnidadPorId($oUnidad);
			$html[$nivel]=$oUnidad->getDs_unidad();
		//}
		for ($i=0; $i < count($html); $i++){
			$ds_unidad .= ' - '.$html[$i];
		}
		
		$xtpl->assign ( 'ds_unidaddir',  $ds_unidad );
		$xtpl->assign ( 'nu_cuildir',  ( $oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil() ) );
		$xtpl->assign ( 'ds_titulodir',  ( $oDocente->getDs_titulo() ) );
		$xtpl->assign ( 'ds_calledir',  ( $oDocente->getDs_calle() ) );
		$xtpl->assign ( 'nu_nrodir',  ( $oDocente->getNu_nro() ) );
		$xtpl->assign ( 'nu_pisodir',  ( $oDocente->getNu_piso() ) );
		$xtpl->assign ( 'ds_deptodir',  ( $oDocente->getDs_depto() ) );
		$xtpl->assign ( 'ds_localidaddir',  ( $oDocente->getDs_localidad() ) );
		$xtpl->assign ( 'ds_provinciadir',  ( $oDocente->getDs_provincia() ) );
		$xtpl->assign ( 'nu_cpdir',  ( $oDocente->getNu_cp() ) );
		$xtpl->assign ( 'ds_maildir',  ( $oDocente->getDs_mail() ) );
		
		$proyectos = ProyectoQuery::getProyectosDocentes($oDocente->getCd_docente() );
		$count = count ( $proyectos );
		for($i = 0; $i < $count; $i ++) {
			if ($cd_proyecto == $proyectos [$i]['cd_proyecto']) $xtpl->assign ( 'nu_horasinvdir',  $proyectos [$i]['nu_horasinv'] );
			$proyectos [$i]['dt_ini']=FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini']);
			$proyectos [$i]['dt_fin']=FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin']);
			$xtpl->assign ( 'DATOS', $proyectos [$i] );
			$xtpl->parse ( 'main.rowdir' );
		}
	}
	
	$oIntegrante = new Integrante();
	$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
	$oIntegrante->setCd_tipoinvestigador(2);
	$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
	$countp = count ( $integrantes );
	for($j = 0; $j < $countp; $j ++) {
		$oDocente = new Docente ( );
		$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
		DocenteQuery::getDocentePorid ( $oDocente );
		$xtpl->assign ( 'ds_codirector',  ( $oDocente->getDs_apellido().', '.$oDocente->getDs_nombre() ) );
		$xtpl->assign ( 'ds_catcodir',  ( $oDocente->getDs_categoria()) );
		$xtpl->assign ( 'ds_cargocodir',  ( $oDocente->getDs_cargo() ) );
		$xtpl->assign ( 'ds_dedcodir',  ( $oDocente->getDs_deddoc()) );
		$xtpl->assign ( 'ds_facultadcodir',  ( $oDocente->getDs_facultad() ) );
		$xtpl->assign ( 'ds_universidadcodir',  ( $oDocente->getDs_universidad() ) );
		$xtpl->assign ( 'ds_carrerainvcodir',  ( $oDocente->getDs_carrerainv()) );
		$xtpl->assign ( 'ds_organismocodir',  ( $oDocente->getDs_organismo()) );
		
		$ds_unidad = '';	
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
		$ds_unidad .= $oTipounidad->getDs_tipounidad();
		//if ($oUnidad->getCd_tipounidad()){
			UnidadQuery::getUnidadPorId($oUnidad);
			$html[$nivel]=$oUnidad->getDs_unidad();
		//}
		for ($i=0; $i < count($html); $i++){
			$ds_unidad .= ' - '.$html[$i];
		}
		
		$xtpl->assign ( 'ds_unidadcodir',  $ds_unidad );
		$xtpl->assign ( 'nu_cuilcodir',  ( $oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil() ) );
		$xtpl->assign ( 'ds_titulocodir',  ( $oDocente->getDs_titulo() ) );
		$xtpl->assign ( 'ds_callecodir',  ( $oDocente->getDs_calle() ) );
		$xtpl->assign ( 'nu_nrocodir',  ( $oDocente->getNu_nro() ) );
		$xtpl->assign ( 'nu_pisocodir',  ( $oDocente->getNu_piso() ) );
		$xtpl->assign ( 'ds_deptocodir',  ( $oDocente->getDs_depto() ) );
		$xtpl->assign ( 'ds_localidadcodir',  ( $oDocente->getDs_localidad() ) );
		$xtpl->assign ( 'ds_provinciacodir',  ( $oDocente->getDs_provincia() ) );
		$xtpl->assign ( 'nu_cpcodir',  ( $oDocente->getNu_cp() ) );
		$xtpl->assign ( 'ds_mailcodir',  ( $oDocente->getDs_mail() ) );
		
		if ($oDocente->getCd_docente()){
			$ds_codirectoresquema = '<p><strong>6.2 CODIRECTOR&nbsp; </strong><br />
		-  Apellido y Nombres: <strong>'.$oDocente->getDs_apellido().', '.$oDocente->getDs_nombre().'</strong><br />
		-  Cargo/s. '.$oDocente->getDs_cargo().' <br />
		-  Dedicaci&oacute;n/es '.$oDocente->getDs_deddoc().' <br />
		-  Facultad a la que pertenece&nbsp;  '.$oDocente->getDs_facultad().'<br />
		-  Universidad. '.$oDocente->getDs_universidad().' <br />
		-  Lugar de Trabajo. '.$ds_unidad.' <br />
		- Categor&iacute;a docente -  investigador (I, II, III, IV, V)&nbsp; '.$oDocente->getDs_categoria().' <br />
		-  Cargo en la Carrera  del Investigador (CIC - CONICET)&nbsp; '.$oDocente->getDs_carrerainv().' - '.$oDocente->getDs_organismo().' <br />
		-  T&iacute;tulo. '.$oDocente->getDs_titulo().' <br />';
		$proyectos = ProyectoQuery::getProyectosDocentes($oDocente->getCd_docente() );
		$count = count ( $proyectos );
		
		for($i = 0; $i < $count; $i ++) {
			if ($cd_proyecto == $proyectos [$i]['cd_proyecto']) $nu_horasinvcodir = $proyectos [$i]['nu_horasinv'];
			$proyectos [$i]['dt_ini']=FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini']);
			$proyectos [$i]['dt_fin']=FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin']);
			
			
		}
			
			
		$ds_codirectoresquema .= '-  Dedicaci&oacute;n en este proyecto en horas por semana. (<em>Los miembros de proyectos con cargo de dedicaci&oacute;n exclusiva podr&aacute;n  aportar un m&aacute;ximo de 35 hs; con cargo de dedicaci&oacute;n semiexclusiva&nbsp; un m&aacute;ximo de 15 hs y con cargo de dedicaci&oacute;n  simple un m&aacute;ximo de&nbsp; 4 hs</em>). '.$nu_horasinvcodir.' <br />
		-  Participaci&oacute;n en proyectos: <em>El  Director/es y cada integrante deber&aacute; especificar todos los proyectos en los que  interviene (t&iacute;tulo y director) indicando claramente la participaci&oacute;n en horas  semanales en cada proyecto (incluyendo el proyecto en acreditaci&oacute;n).</em><br />
		<em>Los  miembros del proyecto con mayor dedicaci&oacute;n podr&aacute;n participar hasta en 2 (dos)  proyectos acreditados, y los miembros con dedicaci&oacute;n simple en un (1) proyecto</em>.
		</p>
		  <table border="1" cellspacing="0" cellpadding="0" width="500">
		    <tr>
		    <th scope="col"><div align="center">C&oacute;digo</div></th>
		    <th scope="col"><div align="center">T&iacute;tulo</div></th>
			 <th scope="col"><div align="center">Director</div></th>
			  <th scope="col"><div align="center">Inicio</div></th>
			   <th scope="col"><div align="center">Fin</div></th>
			   <th scope="col"><div align="center">Horas</div></th>
		  </tr>';		
		for($i = 0; $i < $count; $i ++) {	
			$ds_codirectoresquema .= '<tr>
				<td>'.$proyectos [$i]['ds_codigo'].'</td>
				<td><div align="left">'.$proyectos [$i]['ds_titulo'].'</div></td>
				<td><div align="left">'.$proyectos [$i]['ds_director'].'</div></td>
				<td>'.$proyectos [$i]['dt_ini'].'</td>
				<td>'.$proyectos [$i]['dt_fin'].'</td>
				<td>'.$proyectos [$i]['nu_horasinv'].'</td>
			</tr>';
		}
			
		$ds_codirectoresquema .= '</table>';
		}
	}
	$xtpl->assign ( 'ds_codirectoresquema',  $ds_codirectoresquema );
	
	$ds_formadosesquema = '';
	$oIntegrante = new Integrante();
	$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
	$oIntegrante->setCd_tipoinvestigador(3);
	$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
	$countp = count ( $integrantes );
	if ($countp > 0){
		$ds_formadosesquema .= '<p><strong>6.3 INVESTIGADORES FORMADOS&nbsp; </strong></p>';
		for($j = 0; $j < $countp; $j ++) {
			$oDocente = new Docente ( );
			$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
			DocenteQuery::getDocentePorid ( $oDocente );
			if ($oDocente->getCd_docente()){
				$ds_unidad = '';	
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
				$ds_unidad .= $oTipounidad->getDs_tipounidad();
				//if ($oUnidad->getCd_tipounidad()){
					UnidadQuery::getUnidadPorId($oUnidad);
					$html[$nivel]=$oUnidad->getDs_unidad();
				//}
				for ($i=0; $i < count($html); $i++){
					$ds_unidad .= ' - '.$html[$i];
				}
				
					$ds_formadosesquema .= '<p>-  Apellido y Nombres: <strong>'.$oDocente->getDs_apellido().', '.$oDocente->getDs_nombre().'</strong><br />
				-  Cargo/s. '.$oDocente->getDs_cargo().' <br />
				-  Dedicaci&oacute;n/es '.$oDocente->getDs_deddoc().' <br />
				-  Facultad a la que pertenece&nbsp;  '.$oDocente->getDs_facultad().'<br />
				-  Universidad. '.$oDocente->getDs_universidad().' <br />
				-  Lugar de Trabajo. '.$ds_unidad.' <br />
				- Categor&iacute;a docente -  investigador (I, II, III, IV, V)&nbsp; '.$oDocente->getDs_categoria().' <br />
				-  Cargo en la Carrera  del Investigador (CIC - CONICET)&nbsp; '.$oDocente->getDs_carrerainv().' - '.$oDocente->getDs_organismo().' <br />
				-  T&iacute;tulo. '.$oDocente->getDs_titulo().' <br />';
				$proyectos = ProyectoQuery::getProyectosDocentes($oDocente->getCd_docente() );
				$count = count ( $proyectos );
				
				for($i = 0; $i < $count; $i ++) {
					if ($cd_proyecto == $proyectos [$i]['cd_proyecto']) $nu_horasinvcodir = $proyectos [$i]['nu_horasinv'];
					$proyectos [$i]['dt_ini']=FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini']);
					$proyectos [$i]['dt_fin']=FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin']);
					
					
				}
					
					
				$ds_formadosesquema .= '-  Dedicaci&oacute;n en este proyecto en horas por semana. (<em>Los miembros de proyectos con cargo de dedicaci&oacute;n exclusiva podr&aacute;n  aportar un m&aacute;ximo de 35 hs; con cargo de dedicaci&oacute;n semiexclusiva&nbsp; un m&aacute;ximo de 15 hs y con cargo de dedicaci&oacute;n  simple un m&aacute;ximo de&nbsp; 4 hs</em>). '.$nu_horasinvcodir.' <br />
				-  Participaci&oacute;n en proyectos: <em>El  Director/es y cada integrante deber&aacute; especificar todos los proyectos en los que  interviene (t&iacute;tulo y director) indicando claramente la participaci&oacute;n en horas  semanales en cada proyecto (incluyendo el proyecto en acreditaci&oacute;n).</em><br />
				<em>Los  miembros del proyecto con mayor dedicaci&oacute;n podr&aacute;n participar hasta en 2 (dos)  proyectos acreditados, y los miembros con dedicaci&oacute;n simple en un (1) proyecto</em>.
				
				 <table border="1" cellspacing="0" cellpadding="0" width="500">
				    <tr>
				    <th scope="col"><div align="center">C&oacute;digo</div></th>
				    <th scope="col"><div align="center">T&iacute;tulo</div></th>
					 <th scope="col"><div align="center">Director</div></th>
					  <th scope="col"><div align="center">Inicio</div></th>
					   <th scope="col"><div align="center">Fin</div></th>
					   <th scope="col"><div align="center">Horas</div></th>
				  </tr>';		
				for($i = 0; $i < $count; $i ++) {	
					$ds_formadosesquema .= '<tr>
						<td>'.$proyectos [$i]['ds_codigo'].'</td>
						<td><div align="left">'.$proyectos [$i]['ds_titulo'].'</div></td>
						<td><div align="left">'.$proyectos [$i]['ds_director'].'</div></td>
						<td>'.$proyectos [$i]['dt_ini'].'</td>
						<td>'.$proyectos [$i]['dt_fin'].'</td>
						<td>'.$proyectos [$i]['nu_horasinv'].'</td>
					</tr>';
				}
					
				$ds_formadosesquema .= '</table>';
			}
			
		}
		
	}
	$xtpl->assign ( 'ds_formadosesquema',  $ds_formadosesquema );
	
	$ds_formacionesquema = '';
	$oIntegrante = new Integrante();
	$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
	$oIntegrante->setCd_tipoinvestigador(4);
	$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
	$countp = count ( $integrantes );
	if ($countp > 0){
		$ds_formacionesquema .= '<p><strong>6.4 INVESTIGADORES EN FORMACION&nbsp; </strong></p>';
		for($j = 0; $j < $countp; $j ++) {
			$oDocente = new Docente ( );
			$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
			DocenteQuery::getDocentePorid ( $oDocente );
			if ($oDocente->getCd_docente()){
				$ds_unidad = '';	
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
				$ds_unidad .= $oTipounidad->getDs_tipounidad();
			//	if ($oUnidad->getCd_tipounidad()){
					UnidadQuery::getUnidadPorId($oUnidad);
					$html[$nivel]=$oUnidad->getDs_unidad();
			//	}
				for ($i=0; $i < count($html); $i++){
					$ds_unidad .= ' - '.$html[$i];
				}
				
					$ds_formacionesquema .= '<p>-  Apellido y Nombres: <strong>'.$oDocente->getDs_apellido().', '.$oDocente->getDs_nombre().'</strong><br />
				-  Cargo/s. '.$oDocente->getDs_cargo().' <br />
				-  Dedicaci&oacute;n/es '.$oDocente->getDs_deddoc().' <br />
				-  Facultad a la que pertenece&nbsp;  '.$oDocente->getDs_facultad().'<br />
				-  Universidad. '.$oDocente->getDs_universidad().' <br />
				-  Lugar de Trabajo. '.$ds_unidad.' <br />
				- Categor&iacute;a docente -  investigador (I, II, III, IV, V)&nbsp; '.$oDocente->getDs_categoria().' <br />
				-  Cargo en la Carrera  del Investigador (CIC - CONICET)&nbsp; '.$oDocente->getDs_carrerainv().' - '.$oDocente->getDs_organismo().' <br />
				-  T&iacute;tulo. '.$oDocente->getDs_titulo().' <br />';
				$proyectos = ProyectoQuery::getProyectosDocentes($oDocente->getCd_docente() );
				$count = count ( $proyectos );
				
				for($i = 0; $i < $count; $i ++) {
					if ($cd_proyecto == $proyectos [$i]['cd_proyecto']) $nu_horasinvcodir = $proyectos [$i]['nu_horasinv'];
					$proyectos [$i]['dt_ini']=FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini']);
					$proyectos [$i]['dt_fin']=FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin']);
					
					
				}
					
					
				$ds_formacionesquema .= '-  Dedicaci&oacute;n en este proyecto en horas por semana. (<em>Los miembros de proyectos con cargo de dedicaci&oacute;n exclusiva podr&aacute;n  aportar un m&aacute;ximo de 35 hs; con cargo de dedicaci&oacute;n semiexclusiva&nbsp; un m&aacute;ximo de 15 hs y con cargo de dedicaci&oacute;n  simple un m&aacute;ximo de&nbsp; 4 hs</em>). '.$nu_horasinvcodir.' <br />
				-  Participaci&oacute;n en proyectos: <em>El  Director/es y cada integrante deber&aacute; especificar todos los proyectos en los que  interviene (t&iacute;tulo y director) indicando claramente la participaci&oacute;n en horas  semanales en cada proyecto (incluyendo el proyecto en acreditaci&oacute;n).</em><br />
				<em>Los  miembros del proyecto con mayor dedicaci&oacute;n podr&aacute;n participar hasta en 2 (dos)  proyectos acreditados, y los miembros con dedicaci&oacute;n simple en un (1) proyecto</em>.
				
				 <table border="1" cellspacing="0" cellpadding="0" width="500">
				    <tr>
				    <th scope="col"><div align="center">C&oacute;digo</div></th>
				    <th scope="col"><div align="center">T&iacute;tulo</div></th>
					 <th scope="col"><div align="center">Director</div></th>
					  <th scope="col"><div align="center">Inicio</div></th>
					   <th scope="col"><div align="center">Fin</div></th>
					   <th scope="col"><div align="center">Horas</div></th>
				  </tr>';		
				for($i = 0; $i < $count; $i ++) {	
					$ds_formacionesquema .= '<tr>
						<td>'.$proyectos [$i]['ds_codigo'].'</td>
						<td><div align="left">'.$proyectos [$i]['ds_titulo'].'</div></td>
						<td><div align="left">'.$proyectos [$i]['ds_director'].'</div></td>
						<td>'.$proyectos [$i]['dt_ini'].'</td>
						<td>'.$proyectos [$i]['dt_fin'].'</td>
						<td>'.$proyectos [$i]['nu_horasinv'].'</td>
					</tr>';
				}
					
				$ds_formacionesquema .= '</table>';
			}
			
		}
		
	}
	$xtpl->assign ( 'ds_formacionesquema',  $ds_formacionesquema );
	
	$ds_becariosesquema = '';
	$oIntegrante = new Integrante();
	$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
	$oIntegrante->setCd_tipoinvestigador(5);
	$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
	$countp = count ( $integrantes );
	if ($countp > 0){
		$ds_becariosesquema .= '<p><strong>6.5 TESISTAS, BECARIOS&nbsp; </strong></p>';
		for($j = 0; $j < $countp; $j ++) {
			$oDocente = new Docente ( );
			$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
			DocenteQuery::getDocentePorid ( $oDocente );
			if ($oDocente->getCd_docente()){
				$ds_unidad = '';	
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
				$ds_unidad .= $oTipounidad->getDs_tipounidad();
			//	if ($oUnidad->getCd_tipounidad()){
					UnidadQuery::getUnidadPorId($oUnidad);
					$html[$nivel]=$oUnidad->getDs_unidad();
			//	}
				for ($i=0; $i < count($html); $i++){
					$ds_unidad .= ' - '.$html[$i];
				}
				
					$ds_becariosesquema .= '<p>-  Apellido y Nombres: <strong>'.$oDocente->getDs_apellido().', '.$oDocente->getDs_nombre().'</strong><br />
				-  Cargo/s. '.$oDocente->getDs_cargo().' <br />
				-  Dedicaci&oacute;n/es '.$oDocente->getDs_deddoc().' <br />
				-  Facultad a la que pertenece&nbsp;  '.$oDocente->getDs_facultad().'<br />
				-  Universidad. '.$oDocente->getDs_universidad().' <br />
				-  Lugar de Trabajo. '.$ds_unidad.' <br />
				- Categor&iacute;a docente -  investigador (I, II, III, IV, V)&nbsp; '.$oDocente->getDs_categoria().' <br />
				-  Cargo en la Carrera  del Investigador (CIC - CONICET)&nbsp; '.$oDocente->getDs_carrerainv().' - '.$oDocente->getDs_organismo().' <br />
				-  T&iacute;tulo. '.$oDocente->getDs_titulo().' <br />';
				$proyectos = ProyectoQuery::getProyectosDocentes($oDocente->getCd_docente() );
				$count = count ( $proyectos );
				
				for($i = 0; $i < $count; $i ++) {
					if ($cd_proyecto == $proyectos [$i]['cd_proyecto']) $nu_horasinvcodir = $proyectos [$i]['nu_horasinv'];
					$proyectos [$i]['dt_ini']=FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini']);
					$proyectos [$i]['dt_fin']=FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin']);
					
					
				}
					
					
				$ds_becariosesquema .= '-  Dedicaci&oacute;n en este proyecto en horas por semana. (<em>Los miembros de proyectos con cargo de dedicaci&oacute;n exclusiva podr&aacute;n  aportar un m&aacute;ximo de 35 hs; con cargo de dedicaci&oacute;n semiexclusiva&nbsp; un m&aacute;ximo de 15 hs y con cargo de dedicaci&oacute;n  simple un m&aacute;ximo de&nbsp; 4 hs</em>). '.$nu_horasinvcodir.' <br />
				-  Participaci&oacute;n en proyectos: <em>El  Director/es y cada integrante deber&aacute; especificar todos los proyectos en los que  interviene (t&iacute;tulo y director) indicando claramente la participaci&oacute;n en horas  semanales en cada proyecto (incluyendo el proyecto en acreditaci&oacute;n).</em><br />
				<em>Los  miembros del proyecto con mayor dedicaci&oacute;n podr&aacute;n participar hasta en 2 (dos)  proyectos acreditados, y los miembros con dedicaci&oacute;n simple en un (1) proyecto</em>.
				
				 <table border="1" cellspacing="0" cellpadding="0" width="500">
				    <tr>
				    <th scope="col"><div align="center">C&oacute;digo</div></th>
				    <th scope="col"><div align="center">T&iacute;tulo</div></th>
					 <th scope="col"><div align="center">Director</div></th>
					  <th scope="col"><div align="center">Inicio</div></th>
					   <th scope="col"><div align="center">Fin</div></th>
					   <th scope="col"><div align="center">Horas</div></th>
				  </tr>';		
				for($i = 0; $i < $count; $i ++) {	
					$ds_becariosesquema .= '<tr>
						<td>'.$proyectos [$i]['ds_codigo'].'</td>
						<td><div align="left">'.$proyectos [$i]['ds_titulo'].'</div></td>
						<td><div align="left">'.$proyectos [$i]['ds_director'].'</div></td>
						<td>'.$proyectos [$i]['dt_ini'].'</td>
						<td>'.$proyectos [$i]['dt_fin'].'</td>
						<td>'.$proyectos [$i]['nu_horasinv'].'</td>
					</tr>';
				}
					
				$ds_becariosesquema .= '</table>';
			}
			
		}
		
	}
	$xtpl->assign ( 'ds_becariosesquema',  $ds_becariosesquema );
	
	$ds_colaboladoresesquema = '';
	$oIntegrante = new Integrante();
	$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
	$oIntegrante->setCd_tipoinvestigador(6);
	$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
	$countp = count ( $integrantes );
	if ($countp > 0){
		$ds_colaboladoresesquema .= '<p><strong>6.6 COLABOLADORES&nbsp; </strong>(Docentes ad-honorem / adscriptos, profesionales sin cargo docente y alumnos avanzados(*) -podrán adeudar hasta seis (6) asignaturas de su Plan de Estudios-). </p>';
		for($j = 0; $j < $countp; $j ++) {
			$oDocente = new Docente ( );
			$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
			DocenteQuery::getDocentePorid ( $oDocente );
			if ($oDocente->getCd_docente()){
				$ds_unidad = '';	
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
				$ds_unidad .= $oTipounidad->getDs_tipounidad();
				//if ($oUnidad->getCd_tipounidad()){
					UnidadQuery::getUnidadPorId($oUnidad);
					$html[$nivel]=$oUnidad->getDs_unidad();
			//	}
				for ($i=0; $i < count($html); $i++){
					$ds_unidad .= ' - '.$html[$i];
				}
				
					$ds_colaboladoresesquema .= '<p>-  Apellido y Nombres: <strong>'.$oDocente->getDs_apellido().', '.$oDocente->getDs_nombre().'</strong><br />
				-  Cargo/s. '.$oDocente->getDs_cargo().' <br />
				-  Dedicaci&oacute;n/es '.$oDocente->getDs_deddoc().' <br />
				-  Facultad a la que pertenece&nbsp;  '.$oDocente->getDs_facultad().'<br />
				-  Universidad. '.$oDocente->getDs_universidad().' <br />
				-  Lugar de Trabajo. '.$ds_unidad.' <br />
				- Categor&iacute;a docente -  investigador (I, II, III, IV, V)&nbsp; '.$oDocente->getDs_categoria().' <br />
				-  Cargo en la Carrera  del Investigador (CIC - CONICET)&nbsp; '.$oDocente->getDs_carrerainv().' - '.$oDocente->getDs_organismo().' <br />
				-  T&iacute;tulo. '.$oDocente->getDs_titulo().' <br />';
				$proyectos = ProyectoQuery::getProyectosDocentes($oDocente->getCd_docente() );
				$count = count ( $proyectos );
				
				for($i = 0; $i < $count; $i ++) {
					if ($cd_proyecto == $proyectos [$i]['cd_proyecto']) $nu_horasinvcodir = $proyectos [$i]['nu_horasinv'];
					$proyectos [$i]['dt_ini']=FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini']);
					$proyectos [$i]['dt_fin']=FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin']);
					
					
				}
					
					
				$ds_colaboladoresesquema .= '-  Dedicaci&oacute;n en este proyecto en horas por semana. (<em>Los miembros de proyectos con cargo de dedicaci&oacute;n exclusiva podr&aacute;n  aportar un m&aacute;ximo de 35 hs; con cargo de dedicaci&oacute;n semiexclusiva&nbsp; un m&aacute;ximo de 15 hs y con cargo de dedicaci&oacute;n  simple un m&aacute;ximo de&nbsp; 4 hs</em>). '.$nu_horasinvcodir.' <br />
				-  Participaci&oacute;n en proyectos: <em>El  Director/es y cada integrante deber&aacute; especificar todos los proyectos en los que  interviene (t&iacute;tulo y director) indicando claramente la participaci&oacute;n en horas  semanales en cada proyecto (incluyendo el proyecto en acreditaci&oacute;n).</em><br />
				<em>Los  miembros del proyecto con mayor dedicaci&oacute;n podr&aacute;n participar hasta en 2 (dos)  proyectos acreditados, y los miembros con dedicaci&oacute;n simple en un (1) proyecto</em>.
				
				 <table border="1" cellspacing="0" cellpadding="0" width="500">
				    <tr>
				    <th scope="col"><div align="center">C&oacute;digo</div></th>
				    <th scope="col"><div align="center">T&iacute;tulo</div></th>
					 <th scope="col"><div align="center">Director</div></th>
					  <th scope="col"><div align="center">Inicio</div></th>
					   <th scope="col"><div align="center">Fin</div></th>
					   <th scope="col"><div align="center">Horas</div></th>
				  </tr>';		
				for($i = 0; $i < $count; $i ++) {	
					$ds_colaboladoresesquema .= '<tr>
						<td>'.$proyectos [$i]['ds_codigo'].'</td>
						<td><div align="left">'.$proyectos [$i]['ds_titulo'].'</div></td>
						<td><div align="left">'.$proyectos [$i]['ds_director'].'</div></td>
						<td>'.$proyectos [$i]['dt_ini'].'</td>
						<td>'.$proyectos [$i]['dt_fin'].'</td>
						<td>'.$proyectos [$i]['nu_horasinv'].'</td>
					</tr>';
				}
					
				$ds_colaboladoresesquema .= '</table>';
			}
			
		}
		
	}
	$xtpl->assign ( 'ds_colaboladoresesquema',  $ds_colaboladoresesquema );
		
	$xtpl->assign ( 'ds_facultad',  ( $oProyecto->getDs_facultad() ) );
	$ds_unidad = '';	
	$nivel=$oProyecto->getNu_nivelunidad();
	$html = array();
	$oUnidad = new Unidad();
	$oUnidad->setCd_unidad($oProyecto->getCd_unidad());
	
	while($nivel>0){
		UnidadQuery::getUnidadPorId($oUnidad);
		$html[$nivel]=$oUnidad->getDs_unidad();
		
		$oUnidad->setCd_unidad($oUnidad->getCd_padre());
		$nivel--;
	}
	UnidadQuery::getUnidadPorId($oUnidad);
		$html[$nivel]=$oUnidad->getDs_unidad();
		
	$oTipounidad = new Tipounidad();
	$oTipounidad->setCd_tipounidad($oUnidad->getCd_tipounidad());
	TipounidadQuery::getTipounidadPorId($oTipounidad);
	$ds_unidad .= $oTipounidad->getDs_tipounidad();
	//if ($oUnidad->getCd_tipounidad()){
		
	//}
	for ($i=0; $i < count($html); $i++){
		$ds_unidad .= ' - '.$html[$i];
	}

	$xtpl->assign ( 'ds_unidad',  $ds_unidad );
	
	$xtpl->assign ( 'titulo', 'Ver proyecto' );
	
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/accesodenegado.php' );
?>