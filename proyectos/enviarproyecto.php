<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';
ini_set("memory_limit","400M");
set_time_limit(1200);
$enviar = (isset($_GET['enviar']))?1:0;
$funcion = ($enviar)?"Enviar proyecto":"Ver proyecto";
if (PermisoQuery::permisosDeUsuario( $cd_usuario, $funcion )) {
	$err=array();
	$item=0;
	$oProyecto = new Proyecto ( );
	$oProyecto->setCd_proyecto ($_GET ['cd_proyecto']);
	$dir = APP_PATH.'pdfs/'.$oProyecto->getCd_proyecto().'/';
	$path = WEB_PATH.'pdfs/'.$oProyecto->getCd_proyecto().'/';
	if (file_exists($dir)){
		if ($enviar){
			ProyectoQuery::getProyectoPorid ( $oProyecto );
			$oIntegrante = new Integrante();
			$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
			$oIntegrante->setCd_tipoinvestigador(1);	
			$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
			$countp = count ( $integrantes );
			for($j = 0; $j < $countp; $j ++) {
				$nu_horasinvdir = $integrantes [$j]['nu_horasinv'];
				$oDocente = new Docente ( );
				$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
				DocenteQuery::getDocentePorid ( $oDocente );
				$cd_deddir = $oDocente->getCd_deddoc();
				$cd_carrerainvdir = $oDocente->getCd_carrerainv();
				$nivel=$oDocente->getNu_nivelunidad();
				$ds_maildir = $oDocente->getDs_mail();
				$ds_director = $oDocente->getDs_nombre().' '.$oDocente->getDs_apellido();
				$oUnidad = new Unidad();
				$oUnidad->setCd_unidad($oDocente->getCd_unidad());
				
				while($nivel>0){
					UnidadQuery::getUnidadPorId($oUnidad);
					$oUnidad->setCd_unidad($oUnidad->getCd_padre());
					$nivel--;
				}
				UnidadQuery::getUnidadPorId($oUnidad);
				if ($oUnidad->getCd_unidad()!=1850){
					if (!in_array($oDocente->getDs_categoria(),$categoriasPermitidasEx)){
						$err[$item]='Director externo sin categoría I o II';
						$item++;
					}
					else{
						$oIntegrante = new Integrante();
						$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
						$oIntegrante->setCd_tipoinvestigador(2);	
						$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
						$countp = count ( $integrantes );
						$nu_horasinvcodir = array();
						$cd_dedcodir = array();
						$cd_carrerainvcodir = array();
						$cd_unidad0codir = array();
						$cd_facultadcodir = array();
						for($j = 0; $j < $countp; $j ++) {
							$nu_horasinvcodir[$j] = $integrantes [$j]['nu_horasinv'];
							$oDocente = new Docente ( );
							$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
							DocenteQuery::getDocentePorid ( $oDocente );
							$cd_deddir [$j]= $oDocente->getCd_deddoc();
							$cd_carrerainvcodir [$j]= $oDocente->getCd_carrerainv();
							$nivel=$oDocente->getNu_nivelunidad();
							$oUnidad = new Unidad();
							$oUnidad->setCd_unidad($oDocente->getCd_unidad());
							
							while($nivel>0){
								UnidadQuery::getUnidadPorId($oUnidad);
								$oUnidad->setCd_unidad($oUnidad->getCd_padre());
								if ($nivel==1){
									$cd_facultadcodir [$j]= $oUnidad->getCd_facultad();
								}
								$nivel--;
							}
							UnidadQuery::getUnidadPorId($oUnidad);	
							$cd_unidad0codir [$j]= $oUnidad->getCd_unidad();
									
						}
						$err[$item]='Director externo sin Codirector/es con lugar de trabajo en la Unidad Acad&eacute;mica que se presenta el proyecto';
						$item++;
						for($j = 0; $j < $countp; $j ++) {
							if ($cd_facultadcodir [$j] == $oProyecto->getCd_facultad()){
								$item--;
								break;
							}	
						}
											
					}
				}
				if (!in_array($cd_deddir, $mayordedicacion)){
					$err[$item]='Director y Codirector/es sin mayor dedicaci&oacute;n y lugar de trabajo en la U.N.L.P.';
					$item++;
					for($j = 0; $j < $countp; $j ++) {
						if ((in_array($cd_deddir [$j], $mayordedicacion))&&($cd_unidad0codir [$j]==1850)){
							$item--;
							break;
						}	
					}
				}
				if ($nu_horasinvdir<$minhsdircodir){
					$err[$item]='Director y Codirector/es con dedicaci&oacute;n menor a '.$minhsdircodir.' hs. semanales';
					$item++;
					for($j = 0; $j < $countp; $j ++) {
						if ($nu_horasinvcodir[$j]>=$minhsdircodir){
							$item--;
							break;
						}	
					}
				}
				$integrantes = IntegranteQuery::getIntegrantes( 'ds_investigador', 'ASC', '', 1, 25, $oProyecto->getCd_proyecto() );
				$countp = count ( $integrantes );
				$nu_horastotal=0;
				$nu_total=0;
				$nu_categorizados=0;
				$nu_mayordedicacion=0;
				for($j = 0; $j < $countp; $j ++) {
					$nu_total++;
					$nu_horastotal = $nu_horastotal+$integrantes [$j]['nu_horasinv'];
					$oDocente = new Docente ( );
					$oDocente->setCd_docente ( $integrantes [$j]['cd_docente']);
					DocenteQuery::getDocentePorid ( $oDocente );
					$nivel=$oDocente->getNu_nivelunidad();
					$oUnidad = new Unidad();
					$oUnidad->setCd_unidad($oDocente->getCd_unidad());
					while($nivel>0){
						UnidadQuery::getUnidadPorId($oUnidad);
						$oUnidad->setCd_unidad($oUnidad->getCd_padre());
						if ($nivel==1){
							$cd_facultad= $oUnidad->getCd_facultad();
						}
						$nivel--;
					}
					UnidadQuery::getUnidadPorId($oUnidad);	
					
					if ((in_array($oDocente->getDs_categoria(),$categorias))&&($oUnidad->getCd_unidad()==1850)) $nu_categorizados++;	
					if ((in_array($oDocente->getCd_deddoc(),$mayordedicacion))&&($oProyecto->getCd_facultad()==$cd_facultad)) $nu_mayordedicacion++;		
					
				}
				if ($nu_total<$minintegrantes){
					$err[$item]='Proyecto con menos de '.$minintegrantes.' integrantes';
					$item++;
				}
				if ($nu_categorizados<$mincategorizados){
					$err[$item]='Proyecto con menos de '.$mincategorizados.' integrantes categorizados con lugar de trabajo en la U.N.L.P.';
					$item++;
				}
				if ($nu_mayordedicacion<$minmayordedicacion){
					$err[$item]='Proyecto con menos de '.$minmayordedicacion.' integrantes con mayor dedicaci&oacute;n en la Unidad Acad&eacute;mica que se presenta el proyecto';
					$item++;
				}
				if ($nu_horastotal<$minhstotales){
					$err[$item]='La suma de dedicaciones horarias de los miembros es menor a '.$minhstotales.' hs. semanales';
					$item++;
				}
				
				
			}
		}	
		if (!$item){
			$altaHtml=file_get_contents('verproyectoPDF.php');
			$altaHtml='<? $cd_proyecto = '.$oProyecto->getCd_proyecto().';?>'.$altaHtml;
			
			ob_start();
			@eval("?" . ">$altaHtml");
			$altaHtml = ob_get_contents();
			ob_end_clean();
			
		
			/*require_once("../dompdf/dompdf_config.inc.php");
			$dompdf = new DOMPDF();
			$dompdf->set_paper('a4');
			$script = '<script type="text/php">
			if ( isset($pdf) ) {
			$font = Font_Metrics::get_font("verdana", "bold");
			$pdf->page_text(515, 815, "PÃ¡gina: {PAGE_NUM} de {PAGE_COUNT}", $font,
			6, array(0,0,0));
			$header = $pdf->open_object();
		   
		    $pdf->image("../img/secretaria.gif", "gif", 40,10, 500, 50);
		    $pdf->close_object();
		    $pdf->add_object($header, "all"); 
			
			
			}
			</script>';
			$altaHtml = str_replace('<body>', '<body>'.$script, $altaHtml);
			$altaHtml = str_replace('<table', '<div style="page-break-after: always;"><table', $altaHtml);
			$altaHtml = str_replace('</table>', '</table></div>', $altaHtml);
			$altaHtml = preg_replace('/<tbody>|<\/tbody>/', '', $altaHtml);
			$dompdf->load_html ($altaHtml);
			$dompdf->render ();*/
			
			
			$nombre_archivo = "Solicitud_".$oProyecto->getCd_proyecto(). ".rtf";
			//$pdf = $dompdf->output ();
							
							
		//	file_put_contents('../pdfs/'.$oProyecto->getCd_proyecto().'/'.$nombre_archivo, $pdf);
			/*copy(APP_PATH.'pdfs/header.htm', $dir.'header.htm');
			copy(APP_PATH.'pdfs/filelist.xml', $dir.'filelist.xml');
			copy(APP_PATH.'pdfs/image001.png', $dir.'image001.png');*/
			/*$xtpl = new XTemplate ( $dir.'header.htm' );
			$xtpl->assign ( 'ds_path', $path.$nombre_archivo );
			
			$xtpl->parse ( 'main' );*/
			
			$htmltodoc = new HTML_TO_DOC(); 
			$htmltodoc->createDoc(utf8_encode($altaHtml), $dir.$nombre_archivo);
			$salida = FuncionesComunes::rtf($dir.$nombre_archivo, $oProyecto->getCd_proyecto());
			if ($enviar){
				$oProyecto->setCd_estado(2);
				$exito = ProyectoQuery::modificarProyecto ( $oProyecto );
				$oFuncion = new Funcion();
				$oFuncion -> setDs_funcion($funcion);
				FuncionQuery::getFuncionPorDs($oFuncion);
				$oMovimiento = new Movimiento();
				$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
				$oMovimiento->setCd_usuario($cd_usuario);
				$oMovimiento->setDs_movimiento('Proyecto: '.$oProyecto->getDs_titulo());
				MovimientoQuery::insertarMovimiento($oMovimiento);
				$oUsuario = new Usuario();
				$oUsuario->setCd_usuario($cd_usuario);
				UsuarioQuery::getUsuarioPorId($oUsuario);
				$cabeceras="From: ".$ds_director."<".$oUsuario->getDs_mail().">\nReply-To: ".$oUsuario->getDs_mail()."\nReturn-path: ".$oUsuario->getDs_mail()."\n";
				$cabeceras .="BCC: ".$oUsuario->getDs_mail()."\n";
				if ($ds_maildir!=$oUsuario->getDs_mail())
					$cabeceras .="BCC: ".$ds_maildir."\n";
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
				        if (is_file($dir.$archivo))
				         {
				         	if (!in_array($archivo,$archivosNoEnv)){
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
				         	}
							//$adjuntos .= "--Message-Boundary--\n"; 
				         }
					}
				}
				
				closedir($handle);
				
				$shtml = $body_top."<html><body><div style='padding-left: 30px; padding-right: 30px; padding-top: 30px ; padding-bottom: 30px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #666666; background-color:#FFFFFF'><img src=\"".WEB_PATH."img/image002.gif\" alt=\"Logo\" longdesc=\"Logo\"><br>ACREDITACION DE PROYECTOS<hr style= 'color: #999999; text-decoration: none;'><p><strong>Solicitud de Acreditaci&oacute;n <br>Proyecto</strong>: ".$oProyecto->getCd_proyecto()."<br><strong>Título</strong>: ".$oProyecto->getDs_titulo()."<br><strong>Director</strong>: ".$oProyecto->getDs_director()."</p><hr style= 'color: #999999; text-decoration: none;'></body></html>";
				$shtml .= $adjuntos;
	
				
				if (!$test) {
					mail($mailReceptor,'Acreditación de Proyectos',$shtml,$cabeceras);
				}
				
				
			}
			else {
				
				header('Content-type: application/rtf');
				header('Content-Disposition: attachment; filename="'.$nombre_archivo.'"');
				readfile($dir.$nombre_archivo);
			}
			
			header ( 'Location:index.php');
		}
		else
			header ( 'Location:index.php?err='.FuncionesComunes::array_envia($err) );
	}
	else{
		$err[$item]='Proyecto anterior al 2010';
		header ( 'Location:index.php?err='.FuncionesComunes::array_envia($err) );	
	}	
} else
	header ( 'Location:../includes/finsolicitud.php' );
?>
