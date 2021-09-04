<?
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

/*******************************************************
 * La variable er por GET indica el tipo de error por el
 * que se redireccionó al login
 *******************************************************/
$insertar = ($_SESSION ['insertar'])?$_SESSION ['insertar']:(($_GET['insertar'])?$_GET['insertar']:0);
$_SESSION ['insertar'] = $insertar;
$funcion = ($insertar)?"Alta proyecto":"Modificar proyecto";
if (PermisoQuery::permisosDeUsuario( $cd_usuario, $funcion )) {
	$ds_tipomodificacion='';
	$oProyecto = (isset ( $_SESSION ['proyecto'] ))?$_SESSION ['proyecto']:new Proyecto ( );
	$oIntegrante = (isset ( $_SESSION ['integrante'] ))?$_SESSION ['integrante']:new Integrante( );
	$oDocente =(isset ( $_SESSION ['docente'] ))?$_SESSION ['docente']:new Docente ( );
	$oUnidad =(isset ( $_SESSION ['unidad'] ))?$_SESSION ['unidad']:new Unidad ( );
	$facultades = (isset ( $_SESSION ['facultades'] ))?$_SESSION ['facultades']:array();
		
		
		
		
		
		
		if ($_GET['pagina']==7){
			$oProyecto->iniEvaluadores();
			$i=0;
			while ( ( $_POST ['cd_excusado'.($i+1)] )){
				
					$oProyecto->setEvaluadores( $_POST ['cd_excusado'.($i+1)], $i, 'cd_evaluador');
					$oProyecto->setEvaluadores( $_POST ['ds_excusado'.($i+1)], $i, 'ds_evaluador');
					
					$oProyecto->setEvaluadores( 1, $i, 'cd_tipoevaluador');
				
				$i++;
			}
			$j=$i;
			$i=0;
			while ( ( $_POST ['cd_recusado'.($i+1)] )){
				
					$oProyecto->setEvaluadores( $_POST ['cd_recusado'.($i+1)], $j, 'cd_evaluador');
					$oProyecto->setEvaluadores( $_POST ['ds_recusado'.($i+1)], $j, 'ds_evaluador');
					
					$oProyecto->setEvaluadores( 2, $j, 'cd_tipoevaluador');
				
				$i++;
				$j++;
			}
			//$j=$i;
			$i=0;
			while ( ( $_POST ['cd_sugerido'.($i+1)] )){
				
					$oProyecto->setEvaluadores( $_POST ['cd_sugerido'.($i+1)], $j, 'cd_evaluador');
					$oProyecto->setEvaluadores( $_POST ['ds_sugerido'.($i+1)], $j, 'ds_evaluador');
					
					$oProyecto->setEvaluadores( 3, $j, 'cd_tipoevaluador');
				
				$i++;
				$j++;
			}
			
		}
		
		
	$exito = ($insertar)?ProyectoQuery::insertarProyecto ( $oProyecto ):ProyectoQuery::modificarProyecto ( $oProyecto );
	
	
	if ($exito){
		if ($insertar){
			/*$oIntegrante = new Integrante();
			$oIntegrante->setCd_docente($oDocente->getCd_docente());*/
			$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
			$oIntegrante->setCd_tipoinvestigador(1);
			$oIntegrante->setDt_alta($oProyecto->getDt_ini());
			
			
			
		IntegranteQuery::insertarIntegrante($oIntegrante);
			
			
			
		}
		else IntegranteQuery::modificarIntegrante($oIntegrante);
		UnidadQuery::modificarUnidad($oUnidad);
		
		$oFacultadproyecto = new Facultadproyecto();
		$oFacultadproyecto->setCd_proyecto($oProyecto->getCd_proyecto());
		FacultadproyectoQuery::eliminarFacultadproyectoPorFacultad($oFacultadproyecto);
		
		$count = count ( $facultades );
		for($i = 0; $i < $count; $i ++) {
			$oFacultadproyecto->setCd_facultad($facultades[$i]);
			FacultadproyectoQuery::insertarFacultadproyecto($oFacultadproyecto);
		}
		
		//DocenteQuery::modificarDocente($oDocente);
		/*if ($_GET['pagina']==6){
			$oFondo = new Fondo();
			$oFondo->setCd_proyecto($oProyecto->getCd_proyecto());
			FondoQuery::eliminarFondoPorProyecto($oFondo);
			$fondos = $oProyecto->getFondos();
			$count = count ( $fondos );
			for($i = 0; $i < $count; $i ++) {
				$oFondo->setBl_tramite($fondos[$i]['bl_tramite']);
				$oFondo->setDs_fuente($fondos[$i]['ds_fuente']);
				$oFondo->setDs_resolucion($fondos[$i]['ds_resolucion']);
				$oFondo->setNu_monto($fondos[$i]['nu_monto']);
				if (($oFondo->getDs_fuente()!='')||($oFondo->getDs_resolucion()!='')||($oFondo->getNu_monto()!=''))
					FondoQuery::insertarFondo($oFondo);
			}
		}*/
		if ($_GET['pagina']==7){
			$oProyectoevaluador = new Proyectoevaluador();
			$oProyectoevaluador->setCd_proyecto($oProyecto->getCd_proyecto());
			ProyectoevaluadorQuery::eliminarProyectoevaluadorPorProyecto($oProyectoevaluador);
			$evaluadores = $oProyecto->getEvaluadores();
			$count = count ( $evaluadores );
			for($i = 0; $i < $count; $i ++) {
				$oProyectoevaluador->setCd_evaluador($evaluadores[$i]['cd_evaluador']);
				$oProyectoevaluador->setCd_tipoevaluador($evaluadores[$i]['cd_tipoevaluador']);
				
				if ($oProyectoevaluador->getCd_evaluador()!='')
					$exito = ProyectoevaluadorQuery::insertarProyectoevaluador($oProyectoevaluador);
					if (!$exito) {
										
						header ( 'Location: altaproyecto6.php?er=2' );
						exit;
					}
			}
		}
		$oFuncion = new Funcion();
		$oFuncion -> setDs_funcion($funcion);
		FuncionQuery::getFuncionPorDs($oFuncion);
		$oMovimiento = new Movimiento();
		$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
		$oMovimiento->setCd_usuario($cd_usuario);
		$oMovimiento->setDs_movimiento('Proyecto: '.$oProyecto->getDs_titulo());
		MovimientoQuery::insertarMovimiento($oMovimiento);
		$_SESSION['proyecto']=$oProyecto;
		$_SESSION['cd_proyecto']=$oProyecto->getCd_proyecto();
		$_SESSION['integrante']=$oIntegrante;
		$_SESSION['docente']=$oDocente;
		//header ( 'Location: altaproyecto2.php?cd_proyecto='.$cd_proyecto ); 
		
	}
		else{
		header ( 'Location: altaproyecto6.php?er=1' );
		exit;
		}
	
	
	$_SESSION ['insertar'] = 0;	
	switch ( $_GET['pagina']) {
			case '1' :
				header ( 'Location: altaproyecto1.php');
			break;
			case '2' :
				header ( 'Location: altaproyecto2.php');
			break;
			case '3' :
				header ( 'Location: altaproyecto3.php');
			break;
			case '4' :
				header ( 'Location: altaproyecto4.php');
			break;
			case '5' :
				header ( 'Location: altaproyecto5.php');
			break;
			case '6' :
				header ( 'Location: altaproyecto6.php');
			break;
			case '7' :
				$urlsiguiente = ($_SESSION ['insertando'])?'Location: ../integrantes/modificarintegrante.php?cd_proyecto='.$oProyecto->getCd_proyecto().'&cd_docente='.$oDocente->getCd_docente():'Location: index.php';	
				header ( $urlsiguiente);
			break;
	}
	
} else
	header ( 'Location:../includes/finsolicitud.php' );
	