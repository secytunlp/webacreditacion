<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

$acreditar = (isset($_GET['acreditar']))?1:0;

$funcion = ($acreditar)?"Confirmar acreditación":"Confirmar solicitud";

if (PermisoQuery::permisosDeUsuario( $cd_usuario, $funcion )) {
	
	$xtpl = new XTemplate ( 'confirmaracreditacion.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	
	
	$cd_proyecto = $_GET ['cd_proyecto'];
	$oProyecto = new Proyecto ( );
	$oProyecto->setCd_proyecto ( $cd_proyecto );
	ProyectoQuery::getProyectoPorId($oProyecto);
	$xtpl->assign ( 'cd_proyecto',  $cd_proyecto );
	$xtpl->assign ( 'acreditar',  $acreditar );
	$xtpl->assign ( 'ds_titulo',  ( $oProyecto->getDs_titulo()) );
	$xtpl->assign ( 'ds_director',  ( $oProyecto->getDs_director()) );
	$oEvaluacion = new Evaluacion();
	$oEvaluacion->setCd_proyecto($oProyecto->getCd_proyecto());
	$evaluaciones=EvaluacionQuery::getEvaluacionPorProyecto($oEvaluacion);
	for ($j = 0; $j < count($evaluaciones); $j++) {
		$eval = array();
		$eval['nu_numero']=$j+1;
		$oEvaluacion1 = new Evaluacion();
		$oEvaluacion1->setCd_evaluacion($evaluaciones[$j]['cd_evaluacion']);
		EvaluacionQuery::getEvaluacionPorId($oEvaluacion1);
		$subtotal=0;
		for ($subgrupo = 1; $subgrupo < 5; $subgrupo++) {
			$oEvaluacionproyectoplanilla = new Evaluacionproyectoplanilla();		
			$oEvaluacionproyectoplanilla->setCd_subgrupo($subgrupo);
			$evaluacionesproyectos = EvaluacionproyectoplanillaQuery::getEvaluacionproyectoplanillaPorSubgrupo($oEvaluacionproyectoplanilla);
			
			$count = count ( $evaluacionesproyectos );	
			$subtotal=0;
			$puntaje = array();
			for($i = 0; $i < $count; $i ++) {	
					
		    	$oEvaluacionproyectopuntaje = new Evaluacionproyectopuntaje();
				$oEvaluacionproyectopuntaje->setCd_evaluacion($oEvaluacion1->getCd_evaluacion());
				$oEvaluacionproyectopuntaje->setCd_evaluacionproyectoplanilla($evaluacionesproyectos[$i]['cd_evaluacionproyectoplanilla']);
				//EvaluacionproyectopuntajeQuery::getEvaluacionproyectopuntajePorEvaluacion($oEvaluacionproyectopuntaje);
		    	if ($oProyecto->getCd_tipoacreditacion()==1) {
				EvaluacionproyectopuntajeQuery::getEvaluacionproyectopuntajePorEvaluacion($oEvaluacionproyectopuntaje);
				}
				else
					EvaluacionproyectopuntajePPIDQuery::getEvaluacionproyectopuntajePorEvaluacion($oEvaluacionproyectopuntaje);
				$total +=$oEvaluacionproyectopuntaje->getNu_puntaje();
		    	$subtotal +=$oEvaluacionproyectopuntaje->getNu_puntaje();
				
					
			
			}	
			$promedio = intval($subtotal/$count);
		switch ($promedio) {
				case 0:
				   $letra='M';
				   break;
				case 1:
				   $letra='M';
				   break;
				case 2:
				   $letra='M';
				   break;
				case 3:
				   $letra='M';
				   break;
				case 4:
				   $letra='R';
				   break;
				case 5:
				   $letra='R';
				   break;
				case 6:
				   $letra=($oProyecto->getCd_tipoacreditacion()==1)?'R':'B';
				   break;
				case 7:
				   $letra='B';
				   break;
				case 8:
				   $letra=($oProyecto->getCd_tipoacreditacion()==1)?'B':'MB';
				   break;
				case 9:
				   $letra=($oProyecto->getCd_tipoacreditacion()==1)?'B':'MB';
				   break;
				case 10:
				   $letra=($oProyecto->getCd_tipoacreditacion()==1)?'MB':'E';
				   break;
			}
			
			$eval['ds_grupo'.$subgrupo]=htmlentities($evaluacionesproyectos[0]['ds_subgrupo']);
			$eval['ds_letra'.$subgrupo]=$letra;
		}
		if ($total) {
		
			if($oEvaluacion1->getNu_puntaje()==0){
				$aprobado='APROBADO';
			}
			else $aprobado='NO APROBADO';
		}
		
		$eval['ds_evaluacion']=$aprobado;
		$eval['ds_observaciones']=$oEvaluacion1->getDs_observacion();
		$xtpl->assign ( 'EVAL', $eval );
		$xtpl->parse ( 'main.evaluacion' );
	}
		
	
	if (isset ( $_GET ['er'] )) {
		if ($_GET ['er'] == 1) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "Error: no se pudo rechazar";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
	} else {
		$xtpl->assign ( 'classMsj', '' );
		$xtpl->assign ( 'msj', '' );
	}
	$xtpl->parse ( 'main.msj' );
	
	$xtpl->assign ( 'titulo', 'SeCyT - Confirmar acreditación' );
	
	
	
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/accesodenegado.php' );
?>