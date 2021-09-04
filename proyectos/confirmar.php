<?
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

$acreditar = (isset($_GET['acreditar']))?1:0;

$funcion = ($acreditar)?"Confirmar acreditación":"Admitir solicitud";

if (PermisoQuery::permisosDeUsuario( $cd_usuario, $funcion )) {
	$cd_estado = ($acreditar)?5:3;
	$cd_proyecto = $_GET ['cd_proyecto'];
	$oProyecto = new Proyecto ( );
	$oProyecto->setCd_proyecto ( $cd_proyecto );
	ProyectoQuery::getProyectoPorId($oProyecto);
	$oProyecto->setCd_estado($cd_estado);
	if ($acreditar) {
		ProyectoQuery::dameCodigo($oProyecto);
	}
	$exito = ProyectoQuery::modificarProyecto ( $oProyecto );	
	$oFuncion = new Funcion();
	$oFuncion -> setDs_funcion($funcion);
	FuncionQuery::getFuncionPorDs($oFuncion);
	$oMovimiento = new Movimiento();
	$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
	$oMovimiento->setCd_usuario($cd_usuario);
	$oMovimiento->setDs_movimiento($funcion.' Proyecto: '.$oProyecto->getDs_titulo());
	MovimientoQuery::insertarMovimiento($oMovimiento);
	if ($exito){
		$oIntegrante = new Integrante();
		$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
		$oIntegrante->setCd_tipoinvestigador(1);
		$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
		$oDocente = new Docente ( );
		$oDocente->setCd_docente ( $integrantes [0]['cd_docente']);
		DocenteQuery::getDocentePorId($oDocente);
		$oUsuario = new Usuario();
		$oUsuario->setNu_documento($oDocente->getNu_documento());
		UsuarioQuery::getUsuarioPorDocumento($oUsuario);
		$cabeceras="From: ".$nameFrom."<".$mailFrom.">\nReply-To: ".$mailFrom."\n";
		if ($oDocente->getDs_mail()!=$oUsuario->getDs_mail())
			$cabeceras .="BCC: ".$oDocente->getDs_mail()."\n";
		$oUsuarioF = new Usuario();
		$oUsuarioF->setCd_facultad($oProyecto->getCd_facultad());
		$usuarios = UsuarioQuery::getUsuariosPorFac($oUsuarioF);
		$count = count ( $usuarios );
		for($i = 0; $i < $count; $i ++) {
			$cabeceras .="BCC: ".$usuarios [$i]['ds_mail']."\n";
		}
		$cabeceras .="X-Mailer:PHP/".phpversion()."\n";
		$cabeceras .="Mime-Version: 1.0\n";
		$cabeceras .= "Content-type: multipart/mixed; ";
		$cabeceras .= "boundary=\"Message-Boundary\"\n";
		$cabeceras .= "Content-transfer-encoding: 7BIT\n";
		$body_top = "--Message-Boundary\n";
		$body_top .= "Content-type: text/html; charset=iso-8859-1\n";
		$body_top .= "Content-transfer-encoding: 7BIT\n";
		$body_top .= "Content-description: Mail message body\n\n";
		$ds_subjet = ($acreditar)?'Confirmación de Acreditación':'Admisión de Solicitud de Acreditación';
		$ds_coment = ($acreditar)?'':'La solicitud del presente proyecto ha sido admitida y se incorpora al proceso de evaluación';
		$shtml = $body_top. "<html><body><div style='padding-left: 30px; padding-right: 30px; padding-top: 30px ; padding-bottom: 30px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #666666; background-color:#FFFFFF'><img src=\"".WEB_PATH."img/image002.gif\" alt=\"Logo\" longdesc=\"Logo\"><br>ACREDITACION DE PROYECTOS<hr style= 'color: #999999; text-decoration: none;'><p><strong>".$ds_subjet."<br>Proyecto</strong>: ".$oProyecto->getDs_titulo()."<br><strong>Director</strong>: ".$oProyecto->getDs_director()."<br>".$ds_coment."</p><hr style= 'color: #999999; text-decoration: none;'>";
		if ($acreditar) {
			$shtml .='Evaluación 1:<br>';
			$oEvaluacion = new Evaluacion();
			$oEvaluacion->setCd_proyecto($oProyecto->getCd_proyecto());
			$evaluaciones=EvaluacionQuery::getEvaluacionPorProyecto($oEvaluacion);
			$oEvaluacion1 = new Evaluacion();
			$oEvaluacion1->setCd_evaluacion($evaluaciones[0]['cd_evaluacion']);
			EvaluacionQuery::getEvaluacionPorId($oEvaluacion1);
			$oEvaluacion2 = new Evaluacion();
			$oEvaluacion2->setCd_evaluacion($evaluaciones[1]['cd_evaluacion']);
			EvaluacionQuery::getEvaluacionPorId($oEvaluacion2);
			
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
					EvaluacionproyectopuntajeQuery::getEvaluacionproyectopuntajePorEvaluacion($oEvaluacionproyectopuntaje);
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
					   $letra='R';
					   break;
					case 7:
					   $letra='B';
					   break;
					case 8:
					   $letra='B';
					   break;
					case 9:
					   $letra='B';
					   break;
					case 10:
					   $letra='MB';
					   break;
				}
				$shtml .=$evaluacionesproyectos[0]['ds_subgrupo'].': '.$letra.'<br>';
			}
			if ($total) {
			
				if($oEvaluacion1->getNu_puntaje()==0){
					$aprobado='APROBADO';
				}
				else $aprobado='NO APROBADO';
			}
			$shtml .='Calificación: '.$aprobado.'<br>';
			$shtml .='Observaciones: '.$oEvaluacion1->getDs_observacion()."<br><hr style= 'color: #999999; text-decoration: none;'>";
			$subtotal=0;
			$shtml .='Evaluación 2:<br>';
			for ($subgrupo = 1; $subgrupo < 5; $subgrupo++) {
				$oEvaluacionproyectoplanilla = new Evaluacionproyectoplanilla();		
				$oEvaluacionproyectoplanilla->setCd_subgrupo($subgrupo);
				$evaluacionesproyectos = EvaluacionproyectoplanillaQuery::getEvaluacionproyectoplanillaPorSubgrupo($oEvaluacionproyectoplanilla);
				
				$count = count ( $evaluacionesproyectos );	
				$subtotal=0;
				$puntaje = array();
				for($i = 0; $i < $count; $i ++) {	
						
			    	$oEvaluacionproyectopuntaje = new Evaluacionproyectopuntaje();
					$oEvaluacionproyectopuntaje->setCd_evaluacion($oEvaluacion2->getCd_evaluacion());
					$oEvaluacionproyectopuntaje->setCd_evaluacionproyectoplanilla($evaluacionesproyectos[$i]['cd_evaluacionproyectoplanilla']);
					EvaluacionproyectopuntajeQuery::getEvaluacionproyectopuntajePorEvaluacion($oEvaluacionproyectopuntaje);
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
					   $letra='R';
					   break;
					case 7:
					   $letra='B';
					   break;
					case 8:
					   $letra='B';
					   break;
					case 9:
					   $letra='B';
					   break;
					case 10:
					   $letra='MB';
					   break;
				}
				$shtml .=$evaluacionesproyectos[0]['ds_subgrupo'].': '.$letra.'<br>';
			}
			if ($total) {
			
				if($oEvaluacion2->getNu_puntaje()==0){
					$aprobado='APROBADO';
				}
				else $aprobado='NO APROBADO';
			}
			$shtml .='Calificación: '.$aprobado.'<br>';
			$shtml .='Observaciones: '.$oEvaluacion2->getDs_observacion()."<br><hr style= 'color: #999999; text-decoration: none;'>";
			if ($evaluaciones[2]['cd_evaluacion']) {
				$shtml .='Evaluación 3:<br>';
				$oEvaluacion3 = new Evaluacion();
				$oEvaluacion3->setCd_evaluacion($evaluaciones[2]['cd_evaluacion']);
				EvaluacionQuery::getEvaluacionPorId($oEvaluacion3);
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
						$oEvaluacionproyectopuntaje->setCd_evaluacion($oEvaluacion3->getCd_evaluacion());
						$oEvaluacionproyectopuntaje->setCd_evaluacionproyectoplanilla($evaluacionesproyectos[$i]['cd_evaluacionproyectoplanilla']);
						EvaluacionproyectopuntajeQuery::getEvaluacionproyectopuntajePorEvaluacion($oEvaluacionproyectopuntaje);
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
						   $letra='R';
						   break;
						case 7:
						   $letra='B';
						   break;
						case 8:
						   $letra='B';
						   break;
						case 9:
						   $letra='B';
						   break;
						case 10:
						   $letra='MB';
						   break;
					}
					$shtml .=$evaluacionesproyectos[0]['ds_subgrupo'].': '.$letra.'<br>';
				}
				if ($total) {
				
					if($oEvaluacion3->getNu_puntaje()==0){
						$aprobado='APROBADO';
					}
					else $aprobado='NO APROBADO';
				}
				$shtml .='Calificación: '.$aprobado.'<br>';
				$shtml .='Observaciones: '.$oEvaluacion3->getDs_observacion()."<br><hr style= 'color: #999999; text-decoration: none;'>";
			}
			$shtml .= "</body></html>\n\n--Message-Boundary\n";
		}
		if (!$test) {
			mail($oUsuario->getDs_mail(),$ds_subjet,$shtml,$cabeceras);
		}
		header ( 'Location:index.php'); 
	}else
		header ( 'Location: confirmar.php?er=1&cd_proyecto=' . $oProyecto->getCd_proyecto() );
} else
	header ( 'Location:../includes/accesodenegado.php' );
	