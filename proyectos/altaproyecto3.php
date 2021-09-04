<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';


$insertar = ($_SESSION ['insertar'])?$_SESSION ['insertar']:(($_GET['insertar'])?$_GET['insertar']:0);
$_SESSION ['insertar'] = $insertar;
$funcion = ($insertar)?"Alta proyecto":"Modificar proyecto";
if (PermisoQuery::permisosDeUsuario( $cd_usuario, $funcion )) {
	//include APP_PATH . 'includes/menu.php';
	$xtpl = new XTemplate ( 'altaproyecto3.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	
		
		$oProyecto = $_SESSION['proyecto'];
		if ($oProyecto->getCd_estado()==1) {
			
			
			
			$xtpl->assign ( 'ds_avance',  stripslashes( htmlspecialchars($oProyecto->getDs_avance() )) );
			$xtpl->assign ( 'ds_formacion',  stripslashes( htmlspecialchars($oProyecto->getDs_formacion())) );
			$xtpl->assign ( 'ds_transferencia',  stripslashes( htmlspecialchars($oProyecto->getDs_transferencia()) ) );
			$xtpl->assign ( 'ds_plan',  stripslashes( htmlspecialchars($oProyecto->getDs_plan() )) );
			
			if (isset ( $_POST ['ds_cronograma'] ))
				$oProyecto->setDs_cronograma (  ( $_POST ['ds_cronograma'] ) );
			if (isset ( $_POST ['ds_disponible'] ))
				$oProyecto->setDs_disponible (  ( $_POST ['ds_disponible'] ) );
			if (isset ( $_POST ['ds_necesario'] ))
				$oProyecto->setDs_necesario (  ( $_POST ['ds_necesario'] ) );
			if (isset ( $_POST ['ds_fuentes'] ))
				$oProyecto->setDs_fuentes (  ( $_POST ['ds_fuentes'] ) );
			
		
			$_SESSION['proyecto']=$oProyecto;	
				
			
			
			
		
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