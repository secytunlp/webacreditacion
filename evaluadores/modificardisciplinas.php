<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar disciplinas" )) {
	
	$xtpl = new XTemplate ( 'modificardisciplinas.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	
		$cd_usuario = $_SESSION ["cd_usuarioSession"];
		$oUsuario = new Usuario ( );
		$oUsuario->setCd_usuario ( $cd_usuario );
		UsuarioQuery::getUsuarioPorId ( $oUsuario );
		
		
	
	
	if (isset ( $_GET ['er'] )) {
		if ($_GET ['er'] == 1) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			
			$msj = "Error: No se han modificado los datos de usuario";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
	} else {
		$xtpl->assign ( 'classMsj', '' );
		$xtpl->assign ( 'msj', '' );
	}
	$xtpl->parse ( 'main.msj' );
	
	$xtpl->assign ( 'titulo', 'SeCyT - Disciplinas' );
	
	
	$li_especialidad='';
	$cd_especialidad='';
	$oEvaludorespecialidad = new Evaluadorespecialidad();
	$oEvaludorespecialidad->setCd_usuario($oUsuario->getCd_usuario());
	$especialidades=EvaluadorespecialidadQuery::getEvaluadorespecialidadPorUsuario($oEvaludorespecialidad);
	foreach ($especialidades as $especialidad) {
		$li_especialidad .='<li id="li_'.$especialidad['cd_especialidad'].'">'.$especialidad['ds_codigo'].' - '.$especialidad['ds_especialidad'].'<a href="" onclick="javascript:borrarDisciplina('.$especialidad['cd_especialidad'].'); return false;"><img src=../img/del.jpg></a></li>';
		if ($cd_especialidad) {
			$cd_especialidad .=','.$especialidad['cd_especialidad'];
		}
		else $cd_especialidad =$especialidad['cd_especialidad'];
	}
	$xtpl->assign ( 'li_especialidades', $li_especialidad );
	$xtpl->assign ( 'cd_especialidad', $cd_especialidad );
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/accesodenegado.php' );
?>