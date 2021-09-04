<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario ( $cd_usuario, "Ver perfil" )) {
	
	//include APP_PATH . 'includes/menu.php';
	/*******************************************************
	 * La variable er por GET indica el tipo de error por el
	 * que se redireccionó al login
	 *******************************************************/
	
	$xtpl = new XTemplate ( 'verperfil.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	if (isset ( $_GET ['id'] )) {
		$cd_perfil = $_GET ['id'];
		$oPerfil = new Perfil ( );
		$oPerfil->setCd_perfil ( $cd_perfil );
		PerfilQuery::getPerfilPorid ( $oPerfil );
		$xtpl->assign ( 'cd_perfil',  ( $oPerfil->getCd_perfil () ) );
		$xtpl->assign ( 'ds_perfil',  ( $oPerfil->getDs_perfil () ) );
		$oPerfilFuncion = new Perfilfuncion ( );
		$oPerfilFuncion->setCd_perfil ( $oPerfil->getCd_perfil () );
		$funciones = PerfilfuncionQuery::getFuncionesDePerfil ( $oPerfilFuncion );
		$limit = count ( $funciones );
		$ds_funciones = array ( );
		$i = 0;
		while ( $i < $limit ) {
			$oFuncion = new Funcion ( );
			$cd_funcion = $funciones [$i];
			$oFuncion->setCd_funcion ( $cd_funcion );
			$ds_funciones [$i] = FuncionQuery::getDs_funcion ( $oFuncion );
			$i ++;
		}
		$rowsize = count ( $ds_funciones );
		for($i = 0; $i < $rowsize; $i ++) {
			$xtpl->assign ( 'ds_funciones', $ds_funciones [$i] );
			$xtpl->parse ( 'main.funciones' );
		}
	
	}
	
	$xtpl->assign ( 'titulo', 'Detalle de perfil' );
	
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/accesodenegado.php' );
?>
