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
	
	
	if (isset ( $_POST ['ds_marco'] ))
		$oProyecto->setDs_marco (  ( $_POST ['ds_marco'] ) );
	if (isset ( $_POST ['ds_aporte'] ))
		$oProyecto->setDs_aporte (  ( $_POST ['ds_aporte'] ) );
	if (isset ( $_POST ['ds_objetivos'] ))
		$oProyecto->setDs_objetivos (  ( $_POST ['ds_objetivos'] ) );
	if (isset ( $_POST ['ds_metodologia'] ))
		$oProyecto->setDs_metodologia (  ( $_POST ['ds_metodologia'] ) );
	if (isset ( $_POST ['ds_metas'] ))
		$oProyecto->setDs_metas (  ( $_POST ['ds_metas'] ) );
	if (isset ( $_POST ['ds_antecedentes'] ))
		$oProyecto->setDs_antecedentes (  ( $_POST ['ds_antecedentes'] ) );
	
	$_SESSION['proyecto']=$oProyecto;
	header ( 'Location: altaproyecto6-action.php?pagina=3');
} else
	header ( 'Location:../includes/finsolicitud.php' );
	