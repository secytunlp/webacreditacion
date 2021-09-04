<?
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

$acreditar = ($_POST['acreditar'])?1:0;

$funcion = ($acreditar)?"Rechazar acreditación":"Rechazar solicitud";

if (PermisoQuery::permisosDeUsuario( $cd_usuario, $funcion )) {
	$cd_estado = ($acreditar)?7:4;
	$cd_proyecto = $_POST ['cd_proyecto'];
	$oProyecto = new Proyecto ( );
	$oProyecto->setCd_proyecto ( $cd_proyecto );
	ProyectoQuery::getProyectoPorId($oProyecto);
	$oProyecto->setCd_estado($cd_estado);
	
	$exito = ProyectoQuery::modificarProyecto ( $oProyecto );	
	$oFuncion = new Funcion();
	$oFuncion -> setDs_funcion($funcion);
	FuncionQuery::getFuncionPorDs($oFuncion);
	$oMovimiento = new Movimiento();
	$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
	$oMovimiento->setCd_usuario($cd_usuario);
	$oMovimiento->setDs_movimiento($funcion.' Proyecto: '.$oProyecto->getDs_titulo());
	$oMovimiento->setDs_consecuencia($_POST['ds_consecuencia']);
	MovimientoQuery::insertarMovimiento($oMovimiento);
	if ($exito){
		$oIntegrante = new Integrante();
		$oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
		$oIntegrante->setCd_tipoinvestigador(1);
		$integrantes = IntegranteQuery::getIntegrantePorTipo($oIntegrante);
		$oDocente = new Docente ( );
		$oDocente->setCd_docente ( $integrantes [0]['cd_docente']);
		DocenteQuery::getDocentePorId($oDocente);
		$oUsuario = new Usuario();
		$oUsuario->setNu_documento($oDocente->getNu_documento());
		UsuarioQuery::getUsuarioPorDocumento($oUsuario);
		$cabeceras="From: ".$nameFrom."<".$mailFrom.">\nReply-To: ".$mailFrom."\n";
		if ($oDocente->getDs_mail()!=$oUsuario->getDs_mail())
			$cabeceras .="BCC: ".$oDocente->getDs_mail()."\n";
		$oUsuarioF = new Usuario();
		$oUsuarioF->setCd_facultad($oProyecto->getCd_facultad());
		$usuarios = UsuarioQuery::getUsuariosPorFac($oUsuarioF);
		$count = count ( $usuarios );
		for($i = 0; $i < $count; $i ++) {
			$cabeceras .="BCC: ".$usuarios [$i]['ds_mail']."\n";
		}
		$cabeceras .="X-Mailer:PHP/".phpversion()."\n";
		$cabeceras .="Mime-Version: 1.0\n";
		$cabeceras .= "Content-type: multipart/mixed; ";
		$cabeceras .= "boundary=\"Message-Boundary\"\n";
		$cabeceras .= "Content-transfer-encoding: 7BIT\n";
		$body_top = "--Message-Boundary\n";
		$body_top .= "Content-type: text/html; charset=iso-8859-1\n";
		$body_top .= "Content-transfer-encoding: 7BIT\n";
		$body_top .= "Content-description: Mail message body\n\n";
		$ds_subjet = ($acreditar)?'Rechazo de Acreditación':'Rechazo de Solicitud de Acreditación';
		$shtml = $body_top. "<html><body><div style='padding-left: 30px; padding-right: 30px; padding-top: 30px ; padding-bottom: 30px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #666666; background-color:#FFFFFF'><img src=\"".WEB_PATH."img/image002.gif\" alt=\"Logo\" longdesc=\"Logo\"><br>ACREDITACION DE PROYECTOS<hr style= 'color: #999999; text-decoration: none;'><p><strong>".$ds_subjet."<br>Proyecto</strong>: ".$oProyecto->getDs_titulo()."<br><strong>Director</strong>: ".$oProyecto->getDs_director()."<br>
    <strong>Motivos</strong>: ".htmlentities($_POST['ds_consecuencia'])."</p><hr style= 'color: #999999; text-decoration: none;'></body></html>";
		$shtml .= "\n\n--Message-Boundary\n";
		if (!$test) {
			mail($oUsuario->getDs_mail(),$ds_subjet,$shtml,$cabeceras);
		}
		
		header ( 'Location:index.php'); 
	}else
		header ( 'Location: rechazar.php?er=1&cd_proyecto=' . $oProyecto->getCd_proyecto() );
} else
	header ( 'Location:../includes/accesodenegado.php' );
	