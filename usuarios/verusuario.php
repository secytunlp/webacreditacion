<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Ver usuario" )) {
	//include APP_PATH . 'includes/menu.php';
	/*******************************************************
	 * La variable er por GET indica el tipo de error por el
	 * que se redireccionó al login
	 *******************************************************/
	
	$xtpl = new XTemplate ( 'verusuario.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	if (isset ( $_GET ['id'] )) {
		$cd_usuario = $_GET ['id'];
		$oUsuario = new Usuario ( );
		$oUsuario->setCd_usuario ( $cd_usuario );
		UsuarioQuery::getUsuarioPorId ( $oUsuario );
		$xtpl->assign ( 'ds_apynom',  ( $oUsuario->getDs_apynom () ) );
		$xtpl->assign ( 'ds_mail',  ( $oUsuario->getDs_mail () ) );
		$xtpl->assign ( 'nu_cuil',  ( $oUsuario->getNu_precuil().'-'.$oUsuario->getNu_documento().'-'.$oUsuario->getNu_postcuil() ) );
		$oPerfil = new Perfil ( );
		$oPerfil->setCd_perfil ( $oUsuario->getCd_perfil () );
		PerfilQuery::getPerfilPorid ( $oPerfil );
		$xtpl->assign ( 'ds_perfil',  ( $oPerfil->getDs_perfil () ) );
		$oFacultad = new Facultad ( );
		$oFacultad->setCd_facultad ( $oUsuario->getCd_facultad () );
		FacultadQuery::getFacultadPorid ( $oFacultad );
		$xtpl->assign ( 'ds_facultad',  ( $oFacultad->getDs_facultad () ) );
	}
	
	$xtpl->assign ( 'titulo', 'SeCyT - Detalle de usuario' );
	
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/accesodenegado.php' );
?>
