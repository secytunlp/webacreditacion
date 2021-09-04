<?
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

/*******************************************************
 * La variable er por GET indica el tipo de error por el
 * que se redireccionó al login
 *******************************************************/
if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Alta usuario" )) {
	
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
	
	if (isset ( $_POST ['apynom'] ))
		$oUsuario->setDs_apynom (  ( $_POST ['apynom'] ) );
	
	if (isset ( $_POST ['mail'] ))
		$oUsuario->setDs_mail (  ( $_POST ['mail'] ) );
	
	if (isset ( $_POST ['pass'] ))
		$oUsuario->setDs_password (  ( $_POST ['pass'] ) );
	
	/*if (isset ( $_POST ['perfil'] ))
		$oUsuario->setCd_perfil (  ( $_POST ['perfil'] ) );*/
		
	if (isset ( $_POST ['facultad'] ))
		$oUsuario->setCd_facultad (  ( $_POST ['facultad'] ) );

	$perfiles = $_POST ['perfiles'];
	$usuarioPerfiles = array ( );
	$i = 0;
	$long = count ( $perfiles );
	while ( $i < $long ) {
		$f = $perfiles [$i];
		$pf = new Usuarioperfil();
		$pf->setCd_usuario ( $oUsuario->getCd_usuario() );
		$pf->setCd_perfil ( $f );
		array_push ( $usuarioPerfiles, $pf );
		$i ++;
	}
	$oUsuario->setDt_alta(date('Y-m-d'));	
	$oUsuario->setBl_activo(1);
		
	$exito = UsuarioQuery::insertUsuario ( $oUsuario );
	if ($exito)
		$exito = UsuarioperfilQuery::insertarPerfilesDeUsuario ( $oUsuario, $usuarioPerfiles );
	if ($exito){
		
		$oFuncion = new Funcion();
		$oFuncion -> setDs_funcion("Alta usuario");
		FuncionQuery::getFuncionPorDs($oFuncion);
		$oMovimiento = new Movimiento();
		$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
		$oMovimiento->setCd_usuario($cd_usuario);
		$oMovimiento->setDs_movimiento('Usuario: '.$oUsuario->getDs_apynom());
		MovimientoQuery::insertarMovimiento($oMovimiento);
		header ( 'Location: index.php ' ); 
	}
		else
		header ( 'Location: altausuario.php?er=1' );

} else
	header ( 'Location:../includes/accesodenegado.php' );
	