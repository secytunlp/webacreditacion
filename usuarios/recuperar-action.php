<?
include '../includes/include.php';

	
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
	
	UsuarioQuery::getUsuarioPorDocumento($oUsuario);
	if ($oUsuario->getCd_usuario()){
		if (isset ( $_POST ['mail'] ))
			$oUsuario->setDs_mail (  ( $_POST ['mail'] ) );
		$nu_clave = FuncionesComunes::generar_clave(3);
		$ds_clave = substr($oUsuario->getDs_apynom(),0,3);
		$ds_password = $ds_clave.$nu_clave;
		$oUsuario->setDs_password($ds_password);
		UsuarioQuery::modificarUsuario($oUsuario);
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
		$shtml = $body_top. "<html><body><div style='padding-left: 30px; padding-right: 30px; padding-top: 30px ; padding-bottom: 30px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #666666; background-color:#FFFFFF'><img src=\"".WEB_PATH."img/image002.gif\" alt=\"Logo\" longdesc=\"Logo\"><br>PROYECTOS DE INVESTIGACION<hr style= 'color: #999999; text-decoration: none;'><p><strong>Por favor conserve este email. Los datos de su cuenta son los siguientes:<br>Apellido y Nombre</strong>: ".$oUsuario->getDs_apynom()."<br><strong>C.U.I.L.</strong>: ".$oUsuario->getNu_precuil().'-'.$oUsuario->getNu_documento().'-'.$oUsuario->getNu_postcuil()."<br><strong>E-mail</strong>: ".$oUsuario->getDs_mail()."<br><strong>Facultad</strong>: ".$oFacultad->getDs_facultad()."<br><strong>Password</strong>: ".$oUsuario->getDs_password()."</p><hr style= 'color: #999999; text-decoration: none;'></body></html>";
		$shtml .= "\n\n--Message-Boundary\n";
		if (!$test) {
			mail($oUsuario->getDs_mail(),"Recuperar password",$shtml,$cabeceras);
		}
		header ( 'Location: ../index.php?er=3');
	}
	else
		header ( 'Location: recuperar.php?er=1');