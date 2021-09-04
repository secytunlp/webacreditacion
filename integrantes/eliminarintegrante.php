<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

//verifico si tiene permiso para la acción
if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Baja integrante" )) {
	
	
	if ((isset ( $_GET ['cd_proyecto'] ))&&(isset ( $_GET ['cd_docente'] )))  {
		$oIntegrante = new Integrante();
		$oIntegrante->setCd_docente($_GET ['cd_docente']);
		$oIntegrante->setCd_proyecto($_GET ['cd_proyecto']);
		IntegranteQuery::getIntegrantePorId($oIntegrante);
		if ($oIntegrante->getDs_curriculum()){
			$dir = APP_PATH.'pdfs/'.$_SESSION ["nu_yearSession"].'/'.$oIntegrante->getCd_proyecto().'/'.$oIntegrante->getDs_curriculum();
			if (file_exists($dir)) unlink($dir);
		}
		$exito=IntegranteQuery::eliminarIntegrante($oIntegrante);
		if ($exito){
			
			$oFuncion = new Funcion();
			$oFuncion -> setDs_funcion("Baja integrante");
			FuncionQuery::getFuncionPorDs($oFuncion);
			$oMovimiento = new Movimiento();
			$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
			$oMovimiento->setCd_usuario($cd_usuario);
			$oMovimiento->setDs_movimiento('Proyecto: '.$oIntegrante->getCd_proyecto().' Docente: '.$oIntegrante->getCd_docente());
			MovimientoQuery::insertarMovimiento($oMovimiento);
			header ( 'Location: ../proyectos/verproyecto.php?id='.$oIntegrante->getCd_proyecto() ); 
		}else
			header ( 'Location:../proyectos/verproyecto.php?er=1&id='.$oIntegrante->getCd_proyecto() );
	}
} else {
	header ( 'Location:../includes/finsolicitud.php' );
}
?>