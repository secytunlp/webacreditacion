<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario ( $cd_usuario, "Baja perfil" )) {
	
	$oPerfil = new Perfil ( );
	
	if (isset ( $_GET ['id'] )) {
		$cd_perfil = $_GET ['id'];
		$oPerfil->setCd_perfil ( $cd_perfil );
		
		$oUsuario = new Usuario ( );
		$oUsuario->setCd_perfil ( $oPerfil->getCd_perfil () );
		
		$asignado = UsuarioQuery::estaAsignadoAPerfil ( $oUsuario );
		$exito = false;
		if (! $asignado) {
			$exito = PerfilFuncionQuery::eliminarPerfilfuncion ( $oPerfil->getCd_perfil() );
			if ($exito)
				$exito = PerfilQuery::eliminarPerfil ( $oPerfil );
			if ($exito){
				$oFuncion = new Funcion();
				$oFuncion -> setDs_funcion("Baja perfil");
				FuncionQuery::getFuncionPorDs($oFuncion);
				$oMovimiento = new Movimiento();
				$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
				$oMovimiento->setCd_usuario($cd_usuario);
				$oMovimiento->setDs_movimiento('Perfil: '.$oPerfil->getCd_perfil());
				MovimientoQuery::insertarMovimiento($oMovimiento);
			}
		}
		
		if ($exito)
			header ( 'Location: index.php' ); else
			header ( 'Location:index.php?er=1' );
	}
} else
	header ( 'Location:../includes/accesodenegado.php' );
?>