<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Rechazar alta/baja" )) {
	
	$xtpl = new XTemplate ( 'rechazar.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	
	
	$cd_proyecto = $_GET ['cd_proyecto'];
	$oProyecto = new Proyecto ( );
	$oProyecto->setCd_proyecto ( $cd_proyecto );
	ProyectoQuery::getProyectoPorId($oProyecto);
	$xtpl->assign ( 'cd_proyecto',  $cd_proyecto );
	$xtpl->assign ( 'ds_codigo',  ( $oProyecto->getDs_codigo() ) );
	$cd_docente = $_GET ['cd_docente'];
	$xtpl->assign ( 'cd_docente',  $cd_docente );
	$oDocente = new Docente ( );
	$oDocente->setCd_docente ( $cd_docente );
	DocenteQuery::getDocentePorId($oDocente);
	$xtpl->assign ( 'ds_integrante',  ( $oDocente->getDs_apellido().', '.$oDocente->getDs_nombre().' ('.$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil().')' ) );	
	$oIntegrante = new Integrante();
	$oIntegrante->setCd_docente($cd_docente);
	$oIntegrante->setCd_proyecto($cd_proyecto);
	IntegranteQuery::getIntegrantePorId($oIntegrante);	
	$baja =(($oIntegrante->getDt_bajapendiente())&&($oIntegrante->getDt_bajapendiente()!='0000-00-00'))?1:0;
	$alta =(($oIntegrante->getDt_altapendiente())&&($oIntegrante->getDt_altapendiente()!='0000-00-00'))?1:0;
	$dt_bajapendiente = $oIntegrante->getDt_bajapendiente();
	$dt_altapendiente = $oIntegrante->getDt_altapendiente();
	$fechaMovimiento = ($baja==1)?'Fecha de Baja: '.FuncionesComunes::fechaMysqlaPHP($dt_bajapendiente):(($alta==1)?'Fecha de Alta: '.FuncionesComunes::fechaMysqlaPHP($dt_altapendiente):'');
	$xtpl->assign ( 'dt_fecha',  ( $fechaMovimiento ) );
	if (isset ( $_GET ['er'] )) {
		if ($_GET ['er'] == 1) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "Error: No se han modificado los datos de integrante";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
	} else {
		$xtpl->assign ( 'classMsj', '' );
		$xtpl->assign ( 'msj', '' );
	}
	$xtpl->parse ( 'main.msj' );
	
	$xtpl->assign ( 'titulo', 'SeCyT - Rechazar alta/baja' );
	
	
	
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/accesodenegado.php' );
?>