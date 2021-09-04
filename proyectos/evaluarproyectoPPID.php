<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';



if (PermisoQuery::permisosDeUsuario( $cd_usuario, 'Evaluar proyecto' )) {
	//include APP_PATH . 'includes/menu.php';
	$xtpl = new XTemplate ( 'evaluarproyectoPPID.html' );
	include APP_PATH.'includes/cargarmenu.php';
	
	
		
	$cd_proyecto = $_GET ['cd_proyecto'];
	$oProyecto = new Proyecto();
	$oProyecto->setCd_proyecto($cd_proyecto);
	ProyectoQuery::getProyectoPorId ($oProyecto);
	
	$oEvaluacion = new Evaluacion();
	$oEvaluacion->setCd_proyecto($cd_proyecto);	
	$oEvaluacion->setCd_usuario($cd_usuario);
	EvaluacionQuery::getEvaluacionPorProyectoEvaluador($oEvaluacion);
	if ($oEvaluacion->getCd_estado()==6) {
		
		$xtpl->assign ( 'ds_titulo',  stripslashes( htmlspecialchars($oProyecto->getDs_titulo()) ) );
		$xtpl->assign ( 'ds_director',  stripslashes( htmlspecialchars($oProyecto->getDs_director()) ) );		
		
			
		$xtpl->assign ( 'cd_evaluacion',  ( $oEvaluacion->getCd_evaluacion() ) );
		$xtpl->assign ( 'cd_proyecto',  $cd_proyecto );
		
		$oEvaluacionproyectoplanilla = new Evaluacionproyectoplanilla();
		
		
		$evaluacionOUT = array ( );
		for ($subgrupo = 1; $subgrupo < 5; $subgrupo++) {
			
			
		$oEvaluacionproyectoplanilla->setCd_subgrupo($subgrupo);
		$evaluacionesproyectos = EvaluacionproyectoplanillaQuery::getEvaluacionproyectoPPIDplanillaPorSubgrupo($oEvaluacionproyectoplanilla);
		
		$count = count ( $evaluacionesproyectos );	
		
		$speech = '';
		$rowAlt = '';
		$rowspan=3;
			$evaluacionOUT[$subgrupo]['ds_evaluacionproyecto'] = '<p>'.$subgrupo.') Evaluaci&oacute;n de 0 a 10</p>';
			if ($speech) {
				$evaluacionOUT[$subgrupo]['ds_evaluacionproyecto'] .= '<p>'.$speech.'</p>';
			}
			$evaluacionOUT[$subgrupo]['ds_evaluacionproyecto'] .='<table border="0" cellpadding="0" cellspacing="0"><tr><td><table  border="1" cellpadding="0" cellspacing="0" style="width:100%; border-style: solid; border-width: 1px;  border-color: #666 ;margin-bottom:5px">
	                    <tr style="border-style: solid; border-width: 1px; border-color: #666"><td style="background-color: #eee;color:#333; width:80px" rowspan="'.$rowspan.'">'.$evaluacionesproyectos[0]['ds_subgrupo'].'</td>';
			 
			
			 $evaluacionOUT[$subgrupo]['ds_evaluacionproyecto'] .='<input type="hidden"  name="nu_cantitem'.$subgrupo.'" id="nu_cantitem'.$subgrupo.'" value="'.$count.'">';
			for($i = 0; $i < $count; $i ++) {	
				$evaluacionOUT[$subgrupo]['ds_evaluacionproyecto'] .='<td><div align="center">'. $evaluacionesproyectos[$i]['ds_letra'].'</div></td>';
			}
			if ($rowAlt) {
				$evaluacionOUT[$subgrupo]['ds_evaluacionproyecto'] .= $rowAlt;
			}	
	                        
	    $evaluacionOUT[$subgrupo]['ds_evaluacionproyecto'] .='</tr><tr>';
	    for($i = 0; $i < $count; $i ++) {	
				$evaluacionOUT[$subgrupo]['ds_evaluacionproyecto'] .='<td>'. $evaluacionesproyectos[$i]['ds_evaluacionproyectoplanilla'].'</td>';
				
				
		
		}	
	                        
	   
	     $evaluacionOUT[$subgrupo]['ds_evaluacionproyecto'] .='</tr><tr>';
	    for($i = 0; $i < $count; $i ++) {	
				
	    	$oEvaluacionproyectopuntaje = new Evaluacionproyectopuntaje();
			$oEvaluacionproyectopuntaje->setCd_evaluacion($oEvaluacion->getCd_evaluacion());
			$oEvaluacionproyectopuntaje->setCd_evaluacionproyectoplanilla($evaluacionesproyectos[$i]['cd_evaluacionproyectoplanilla']);
			EvaluacionproyectopuntajePPIDQuery::getEvaluacionproyectopuntajePorEvaluacion($oEvaluacionproyectopuntaje);
	    	
			$evaluacionOUT[$subgrupo]['ds_evaluacionproyecto'] .='<td><div align="center"><input type="text" size="5" name="nu_puntajeP'.$oEvaluacionproyectopuntaje->getCd_evaluacionproyectoplanilla().'" id="nu_puntaje'.$evaluacionesproyectos[$i]['cd_subgrupo'].$i.'" value="'.$oEvaluacionproyectopuntaje->getNu_puntaje().'" onblur="sumarPuntaje();" class="fValidate[\'integer\']"></div><div id="divpuntaje'.$evaluacionesproyectos[$i]['cd_subgrupo'].$i.'" class="fValidator-msg"></div></td>';
				
				
		
		}	
	                        
	    $evaluacionOUT[$subgrupo]['ds_evaluacionproyecto'] .='</tr>';
	     $evaluacionOUT[$subgrupo]['ds_evaluacionproyecto'] .='</table></td>';
	     $evaluacionOUT[$subgrupo]['ds_evaluacionproyecto'] .='<td style="padding-left:20px"><table  border="1" cellpadding="0" cellspacing="0" style="width:100%; border-style: solid; border-width: 1px;  border-color: #666 ;margin-bottom:5px">
	                    <tr style="border-style: solid; border-width: 1px; border-color: #666"><td style="background-color: #eee;color:#333; width:80px">'.$evaluacionesproyectos[0]['ds_subgrupo'].'</td><tr><td style="background-color: #eee;color:#333; width:80px"><div id="divletra'.$evaluacionesproyectos[0]['cd_subgrupo'].'" class="fValidator-msg" align="center"></div><input type="hidden" name="ds_letra'.$evaluacionesproyectos[0]['cd_subgrupo'].'" id="ds_letra'.$evaluacionesproyectos[0]['cd_subgrupo'].'" /></td></tr></table>';
	    
	     $evaluacionOUT[$subgrupo]['ds_evaluacionproyecto'] .='</td></tr></table>';
		//$xtpl->assign ( 'ds_evaluacionproyecto',  $ds_evaluacionproyecto );
		$xtpl->assign ( 'DATOS', $evaluacionOUT[$subgrupo] );
		$xtpl->parse ( 'main.subgrupo' );
		}
	                              
	                        
		
		if (isset ( $_GET ['er'] )) {
			if ($_GET ['er'] == 1) {
				$xtpl->assign ( 'classMsj', 'msjerror' );
				$msj = "Error: Ocurri&oacute; un problema. Intente nuevamente";
				$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
			}
		} else {
			$xtpl->assign ( 'classMsj', '' );
			$xtpl->assign ( 'msj', '' );
		}
		$xtpl->parse ( 'main.msj' );
		
		$titulo = 'SeCyT - Evaluar Proyecto';
		$xtpl->assign ( 'titulo', $titulo );
		$xtpl->assign ( 'ds_observacion', stripslashes( htmlspecialchars($oEvaluacion->getDs_observacion())) );
		
		
		
		
		
		$xtpl->parse ( 'main' );
		$xtpl->out ( 'main' );
	}
	else 
		header('Location:../includes/accesodenegado.php');
}
else 
	header('Location:../includes/accesodenegado.php');
?>