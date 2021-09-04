<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario ( $cd_usuario, "Modificar perfil" )) {
	//include APP_PATH . 'includes/menu.php';
	/*******************************************************
	 * La variable er por GET indica el tipo de error por el
	 * que se redireccionó al login
	 *******************************************************/
	
	$xtpl = new XTemplate ( 'modificarperfil.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	if (isset ( $_GET ['id'] )) {
		$cd_perfil = $_GET ['id'];
		$oPerfil = new Perfil ( );
		$oPerfil->setCd_perfil ( $cd_perfil );
		PerfilQuery::getPerfilPorId ( $oPerfil );
		$xtpl->assign ( 'cd_perfil',  ( $oPerfil->getCd_perfil () ) );
		$xtpl->assign ( 'ds_perfil',  ( htmlspecialchars($oPerfil->getDs_perfil ()) ) );
		
		$perfilfuncion = new Perfilfuncion ( );
		$perfilfuncion->setCd_perfil ( $oPerfil->getCd_perfil () );
		
		//$funciones es un array con el id de las funciones del perfil
		$funciones = PerfilfuncionQuery::getFuncionesDePerfil ( $perfilfuncion );
		$listaFunciones = FuncionQuery::listarFunciones ( $funciones );
		$rowsize = count ( $listaFunciones );
		
		for($i = 0; $i < $rowsize; $i ++) {
			$xtpl->assign ( 'DATA', $listaFunciones [$i] );
			$xtpl->parse ( 'main.funciones' );
		}
		
		$xtpl->assign ( 'funciones' );
	}
	
	if (isset ( $_GET ['er'] )) {
		if ($_GET ['er'] == 0) {
			$xtpl->assign ( 'classMsj', 'msjOk' );
			$xtpl->assign ( 'msj', 'Se han modificado los datos correctamente' );
		}
		if ($_GET ['er'] == 1) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "Error: No se han modificado los datos del perfil";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
	} else {
		$xtpl->assign ( 'classMsj', '' );
		$xtpl->assign ( 'msj', '' );
	}
	$xtpl->parse ( 'main.msj' );
	
	$xtpl->assign ( 'titulo', 'Modificar Perfil' );
	
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/accesodenegado.php' );
?>