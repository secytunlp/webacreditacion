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
	
		
		
		
		
		/*if (isset ( $_POST ['nu_horasinv'] ))
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
		
		//if ($_GET['pagina']==6){
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
		//}
		
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
		if (isset ( $_POST ['bl_notificacion'] ))
		$oProyecto->setBl_notificacion (  ( $_POST ['bl_notificacion'] ) );
	
	
	
	$_SESSION['proyecto']=$oProyecto;
	header ( 'Location: altaproyecto6-action.php?pagina=6');
	
	
} else
	header ( 'Location:../includes/finsolicitud.php' );
	