<?
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

/*******************************************************
 * La variable er por GET indica el tipo de error por el
 * que se redireccionó al login
 *******************************************************/
$insertar = ($_SESSION ['insertar'])?$_SESSION ['insertar']:(($_GET['insertar'])?$_GET['insertar']:0);
$_SESSION ['insertar'] = $insertar;
$funcion = ($insertar)?"Alta proyecto":"Modificar proyecto";
if (PermisoQuery::permisosDeUsuario( $cd_usuario, $funcion )) {
	
	$oProyecto = (isset ( $_SESSION ['proyecto'] ))?$_SESSION ['proyecto']:new Proyecto ( );
	
	if (isset ( $_POST ['ds_cronograma'] ))
		$oProyecto->setDs_cronograma (  ( $_POST ['ds_cronograma'] ) );
	if (isset ( $_POST ['ds_disponible'] ))
		$oProyecto->setDs_disponible (  ( $_POST ['ds_disponible'] ) );
	if (isset ( $_POST ['ds_necesario'] ))
		$oProyecto->setDs_necesario (  ( $_POST ['ds_necesario'] ) );
	if (isset ( $_POST ['ds_fuentes'] ))
		$oProyecto->setDs_fuentes (  ( $_POST ['ds_fuentes'] ) );
	
	
	
	$_SESSION['proyecto']=$oProyecto;
	header ( 'Location: altaproyecto6-action.php?pagina=5');
} else
	header ( 'Location:../includes/finsolicitud.php' );
	