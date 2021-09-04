<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Ver movimiento" )) {
	//include APP_PATH . 'includes/menu.php';
	/*******************************************************
	 * La variable er por GET indica el tipo de error por el
	 * que se redireccionó al login
	 *******************************************************/
	
	$xtpl = new XTemplate ( 'vermovimiento.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	if (isset ( $_GET ['id'] )) {
		$cd_movimiento = $_GET ['id'];
		$oMovimiento = new Movimiento ( );
		$oMovimiento->setCd_movimiento ( $cd_movimiento );
		MovimientoQuery::getMovimientoPorId ( $oMovimiento );
		$xtpl->assign ( 'ds_apynom',  ( $oMovimiento->getDs_apynom () ) );
		$xtpl->assign ( 'ds_funcion',  ( $oMovimiento->getDs_funcion() ) );
		$xtpl->assign ( 'ds_movimiento',  ( $oMovimiento->getDs_movimiento() ) );
		$xtpl->assign ( 'ds_consecuencia',  ( $oMovimiento->getDs_consecuencia() ) );
		$xtpl->assign ( 'dt_fecha',  ( FuncionesComunes::fechaHoraMysqlaPHP($oMovimiento->getDt_fecha() )) );
	}
	
	$xtpl->assign ( 'titulo', 'SeCyT - Detalle de movimiento' );
	
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/accesodenegado.php' );
?>
