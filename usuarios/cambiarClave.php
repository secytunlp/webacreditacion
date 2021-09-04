<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Cambiar clave" )) {
	
	//include APP_PATH . 'includes/menu.php';
	
	$xtpl = new XTemplate ( 'cambiarClave.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	if (isset ( $_GET ['er'] )) {
		$xtpl->assign ( 'classMsj', 'msjError' );
		$msj = "Error: Contraseña Actual incorrecta";
		$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
	}
	
	$xtpl->parse ( 'main.msj' );
	
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/accesodenegado.php' );
?>