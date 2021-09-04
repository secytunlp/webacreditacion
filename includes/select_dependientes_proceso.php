<?php
include_once '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

switch($_GET["select"])
{
	
	
	case 'activarUsuario':
		$oUsuario = new Usuario();
		$oUsuario->setCd_usuario($_GET['elem']);
		UsuarioQuery::getUsuarioPorId($oUsuario);
		$oUsuario->setBl_activo($_GET['activar']);
		UsuarioQuery::modificarUsuario($oUsuario);
		break;
}
?>