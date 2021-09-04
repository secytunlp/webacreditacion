<?
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Rechazar alta/baja" )) {
	
	$cd_proyecto = $_POST ['cd_proyecto'];
	$oProyecto = new Proyecto ( );
	$oProyecto->setCd_proyecto ( $cd_proyecto );
	ProyectoQuery::getProyectoPorId($oProyecto);
	
	$cd_docente = $_POST ['cd_docente'];
	$oDocente = new Docente ( );
	$oDocente->setCd_docente ( $cd_docente );
	DocenteQuery::getDocentePorId($oDocente);
	$oIntegrante = new Integrante();
	$oIntegrante->setCd_docente($cd_docente);
	$oIntegrante->setCd_proyecto($cd_proyecto);
	IntegranteQuery::getIntegrantePorId($oIntegrante);	
	$baja =(($oIntegrante->getDt_bajapendiente())&&($oIntegrante->getDt_bajapendiente()!='0000-00-00'))?1:0;
	$alta =(($oIntegrante->getDt_altapendiente())&&($oIntegrante->getDt_altapendiente()!='0000-00-00'))?1:0;
	$dt_bajapendiente = $oIntegrante->getDt_bajapendiente();
	$dt_altapendiente = $oIntegrante->getDt_altapendiente();
	$oIntegrante->setDt_bajapendiente ('0000-00-00');
	$oIntegrante->setDt_altapendiente ('0000-00-00');
	$exito = ($baja==1)?IntegranteQuery::modificarIntegrante ( $oIntegrante ):(($alta==1)?IntegranteQuery::eliminarIntegrante ( $oIntegrante ):false);	
	$oFuncion = new Funcion();
	$oFuncion -> setDs_funcion("Rechazar alta/baja");
	FuncionQuery::getFuncionPorDs($oFuncion);
	$oMovimiento = new Movimiento();
	$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
	$oMovimiento->setCd_usuario($cd_usuario);
	$fechaMovimiento = ($baja==1)?'Fecha de Baja: '.FuncionesComunes::fechaMysqlaPHP($dt_bajapendiente):(($alta==1)?'Fecha de Alta: '.FuncionesComunes::fechaMysqlaPHP($dt_altapendiente):'');
	$oMovimiento->setDs_movimiento('Docente: '.$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil().' - Proyecto: '.$oProyecto->getDs_codigo().' - '.$fechaMovimiento);
	$oMovimiento->setDs_consecuencia($_POST['ds_consecuencia']);
	MovimientoQuery::insertarMovimiento($oMovimiento);
	if ($exito){
		$altapendiente = (IntegranteQuery::tieneAltasPendientes($cd_proyecto))?1:0;
		$bajapendiente = (IntegranteQuery::tieneBajasPendientes($cd_proyecto))?1:0;
		$oProyecto->setBl_bajapendiente($bajapendiente);
		$oProyecto->setBl_altapendiente($altapendiente);
		$exito = ProyectoQuery::modificarProyecto ( $oProyecto );
		$ds_funcion = ($baja==1)?'Baja integrante':(($alta==1)?'Alta integrante':'');
		$oFuncion -> setDs_funcion($ds_funcion);
		FuncionQuery::getFuncionPorDs($oFuncion);
		$movimientos = MovimientoQuery::getMovimientosPorDs($oFuncion->getCd_funcion(), $oProyecto->getDs_codigo(), $oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil());
		$count = count ( $movimientos );
		for($i = 0; $i < $count; $i ++) {
			$oUsuario = new Usuario();
			$oUsuario->setCd_usuario($movimientos [$i]['cd_usuario']);
			UsuarioQuery::getUsuarioPorId($oUsuario);
			$body_top = "--Message-Boundary\n";
			$body_top .= "Content-type: text/html; charset=iso-8859-1\n";
			$body_top .= "Content-transfer-encoding: 7BIT\n";
			$body_top .= "Content-description: Mail message body\n\n";
			
			$shtml = $body_top. "Rechazo de ".$ds_funcion."<br>Proyecto: ".$oProyecto->getDs_codigo()."<br>Integrante: ".$oDocente->getDs_apellido().", ".$oDocente->getDs_nombre()." (".$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil().")<br>".$fechaMovimiento."<br>Motivos: ".nl2br($_POST['ds_consecuencia']);
			mail($oUsuario->getDs_mail(),"Rechazo de ".$ds_funcion,$shtml,'');
		}
		header ( 'Location: ../proyectos/verproyecto.php?id='.$oProyecto->getCd_proyecto() ); 
	}else
		header ( 'Location: confirmar.php?er=1&cd_proyecto=' . $oProyecto->getCd_proyecto().'&cd_docente='.$oDocente->getCd_docente() );
} else
	header ( 'Location:../includes/accesodenegado.php' );
	