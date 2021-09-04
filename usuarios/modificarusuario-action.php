<?
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar usuario" )) {
	
	$oUsuario = new Usuario ( );
	
	if (isset ( $_POST ['nu_precuil'] ))
		$oUsuario->setNu_precuil ( $_POST ['nu_precuil'] ); else
		$oUsuario->setNu_precuil ( '' );
	
	if (isset ( $_POST ['nu_documento'] ))
		$oUsuario->setNu_documento ( $_POST ['nu_documento'] ); else
		$oUsuario->setNu_documento ( '' );
		
	if (isset ( $_POST ['nu_postcuil'] ))
		$oUsuario->setNu_postcuil ( $_POST ['nu_postcuil'] ); else
		$oUsuario->setNu_postcuil ( '' );
	
	if (isset ( $_POST ['cd_usuario'] ))
		$oUsuario->setCd_usuario ( $_POST ['cd_usuario'] );
	
	if (isset ( $_POST ['apynom'] ))
		$oUsuario->setDs_apynom (  ( $_POST ['apynom'] ) );
	
	if (isset ( $_POST ['mail'] ))
		$oUsuario->setDs_mail (  ( $_POST ['mail'] ) );
	
	/*if (isset ( $_POST ['perfil'] ))
		$oUsuario->setCd_perfil (  ( $_POST ['perfil'] ) );*/
		
	if (isset ( $_POST ['facultad'] ))
		$oUsuario->setCd_facultad (  ( $_POST ['facultad'] ) );
		
	if (isset ( $_POST ['dt_alta'] ))
		$oUsuario->setDt_alta (  ( $_POST ['dt_alta'] ) );
		
	if (isset ( $_POST ['bl_activo'] ))
		$oUsuario->setBl_activo (  ( $_POST ['bl_activo'] ) );
	
	if (isset ( $_POST ['reset'] )) {
		$reset = $_POST ['reset'];
		if ($reset == 'true')
			$oUsuario->setDs_password ( $oUsuario->getNu_documento () );
	}
	
	if (isset ( $_POST ['perfiles'] ))
		$perfiles = $_POST ['perfiles']; else
		$perfiles = array ( );

	$usuarioPerfiles = array ( );
	$i = 0;
	$long = count ( $perfiles );
	while ( $i < $long ) {
		$f = $perfiles [$i];
		$pf = new Usuarioperfil ( );
		$pf->setCd_usuario ( $oUsuario->getCd_usuario() );
		$pf->setCd_perfil ( $f );
		array_push ( $usuarioPerfiles, $pf );
		$i ++;
	}	
		
	$exito = UsuarioQuery::modificarUsuario ( $oUsuario );
	if ($exito)
		$exito = UsuarioperfilQuery::modificarPerfilesDeUsuario ( $oUsuario, $usuarioPerfiles );
	if ($exito){
		$oFuncion = new Funcion();
		$oFuncion -> setDs_funcion("Modificar usuario");
		FuncionQuery::getFuncionPorDs($oFuncion);
		$oMovimiento = new Movimiento();
		$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
		$oMovimiento->setCd_usuario($cd_usuario);
		$oMovimiento->setDs_movimiento('Usuario: '.$oUsuario->getDs_apynom());
		MovimientoQuery::insertarMovimiento($oMovimiento);
		header ( 'Location: index.php ' ); 
	}else
		header ( 'Location: modificarusuario.php?er=1&id=' . $oUsuario->getCd_usuario () );

} else
	header ( 'Location:../includes/accesodenegado.php' );	