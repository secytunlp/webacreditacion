<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar usuario" )) {
	
	$xtpl = new XTemplate ( 'modificarusuario.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	if (isset ( $_GET ['id'] )) {
		$cd_usuario = $_GET ['id'];
		$oUsuario = new Usuario ( );
		$oUsuario->setCd_usuario ( $cd_usuario );
		UsuarioQuery::getUsuarioPorId ( $oUsuario );
		$xtpl->assign ( 'ds_apynom',  ( htmlspecialchars($oUsuario->getDs_apynom ()) ) );
		$xtpl->assign ( 'ds_mail',  ( $oUsuario->getDs_mail () ) );
		$xtpl->assign ( 'nu_precuil',  ( $oUsuario->getNu_precuil() ) );
		$xtpl->assign ( 'nu_documento',  ( $oUsuario->getNu_documento() ) );
		$xtpl->assign ( 'nu_postcuil',  ( $oUsuario->getNu_postcuil() ) );
		$xtpl->assign ( 'cd_usuario', $oUsuario->getCd_usuario () );
		$xtpl->assign ( 'dt_alta', $oUsuario->getDt_alta() );
		$xtpl->assign ( 'bl_activo', $oUsuario->getBl_activo() );
		
		
		
	}
	
	if (isset ( $_GET ['er'] )) {
		if ($_GET ['er'] == 1) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			
			$msj = "Error: No se han modificado los datos de usuario";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
	} else {
		$xtpl->assign ( 'classMsj', '' );
		$xtpl->assign ( 'msj', '' );
	}
	$xtpl->parse ( 'main.msj' );
	
	$xtpl->assign ( 'titulo', 'SeCyT - Modificar usuario' );
	
	/*$perfiles = PerfilQuery::listar ( $oUsuario->getCd_perfil () );
	$rowsize = count ( $perfiles );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $perfiles [$i] );
		$xtpl->parse ( 'main.option' );
	}*/
	
	$facultades = FacultadQuery::listar ($oUsuario->getCd_facultad ());
	$rowsize = count ( $facultades );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $facultades [$i] );
		$xtpl->parse ( 'main.option1' );
	}
	
	$usuarioperfil = new Usuarioperfil ( );
	$usuarioperfil->setCd_usuario( $oUsuario->getCd_usuario() );
	
	$perfiles = UsuarioperfilQuery::getPerfilesDeUsuario ( $usuarioperfil );
	$listaPerfiles = PerfilQuery::listarPerfiles ( $perfiles );
	$rowsize = count ( $listaPerfiles );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $listaPerfiles [$i] );
		$xtpl->parse ( 'main.perfiles' );
	}
	
	$xtpl->assign ( 'perfiles' );
	
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/accesodenegado.php' );
?>