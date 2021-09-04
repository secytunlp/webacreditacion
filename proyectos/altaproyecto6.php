<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';


$insertar = ($_SESSION ['insertar'])?$_SESSION ['insertar']:(($_GET['insertar'])?$_GET['insertar']:0);
$_SESSION ['insertar'] = $insertar;
$funcion = ($insertar)?"Alta proyecto":"Modificar proyecto";
if (PermisoQuery::permisosDeUsuario( $cd_usuario, $funcion )) {
	//include APP_PATH . 'includes/menu.php';
	$xtpl = new XTemplate ( 'altaproyecto6.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	
		
		$oProyecto = $_SESSION['proyecto'];
		if ($oProyecto->getCd_estado()==1) {
			
			$oIntegrante = (isset ( $_SESSION ['integrante'] ))?$_SESSION ['integrante']:new Integrante( );
			
			$oDocente =(isset ( $_SESSION ['docente'] ))?$_SESSION ['docente']:new Docente ( );
			
			
			$year = $_SESSION ["nu_yearSession"];
			
			
			
			
			
			$oProyectoevaluador = new Proyectoevaluador();
			$oProyectoevaluador->setCd_proyecto($oProyecto->getCd_proyecto());
			//$oProyectoevaluador->setBl_tramite(0);
			$proyectoevaluadors = ($oProyecto->getEvaluadores())?$oProyecto->getEvaluadores():ProyectoevaluadorQuery::getProyectoevaluador($oProyectoevaluador);
			$count = count ( $proyectoevaluadors );
			$m=1;
			for($i = 0; $i < $count; $i ++) {
				
				if ($proyectoevaluadors[$i]['cd_tipoevaluador']==1){
					$xtpl->assign ( 'ds_excusado'.$m,  $proyectoevaluadors[$i]['ds_evaluador'] );
					$xtpl->assign ( 'cd_excusado'.$m,  $proyectoevaluadors[$i]['cd_evaluador'] );
					$m++;
				}
				
			}
			$m=1;
			for($i = 0; $i < $count; $i ++) {
				if ($proyectoevaluadors[$i]['cd_tipoevaluador']==2){
					
					$xtpl->assign ( 'ds_recusado'.$m,  $proyectoevaluadors[$i]['ds_evaluador'] );
					$xtpl->assign ( 'cd_recusado'.$m,  $proyectoevaluadors[$i]['cd_evaluador'] );
					$m++;
				}
				
			}
			$m=1;
			for($i = 0; $i < $count; $i ++) {
				
				if ($proyectoevaluadors[$i]['cd_tipoevaluador']==3){
					$xtpl->assign ( 'ds_sugerido'.$m, $proyectoevaluadors[$i]['ds_evaluador'] );
					$xtpl->assign ( 'cd_sugerido'.$m,  $proyectoevaluadors[$i]['cd_evaluador'] );
					$m++;
				}
				
			}
			
			
			
			
			
		
		
		$oTipoacreditacion = new Tipoacreditacion();
		$oTipoacreditacion->setCd_tipoacreditacion($oProyecto->getCd_tipoacreditacion());
		TipoacreditacionQuery::getTipoacreditacionPorCd($oTipoacreditacion);
		$titulo = 'SeCyT - Planilla de Evaluadores ';
		$titulo .=$oTipoacreditacion->getDs_tipoacreditacion();
		if (isset ( $_GET ['er'] )) {
			if ($_GET ['er'] == 1) {
				$xtpl->assign ( 'classMsj', 'msjerror' );
				$msj = "Error: El proyecto no se ha dado de alta. Intente nuevamente";
				$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
			}
			if ($_GET ['er'] == 2) {
				$xtpl->assign ( 'classMsj', 'msjerror' );
				$msj = "Error: Eligi� mas de una vez al mismo evaluador";
				$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
			}
		} else {
			$xtpl->assign ( 'classMsj', '' );
			$xtpl->assign ( 'msj', '' );
		}
		$xtpl->parse ( 'main.msj' );
		
		$nuevaFecha = explode ( "-", $oProyecto->getDt_ini() );
		$year = $nuevaFecha [0];
		$jovenes = ($year<2014)?'j&oacute;venes investigadores':'investigadores en formaci&oacute;n';
		$ppid = ($oProyecto->getCd_tipoacreditacion()==2)?'<br>el objetivo de estos proyectos es fortalecer los antecedentes en direcci&oacute;n de proyectos de '.$jovenes.',  en el contexto de proyectos acreditados por la UNLP de los cuales formen parte':'';
		
		$xtpl->assign ( 'titulo', $titulo.$ppid );
		
		
		
		
		
			
		
		
		$xtpl->parse ( 'main' );
		$xtpl->out ( 'main' );
	}
	else 
		header('Location:../includes/accesodenegado.php');
}
else 
	header('Location:../includes/finsolicitud.php');
?>