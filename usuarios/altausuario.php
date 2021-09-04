<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';


if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Alta usuario" )) {
	//include APP_PATH . 'includes/menu.php';
	$xtpl = new XTemplate ( 'altausuario.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	if (isset ( $_GET ['er'] )) {
		if ($_GET ['er'] == 1) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "Error: El usuario no se ha dado de alta. Intente con otro C.U.I.L.";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
	} else {
		$xtpl->assign ( 'classMsj', '' );
		$xtpl->assign ( 'msj', '' );
	}
	$xtpl->parse ( 'main.msj' );
	
	$xtpl->assign ( 'titulo', 'SeCyT - Alta usuario' );
	
	/*$perfiles = PerfilQuery::listar ();
	$rowsize = count ( $perfiles );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $perfiles [$i] );
		$xtpl->parse ( 'main.option' );
	}*/
	
	$facultades = FacultadQuery::listar ();
	$rowsize = count ( $facultades );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $facultades [$i] );
		$xtpl->parse ( 'main.option1' );
	}
	
	$perfiles = PerfilQuery::getPerfiles('ds_perfil', 'ASC', '%%', '1', '100');
	$rowsize = count ( $perfiles );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $perfiles [$i] );
		$xtpl->parse ( 'main.perfiles' );
	}
	
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
}
else 
	header('Location:../includes/accesodenegado.php');
?>