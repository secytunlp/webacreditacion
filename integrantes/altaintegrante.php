<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';


if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Alta integrante" )) {
	
	$xtpl = new XTemplate ( 'altaintegrante.html' );
	include APP_PATH.'includes/cargarmenu.php';
	
	if (isset ( $_GET ['cd_proyecto'] ))  {
		$cd_proyecto = $_GET ['cd_proyecto'];
		$oProyecto = new Proyecto ( );
		$oProyecto->setCd_proyecto ( $cd_proyecto );
		ProyectoQuery::getProyectoPorid ( $oProyecto );
		$xtpl->assign ( 'cd_proyecto',  ( $oProyecto->getCd_proyecto () ) );
		/*$xtpl->assign ( 'ds_codigo',  ( $oProyecto->getDs_codigo () ) );
		$xtpl->assign ( 'ds_titulo',  ( $oProyecto->getDs_titulo () ) );
		$xtpl->assign ( 'ds_director',  ( $oProyecto->getDs_director () ) );
		$xtpl->assign ( 'dt_ini',  FuncionesComunes::fechaMysqlaPHP( $oProyecto->getDt_ini () ) );
		$xtpl->assign ( 'dt_fin',  FuncionesComunes::fechaMysqlaPHP( $oProyecto->getDt_fin () ) );
		if ($oProyecto->getNu_duracion()==2){		
			$xtpl->assign ( 'chequeado2',  "checked='checked'" );
			$xtpl->assign ( 'duracionTXT',  1 );
		}
		if ($oProyecto->getNu_duracion()==4){		
			$xtpl->assign ( 'chequeado4',  "checked='checked'" );
			$xtpl->assign ( 'duracionTXT',  1 );
		}*/
		
		$disabled = (PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar docente" ))?'':'disabled="disabled"';
		
		$xtpl->assign ( 'disabled',  $disabled );
		
	}
	
	
	
	
		
	$categorias = CategoriaQuery::listar ();
	$rowsize = count ( $categorias );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $categorias [$i] );
		$xtpl->parse ( 'main.categoria' );
	}
	
	$provincias = ProvinciaQuery::listar ();
	$rowsize = count ( $provincias );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $provincias [$i] );
		$xtpl->parse ( 'main.provincia' );
	}
	
	$cargos = CargoQuery::listar ();
	$rowsize = count ( $cargos );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $cargos [$i] );
		$xtpl->parse ( 'main.cargo' );
	}
	
	$deddocs = DeddocQuery::listar ();
	$rowsize = count ( $deddocs );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $deddocs [$i] );
		$xtpl->parse ( 'main.deddoc' );
	}
	
	$facultades = FacultadQuery::listar ();
	$rowsize = count ( $facultades );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $facultades [$i] );
		$xtpl->parse ( 'main.facultad' );
	}
	
	$universidads = UniversidadQuery::listar ();
	$rowsize = count ( $universidads );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $universidads [$i] );
		$xtpl->parse ( 'main.universidad' );
	}
	
	$tipounidades = TipounidadQuery::listar ();
	$rowsize = count ( $tipounidades );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $tipounidades [$i] );
		$xtpl->parse ( 'main.tipounidad' );
	}
	
	//$codir = ($oProyecto->getCd_tipoacreditacion()==1)?0:1;
	$codir = 0;
	$tipoinvestigadores = TipoinvestigadorQuery::listar ('',1,$codir);
	$rowsize = count ( $tipoinvestigadores );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $tipoinvestigadores [$i] );
		$xtpl->parse ( 'main.tipoinvestigador' );
	}
	
	
	
	
	
	$carrerainvs = CarrerainvQuery::listar ();
	$rowsize = count ( $carrerainvs );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $carrerainvs [$i] );
		$xtpl->parse ( 'main.carrerainv' );
	}
	
	$organismos = OrganismoQuery::listar ();
	$rowsize = count ( $organismos );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $organismos [$i] );
		$xtpl->parse ( 'main.organismo' );
	}
	
	$proyectos = ProyectoQuery::getProyectosDocentes($cd_docente );
	$count = count ( $proyectos );
	for($i = 0; $i < $count; $i ++) {
		$proyectos [$i]['dt_ini']=FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini']);
		$proyectos [$i]['dt_fin']=FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin']);
		$proyectos [$i]['nu_horasinv']=($proyectos [$i]['nu_horasinv'])?$proyectos [$i]['nu_horasinv']:'0';	
		$proyectos [$i]['item']=$i;
		$xtpl->assign ( 'DATOS', $proyectos [$i] );
		$xtpl->parse ( 'main.row' );
	}
	$proyectos [$count]['cd_proyecto']= $oProyecto->getCd_proyecto();
	$proyectos [$count]['ds_codigo']= $oProyecto->getDs_codigo();
	$proyectos [$count]['ds_titulo']= $oProyecto->getDs_titulo();
	$proyectos [$count]['ds_director']= $oProyecto->getDs_director();
	$proyectos [$count]['dt_ini']=FuncionesComunes::fechaMysqlaPHP($oProyecto->getDt_ini());
	$proyectos [$count]['dt_fin']=FuncionesComunes::fechaMysqlaPHP($oProyecto->getDt_fin());
	//$proyectos [$count]['nu_horasinv']=($oProyecto->getNu_horasinv())?$oProyecto->getNu_horasinv():'0';
	$proyectos [$count]['nu_horasinv']='0';
	$proyectos [$count]['item']=$count;
	$xtpl->assign ( 'DATOS', $proyectos [$i] );
	$xtpl->parse ( 'main.row' );
	
	if (isset ( $_GET ['er'] )) {
		if ($_GET ['er'] == 1) {
			$msj = "Error: No se han modificado los datos del docente";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
		if ($_GET ['er'] == 2) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "Error: El docente ya es integrante del proyecto";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
		if ($_GET ['er'] == 3) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "Error: El docente ya es integrante de 2 proyectos en ejecuci&oacute;n o no tiene dedicaci&oacute;n suficiente para ser integrante de m&aacute;s de un proyecto";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
		if ($_GET ['er'] == 4) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = ($oProyecto->getCd_tipoacreditacion()==1)?"Error: La categor&iacute;a del codirector debe ser I, II o III o debe tener Cargo en la Carrera del Investigador con lugar de trabajo en la U.N.L.P.":"Error: La categor&iacute;a del codirector no puede ser V";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
	} else {
		$xtpl->assign ( 'classMsj', '' );
		$xtpl->assign ( 'msj', '' );
	}
	$xtpl->parse ( 'main.msj' );
	
	//$xtpl->assign ( 'titulo', 'Alta de integrante' );
	$nuevaFecha = explode ( "-", $oProyecto->getDt_ini() );
		$year = $nuevaFecha [0];
		$jovenes = ($year<2014)?'j&oacute;venes investigadores':'investigadores en formaci&oacute;n';
		$ppid = ($oProyecto->getCd_tipoacreditacion()==2)?'<br>el objetivo de estos proyectos es fortalecer los antecedentes en direcci&oacute;n de proyectos de '.$jovenes.',  en el contexto de proyectos acreditados por la UNLP de los cuales formen parte':'';
		
	$xtpl->assign ( 'titulo', 'SeCyT - Alta de integrante'.$ppid );
	
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/finsolicitud.php' );
?>