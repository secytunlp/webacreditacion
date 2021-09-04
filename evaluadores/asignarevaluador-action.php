<?
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

/*******************************************************
 * La variable er por GET indica el tipo de error por el
 * que se redireccionó al login
 *******************************************************/

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Asignar Evaluador" )) {
	
	if ( $_POST ['cd_evaluador1'] ){
		$oEvaluacion1 = new Evaluacion();
		$oEvaluacion1->setCd_usuario($_POST ['cd_evaluador1']);
	
	
		if ( $_POST ['cd_proyecto'] )
			$oEvaluacion1->setCd_proyecto($_POST ['cd_proyecto']);
		
		if ( $_POST ['cd_evaluacion1'] )
			$oEvaluacion1->setCd_evaluacion($_POST ['cd_evaluacion1']);
		
		$oEvaluacion1->setCd_estado(1);
		$oEvaluacion1->setBl_interno(1);
		$oEvaluacion1->setDt_fecha(date('YmdHis'));
		$oUsuario = new Usuario();
		$oUsuario->setCd_usuario($oEvaluacion1->getCd_usuario());
		UsuarioQuery::getUsuarioPorId($oUsuario);
		if (!ProyectoevaluadorQuery::fueRecusado($oEvaluacion1->getCd_proyecto(), $oUsuario->getNu_documento())) {
			
			if ($oEvaluacion1->getCd_evaluacion())  {
					$exito = EvaluacionQuery::modificarEvaluacion($oEvaluacion1);
				}	
			else
				$exito = EvaluacionQuery::insertEvaluacion($oEvaluacion1);
			
			if ($exito){
				$oFuncion = new Funcion();
				$oFuncion -> setDs_funcion("Asignar Evaluador");
				FuncionQuery::getFuncionPorDs($oFuncion);
				$oMovimiento = new Movimiento();
				$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
				$oMovimiento->setCd_usuario($cd_usuario);
				$oProyecto = new Proyecto();
				$oProyecto->setCd_proyecto($oEvaluacion1->getCd_proyecto());
				ProyectoQuery::getProyectoPorId($oProyecto);
				$oMovimiento->setDs_movimiento('Asignación del Evaluador: '.$oUsuario->getDs_apynom().' al proyecto '.$oProyecto->getDs_titulo());
				MovimientoQuery::insertarMovimiento($oMovimiento);
				
			}
				else{
				header ( 'Location: asignarevaluador.php?er=1&cd_proyecto='.$cd_proyecto );
				exit;
				}
		}
		else{
				header ( 'Location: asignarevaluador.php?er=3&cd_proyecto='.$cd_proyecto );
				exit;
				}
	}
	
	if ( $_POST ['cd_evaluador2'] ){
		$oEvaluacion2 = new Evaluacion();
		$oEvaluacion2->setCd_usuario($_POST ['cd_evaluador2']);
	
	
		if ( $_POST ['cd_proyecto'] )
			$oEvaluacion2->setCd_proyecto($_POST ['cd_proyecto']);
		
		if ( $_POST ['cd_evaluacion2'] )
			$oEvaluacion2->setCd_evaluacion($_POST ['cd_evaluacion2']);
		
		$oEvaluacion2->setCd_estado(1);
		$oEvaluacion2->setBl_interno(0);
		$oEvaluacion2->setDt_fecha(date('YmdHis'));
		$oUsuario = new Usuario();
		$oUsuario->setCd_usuario($oEvaluacion2->getCd_usuario());
		UsuarioQuery::getUsuarioPorId($oUsuario);
		if (!ProyectoevaluadorQuery::fueRecusado($oEvaluacion2->getCd_proyecto(), $oUsuario->getNu_documento())) {
			if ($oEvaluacion2->getCd_evaluacion())  {
					$exito = EvaluacionQuery::modificarEvaluacion($oEvaluacion2);
				}	
			else
				$exito = EvaluacionQuery::insertEvaluacion($oEvaluacion2);
			
			if ($exito){
				$oFuncion = new Funcion();
				$oFuncion -> setDs_funcion("Asignar Evaluador");
				FuncionQuery::getFuncionPorDs($oFuncion);
				$oMovimiento = new Movimiento();
				$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
				$oMovimiento->setCd_usuario($cd_usuario);
				$oProyecto = new Proyecto();
				$oProyecto->setCd_proyecto($oEvaluacion2->getCd_proyecto());
				ProyectoQuery::getProyectoPorId($oProyecto);
				
				$oMovimiento->setDs_movimiento('Asignación del Evaluador: '.$oUsuario->getDs_apynom().' al proyecto '.$oProyecto->getDs_titulo());
				MovimientoQuery::insertarMovimiento($oMovimiento);
				
			}
				else{
				header ( 'Location: asignarevaluador.php?er=2&cd_proyecto='.$cd_proyecto );
				exit;}
		}
		else{
				header ( 'Location: asignarevaluador.php?er=4&cd_proyecto='.$cd_proyecto );
				exit;
				}
	}
	if ( $_POST ['cd_evaluador3'] ){
		$oEvaluacion3 = new Evaluacion();
		$oEvaluacion3->setCd_usuario($_POST ['cd_evaluador3']);
	
	
		if ( $_POST ['cd_proyecto'] )
			$oEvaluacion3->setCd_proyecto($_POST ['cd_proyecto']);
		
		if ( $_POST ['cd_evaluacion3'] )
			$oEvaluacion3->setCd_evaluacion($_POST ['cd_evaluacion3']);
		
		$oEvaluacion3->setCd_estado(1);
		$oEvaluacion3->setBl_interno(0);
		$oEvaluacion3->setDt_fecha(date('YmdHis'));
		$oUsuario = new Usuario();
		$oUsuario->setCd_usuario($oEvaluacion3->getCd_usuario());
		UsuarioQuery::getUsuarioPorId($oUsuario);
		if (!ProyectoevaluadorQuery::fueRecusado($oEvaluacion3->getCd_proyecto(), $oUsuario->getNu_documento())) {
			if ($oEvaluacion3->getCd_evaluacion())  {
					$exito = EvaluacionQuery::modificarEvaluacion($oEvaluacion3);
				}	
			else
				$exito = EvaluacionQuery::insertEvaluacion($oEvaluacion3);
			
			if ($exito){
				$oFuncion = new Funcion();
				$oFuncion -> setDs_funcion("Asignar Evaluador");
				FuncionQuery::getFuncionPorDs($oFuncion);
				$oMovimiento = new Movimiento();
				$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
				$oMovimiento->setCd_usuario($cd_usuario);
				$oProyecto = new Proyecto();
				$oProyecto->setCd_proyecto($oEvaluacion3->getCd_proyecto());
				ProyectoQuery::getProyectoPorId($oProyecto);
				$oMovimiento->setDs_movimiento('Asignación del Evaluador: '.$oUsuario->getDs_apynom().' al proyecto '.$oProyecto->getDs_titulo());
				MovimientoQuery::insertarMovimiento($oMovimiento);
				
			}
				else{
				header ( 'Location: asignarevaluador.php?er=6&cd_proyecto='.$cd_proyecto );
				exit;}
		}
		else{
				header ( 'Location: asignarevaluador.php?er=5&cd_proyecto='.$cd_proyecto );
				exit;
				}
	}
	header ( 'Location: ../proyectos/index.php ' ); 
} else
	header ( 'Location:../includes/accesodenegado.php' );
	