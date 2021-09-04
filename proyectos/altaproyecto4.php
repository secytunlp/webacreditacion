<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';


$insertar = ($_SESSION ['insertar'])?$_SESSION ['insertar']:(($_GET['insertar'])?$_GET['insertar']:0);
$_SESSION ['insertar'] = $insertar;
$funcion = ($insertar)?"Alta proyecto":"Modificar proyecto";
if (PermisoQuery::permisosDeUsuario( $cd_usuario, $funcion )) {
	//include APP_PATH . 'includes/menu.php';
	$xtpl = new XTemplate ( 'altaproyecto4.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	
		
		$oProyecto = $_SESSION['proyecto'];
		if ($oProyecto->getCd_estado()==1) {
				
			$oDocente =(isset ( $_SESSION ['docente'] ))?$_SESSION ['docente']:new Docente ( );
			$oIntegrante = (isset ( $_SESSION ['integrante'] ))?$_SESSION ['integrante']:new Integrante( );
			$grillasCronograma = '';
			$doGrillas = '';
			$divsRequeridos = '';
			for ($i = 1; $i <= $oProyecto->getNu_duracion(); $i++) {
				$grillasCronograma .= 'Año '.$i.'<div id="divGrid'.$i.'"></div><div id="buttonGrid"><input type="button" value="Insertar actividad" onclick="insertar(\''.$i.'\')"></div><div id="divGridRequerido'.$i.'" class="fValidator-msg"></div><br><br>';
				$doGrillas .= 'doGrid(\''.$i.'\');';
				$divsRequeridos .= 'if(($("#ds_actividad'.$i.'").val()===\'\')||(!$("#ds_actividad'.$i.'").val())){$( "#divGridRequerido'.$i.'" ).html(\'Ingrese al menos una actividad\');return false}else{$( "#divGridRequerido'.$i.'" ).html(\'\');}';
			}
			$xtpl->assign ( 'grillasCronograma',  $grillasCronograma);
			$xtpl->assign ( 'doGrillas',  $doGrillas);
			$xtpl->assign ( 'divsRequeridos',  $divsRequeridos);
			
			$xtpl->assign ( 'ds_cronograma',  stripslashes( htmlspecialchars($oProyecto->getDs_cronograma())) );
			$xtpl->assign ( 'ds_disponible',  stripslashes( htmlspecialchars($oProyecto->getDs_disponible()) ) );
			$xtpl->assign ( 'ds_necesario',  stripslashes( htmlspecialchars($oProyecto->getDs_necesario()) ));
			$xtpl->assign ( 'ds_fuentes',  stripslashes( htmlspecialchars($oProyecto->getDs_fuentes() ) ));
			
			/*if ($_FILES['ds_curriculum']['tmp_name']) {
			   
				
				
				//DocenteQuery::getDocentePorDocumento($oDocente);
				if ($oProyecto->getCd_proyecto()){
					$dir = APP_PATH.'pdfs/'.$_SESSION ["nu_yearSession"].'/';
					if (!file_exists($dir)) mkdir($dir, 0777); 
					$dir .= $oProyecto->getCd_proyecto().'/';
				
					if (is_file($dir.$oIntegrante->getDs_curriculum()))
			         {
			         	unlink($dir.$oIntegrante->getDs_curriculum());
			         }
					
					if (!file_exists($dir)) mkdir($dir, 0777); 
					
					$nuevo=$_FILES['ds_curriculum']['name'];
					$pos = strrpos($nuevo,'.');
					
					if ($pos)
						$extension=substr($nuevo, $pos, strlen($nuevo));
								
					$nuevo=$oDocente->getDs_apellido().$extension;
					
			        if (!move_uploaded_file($_FILES['ds_curriculum']['tmp_name'], $dir.$nuevo)){
						echo '<script> window.top.mensajeError(\'Error al Subir el Archivo '.$dir.$nuevo.'\');</script>';
			        exit;
			        }
					
			    	$oIntegrante->setDs_curriculumT($nuevo);
				}
			}
			if (isset ( $_POST ['nu_horasinv'] ))
				$oIntegrante->setNu_horasinv (  ( $_POST ['nu_horasinv'] ) );*/
			if (isset ( $_POST ['nu_ano1'] ))
				$oProyecto->setNu_ano1 (  ( $_POST ['nu_ano1'] ) );
			if (isset ( $_POST ['nu_ano2'] ))
				$oProyecto->setNu_ano2 (  ( $_POST ['nu_ano2'] ) );
			if (isset ( $_POST ['nu_ano3'] ))
				$oProyecto->setNu_ano3 (  ( $_POST ['nu_ano3'] ) );
			if (isset ( $_POST ['nu_ano4'] ))
				$oProyecto->setNu_ano4 (  ( $_POST ['nu_ano4'] ) );
			if (isset ( $_POST ['ds_factibilidad'] ))
				$oProyecto->setDs_factibilidad (  ( $_POST ['ds_factibilidad'] ) );
			if (isset ( $_POST ['ds_fondotramite'] ))
				$oProyecto->setDs_fondotramite (  ( $_POST ['ds_fondotramite'] ) );
			/*$oProyecto->iniFondos();
			$i=0;
			while (isset ( $_POST ['nu_monto'.$i] )){
				//if (($_POST ['nu_monto'.$i]!='')||($_POST ['ds_fuente'.$i]!='')||($_POST ['ds_resolucion'.$i]!='')){
					$oProyecto->setFondos( $_POST ['nu_monto'.$i], $i, 'nu_monto');
					$oProyecto->setFondos( $_POST ['ds_fuente'.$i], $i, 'ds_fuente');
					$oProyecto->setFondos( $_POST ['ds_resolucion'.$i], $i, 'ds_resolucion');
					$oProyecto->setFondos( 0, $i, 'bl_tramite');
				//}
				$i++;
			}
			$j=$i;
			$i=0;
			while (isset ( $_POST ['nu_montoT'.$i] )){
				//if (($_POST ['nu_montoT'.$i]!='')||($_POST ['ds_fuenteT'.$i]!='')){
					$oProyecto->setFondos( $_POST ['nu_montoT'.$i], $j, 'nu_monto');
					$oProyecto->setFondos( $_POST ['ds_fuenteT'.$i], $j, 'ds_fuente');
					$oProyecto->setFondos( '', $j, 'ds_resolucion');
					$oProyecto->setFondos( 1, $j, 'bl_tramite');
				//}
				$i++;
				$j++;
			}*/
			
			if (isset ( $_POST ['nu_consumo1'] ))
				$oProyecto->setNu_consumo1 (  ( $_POST ['nu_consumo1'] ) );
			if (isset ( $_POST ['nu_consumo2'] ))
				$oProyecto->setNu_consumo2 (  ( $_POST ['nu_consumo2'] ) );
			if (isset ( $_POST ['nu_consumo3'] ))
				$oProyecto->setNu_consumo3 (  ( $_POST ['nu_consumo3'] ) );
			if (isset ( $_POST ['nu_consumo4'] ))
				$oProyecto->setNu_consumo4 (  ( $_POST ['nu_consumo4'] ) );
			if (isset ( $_POST ['nu_servicios1'] ))
				$oProyecto->setNu_servicios1 (  ( $_POST ['nu_servicios1'] ) );
			if (isset ( $_POST ['nu_servicios2'] ))
				$oProyecto->setNu_servicios2 (  ( $_POST ['nu_servicios2'] ) );
			if (isset ( $_POST ['nu_servicios3'] ))
				$oProyecto->setNu_servicios3 (  ( $_POST ['nu_servicios3'] ) );
			if (isset ( $_POST ['nu_servicios4'] ))
				$oProyecto->setNu_servicios4 (  ( $_POST ['nu_servicios4'] ) );
			if (isset ( $_POST ['nu_bibliografia1'] ))
				$oProyecto->setNu_bibliografia1 (  ( $_POST ['nu_bibliografia1'] ) );
			if (isset ( $_POST ['nu_bibliografia2'] ))
				$oProyecto->setNu_bibliografia2 (  ( $_POST ['nu_bibliografia2'] ) );
			if (isset ( $_POST ['nu_bibliografia3'] ))
				$oProyecto->setNu_bibliografia3 (  ( $_POST ['nu_bibliografia3'] ) );
			if (isset ( $_POST ['nu_bibliografia4'] ))
				$oProyecto->setNu_bibliografia4 (  ( $_POST ['nu_bibliografia4'] ) );
			if (isset ( $_POST ['nu_cientifico1'] ))
				$oProyecto->setNu_cientifico1 (  ( $_POST ['nu_cientifico1'] ) );
			if (isset ( $_POST ['nu_cientifico2'] ))
				$oProyecto->setNu_cientifico2 (  ( $_POST ['nu_cientifico2'] ) );
			if (isset ( $_POST ['nu_cientifico3'] ))
				$oProyecto->setNu_cientifico3 (  ( $_POST ['nu_cientifico3'] ) );
			if (isset ( $_POST ['nu_cientifico4'] ))
				$oProyecto->setNu_cientifico4 (  ( $_POST ['nu_cientifico4'] ) );
			if (isset ( $_POST ['nu_computacion1'] ))
				$oProyecto->setNu_computacion1 (  ( $_POST ['nu_computacion1'] ) );
			if (isset ( $_POST ['nu_computacion2'] ))
				$oProyecto->setNu_computacion2 (  ( $_POST ['nu_computacion2'] ) );
			if (isset ( $_POST ['nu_computacion3'] ))
				$oProyecto->setNu_computacion3 (  ( $_POST ['nu_computacion3'] ) );
			if (isset ( $_POST ['nu_computacion4'] ))
				$oProyecto->setNu_computacion4 (  ( $_POST ['nu_computacion4'] ) );
			if (isset ( $_POST ['nu_otros1'] ))
				$oProyecto->setNu_otros1 (  ( $_POST ['nu_otros1'] ) );
			if (isset ( $_POST ['nu_otros2'] ))
				$oProyecto->setNu_otros2 (  ( $_POST ['nu_otros2'] ) );
			if (isset ( $_POST ['nu_otros3'] ))
				$oProyecto->setNu_otros3 (  ( $_POST ['nu_otros3'] ) );
			if (isset ( $_POST ['nu_otros4'] ))
				$oProyecto->setNu_otros4 (  ( $_POST ['nu_otros4'] ) );
			if (isset ( $_POST ['bl_publicar'] ))
				$oProyecto->setBl_publicar (  ( $_POST ['bl_publicar'] ) );
			/*$i=0;
			$ok=1;
			while ($ok){
				if ( $_POST ['cd_unidad'.$i] !=''){
					$oDocente->setCd_unidad (  ( $_POST ['cd_unidad'.$i] ) );
					$oDocente->setNu_nivelunidad($i);
				}
				else $ok=0;
				$i++;
					
			}*/
					
			$_SESSION['proyecto']=$oProyecto;	
			$_SESSION['integrante']=$oIntegrante;
			$_SESSION['docente']=$oDocente;
			
			
			
			
		
		
		$oTipoacreditacion = new Tipoacreditacion();
		$oTipoacreditacion->setCd_tipoacreditacion($oProyecto->getCd_tipoacreditacion());
		TipoacreditacionQuery::getTipoacreditacionPorCd($oTipoacreditacion);
		$titulo = ($_SESSION ['insertando'])?'SeCyT - Alta proyecto ':'SeCyT - Modificar proyecto ';
		$titulo .=$oTipoacreditacion->getDs_tipoacreditacion();
		if (isset ( $_GET ['er'] )) {
			if ($_GET ['er'] == 1) {
				$xtpl->assign ( 'classMsj', 'msjerror' );
				$msj = "Error: El proyecto no se ha dado de alta. Intente nuevamente";
				$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
			}
		} else {
			$xtpl->assign ( 'classMsj', '' );
			$xtpl->assign ( 'msj', '' );
		}
		$xtpl->parse ( 'main.msj' );
		
		$nuevaFecha = explode ( "-", $oProyecto->getDt_ini() );
		$year = $nuevaFecha [0];
		$jovenes = ($year<2014)?'j&oacute;venes investigadores':'investigadores en formaci&oacute;n';
		$ppid = ($oProyecto->getCd_tipoacreditacion()==2)?'<br>el objetivo de estos proyectos es fortalecer los antecedentes en direcci&oacute;n de proyectos de '.$jovenes.',  en el contexto de proyectos acreditados por la UNLP de los cuales formen parte':'';
		
		$xtpl->assign ( 'titulo', $titulo.$ppid );
		
		
		
		$xtpl->parse ( 'main' );
		$xtpl->out ( 'main' );
	}
	else 
		header('Location:../includes/accesodenegado.php');
}
else 
	header('Location:../includes/finsolicitud.php');
?>