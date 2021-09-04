<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';
if (isset($_GET['ini'])){
	unset($_SESSION ['proyecto']);
	unset($_SESSION ['cd_proyecto']);
	unset($_SESSION ['integrante']);
	unset($_SESSION ['docente']);
	unset($_SESSION ['unidad']);
	unset($_SESSION ['insertar']);
	unset($_SESSION ['insertando']);
}
$insertar = ($_SESSION ['insertar'])?$_SESSION ['insertar']:(($_GET['insertar'])?$_GET['insertar']:0);
$_SESSION ['insertar'] = $insertar;
if($insertar){$_SESSION ['insertando']=1;}
$funcion = ($insertar)?"Alta proyecto":"Modificar proyecto";
if (PermisoQuery::permisosDeUsuario( $cd_usuario, $funcion )) {
	
	$xtpl = new XTemplate ( 'altaproyecto1.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	$oProyecto = (isset ( $_SESSION ['proyecto'] ))?$_SESSION ['proyecto']:new Proyecto ( );
	if (isset($_GET['ini'])){
		$oProyecto->setCd_tipoacreditacion($_GET['cd_tipoacreditacion']);
		$oProyecto->setCd_estado(1);
	}
	if (isset ( $_GET ['cd_proyecto'] )) {
		
		$cd_proyecto = $_GET ['cd_proyecto'];
		
		$oProyecto->setCd_proyecto($cd_proyecto);
		ProyectoQuery::getProyectoPorId ($oProyecto);
	}
		if ($oProyecto->getCd_estado()==1) {
		
		$oTipoacreditacion = new Tipoacreditacion();
		$oTipoacreditacion->setCd_tipoacreditacion($oProyecto->getCd_tipoacreditacion());
		TipoacreditacionQuery::getTipoacreditacionPorCd($oTipoacreditacion);
		$oIntegrante = (isset ( $_SESSION ['integrante'] ))?$_SESSION ['integrante']:new Integrante( );
			
		$oDocente =(isset ( $_SESSION ['docente'] ))?$_SESSION ['docente']:new Docente ( );
		$oDocente->setNu_documento($_SESSION ["nu_documentoSession"]);
		DocenteQuery::getDocentePorDocumento($oDocente);
		
		$oIntegrante->setCd_docente($oDocente->getCd_docente());
		$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
		IntegranteQuery::getIntegrantePorId($oIntegrante);
		if (isset ( $_POST ['ds_marco'] ))
			$oProyecto->setDs_marco (  ( $_POST ['ds_marco'] ) );
		if (isset ( $_POST ['ds_aporte'] ))
			$oProyecto->setDs_aporte (  ( $_POST ['ds_aporte'] ) );
		if (isset ( $_POST ['ds_objetivos'] ))
			$oProyecto->setDs_objetivos (  ( $_POST ['ds_objetivos'] ) );
		if (isset ( $_POST ['ds_metodologia'] ))
			$oProyecto->setDs_metodologia (  ( $_POST ['ds_metodologia'] ) );
		if (isset ( $_POST ['ds_metas'] ))
			$oProyecto->setDs_metas (  ( $_POST ['ds_metas'] ) );
		if (isset ( $_POST ['ds_antecedentes'] ))
			$oProyecto->setDs_antecedentes (  ( $_POST ['ds_antecedentes'] ) );
		$_SESSION['proyecto']=$oProyecto;
		$_SESSION['integrante']=$oIntegrante;
		$_SESSION['docente']=$oDocente;
		$xtpl->assign ( 'cd_proyecto',  ( $oProyecto->getCd_proyecto () ) );
		
		$xtpl->assign ( 'ds_titulo',  stripslashes( htmlspecialchars($oProyecto->getDs_titulo ()) ) );
		$xtpl->assign ( 'ds_abstract',  stripslashes( htmlspecialchars($oProyecto->getDs_abstract1()) ) );
		$xtpl->assign ( 'ds_clave1',  stripslashes( htmlspecialchars($oProyecto->getDs_clave1()) ) );
		$xtpl->assign ( 'ds_clave2',  stripslashes( htmlspecialchars($oProyecto->getDs_clave2() )) );
		$xtpl->assign ( 'ds_clave3',  stripslashes( htmlspecialchars($oProyecto->getDs_clave3() )) );
		$xtpl->assign ( 'ds_clave4',  stripslashes( htmlspecialchars($oProyecto->getDs_clave4() ) ));
		$xtpl->assign ( 'ds_clave5',  stripslashes( htmlspecialchars($oProyecto->getDs_clave5() ) ));
		$xtpl->assign ( 'ds_clave6',  stripslashes( htmlspecialchars($oProyecto->getDs_clave6() ) ));
		$xtpl->assign ( 'ds_abstracteng',  stripslashes( htmlspecialchars($oProyecto->getDs_abstracteng()) ) );
		$xtpl->assign ( 'ds_claveeng1',  stripslashes( htmlspecialchars($oProyecto->getDs_claveeng1()) ) );
		$xtpl->assign ( 'ds_claveeng2',  stripslashes( htmlspecialchars($oProyecto->getDs_claveeng2() )) );
		$xtpl->assign ( 'ds_claveeng3',  stripslashes( htmlspecialchars($oProyecto->getDs_claveeng3() )) );
		$xtpl->assign ( 'ds_claveeng4',  stripslashes( htmlspecialchars($oProyecto->getDs_claveeng4() ) ));
		$xtpl->assign ( 'ds_claveeng5',  stripslashes( htmlspecialchars($oProyecto->getDs_claveeng5() ) ));
		$xtpl->assign ( 'ds_claveeng6',  stripslashes( htmlspecialchars($oProyecto->getDs_claveeng6() ) ));
		$xtpl->assign ( 'ds_linea',  stripslashes( htmlspecialchars($oProyecto->getDs_linea()) ));
		if ($oProyecto->getNu_duracion()==2){		
			$xtpl->assign ( 'chequeado2',  "checked='checked'" );
			$nu_duracionTXT = 1;
			//$xtpl->assign ( 'duracionTXT',  1 );
		}
		if ($oProyecto->getNu_duracion()==4){		
			//$xtpl->assign ( 'chequeado4',  "checked='checked'" );
			$chequeado4 = "checked='checked'";
			$nu_duracionTXT = 1;
			//$xtpl->assign ( 'duracionTXT',  1 );
		}
		$tetra =($oProyecto->getCd_tipoacreditacion()==1)?'TETRA ANUAL<input name="nu_duracion" type="radio" value="4" onclick="copiarRadio(\'duracionTXT\')" '.$chequeado4.'/>':'';
		$xtpl->assign ( 'tetra',  $tetra );
		$xtpl->assign ( 'duracionTXT',  '<input type="hidden" name="duracionTXT" id="duracionTXT" class="fValidate[\'required\']" value="'.$nu_duracionTXT.'"/>' );
		
		if ($oProyecto->getDs_tipo()=='B'){		
			$xtpl->assign ( 'chequeadoB',  "checked='checked'" );
			$xtpl->assign ( 'tipoTXT',  1 );
		}
		
		if ($oProyecto->getDs_tipo()=='A'){		
			$xtpl->assign ( 'chequeadoA',  "checked='checked'" );
			$xtpl->assign ( 'tipoTXT',  1 );
		}
		
		if ($oProyecto->getDs_tipo()=='D'){		
			$xtpl->assign ( 'chequeadoD',  "checked='checked'" );
			$xtpl->assign ( 'tipoTXT',  1 );
		}
		
		if ($oProyecto->getDs_tipo()=='C'){		
			$xtpl->assign ( 'chequeadoC',  "checked='checked'" );
			$xtpl->assign ( 'tipoTXT',  1 );
		}
		
		if ($oProyecto->getBl_transferencia()==1){		
				$xtpl->assign ( 'chequeado1',  "checked='checked'" );
				$xtpl->assign ( 'transferenciaTXT',  1 );
			}
		if ($oProyecto->getBl_transferencia()==0){		
			$xtpl->assign ( 'chequeado0',  "checked='checked'" );
			$xtpl->assign ( 'transferenciaTXT',  0 );
		}
		$nuevaFecha = explode ( "-", $oProyecto->getDt_ini() );
		$year = $nuevaFecha [0];
		$jovenes = ($year<2014)?'j&oacute;venes investigadores':'investigadores en formaci&oacute;n';
		$ppid = ($oProyecto->getCd_tipoacreditacion()==2)?'<br>el objetivo de estos proyectos es fortalecer los antecedentes en direcci&oacute;n de proyectos de '.$jovenes.',  en el contexto de proyectos acreditados por la UNLP de los cuales formen parte':'';
		$titulo = ($insertar)?'SeCyT - Alta proyecto ':'SeCyT - Modificar proyecto ';
		$titulo .=$oTipoacreditacion->getDs_tipoacreditacion();
		
		if (isset ( $_GET ['er'] )) {
			if ($_GET ['er'] == 1) {
				$xtpl->assign ( 'classMsj', 'msjerror' );
				$msj = "Error: Ocurri? un problema. Intente nuevamente";
				$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
			}
		} else {
			$xtpl->assign ( 'classMsj', '' );
			$xtpl->assign ( 'msj', '' );
		}
		$xtpl->parse ( 'main.msj' );
		
		$xtpl->assign ( 'titulo', $titulo.$ppid );
		$xtpl->assign ( 'cd_unidad',  stripslashes( htmlspecialchars($oProyecto->getCd_unidad()) ) );
		$nu_nivelunidad = $oProyecto->getNu_nivelunidad();
		$xtpl->assign ( 'nu_nivelunidad',  stripslashes( htmlspecialchars($nu_nivelunidad) ) );
		$oUnidad = new Unidad();
			$oUnidad->setCd_unidad($oProyecto->getCd_unidad());
			UnidadQuery::getUnidadPorId($oUnidad);
		
		$xtpl->assign ( 'ds_unidad',  stripslashes( htmlspecialchars($oUnidad->getDs_unidad()) ) );
		$xtpl->assign ( 'ds_direccion',  stripslashes( htmlspecialchars($oUnidad->getDs_direccion()) ) );
		$xtpl->assign ( 'ds_telefono',  stripslashes( htmlspecialchars($oUnidad->getDs_telefono()) ) );
		$xtpl->assign ( 'ds_mail',  stripslashes( htmlspecialchars($oUnidad->getDs_mail()) ) );
		
		
		$xtpl->assign ( 'cd_disciplina',  stripslashes( htmlspecialchars($oProyecto->getCd_disciplina()) ) );
		$xtpl->assign ( 'ds_disciplina',  stripslashes( htmlspecialchars($oProyecto->getDs_disciplina()) ) );
	
		$xtpl->assign ( 'cd_especialidad',  stripslashes( htmlspecialchars($oProyecto->getCd_especialidad()) ) );
		$xtpl->assign ( 'ds_especialidad',  stripslashes( htmlspecialchars($oProyecto->getDs_especialidad()) ) );
		
		$xtpl->assign ( 'cd_campo',  stripslashes( htmlspecialchars($oProyecto->getCd_campo()) ) );
		$xtpl->assign ( 'ds_campo',  stripslashes( htmlspecialchars($oProyecto->getDs_campo()) ) );
		
		
		
		$oFacultadproyecto = new Facultadproyecto();
		$oFacultadproyecto->setCd_proyecto($oProyecto->getCd_proyecto());
		$facultades = FacultadproyectoQuery::getFacultadproyecto($oFacultadproyecto);
		
		$facultad = FacultadQuery::listar ($facultades[0]['cd_facultad']);
		$rowsize = count ( $facultad );
		
		for($i = 0; $i < $rowsize; $i ++) {
			$xtpl->assign ( 'DATA', $facultad [$i] );
			$xtpl->parse ( 'main.option1' );
		}
		
		/*$facultades = FacultadQuery::listar ($oProyecto->getCd_facultad());
		$rowsize = count ( $facultades );
		
		for($i = 0; $i < $rowsize; $i ++) {
			$xtpl->assign ( 'DATA', $facultades [$i] );
			$xtpl->parse ( 'main.option1' );
		}*/
		
		
		
		$xtpl->parse ( 'main' );
		$xtpl->out ( 'main' );
	}
	else 
		header('Location:../includes/accesodenegado.php');
}
else 
	header('Location:../includes/finsolicitud.php');
?>