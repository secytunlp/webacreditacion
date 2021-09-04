<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

//verifico si tiene permiso para la acción
if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Asignar Evaluador" )) {
	
	if (isset ( $_GET ['cd_evaluacion'] )) {
		$cd_evaluacion = $_GET ['cd_evaluacion'];
		$oEvaluacion1 = new Evaluacion();
		$oEvaluacion1->setCd_evaluacion($cd_evaluacion);
		EvaluacionQuery::getEvaluacionPorId($oEvaluacion1);
		$exito=EvaluacionQuery::eliminarEvaluacion($oEvaluacion1);
		if ($exito){
			$oEvaluacionproyectopuntaje = new Evaluacionproyectopuntaje();
			$oEvaluacionproyectopuntaje->setCd_evaluacion($cd_evaluacion);
			$exito=EvaluacionproyectopuntajeQuery::eliminarEvaluacionproyectopuntajePorEvaluacion($oEvaluacionproyectopuntaje);
			
				
			if ($exito){
				$oProyecto = new Proyecto();
				$oProyecto->setCd_proyecto($oEvaluacion1->getCd_proyecto());
				ProyectoQuery::getProyectoPorId($oProyecto);
				$oProyecto->setCd_estado(6);
				$exito = ProyectoQuery::modificarProyecto($oProyecto);
				if ($exito){
					$oFuncion = new Funcion();
					$oFuncion -> setDs_funcion("Asignar Evaluador");
					FuncionQuery::getFuncionPorDs($oFuncion);
					$oMovimiento = new Movimiento();
					$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
					$oMovimiento->setCd_usuario($cd_usuario);
					$oUsuario = new Usuario();
					$oUsuario->setCd_usuario($oEvaluacion1->getCd_usuario());
					UsuarioQuery::getUsuarioPorId($oUsuario);
					$oMovimiento->setDs_movimiento('Desasignación del Evaluador: '.$oUsuario->getDs_apynom().' al proyecto '.$oProyecto->getDs_titulo());
					MovimientoQuery::insertarMovimiento($oMovimiento);
					
				}
						
					
				
			}
			
		}
		if ($exito)
			header ( 'Location: index.php' ); else
			 
			header ( 'Location:index.php?er=1' );
	}
} else {
	header ( 'Location:../includes/accesodenegado.php' );
}
?>