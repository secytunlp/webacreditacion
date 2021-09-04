<?
include '../includes/include.php';
/*require '../includes/chequeo.php';
include '../includes/datosSession.php';


if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Alta usuario" )) {*/
	
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
	
	if (isset ( $_POST ['apynom'] ))
		$oUsuario->setDs_apynom (  ( $_POST ['apynom'] ) );
	
	if (isset ( $_POST ['mail'] ))
		$oUsuario->setDs_mail (  ( $_POST ['mail'] ) );
	
	if (isset ( $_POST ['pass'] ))
		$oUsuario->setDs_password (  ( $_POST ['pass'] ) );
	
	
		$oUsuario->setCd_perfil (  ( 3) );
		
	if (isset ( $_POST ['facultad'] ))
		$oUsuario->setCd_facultad (  ( $_POST ['facultad'] ) );
	
	$oDocente = new Docente();
	$oDocente->setNu_documento($oUsuario->getNu_documento());
	DocenteQuery::getDocentePorDocumento($oDocente);
	if ($oDocente->getCd_docente()){
		$xtpl = new XTemplate ( 'verregistro.html' );
		
		$oFacultad = new Facultad();
		$oFacultad->setCd_facultad($oDocente->getCd_facultad());
		FacultadQuery::getFacultadPorid($oFacultad);
		$classFacultad = ($oDocente->getCd_facultad()!=$oUsuario->getCd_facultad())?'Baja':0;
		$classPrecuil = ($oDocente->getNu_precuil()!=$oUsuario->getNu_precuil())?'Baja':0;
		$classPostcuil = ($oDocente->getNu_postcuil()!=$oUsuario->getNu_postcuil())?'Baja':0;
		$classDocumento = ($oDocente->getNu_documento()!=$oUsuario->getNu_documento())?'Baja':0;
		$error = (($classFacultad)||($classPrecuil)||($classPostcuil)||($classDocumento))?'Notar que los datos en <span class=\'Baja\'>rojo</span> son distintos a los del registro':'';
		$xtpl->assign ( 'ds_apynom',  ( $oUsuario->getDs_apynom () ) );
		$xtpl->assign ( 'ds_mail',  ( $oUsuario->getDs_mail () ) );
		$xtpl->assign ( 'nu_precuil',  ( $oUsuario->getNu_precuil() ) );
		$xtpl->assign ( 'nu_documento',  ( $oUsuario->getNu_documento() ) );
		$xtpl->assign ( 'nu_postcuil',  ( $oUsuario->getNu_postcuil() ) );
		$xtpl->assign ( 'ds_password', $oUsuario->getDs_password() );
		$xtpl->assign ( 'cd_facultad', $oUsuario->getCd_facultad() );
		$xtpl->assign ( 'ds_categoria', $oDocente->getDs_categoria() );
		$xtpl->assign ( 'ds_facultad', '<span class=\''.$classFacultad.'\'>'.$oFacultad->getDs_facultad().'</span>' );
		$xtpl->assign ( 'nu_cuil', '<span class=\''.$classPrecuil.'\'>'.$oDocente->getNu_precuil().'</span>'.'-'.'<span class=\''.$classDocumento.'\'>'.$oDocente->getNu_documento().'</span>'.'-'.'<span class=\''.$classPostcuil.'\'>'.$oDocente->getNu_postcuil().'</span>' );	
		
		
		if (isset ( $_GET ['er'] )) {
			if ($_GET ['er'] == 1) {
				$xtpl->assign ( 'classMsj', 'msjerror' );
				
				$msj = "Error: No se han modificado los datos de usuario";
				$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
			}
		} else {
			$xtpl->assign ( 'classMsj', '' );
			$xtpl->assign ( 'msj', '' );
		}
		$xtpl->parse ( 'main.msj' );
		
		$xtpl->assign ( 'titulo', 'SeCyT - Datos de registro' );
		$xtpl->assign ( 'comentario', 'Si sus datos son correctos presione enviar. '.$error );
		
		$xtpl->parse ( 'main' );
		$xtpl->out ( 'main' );
		
	}
	else
		header ( 'Location: registro.php?er=1');

/*} else
	header ( 'Location:../includes/accesodenegado.php' );*/
	


	