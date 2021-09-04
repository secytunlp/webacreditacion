<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';


if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Asignar Evaluador" )) {
	//include APP_PATH . 'includes/menu.php';
	$xtpl = new XTemplate ( 'asignarevaluador.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	if (isset ( $_GET ['er'] )) {
		if ($_GET ['er'] == 1) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "Error: No se pudo asignar el evaluador 1, es posible que ya esté asignado a la evaluación";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
	 elseif ($_GET ['er'] == 2) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "Error: No se pudo asignar el evaluador 2, es posible que ya esté asignado a la evaluación";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
	elseif ($_GET ['er'] == 3) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "Error: No se pudo asignar el evaluador 1, es posible que haya sido excusado/recusado por el director del proyecto";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
	elseif ($_GET ['er'] == 4) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "Error: No se pudo asignar el evaluador 2, es posible que haya sido excusado/recusado por el director del proyecto";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
	elseif ($_GET ['er'] == 5) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "Error: No se pudo asignar el evaluador 3, es posible que haya sido excusado/recusado por el director del proyecto";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
	elseif ($_GET ['er'] == 6) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "Error: No se pudo asignar el evaluador 3, es posible que ya esté asignado a la evaluación";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
	else {
		$xtpl->assign ( 'classMsj', '' );
		$xtpl->assign ( 'msj', '' );
	}
	}
	$xtpl->parse ( 'main.msj' );
	
	$xtpl->assign ( 'titulo', 'SeCyT - Asignar evaluadores' );
	
	$cd_proyecto = $_GET ['cd_proyecto'];
	$oProyecto = new Proyecto();
	$oProyecto->setCd_proyecto($cd_proyecto);
	ProyectoQuery::getProyectoPorId($oProyecto);
	$oProyectoevaluador = new Proyectoevaluador();
	$oProyectoevaluador->setCd_proyecto($oProyecto->getCd_proyecto());
	$oProyectoevaluador->setCd_tipoevaluador(3);
	$proyectoevaluadors = ProyectoevaluadorQuery::getProyectoevaluadorPorTipo($oProyectoevaluador);
	$count = count ( $proyectoevaluadors );
	for($i = 0; $i < $count; $i ++) {
		$xtpl->assign ( 'DATOS', $proyectoevaluadors [$i] );
		$xtpl->parse ( 'main.row' );
	}
	$oEvaluacion = new Evaluacion();
	$oEvaluacion->setCd_proyecto($cd_proyecto);
	$evaluaciones = EvaluacionQuery::getEvaluacionPorProyecto($oEvaluacion);
	if (count($evaluaciones)==0) {
		$ds_evaluador ="<label>Evaluador 1:<input type='text' name='ds_evaluador1' id='ds_evaluador1' value='' size='40'/><input type='text' id='cd_evaluador1' name='cd_evaluador1' value='' style='font-size: 10px; width: 20px;display:none' /></label><input type='hidden' name='cd_evaluacion1' id='cd_evaluacion1' value='' />";
		$xtpl->assign ( 'ds_evaluador1',  $ds_evaluador);
		$ds_evaluador ="<label>Evaluador 2:<input type='text' name='ds_evaluador2' id='ds_evaluador2' value='' size='40'/><input type='text' id='cd_evaluador2' name='cd_evaluador2' value='' style='font-size: 10px; width: 20px;display:none' /></label><input type='hidden' name='cd_evaluacion2' id='cd_evaluacion2' value='' />";
		$xtpl->assign ( 'ds_evaluador2',  $ds_evaluador);
	}
	else{
		if (count($evaluaciones)>=2) {
			$oEvaluador1 = new Usuario();
			$oEvaluador1->setCd_usuario($evaluaciones[0]['cd_usuario']);
			UsuarioQuery::getUsuarioPorId($oEvaluador1);
			
			if (($evaluaciones[0]['cd_usuario'])&&($evaluaciones[0]['cd_estado']==1)) {
				
				$ds_evaluador ="<label>Evaluador 1:<input type='text' name='ds_evaluador1' id='ds_evaluador1' value='".$oEvaluador1->getDs_apynom()."' size='40'/><input type='text' id='cd_evaluador1' name='cd_evaluador1' value='".$evaluaciones[0]['cd_usuario']."' style='font-size: 10px; width: 20px;display:none' /></label><input type='hidden' name='cd_evaluacion1' id='cd_evaluacion1' value='".$evaluaciones[0]['cd_evaluacion']."' />";
				
			}
			else{
				$ds_evaluador ="<label>Evaluador 1: ".$oEvaluador1->getDs_apynom()."</label>";
			}
			$xtpl->assign ( 'ds_evaluador1',  $ds_evaluador);
			$oEvaluador2 = new Usuario();
			$oEvaluador2->setCd_usuario($evaluaciones[1]['cd_usuario']);
			UsuarioQuery::getUsuarioPorId($oEvaluador2);
			if (($evaluaciones[1]['cd_usuario'])&&($evaluaciones[1]['cd_estado']==1)) {
				
				$ds_evaluador ="<label>Evaluador 2:<input type='text' name='ds_evaluador2' id='ds_evaluador2' value='".$oEvaluador2->getDs_apynom()."' size='40'/><input type='text' id='cd_evaluador2' name='cd_evaluador2' value='".$evaluaciones[1]['cd_usuario']."' style='font-size: 10px; width: 20px;display:none' /></label><input type='hidden' name='cd_evaluacion2' id='cd_evaluacion2' value='".$evaluaciones[1]['cd_evaluacion']."' />";
				
			}
			else{
				$ds_evaluador ="<label>Evaluador 2: ".$oEvaluador2->getDs_apynom()."</label>";
			}
			$xtpl->assign ( 'ds_evaluador2',  $ds_evaluador);
			$tercero=($evaluaciones[0]['nu_puntaje'] || $evaluaciones[1]['nu_puntaje'])?1:0;
			if ($tercero){
				$oEvaluador3 = new Usuario();
				$oEvaluador3->setCd_usuario($evaluaciones[2]['cd_usuario']);
				UsuarioQuery::getUsuarioPorId($oEvaluador3);
				if (!$evaluaciones[2]['cd_usuario']){
					$ds_evaluador ="<label>Evaluador 3:<input type='text' name='ds_evaluador3' id='ds_evaluador3' value='' size='40'/><input type='text' id='cd_evaluador3' name='cd_evaluador3' value='' style='font-size: 10px; width: 20px;display:none' /></label><input type='hidden' name='cd_evaluacion3' id='cd_evaluacion3' value='' />";
				}
				elseif ($evaluaciones[2]['cd_estado']==1) {
					
					$ds_evaluador ="<label>Evaluador 3:<input type='text' name='ds_evaluador3' id='ds_evaluador3' value='".$oEvaluador3->getDs_apynom()."' size='40'/><input type='text' id='cd_evaluador3' name='cd_evaluador3' value='".$evaluaciones[2]['cd_usuario']."' style='font-size: 10px; width: 20px;display:none' /></label><input type='hidden' name='cd_evaluacion3' id='cd_evaluacion3' value='".$evaluaciones[2]['cd_evaluacion']."' />";
					
				}
				else{
					$ds_evaluador ="<label>Evaluador 3: ".$oEvaluador3->getDs_apynom()."</label>";
				}
				$xtpl->assign ( 'ds_evaluador3',  $ds_evaluador);
			}
		}
		else{
			$oEvaluador2 = new Usuario();
			$oEvaluador2->setCd_usuario($evaluaciones[0]['cd_usuario']);
			UsuarioQuery::getUsuarioPorId($oEvaluador2);
			if ($evaluaciones[0]['bl_interno']) {
				if (($evaluaciones[0]['cd_usuario'])&&($evaluaciones[0]['cd_estado']==1)) {
					
					$ds_evaluador ="<label>Evaluador 1:<input type='text' name='ds_evaluador1' id='ds_evaluador1' value='".$oEvaluador2->getDs_apynom()."' size='40'/><input type='text' id='cd_evaluador1' name='cd_evaluador1' value='".$evaluaciones[0]['cd_usuario']."' style='font-size: 10px; width: 20px;display:none' /></label><input type='hidden' name='cd_evaluacion1' id='cd_evaluacion1' value='".$evaluaciones[0]['cd_evaluacion']."' />";
					
				}
				else{
					$ds_evaluador ="<label>Evaluador 1: ".$oEvaluador2->getDs_apynom()."</label>";
				}
				$xtpl->assign ( 'ds_evaluador1',  $ds_evaluador);
				$ds_evaluador ="<label>Evaluador 2:<input type='text' name='ds_evaluador2' id='ds_evaluador2' value='' size='40'/><input type='text' id='cd_evaluador2' name='cd_evaluador2' value='' style='font-size: 10px; width: 20px;display:none' /></label><input type='hidden' name='cd_evaluacion2' id='cd_evaluacion2' value='' />";
				$xtpl->assign ( 'ds_evaluador2',  $ds_evaluador);
			}
			else{
				$ds_evaluador ="<label>Evaluador 1:<input type='text' name='ds_evaluador1' id='ds_evaluador1' value='' size='40'/><input type='text' id='cd_evaluador1' name='cd_evaluador1' value='' style='font-size: 10px; width: 20px;display:none' /></label><input type='hidden' name='cd_evaluacion1' id='cd_evaluacion1' value='' />";
				$xtpl->assign ( 'ds_evaluador1',  $ds_evaluador);
				if (($evaluaciones[0]['cd_usuario'])&&($evaluaciones[0]['cd_estado']==1)) {
					
					$ds_evaluador ="<label>Evaluador 2:<input type='text' name='ds_evaluador2' id='ds_evaluador2' value='".$oEvaluador2->getDs_apynom()."' size='40'/><input type='text' id='cd_evaluador2' name='cd_evaluador2' value='".$evaluaciones[0]['cd_usuario']."' style='font-size: 10px; width: 20px;display:none' /></label><input type='hidden' name='cd_evaluacion2' id='cd_evaluacion2' value='".$evaluaciones[0]['cd_evaluacion']."' />";
					
				}
				else{
					$ds_evaluador ="<label>Evaluador 2: ".$oEvaluador2->getDs_apynom()."</label>";
				}
				$xtpl->assign ( 'ds_evaluador2',  $ds_evaluador);
			}
		}
		
		
	}
	
	$xtpl->assign ( 'cd_proyecto',  $cd_proyecto );
	//$xtpl->assign ( 'cd_facultad',  $oSolicitud->getCd_facultadplanilla() );
	
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
}
else 
	header('Location:../includes/accesodenegado.php');
?>