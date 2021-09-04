<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

//verifico si tiene permiso para la acción
if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Baja proyecto" )) {
	
	$oProyecto = new Proyecto();
	if (isset ( $_GET ['cd_proyecto'] )) {
		$cd_proyecto = $_GET ['cd_proyecto'];
		IntegranteQuery::eliminarIntegrantePorProyecto($cd_proyecto);
		$oProyecto->setCd_proyecto($cd_proyecto);
		
		$oFondo = new Fondo();
		$oFondo->setCd_proyecto($cd_proyecto);
		FondoQuery::eliminarFondoPorProyecto($oFondo);
		$oCronograma = new Cronograma();
		$oCronograma->setCd_proyecto($cd_proyecto);
		CronogramaQuery::eliminarCronogramaPorProyecto($oCronograma);
		$oFinanciamientoanterior = new Financiamientoanterior();
		$oFinanciamientoanterior->setCd_proyecto($cd_proyecto);
		FinanciamientoanteriorQuery::eliminarFinanciamientoanteriorPorProyecto($oFinanciamientoanterior);
		$oFinanciamientoitem = new Financiamientoitem();
		$oFinanciamientoitem->setCd_proyecto($cd_proyecto);
		FinanciamientoitemQuery::eliminarFinanciamientoitemPorProyecto($oFinanciamientoitem);
		$oFacultadproyecto = new Facultadproyecto();
		$oFacultadproyecto->setCd_proyecto($cd_proyecto);
		FacultadproyectoQuery::eliminarFacultadproyectoPorFacultad($oFacultadproyecto);
		
		$exito = ProyectoQuery::eliminarProyecto($oProyecto);
		$oFuncion = new Funcion();
		$oFuncion -> setDs_funcion("Baja proyecto");
		FuncionQuery::getFuncionPorDs($oFuncion);
		$oMovimiento = new Movimiento();
		$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
		$oMovimiento->setCd_usuario($cd_usuario);
		$oMovimiento->setDs_movimiento('Proyecto: '.$oProyecto->getCd_proyecto());
		MovimientoQuery::insertarMovimiento($oMovimiento);
		$dir = APP_PATH.'pdfs/'.$_SESSION ["nu_yearSession"].'/'.$oProyecto->getCd_proyecto().'/';
		if (file_exists($dir)){
			$handle=opendir($dir);
			
			while ($archivo = readdir($handle))
			{
		        if (is_file($dir.$archivo))
		         {
		         	unlink($dir.$archivo);
		         	
		         }
			}
			
			closedir($handle); 
			rmdir($dir);
		}
		if ($exito)
			header ( 'Location: index.php' ); else
			header ( 'Location:index.php?er=1' );
	}
} else {
	header ( 'Location:../includes/accesodenegado.php' );
}
?>