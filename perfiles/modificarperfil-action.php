<?
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario ( $cd_usuario, "Modificar perfil" )) {
	
	$oPerfil = new Perfil ( );
	$oPerfil->setCd_perfil (  ( $_POST ['cd_perfil'] ) );
	$oPerfilfuncion = new Perfilfuncion ( );
	
	if (isset ( $_POST ['funciones'] ))
		$funciones = $_POST ['funciones']; else
		$funciones = array ( );
		//Recorro las funciones y creo nuevos obj PerfilFuncion por cada funcion del perfil
	if (isset ( $_POST ['cd_perfil'] )) {
		$oPerfilfuncion->setCd_perfil (  ( $_POST ['cd_perfil'] ) );
		$funciones = $_POST ['funciones'];
		$perfilFunciones = array ( );
		$i = 0;
		$long = count ( $funciones );
		while ( $i < $long ) {
			$f = $funciones [$i];
			$pf = new Perfilfuncion ( );
			$pf->setCd_perfil ( $oPerfil->getCd_perfil () );
			$pf->setCd_funcion ( $f );
			array_push ( $perfilFunciones, $pf );
			$i ++;
		}
	}
	if (isset ( $_POST ['ds_perfil'] ))
		$oPerfil->setDs_perfil ( $_POST ['ds_perfil'] );
	$exitoFunciones = false;
	$exitoPerfil = PerfilQuery::modificarPerfil ( $oPerfil );
	if ($exitoPerfil) {
		$exitoFunciones = PerfilfuncionQuery::modificarFuncionesDePerfil ( $oPerfil, $perfilFunciones );
	}
	$oFuncion = new Funcion();
	$oFuncion -> setDs_funcion("Modificar perfil");
	FuncionQuery::getFuncionPorDs($oFuncion);
	$oMovimiento = new Movimiento();
	$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
	$oMovimiento->setCd_usuario($cd_usuario);
	$oMovimiento->setDs_movimiento('Perfil: '.$oPerfil->getCd_perfil());
	MovimientoQuery::insertarMovimiento($oMovimiento);
	if ($exitoFunciones)
		header ( 'Location: index.php ' ); else
		header ( 'Location: modificarperfil.php?er=1&id=' . $oPerfil->getCd_perfil () );
} else
	header ( 'Location:../includes/accesodenegado.php' );
	