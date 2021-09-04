<?
include '../includes/include.php';
/*require '../includes/chequeo.php';
include '../includes/datosSession.php';*/

/*$categoriasPermitidas = array('I','II','III');
$ds_categoria = $_POST ['ds_categoria'];
if (in_array($ds_categoria, $categoriasPermitidas)) {*/
//if ($ds_categoria != 'V') {	
	$oUsuario = new Usuario ( );
	
	if (isset ( $_POST ['nu_precuil'] ))
		$oUsuario->setNu_precuil ( $_POST ['nu_precuil'] ); else
		$oUsuario->setNu_precuil ( '' );
	
	if (isset ( $_POST ['nu_documento'] ))
		$oUsuario->setNu_documento ( $_POST ['nu_documento'] ); else
		$oUsuario->setNu_documento ( '' );
		
	if (isset ( $_POST ['nu_postcuil'] ))
		$oUsuario->setNu_postcuil ( $_POST ['nu_postcuil'] ); else
		$oUsuario->setNu_postcuil ( '' );
	
	if (isset ( $_POST ['ds_apynom'] ))
		$oUsuario->setDs_apynom (  ( $_POST ['ds_apynom'] ) );
	
	if (isset ( $_POST ['ds_mail'] ))
		$oUsuario->setDs_mail (  ( $_POST ['ds_mail'] ) );
	
	if (isset ( $_POST ['ds_password'] ))
		$oUsuario->setDs_password (  ( $_POST ['ds_password'] ) );
	
	
		//$oUsuario->setCd_perfil (  ( 3) );
		
	if (isset ( $_POST ['cd_facultad'] ))
		$oUsuario->setCd_facultad (  ( $_POST ['cd_facultad'] ) );
	
	$oUsuario->setDt_alta(date('Y-m-d'));	
	$oUsuario->setBl_activo(1);
		
	$exito = UsuarioQuery::insertUsuario ( $oUsuario );
	if ($exito){
		$oUsuarioperfil = new Usuarioperfil();
		$oUsuarioperfil->setCd_perfil(3);
		$oUsuarioperfil->setCd_usuario($oUsuario->getCd_usuario());
		$exito = UsuarioperfilQuery::insertUsuarioperfil ( $oUsuarioperfil );
	}
	if ($exito){
		$oFuncion = new Funcion();
		$oFuncion -> setDs_funcion("Registro usuario");
		FuncionQuery::getFuncionPorDs($oFuncion);
		$oMovimiento = new Movimiento();
		$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
		$oMovimiento->setCd_usuario($oUsuario->getCd_usuario());
		$oMovimiento->setDs_movimiento('Usuario: '.$oUsuario->getDs_apynom());
		MovimientoQuery::insertarMovimiento($oMovimiento);
		$cabeceras="From: ".$nameFrom."<".$mailFrom.">\nReply-To: ".$mailFrom."\n";
		$cabeceras .="X-Mailer:PHP/".phpversion()."\n";
		$cabeceras .="Mime-Version: 1.0\n";
		$cabeceras .= "Content-type: multipart/mixed; ";
		$cabeceras .= "boundary=\"Message-Boundary\"\n";
		$cabeceras .= "Content-transfer-encoding: 7BIT\n";
		$body_top = "--Message-Boundary\n";
		$body_top .= "Content-type: text/html; charset=iso-8859-1\n";
		$body_top .= "Content-transfer-encoding: 7BIT\n";
		$body_top .= "Content-description: Mail message body\n\n";
		$oFacultad = new Facultad();
		$oFacultad->setCd_facultad($oUsuario->getCd_facultad());
		FacultadQuery::getFacultadPorid($oFacultad);
		$shtml = $body_top. "<html><body><div style='padding-left: 30px; padding-right: 30px; padding-top: 30px ; padding-bottom: 30px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #666666; background-color:#FFFFFF'><img src=\"".WEB_PATH."img/image002.gif\" alt=\"Logo\" longdesc=\"Logo\"><br>SISTEMA DE GESTION DE PROYECTOS<hr style= 'color: #999999; text-decoration: none;'><p><strong>Por favor conserve este email. Los datos de su cuenta son los siguientes:<br>Apellido y Nombre</strong>: ".$oUsuario->getDs_apynom()."<br><strong>C.U.I.L.</strong>: ".$oUsuario->getNu_precuil().'-'.$oUsuario->getNu_documento().'-'.$oUsuario->getNu_postcuil()."<br><strong>E-mail</strong>: ".$oUsuario->getDs_mail()."<br><strong>Facultad</strong>: ".$oFacultad->getDs_facultad()."<br><strong>Password</strong>: ".$oUsuario->getDs_password()."</p><hr style= 'color: #999999; text-decoration: none;'></body></html>";
		$shtml .= "\n\n--Message-Boundary\n";
		if (!$test) {
			mail($oUsuario->getDs_mail(),"Registro de usuarios",$shtml,$cabeceras);
		}
		header ( 'Location: ../index.php ' ); 
	}
		else
		header ( 'Location: registro.php?er=2' );

/*} else
	header ( 'Location: registro.php?er=3' );*/
	