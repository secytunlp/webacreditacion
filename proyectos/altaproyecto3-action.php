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
	
	
	if (isset ( $_POST ['ds_avance'] ))
		$oProyecto->setDs_avance (  ( $_POST ['ds_avance'] ) );
	if (isset ( $_POST ['ds_formacion'] ))
		$oProyecto->setDs_formacion (  ( $_POST ['ds_formacion'] ) );
	if (isset ( $_POST ['ds_transferencia'] ))
		$oProyecto->setDs_transferencia (  ( $_POST ['ds_transferencia'] ) );
	if (isset ( $_POST ['ds_plan'] ))
		$oProyecto->setDs_plan (  ( $_POST ['ds_plan'] ) );
	
	
	$_SESSION['proyecto']=$oProyecto;
	header ( 'Location: altaproyecto6-action.php?pagina=4');
} else
	header ( 'Location:../includes/finsolicitud.php' );
	