<?php
include '../fpdf/fpdfhtml.php';
include '../includes/include.php';
include '../includes/datosSession.php';
$enviar = (isset($_GET['enviar']))?1:0;
$enviarE = (isset($_GET['enviarE']))?1:0;
$funcion = ($enviar)?"Enviar evaluacion":"Ver evaluacion";
if (PermisoQuery::permisosDeUsuario( $cd_usuario, $funcion )) {
	$oPDF_Evaluacion = new PDF_Evaluacion ( );
	
	//Header Fijo para todos los estados de cuenta
	
	$oProyecto = new Proyecto();
	$cd_proyecto = $_GET ['cd_proyecto'];
	$oProyecto->setCd_proyecto($cd_proyecto);
	ProyectoQuery::getProyectoPorId ($oProyecto);
	$year = intval(substr($oProyecto->getDt_ini(),0,4));
	$tipo = $oProyecto->getCd_tipoacreditacion();
	$oEvaluacion = new Evaluacion();
	if ($_GET['cd_evaluacion']){
		$oEvaluacion->setCd_evaluacion($_GET['cd_evaluacion']);
		EvaluacionQuery::getEvaluacionPorId($oEvaluacion);
	}
	else{
		$oEvaluacion->setCd_proyecto($cd_proyecto);	
		$oEvaluacion->setCd_usuario($cd_usuario);
		EvaluacionQuery::getEvaluacionPorProyectoEvaluador($oEvaluacion);
	}
	if ($enviar){
		$oEvaluacion->setCd_estado(8);
	}
	$cd_estado = $oEvaluacion->getCd_estado();
	$ds_titulo = $oProyecto->getDs_titulo();
	$ds_director = $oProyecto->getDs_director();
	$oPDF_Evaluacion->AddPage();
	$subtotal=0;
	for ($subgrupo = 1; $subgrupo < 5; $subgrupo++) {
		$oEvaluacionproyectoplanilla = new Evaluacionproyectoplanilla();		
		$oEvaluacionproyectoplanilla->setCd_subgrupo($subgrupo);
		if ($oProyecto->getCd_tipoacreditacion()==1) {
			$evaluacionesproyectos = EvaluacionproyectoplanillaQuery::getEvaluacionproyectoplanillaPorSubgrupo($oEvaluacionproyectoplanilla);
		}
		else 
			$evaluacionesproyectos = EvaluacionproyectoplanillaQuery::getEvaluacionproyectoPPIDplanillaPorSubgrupo($oEvaluacionproyectoplanilla);
		
		
		$count = count ( $evaluacionesproyectos );	
		$subtotal=0;
		$puntaje = array();
		
		for($i = 0; $i < $count; $i ++) {	
				
	    	$oEvaluacionproyectopuntaje = new Evaluacionproyectopuntaje();
			$oEvaluacionproyectopuntaje->setCd_evaluacion($oEvaluacion->getCd_evaluacion());
			$oEvaluacionproyectopuntaje->setCd_evaluacionproyectoplanilla($evaluacionesproyectos[$i]['cd_evaluacionproyectoplanilla']);
			if ($oProyecto->getCd_tipoacreditacion()==1) {
				EvaluacionproyectopuntajeQuery::getEvaluacionproyectopuntajePorEvaluacion($oEvaluacionproyectopuntaje);
			}
			else
				EvaluacionproyectopuntajePPIDQuery::getEvaluacionproyectopuntajePorEvaluacion($oEvaluacionproyectopuntaje);
	    	$total +=$oEvaluacionproyectopuntaje->getNu_puntaje();
	    	$subtotal +=$oEvaluacionproyectopuntaje->getNu_puntaje();
			$puntaje[$i]=$oEvaluacionproyectopuntaje->getNu_puntaje();
				
		
		}	
		if ($oProyecto->getCd_tipoacreditacion()==1) {
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
		}
		else{
			$promedio=FuncionesComunes::Format_toDecimal($subtotal/$count);
			$totalAbs += $promedio;
			$letra=$promedio;
		}
		
		switch ($subgrupo) {
				case 2:
				$speech = ($oProyecto->getCd_tipoacreditacion()==1)?utf8_decode('Evaluación R (Regular) en este ítem, implica la NO APROBACION del Proyecto'):'';
				$rowAlt ='<tr>';
				for($i = 0; $i < $count; $i ++) {	
					if ($i<3) {
						$rowAlt .='<td align="center">';
					}
					elseif ($i==4) $rowAlt .='<td colspan="2" align="center">Antecedentes';
					if ($i<4) 
						$rowAlt .='</td>';
				}
				$rowAlt .='</tr>';
				$rowspan=4;
				$colspan=3;
				
				break;
				case 4:
				$speech = '';
				
				
					$rowAlt =utf8_decode('<tr><td colspan="3" align="center">Recursos para la Realización</td></tr>');
					
						
				
				$rowspan=4;
				$colspan=3;
				
				break;
				default:
					$speech = '';
					$rowAlt = '';
					$rowspan=3;
					
				break;
			}
			$ds_item = utf8_decode('<p>'.$subgrupo.') Evaluación de 0 a 10</p>');
			if ($speech) {
				$ds_item .= '<p>'.$speech.'</p>';
			}
			$ds_item .='<table border="1" cellpadding="0" cellspacing="0"><tr><td  rowspan="'.$rowspan.'" valign="middle" bgcolor="#CCCCCC">'.$evaluacionesproyectos[0]['ds_subgrupo'].'</td>';
			 
			
			 
			for($i = 0; $i < $count; $i ++) {	
				$ds_item .='<td align="center">'. $evaluacionesproyectos[$i]['ds_letra'].'</td>';
				
			}
			
					$ds_item .='<td rowspan="'.$rowspan.'" align="center" valign="middle" bgcolor="#CCCCCC">'.$letra.'</td>';
			if ($rowAlt) {
				$ds_item .= $rowAlt;
			}	
	                        
	    $ds_item .='</tr><tr>';
	    for($i = 0; $i < $count; $i ++) {	
				$ds_item .='<td>'. $evaluacionesproyectos[$i]['ds_evaluacionproyectoplanilla'].'</td>';
				
				
		
		}	
	                        
	   
	     $ds_item .='</tr><tr>';
	    for($i = 0; $i < $count; $i ++) {	
	    	$ds_item .='<td align="center">'.$puntaje[$i].'</td>';
			
				
		
		}	
	                        
	    $ds_item .='</tr>';
	     $ds_item .='</table>';
	  
		
		
	$oPDF_Evaluacion->Item($ds_item);
		
	}
	
	if ($total) {
		
		if($oEvaluacion->getNu_puntaje()==0){
			$aprobado='APROBADO';
		}
		else $aprobado='NO APROBADO';
	}
	$oPDF_Evaluacion->ln(6);
	$oPDF_Evaluacion->SetFont ( 'Arial', '', 16 );
	if ($oProyecto->getCd_tipoacreditacion()==2) {
		$oPDF_Evaluacion->Cell ( 190, 8, 'PROMEDIO DEL PROYECTO: '.$promedio=FuncionesComunes::Format_toDecimal($totalAbs/4), 'LTR',0,'C',1);	
		$oPDF_Evaluacion->ln(8);
	}
	
	$oPDF_Evaluacion->Cell ( 190, 8, $aprobado, 'LBR',0,'C',1);	
	$oUsuario = new Usuario();
	$oUsuario->setCd_usuario($oEvaluacion->getCd_usuario());
	UsuarioQuery::getUsuarioPorId($oUsuario);
	$oPDF_Evaluacion->ln(12);
	$oPDF_Evaluacion->separadorNegro('Observaciones','','');
	$oPDF_Evaluacion->SetFont ( 'Arial', '', 8 );
	$oPDF_Evaluacion->MultiCell(190,4,$oEvaluacion->getDs_observacion(),'LTBR');
	$oEvaluador = new Evaluador();
	$oEvaluador->setNu_documento($oUsuario->getNu_documento());
	EvaluadorQuery::getEvaluadorPorDocumento($oEvaluador);
	$oEvaludorespecialidad = new Evaluadorespecialidad();
	$oEvaludorespecialidad->setCd_usuario($oUsuario->getCd_usuario());
	$especialidades=EvaluadorespecialidadQuery::getEvaluadorespecialidadPorUsuario($oEvaludorespecialidad);
	$ds_firma ='<table border="1" cellpadding="0" cellspacing="0"><tr><td align="center" valign="middle" bgcolor="#CCCCCC">Apellido, Nombre</td><td align="center" valign="middle" bgcolor="#CCCCCC">Categor&iacute;a</td><td align="center" valign="middle" bgcolor="#CCCCCC">Firma</td><td align="center" valign="middle" bgcolor="#CCCCCC">Campo disciplinar</td></tr>';
	
	$especialidadesHTML = '';
	
	foreach ($especialidades as $especialidad) {
		if ($especialidadesHTML) {
			$especialidadesHTML .=' - '.$especialidad['ds_especialidad'];
		}
		else
			$especialidadesHTML =$especialidad['ds_especialidad'];
	}
	$ds_firma .='<tr><td valign="middle">'.$oUsuario->getDs_apynom().'</td><td valign="middle">'.$oEvaluador->getDs_categoria().'</td><td valign="middle" align="center">____________________________________</td><td valign="middle">'.$especialidadesHTML.'</td></tr></table>';
	$oPDF_Evaluacion->WriteHTML($ds_firma);
	//$oPDF_Evaluacion->firma2($oUsuario->getDs_apynom());	
	if ($enviar){
		if ($total) {
		if ((!$oEvaluacion->getNu_puntaje()) || (($oEvaluacion->getDs_observacion()!='') && ($oEvaluacion->getNu_puntaje()))) {
		
		$exito=EvaluacionQuery::modificarEvaluacion($oEvaluacion);
		
		$dir = APP_PATH.'pdfs/'.$year.'/'.$oProyecto->getCd_proyecto().'/';
		
		$ds_evaluador = stripslashes(str_replace("'","_",str_replace(',','',$oUsuario->getDs_apynom())));
		$fileName = "Evaluacion_".$ds_evaluador."_".$oProyecto->getCd_proyecto().".pdf";
		$nombreArchivo = $dir . $fileName;
		//el output se hace en el llamador porque depende de quien lo llame
		
		$oPDF_Evaluacion->Output ( $nombreArchivo, 'F');
		
		$file = fopen($nombreArchivo, "r");
     	$contenido = fread($file, filesize($nombreArchivo));
		$encoded_attach = chunk_split(base64_encode($contenido));
		fclose($file);
		$exito=1;
		if(!EvaluacionQuery::controlEstado($oEvaluacion, 8)){
			$evaluaciones=EvaluacionQuery::getEvaluacionPorProyecto($oEvaluacion);
			if ((count($evaluaciones)>1)&&(((!$evaluaciones[0]['nu_puntaje'] && !$evaluaciones[1]['nu_puntaje']))||(($evaluaciones[0]['nu_puntaje'] && $evaluaciones[1]['nu_puntaje'])))){
				$oProyecto->setCd_estado(8);	
				$exito = ProyectoQuery::modificarProyecto ( $oProyecto );
			}
			if ($evaluaciones[2]['cd_usuario']){
				$oProyecto->setCd_estado(8);	
				$exito = ProyectoQuery::modificarProyecto ( $oProyecto );
				
			}
		}
		if ($exito){
			$oFuncion = new Funcion();
			$oFuncion -> setDs_funcion($funcion);
			FuncionQuery::getFuncionPorDs($oFuncion);
			$oMovimiento = new Movimiento();
			$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
			$oMovimiento->setCd_usuario($cd_usuario);
			$oMovimiento->setDs_movimiento('Proyecto: '.$oProyecto->getDs_titulo());
			MovimientoQuery::insertarMovimiento($oMovimiento);
			
			$cabeceras="From: ".$ds_evaluador."<".$oUsuario->getDs_mail().">\nReply-To: ".$oUsuario->getDs_mail()."\nReturn-path: ".$oUsuario->getDs_mail()."\n";
                       
			$cabeceras .="X-Mailer:PHP/".phpversion()."\n";
			$cabeceras .="Mime-Version: 1.0\n";
			$cabeceras .= "Content-type: multipart/mixed; ";
			$cabeceras .= "boundary=\"Message-Boundary\"\n";
			$cabeceras .= "Content-transfer-encoding: 7BIT\n";
			//$cabeceras .= "X-attachments: ".$nombre_archivo;
			
			$body_top = "--Message-Boundary\n";
			$body_top .= "Content-type: text/html; charset=iso-8859-1\n";
			$body_top .= "Content-transfer-encoding: 7BIT\n";
			$body_top .= "Content-description: Mail message body\n\n";
			if (file_exists($dir)){
				
		      $adjuntos = '';
		     $handle=opendir($dir);
				while ($archivo = readdir($handle))
				{
			        if (strchr($archivo,$fileName))
			         {
			         	//if (!in_array($archivo,$archivosNoEnv)){
				         	$file = fopen($dir.$archivo, "r");
				         	$contenido = fread($file, filesize($dir.$archivo));
							$encoded_attach = chunk_split(base64_encode($contenido));
							fclose($file);
				         	
							//$cabeceras .= "X-attachments: ".$archivo;
				         	$adjuntos .= "\n\n--Message-Boundary\n";
							$adjuntos .= "Content-type: Binary; name=\"$archivo\"\n";
							$adjuntos .= "Content-Transfer-Encoding: BASE64\n";
							$adjuntos .= "Content-disposition: attachment; filename=\"$archivo\"\n\n";
							$adjuntos .= "$encoded_attach\n";
							$adjuntos .= "--Message-Boundary--\n"; 
			         	}
						//$adjuntos .= "--Message-Boundary--\n"; 
			        // }
				}
			}
			
			closedir($handle);
			
			$shtml = $body_top."<html><body><div style='padding-left: 30px; padding-right: 30px; padding-top: 30px ; padding-bottom: 30px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #666666; background-color:#FFFFFF'><img src=\"".WEB_PATH."img/image002.gif\" alt=\"Logo\" longdesc=\"Logo\"><br>ACREDITACION DE PROYECTOS<hr style= 'color: #999999; text-decoration: none;'><p><strong>Solicitud de Acreditaci&oacute;n <br><strong>T&iacute;tulo</strong>: ".htmlentities($oProyecto->getDs_titulo())."<br><strong>Director</strong>: ".htmlentities($oProyecto->getDs_director())."</p><hr style= 'color: #999999; text-decoration: none;'></body></html>";
			$shtml .= $adjuntos;
			$year = $year;
			if (!$test) {
				mail($mailReceptor,"Evaluacion de Acreditacion de Proyectos ".$year,$shtml,$cabeceras);
			}
			
                        
			
			
			header ( 'Location: index.php?er=7' );
		}
		else 
			header ( 'Location: index.php?er=2' );
		}	
		else 
			header ( 'Location: index.php?er=9' );
		}	
		else 
			header ( 'Location: index.php?er=8' );
		
		
	}
	
	else
		$oPDF_Evaluacion->Output();
} else
	header ( 'Location:../includes/accesodenegado.php' );

?>