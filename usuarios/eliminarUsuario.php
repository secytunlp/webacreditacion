<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

//verifico si tiene permiso para la acci�n
if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Baja usuario" )) {
	
	$oUsuario = new Usuario ( );
	
	if (isset ( $_GET ['id'] )) {
		$cd_user = $_GET ['id'];
		$oUsuario->setCd_usuario ( $cd_user );
		$exito = UsuarioperfilQuery::eliminarUsuarioperfil ( $oUsuario->getCd_usuario() );
		if ($exito)
			$exito = UsuarioQuery::eliminarUsuario ( $oUsuario );
		if ($exito){
			$oFuncion = new Funcion();
			$oFuncion -> setDs_funcion("Baja usuario");
			FuncionQuery::getFuncionPorDs($oFuncion);
			$oMovimiento = new Movimiento();
			$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
			$oMovimiento->setCd_usuario($cd_usuario);
			$oMovimiento->setDs_movimiento('Usuario: '.$oUsuario->getCd_usuario());
			MovimientoQuery::insertarMovimiento($oMovimiento);
		}
		if ($exito)
			header ( 'Location: index.php' ); else
			header ( 'Location:index.php?er=1' );
	}
} else {
	header ( 'Location:../includes/accesodenegado.php' );
}
?>