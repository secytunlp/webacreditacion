<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

$acreditar = (isset($_GET['acreditar']))?1:0;

$funcion = ($acreditar)?"Rechazar acreditación":"Rechazar solicitud";

if (PermisoQuery::permisosDeUsuario( $cd_usuario, $funcion )) {
	
	$xtpl = new XTemplate ( 'rechazar.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	
	
	$cd_proyecto = $_GET ['cd_proyecto'];
	$oProyecto = new Proyecto ( );
	$oProyecto->setCd_proyecto ( $cd_proyecto );
	ProyectoQuery::getProyectoPorId($oProyecto);
	$xtpl->assign ( 'cd_proyecto',  $cd_proyecto );
	$xtpl->assign ( 'acreditar',  $acreditar );
	$xtpl->assign ( 'ds_titulo',  ( $oProyecto->getDs_titulo()) );
	$xtpl->assign ( 'ds_director',  ( $oProyecto->getDs_director()) );
	
	if (isset ( $_GET ['er'] )) {
		if ($_GET ['er'] == 1) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "Error: no se pudo rechazar";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
	} else {
		$xtpl->assign ( 'classMsj', '' );
		$xtpl->assign ( 'msj', '' );
	}
	$xtpl->parse ( 'main.msj' );
	
	$xtpl->assign ( 'titulo', 'SeCyT - Rechazar solicitud' );
	
	
	
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/accesodenegado.php' );
?>