<?
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Baja integrante" )) {
	
	
	$cd_docente = $_POST ['cd_docente'];
	$oDocente = new Docente ( );
	$oDocente->setCd_docente ( $cd_docente );
	DocenteQuery::getDocentePorId($oDocente);
	$oIntegrante = new Integrante();
	$oIntegrante->setCd_docente($oDocente->getCd_docente());
	$oIntegrante->setCd_proyecto($cd_proyecto);
	IntegranteQuery::getIntegrantePorId($oIntegrante);	
	$insertarInt=(($oIntegrante->getDt_baja())&&($oIntegrante->getDt_baja()!='0000-00-00'))?0:1;
	$cd_proyecto = $_POST ['cd_proyecto'];
	$oProyecto = new Proyecto ( );
	$oProyecto->setCd_proyecto ( $cd_proyecto );
	if (IntegranteQuery::masDeTresIntegrantes($cd_proyecto)){
		if ($insertarInt){
			
			ProyectoQuery::getProyectoPorId($oProyecto);
			if (isset ( $_POST ['cd_facultad'] ))
				$oProyecto->setCd_facultad ( $_POST ['cd_facultad'] );
			if (isset ( $_POST ['nu_duracion'] ))
				$oProyecto->setNu_duracion ( $_POST ['nu_duracion'] );
			$oProyecto->setBl_bajapendiente(1);
			$exito = ProyectoQuery::modificarProyecto ( $oProyecto );
			if (isset ( $_POST ['cd_facultadDoc'] ))
				$oDocente->setCd_facultad ( $_POST ['cd_facultadDoc'] );
			if (isset ( $_POST ['ds_apellido'] ))
				$oDocente->setDs_apellido ( $_POST ['ds_apellido'] );
			if (isset ( $_POST ['ds_nombre'] ))
				$oDocente->setDs_nombre ( $_POST ['ds_nombre'] );
			if (isset ( $_POST ['nu_precuil'] ))
				$oDocente->setNu_precuil ( $_POST ['nu_precuil'] );
			if (isset ( $_POST ['nu_documento'] ))
				$oDocente->setNu_documento ( $_POST ['nu_documento'] );
			if (isset ( $_POST ['nu_postcuil'] ))
				$oDocente->setNu_postcuil ( $_POST ['nu_postcuil'] );
			if (isset ( $_POST ['cd_categoria'] ))
				$oDocente->setCd_categoria ( $_POST ['cd_categoria'] );
			if (isset ( $_POST ['cd_cargo'] ))
				$oDocente->setCd_cargo ( $_POST ['cd_cargo'] );
			if (isset ( $_POST ['cd_deddoc'] ))
				$oDocente->setCd_deddoc ( $_POST ['cd_deddoc'] );
			if (isset ( $_POST ['cd_universidad'] ))
				$oDocente->setCd_universidad ( $_POST ['cd_universidad'] );
			$exito = DocenteQuery::modificarDocente ( $oDocente );	
			if ($exito){
				if (isset ( $_POST ['nu_horasinv'] ))
					$oIntegrante->setNu_horasinv ( $_POST ['nu_horasinv'] );
				if (isset ( $_POST ['dt_baja'] ))
					$oIntegrante->setDt_bajapendiente (FuncionesComunes::fechaPHPaMysql($_POST ['dt_baja'] ));
				$exito = IntegranteQuery::modificarIntegrante ( $oIntegrante );	
			}
			
			if ($exito){
				$oFuncion = new Funcion();
				$oFuncion -> setDs_funcion("Baja integrante");
				FuncionQuery::getFuncionPorDs($oFuncion);
				$oMovimiento = new Movimiento();
				$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
				$oMovimiento->setCd_usuario($cd_usuario);
				$oMovimiento->setDs_movimiento('Docente: '.$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil().' - Proyecto: '.$oProyecto->getDs_codigo().' - F. Baja: '.$_POST ['dt_baja'].' - F. Interesado: '.$_POST ['dt_interesado'].' - F. Director: '.$_POST ['dt_director'].' - Integrantes: '.$_POST ['radiointegrantes'].' - Dedicacion: '.$_POST ['radiodedicacion'].' - Pautas: '.$_POST ['radiopautas']);
				$oMovimiento->setDs_consecuencia($_POST ['ds_consecuencia']);
				MovimientoQuery::insertarMovimiento($oMovimiento);
				
				
				$bajaHtml=file_get_contents('bajaintegrantePDF.php');
				$bajaHtml='<? $dt_baja = "'.$_POST ['dt_baja'].'";$dt_interesado = "'.$_POST ['dt_interesado'].'";$dt_director = "'.$_POST ['dt_director'].'";$radiointegrantes = "'.$_POST ['radiointegrantes'].'";$radiodedicacion = "'.$_POST ['radiodedicacion'].'";$radiopautas = "'.$_POST ['radiopautas'].'";$cd_docente = '.$_POST ['cd_docente'].';$cd_proyecto = '.$_POST ['cd_proyecto'].';$ds_consecuencia = "'.$_POST ['ds_consecuencia'].'";?>'.$bajaHtml;
				
				ob_start();
				@eval("?" . ">$bajaHtml");
				$bajaHtml = ob_get_contents();
				ob_end_clean();
				
			
				require_once("../dompdf/dompdf_config.inc.php");
				$dompdf = new DOMPDF();
				$dompdf->set_paper('letter');
				
				$dompdf->load_html ($bajaHtml);
				$dompdf->render ();
				$codigoProyecto = str_replace('/','_',$oProyecto->getDs_codigo());
				$nombre_archivo = "baja_" .$codigoProyecto ."_".$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil()."_".date('YmdHis'). ".pdf";
				$pdf = $dompdf->output ();
								
								
				file_put_contents('../pdfs/'.$nombre_archivo, $pdf);
				$file = fopen('../pdfs/'.$nombre_archivo, "r");
				$contenido = fread($file, filesize('../pdfs/'.$nombre_archivo));
				$encoded_attach = chunk_split(base64_encode($contenido));
				fclose($file);
				$cabeceras .= "Content-type: multipart/mixed; ";
				$cabeceras .= "boundary=\"Message-Boundary\"\n";
				$cabeceras .= "Content-transfer-encoding: 7BIT\n";
				$cabeceras .= "X-attachments: ".$nombre_archivo;
				
				$body_top = "--Message-Boundary\n";
				$body_top .= "Content-type: text/html; charset=iso-8859-1\n";
				$body_top .= "Content-transfer-encoding: 7BIT\n";
				$body_top .= "Content-description: Mail message body\n\n";
				
				$shtml = $body_top."Baja de integrante<br>Proyecto: ".$oProyecto->getDs_codigo()."<br>Integrante: ".$oDocente->getDs_apellido().", ".$oDocente->getDs_nombre()." (".$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil().")<br>F. de Baja: ".$_POST ['dt_baja'];
				
				$shtml .= "\n\n--Message-Boundary\n";
				$shtml .= "Content-type: Binary; name=\"$nombre_archivo\"\n";
				$shtml .= "Content-Transfer-Encoding: BASE64\n";
				$shtml .= "Content-disposition: attachment; filename=\"$nombre_archivo\"\n\n";
				$shtml .= "$encoded_attach\n";
				$shtml .= "--Message-Boundary--\n"; 
				//mail($mailReceptor,'Baja de integrantes',$shtml,$cabeceras);
		header ( 'Location: ../proyectos/verproyecto.php?id='.$oProyecto->getCd_proyecto() ); 
			}else
				header ( 'Location: bajaintegrante.php?er=1&cd_proyecto=' . $oProyecto->getCd_proyecto().'&cd_docente='.$oDocente->getCd_docente() );
		}
		else
			header ( 'Location: bajaintegrante.php?er=2&cd_proyecto=' . $oProyecto->getCd_proyecto() .'&cd_docente='.$oDocente->getCd_docente() );
	}
	else
			header ( 'Location: bajaintegrante.php?er=3&cd_proyecto=' . $oProyecto->getCd_proyecto() .'&cd_docente='.$oDocente->getCd_docente() );
} else
	header ( 'Location:../includes/finsolicitud.php' );
	