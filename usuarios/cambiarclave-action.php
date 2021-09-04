<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Cambiar clave" )) {
	
	$oUsuario = new Usuario ( );
	$oUsuario->setCd_usuario ( $_SESSION ["cd_usuarioSession"] );
	UsuarioQuery::getUsuarioPorId ( $oUsuario );
	if (isset ( $_POST ['clave_actual'] )) {
		$clave_actual = MD5 ( $_POST ['clave_actual'] );
		$ds_password = $_POST ['ds_password'];
		$pass = $oUsuario->getDs_password ();
		$exito = false;
		if (strcmp ( $clave_actual, $pass ) == 0) {
			$oUsuario->setDs_password ( $ds_password );
			$exito = UsuarioQuery::modificarUsuario ( $oUsuario );
		}
		$oFuncion = new Funcion();
		$oFuncion -> setDs_funcion("Cambiar clave");
		FuncionQuery::getFuncionPorDs($oFuncion);
		$oMovimiento = new Movimiento();
		$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
		$oMovimiento->setCd_usuario($cd_usuario);
		$oMovimiento->setDs_movimiento('Usuario: '.$oUsuario->getCd_usuario());
		if ($exito) {
			header ( 'location:../inicio.php' );
		} else {
			header ( 'location: cambiarClave.php?er=1' );
		}
	}
} else
	header ( 'Location:../includes/accesodenegado.php' );

?>