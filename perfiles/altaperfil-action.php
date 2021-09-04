<?
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario ( $cd_usuario, "Alta perfil" )) {
	$oPerfil = new Perfil ( );
	
	if (isset ( $_POST ['ds_perfil'] ))
		$oPerfil->setDs_perfil (  ( $_POST ['ds_perfil'] ) );
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
	
	$exito = PerfilQuery::insertarPerfil ( $oPerfil );
	$oFuncion = new Funcion();
	$oFuncion -> setDs_funcion("Alta perfil");
	FuncionQuery::getFuncionPorDs($oFuncion);
	$oMovimiento = new Movimiento();
	$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
	$oMovimiento->setCd_usuario($cd_usuario);
	$oMovimiento->setDs_movimiento('Perfil: '.$oPerfil->getCd_perfil());
	MovimientoQuery::insertarMovimiento($oMovimiento);
	if ($exito) {
		$exitoFunciones = PerfilfuncionQuery::insertarFuncionesDePerfil ( $oPerfil, $perfilFunciones );
	}
	
	if ($exito)
		header ( 'Location: index.php ' ); else
		header ( 'Location: altaperfil.php?er=1' );
} else
	header ( 'Location:../includes/accesodenegado.php' );
?>
	