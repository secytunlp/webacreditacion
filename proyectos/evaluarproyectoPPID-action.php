<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';


if (PermisoQuery::permisosDeUsuario( $cd_usuario, 'Evaluar proyecto' )) {
	$cd_evaluacion = $_POST['cd_evaluacion'];

	
	$ultimoitem = EvaluacionproyectoplanillaQuery::ultimo_idPPID();
	for($i = 1; $i <= $ultimoitem; $i ++) {	
		if ( isset($_POST ['nu_puntajeP'.$i]) ){
			$oEvaluacionproyectopuntaje = new Evaluacionproyectopuntaje();
			$oEvaluacionproyectopuntaje->setCd_evaluacionproyectoplanilla($i);
			$oEvaluacionproyectopuntaje->setCd_evaluacion($cd_evaluacion);
						
			EvaluacionproyectopuntajePPIDQuery::getEvaluacionproyectopuntajePorEvaluacion($oEvaluacionproyectopuntaje);
			
			$oEvaluacionproyectopuntaje->setNu_puntaje( $_POST ['nu_puntajeP'.$i] );
			
			if ($oEvaluacionproyectopuntaje->getCd_evaluacionproyectopuntaje())
				EvaluacionproyectopuntajePPIDQuery::modificarEvaluacionproyectopuntaje($oEvaluacionproyectopuntaje);
			else EvaluacionproyectopuntajePPIDQuery::insertEvaluacionproyectopuntaje($oEvaluacionproyectopuntaje);
		}
	}
	
	
	$cd_proyecto = $_POST['cd_proyecto'];
	$oEvaluacion = new Evaluacion();
	$oEvaluacion->setCd_evaluacion($cd_evaluacion);
	EvaluacionQuery::getEvaluacionPorId($oEvaluacion);
	$oEvaluacion->setNu_puntaje($_POST['desaprobado']);
	$oEvaluacion->setDs_observacion($_POST['ds_observacion']);
	EvaluacionQuery::modificarEvaluacion($oEvaluacion);
	$oProyecto = new Proyecto();
	$oProyecto->setCd_proyecto($cd_proyecto);
	ProyectoQuery::getProyectoPorId($oProyecto);
	$oFuncion = new Funcion();
	$oFuncion -> setDs_funcion('Evaluar proyecto');
	FuncionQuery::getFuncionPorDs($oFuncion);
	$oMovimiento = new Movimiento();
	$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
	$oMovimiento->setCd_usuario($cd_usuario);
	$oMovimiento->setDs_movimiento('Evaluar al proyecto de '.$oProyecto->getDs_titulo());
	MovimientoQuery::insertarMovimiento($oMovimiento);
	header ( 'Location: ../proyectos/index.php ' ); 
	
} else
	header ( 'Location:../includes/accesodenegado.php' );
	