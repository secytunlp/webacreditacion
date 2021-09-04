<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

$insertar = ($_SESSION ['insertar'])?$_SESSION ['insertar']:(($_GET['insertar'])?$_GET['insertar']:0);
$_SESSION ['insertar'] = $insertar;
$funcion = ($insertar)?"Alta proyecto":"Modificar proyecto";
if (PermisoQuery::permisosDeUsuario( $cd_usuario, $funcion )) {
	//include APP_PATH . 'includes/menu.php';
	$xtpl = new XTemplate ( 'altaproyecto2.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	
		
	$oProyecto = $_SESSION['proyecto'];
	if ($oProyecto->getCd_estado()==1) {
		
		$dir = APP_PATH.'js/imagenes/'.$_SESSION ["nu_yearSession"].'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dir .= $oProyecto->getCd_proyecto().'/';
		if (!file_exists($dir)) mkdir($dir, 0777);
		
		$oTipoacreditacion = new Tipoacreditacion();
		$oTipoacreditacion->setCd_tipoacreditacion($oProyecto->getCd_tipoacreditacion());
		TipoacreditacionQuery::getTipoacreditacionPorCd($oTipoacreditacion);
		$xtpl->assign ( 'cd_proyecto',  ( $oProyecto->getCd_proyecto () ) );
		
		$xtpl->assign ( 'ds_marco',  stripslashes( htmlspecialchars($oProyecto->getDs_marco() ) ));
		$xtpl->assign ( 'ds_aporte',  stripslashes( htmlspecialchars($oProyecto->getDs_aporte()) ));
		$xtpl->assign ( 'ds_objetivos',  stripslashes( htmlspecialchars($oProyecto->getDs_objetivos()) ) );
		$xtpl->assign ( 'ds_metodologia',  stripslashes( htmlspecialchars($oProyecto->getDs_metodologia()) ) );
		$xtpl->assign ( 'ds_metas',  stripslashes( htmlspecialchars($oProyecto->getDs_metas() ) ));
		$xtpl->assign ( 'ds_antecedentes',  stripslashes( htmlspecialchars($oProyecto->getDs_antecedentes()) ) );
			
			
		if (isset ( $_POST ['ds_avance'] ))
			$oProyecto->setDs_avance (  ( $_POST ['ds_avance'] ) );
		if (isset ( $_POST ['ds_formacion'] ))
			$oProyecto->setDs_formacion (  ( $_POST ['ds_formacion'] ) );
		if (isset ( $_POST ['ds_transferencia'] ))
			$oProyecto->setDs_transferencia (  ( $_POST ['ds_transferencia'] ) );
		if (isset ( $_POST ['ds_plan'] ))
			$oProyecto->setDs_plan (  ( $_POST ['ds_plan'] ) );
	
		$_SESSION['proyecto']=$oProyecto;	
			
			
		
		
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
		$xtpl->assign ( 'WEB_PATH', WEB_PATH );
		
		
		$xtpl->parse ( 'main' );
		$xtpl->out ( 'main' );
	}
	else 
		header('Location:../includes/accesodenegado.php');
}
else 
	header('Location:../includes/finsolicitud.php');
?>