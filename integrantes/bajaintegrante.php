<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';


if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Baja integrante" )) {
	
	$xtpl = new XTemplate ( 'bajaintegrante.html' );
	
	
	if ((isset ( $_GET ['cd_proyecto'] ))&&(isset ( $_GET ['cd_docente'] )))  {
		$cd_proyecto = $_GET ['cd_proyecto'];
		$oProyecto = new Proyecto ( );
		$oProyecto->setCd_proyecto ( $cd_proyecto );
		ProyectoQuery::getProyectoPorid ( $oProyecto );
		$xtpl->assign ( 'cd_proyecto',  ( $oProyecto->getCd_proyecto () ) );
		$xtpl->assign ( 'ds_codigo',  ( $oProyecto->getDs_codigo () ) );
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
		}
		$cd_docente = $_GET ['cd_docente'];
		$oDocente = new Docente ( );
		$oDocente->setCd_docente ( $cd_docente );
		DocenteQuery::getDocentePorid ( $oDocente );
		$xtpl->assign ( 'cd_docente',  ( $oDocente->getCd_docente () ) );
		$xtpl->assign ( 'ds_nombre',  ( $oDocente->getDs_nombre () ) );
		$xtpl->assign ( 'ds_apellido',  ( $oDocente->getDs_apellido() ) );
		$xtpl->assign ( 'nu_precuil',  ( $oDocente->getNu_precuil() ) );
		$xtpl->assign ( 'nu_documento',  ( $oDocente->getNu_documento() ) );
		$xtpl->assign ( 'nu_postcuil',  ( $oDocente->getNu_postcuil() ) );
		$oIntegrante = new Integrante ( );
		$oIntegrante->setCd_docente ( $cd_docente );
		$oIntegrante->setCd_proyecto ( $cd_proyecto );
		IntegranteQuery::getIntegrantePorId($oIntegrante);
		$xtpl->assign ( 'nu_horasinv',  ( $oIntegrante->getNu_horasinv() ) );
		$dt=(FuncionesComunes::fechaMysqlaPHP($oIntegrante->getDt_baja ())!='00/00/0000')?FuncionesComunes::fechaMysqlaPHP($oIntegrante->getDt_baja ()):'';
		$xtpl->assign ( 'dt_baja',  $dt );
		$disabled = (PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar docente" ))?'':'disabled="disabled"';
		$disabled1 = (PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar docente" ))?'':(($oDocente->getCd_docente()>=90000)?'':'disabled="disabled"');
		$xtpl->assign ( 'disabled',  $disabled );
		$xtpl->assign ( 'disabled1',  $disabled1 );
	}
	
	
	$facultades = FacultadQuery::listar ($oProyecto->getCd_facultad ());
	$rowsize = count ( $facultades );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $facultades [$i] );
		$xtpl->parse ( 'main.facultad' );
	}
	
		
	$categorias = CategoriaQuery::listar ($oDocente->getCd_categoria ());
	$rowsize = count ( $categorias );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $categorias [$i] );
		$xtpl->parse ( 'main.categoria' );
	}
	
	$cargos = CargoQuery::listar ($oDocente->getCd_cargo ());
	$rowsize = count ( $cargos );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $cargos [$i] );
		$xtpl->parse ( 'main.cargo' );
	}
	
	$deddocs = DeddocQuery::listar ($oDocente->getCd_deddoc ());
	$rowsize = count ( $deddocs );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $deddocs [$i] );
		$xtpl->parse ( 'main.deddoc' );
	}
	
	$facultades = FacultadQuery::listar ($oDocente->getCd_facultad ());
	$rowsize = count ( $facultades );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $facultades [$i] );
		$xtpl->parse ( 'main.facultadDoc' );
	}
	
	$universidads = UniversidadQuery::listar ($oDocente->getCd_universidad ());
	$rowsize = count ( $universidads );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $universidads [$i] );
		$xtpl->parse ( 'main.universidad' );
	}
	
	if (isset ( $_GET ['er'] )) {
		if ($_GET ['er'] == 1) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "Error: No se han modificado los datos del docente";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
		if ($_GET ['er'] == 2) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "Error: El docente ya tiene fecha de baja en el proyecto";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
		if ($_GET ['er'] == 3) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "Error: El proyecto no tiene más de 3 integrantes";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
	} else {
		$xtpl->assign ( 'classMsj', '' );
		$xtpl->assign ( 'msj', '' );
	}
	$xtpl->parse ( 'main.msj' );
	
	$xtpl->assign ( 'titulo', 'Baja de integrante' );
	
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/finsolicitud.php' );
?>