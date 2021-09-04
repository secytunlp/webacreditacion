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
	
	$oProyecto = (isset ( $_SESSION ['proyecto'] ))?$_SESSION ['proyecto']:new Proyecto ( );
	$oUnidad = (isset ( $_SESSION ['unidad'] ))?$_SESSION ['unidad']:new Unidad ( );
	$facultades = (isset ( $_SESSION ['facultades'] ))?$_SESSION ['facultades']:array();
	
	if ( $_POST ['cd_proyecto'] ){
		$oProyecto->setCd_proyecto ( $_POST ['cd_proyecto'] );
		$insertar = 0;
	}
	else $insertar = 1;
	
	if (isset ( $_POST ['facultad1'] )){
		$oProyecto->setCd_facultad (  ( $_POST ['facultad1'] ) );
		$facultades[]=$_POST ['facultad1'];
		$i=2;
		while (isset ( $_POST ['facultad'.$i] )) {
			$facultades[]=$_POST ['facultad'.$i];
			$i++;
		}
	}
	
	
	if (isset ( $_POST ['ds_titulo'] ))
		$oProyecto->setDs_titulo ( $_POST ['ds_titulo'] ); else
		$oProyecto->setDs_titulo ( '' );
	
	if (isset ( $_POST ['ds_abstract'] ))
		$oProyecto->setDs_abstract1 ( $_POST ['ds_abstract'] ); else
		$oProyecto->setDs_abstract1 ( '' );
	
	if (isset ( $_POST ['ds_abstracteng'] ))
		$oProyecto->setDs_abstracteng ( $_POST ['ds_abstracteng'] ); else
		$oProyecto->setDs_abstracteng ( '' );
		
	if (isset ( $_POST ['ds_clave1'] ))
		$oProyecto->setDs_clave1 ( $_POST ['ds_clave1'] ); else
		$oProyecto->setDs_clave1 ( '' );

	if (isset ( $_POST ['ds_clave2'] ))
		$oProyecto->setDs_clave2 ( $_POST ['ds_clave2'] ); else
		$oProyecto->setDs_clave2 ( '' );
		
	if (isset ( $_POST ['ds_clave3'] ))
		$oProyecto->setDs_clave3 ( $_POST ['ds_clave3'] ); else
		$oProyecto->setDs_clave3 ( '' );
		
	if (isset ( $_POST ['ds_clave4'] ))
		$oProyecto->setDs_clave4 ( $_POST ['ds_clave4'] ); else
		$oProyecto->setDs_clave4 ( '' );
		
	if (isset ( $_POST ['ds_clave5'] ))
		$oProyecto->setDs_clave5 ( $_POST ['ds_clave5'] ); else
		$oProyecto->setDs_clave5 ( '' );
		
	if (isset ( $_POST ['ds_clave6'] ))
		$oProyecto->setDs_clave6 ( $_POST ['ds_clave6'] ); else
		$oProyecto->setDs_clave6 ( '' );
		
	if (isset ( $_POST ['ds_claveeng1'] ))
		$oProyecto->setDs_claveeng1 ( $_POST ['ds_claveeng1'] ); else
		$oProyecto->setDs_claveeng1 ( '' );

	if (isset ( $_POST ['ds_claveeng2'] ))
		$oProyecto->setDs_claveeng2 ( $_POST ['ds_claveeng2'] ); else
		$oProyecto->setDs_claveeng2 ( '' );
		
	if (isset ( $_POST ['ds_claveeng3'] ))
		$oProyecto->setDs_claveeng3 ( $_POST ['ds_claveeng3'] ); else
		$oProyecto->setDs_claveeng3 ( '' );
		
	if (isset ( $_POST ['ds_claveeng4'] ))
		$oProyecto->setDs_claveeng4 ( $_POST ['ds_claveeng4'] ); else
		$oProyecto->setDs_claveeng4 ( '' );
		
	if (isset ( $_POST ['ds_claveeng5'] ))
		$oProyecto->setDs_claveeng5 ( $_POST ['ds_claveeng5'] ); else
		$oProyecto->setDs_claveeng5 ( '' );
		
	if (isset ( $_POST ['ds_claveeng6'] ))
		$oProyecto->setDs_claveeng6 ( $_POST ['ds_claveeng6'] ); else
		$oProyecto->setDs_claveeng6 ( '' );	
	
	if (isset ( $_POST ['nu_duracion'] ))
		$oProyecto->setNu_duracion(  ( $_POST ['nu_duracion'] ) );	
		
	if (isset ( $_POST ['ds_tipo'] ))
		$oProyecto->setDs_tipo(  ( $_POST ['ds_tipo'] ) );
		
	if (isset ( $_POST ['cd_disciplina'] ))
		$oProyecto->setCd_disciplina(  ( $_POST ['cd_disciplina'] ) );
		
	if (isset ( $_POST ['cd_especialidad'] ))
		$oProyecto->setCd_especialidad(  ( $_POST ['cd_especialidad'] ) );
		
	if (isset ( $_POST ['cd_campo'] ))
		$oProyecto->setCd_campo(  ( $_POST ['cd_campo'] ) );
		
	if (isset ( $_POST ['ds_linea'] ))
		$oProyecto->setDs_linea ( $_POST ['ds_linea'] ); else
		$oProyecto->setDs_linea ( '' );	
		
	if (isset ( $_POST ['bl_transferencia'] ))
		$oProyecto->setBl_transferencia (  ( $_POST ['bl_transferencia'] ) );
		
	$year = $_SESSION ["nu_yearSession"];
	$mesDiaIni = ($oProyecto->getCd_tipoacreditacion()==1)?'-01-01':'-08-01';
	$mesDiaFin = ($oProyecto->getCd_tipoacreditacion()==1)?'-12-31':'-07-31';
	$oProyecto->setDt_ini($year.$mesDiaIni);
	$oProyecto->setDt_inc($year.$mesDiaIni);
	$yearFin = ($oProyecto->getCd_tipoacreditacion()==1)?$year:$year+1;
	$dt_fin = ($oProyecto->getNu_duracion()==2)?($yearFin+1).$mesDiaFin:($yearFin+3).$mesDiaFin;
	$oProyecto->setDt_fin($dt_fin);
	$oProyecto->setCd_estado(1);
	if (isset ( $_POST ['cd_unidad'] )){
		$oProyecto->setCd_unidad(  ( $_POST ['cd_unidad'] ) );
	
	}
	
	if (isset ( $_POST ['nu_nivelunidad'] )){
		$oProyecto->setNu_nivelunidad(  ( $_POST ['nu_nivelunidad'] ) );
		
	}
	
	
	$oUnidad->setCd_unidad($oProyecto->getCd_unidad());
	UnidadQuery::getUnidadPorId($oUnidad);
	if (isset ( $_POST ['ds_direccion'] ))
		$oUnidad->setDs_direccion (  ( $_POST ['ds_direccion'] ) );
	if (isset ( $_POST ['ds_telefono'] ))
		$oUnidad->setDs_telefono (  ( $_POST ['ds_telefono'] ) );
	if (isset ( $_POST ['ds_mail'] ))
		$oUnidad->setDs_mail(  ( $_POST ['ds_mail'] ) );
	
	$_SESSION['proyecto']=$oProyecto;
	$_SESSION['unidad']=$oUnidad;
	$_SESSION['facultades']=$facultades;
	
	header ( 'Location: altaproyecto6-action.php?pagina=2');
} else
	header ( 'Location:../includes/finsolicitud.php' );
	