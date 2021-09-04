<?
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Exportar datos" )) {
	
	$fdocente = fopen("../datos/docentes.csv", "w+") or die("Operation Failed!");
	$modificados = DocenteQuery::getModificados(1);
	$count = count ( $modificados );
	for($i = 0; $i < $count; $i ++) {	
		$nu_documento=($modificados [$i]['nu_documento'])?$modificados [$i]['nu_documento']:'0';
		
		$nu_nro=($modificados [$i]['nu_nro'])?$modificados [$i]['nu_nro']:'0';
		$nu_piso=($modificados [$i]['nu_piso'])?$modificados [$i]['nu_piso']:'0';
		$nu_dedinv=($modificados [$i]['nu_dedinv'])?$modificados [$i]['nu_dedinv']:'0';
		
		$linea = trim($modificados [$i]['ds_nombre']).'¬'.trim($modificados [$i]['ds_apellido']).'¬'.trim($modificados [$i]['nu_precuil']).'¬'.trim($nu_documento).'¬'.trim($modificados [$i]['nu_postcuil']).'¬'.FuncionesComunes::fechaMysqlaPHP(trim($modificados [$i]['dt_nacimiento'])).'¬'.trim($modificados [$i]['ds_sexo']).'¬'.trim($modificados [$i]['ds_calle']).'¬'.trim($nu_nro).'¬'.trim($nu_piso).'¬'.trim($modificados [$i]['ds_depto']).'¬'.trim($modificados [$i]['ds_localidad']).'¬'.trim($modificados [$i]['cd_provincia']).'¬'.trim($modificados [$i]['nu_cp']).'¬'.trim($modificados [$i]['nu_telefono']).'¬'.trim($modificados [$i]['ds_mail']).'¬'.trim($modificados [$i]['cd_categoria']).'¬'.trim($nu_dedinv).'¬'.trim($modificados [$i]['cd_carrerainv']).'¬'.trim($modificados [$i]['cd_organismo']).'¬'.trim($modificados [$i]['cd_facultad']).'¬'.trim($modificados [$i]['cd_cargo']).'¬'.trim($modificados [$i]['cd_deddoc']).'¬'.trim($modificados [$i]['cd_titulo']).'¬'.trim($modificados [$i][' ds_codigo']).'¬'.trim($modificados [$i]['ds_tipomodificacion']).'¬'.trim($modificados [$i]['cd_tipoinvestigador']).'¬'.trim($modificados [$i]['cd_universidad']).'¬'.trim($modificados [$i]['nu_ident']).'¬'.trim($modificados [$i]['ds_proyecto']);
		fputs($fdocente, $linea."\n");
		
	}
	fclose($fdocente);
	$fintegrantes = fopen("../datos/integrantes.csv", "w+") or die("Operation Failed!");
	$insertados = IntegranteQuery::getInsertados(1);
	$count = count ( $insertados );
	for($i = 0; $i < $count; $i ++) {		
		$linea = $insertados [$i]['cd_proyecto'].'¬'.$insertados [$i]['cd_docente'].'¬'.$insertados [$i]['nu_documento'].'¬'.$insertados [$i]['ds_codigo'].'¬'.FuncionesComunes::fechaMysqlaPHP($insertados [$i]['dt_alta']).'¬'.FuncionesComunes::fechaMysqlaPHP($insertados [$i]['dt_baja']).'¬'.trim($insertados [$i]['nu_horasinv']).'¬'.trim($insertados [$i]['cd_tipoinvestigador']);
		/*$oIntegrante = new Integrante();
		$oIntegrante->setCd_docente($insertados [$i]['cd_docente']);
		$oIntegrante->setCd_proyecto($insertados [$i]['cd_proyecto']);
		IntegranteQuery::getIntegrantePorId($oIntegrante);
		$oIntegrante->setBl_insertado(0);
		IntegranteQuery::modificarIntegrante($oIntegrante);**/
		fputs($fintegrantes, $linea."\n");
		
	}
	fclose($fintegrantes);
	
	$fproyectos = fopen("../datos/proyectos.csv", "w+") or die("Operation Failed!");
	$sustituye = array("\r\n", "\n\r", "\n", "\r","chr(10)","chr(13)");
	$acreditados = ProyectoQuery::getProyectosAcreditados(1);
	$count = count ( $acreditados );
	for($i = 0; $i < $count; $i ++) {		
		$linea = $acreditados [$i]['cd_proyecto'].'¬'.$acreditados [$i]['ds_codigo'].'¬'.$acreditados [$i]['ds_titulo'].'¬'.FuncionesComunes::fechaMysqlaPHP($acreditados [$i]['dt_ini']).'¬'.FuncionesComunes::fechaMysqlaPHP($acreditados [$i]['dt_fin']).'¬'.FuncionesComunes::fechaMysqlaPHP($acreditados [$i]['dt_inc']).'¬'.$acreditados [$i]['cd_facultad'].'¬'.$acreditados [$i]['cd_unidad'].'¬'.$acreditados [$i]['cd_campo'].'¬'.$acreditados [$i]['cd_especialidad'].'¬'.$acreditados [$i]['cd_disciplina'].'¬'.$acreditados [$i]['cd_entidad'].'¬'.$acreditados [$i]['ds_linea'].'¬'.$acreditados [$i]['ds_tipo'].'¬'.str_replace($sustituye, '<br>',$acreditados [$i]['ds_abstract1']).'¬'.$acreditados [$i]['ds_clave1'].'¬'.$acreditados [$i]['ds_clave2'].'¬'.$acreditados [$i]['ds_clave3'].'¬'.$acreditados [$i]['ds_clave4'].'¬'.$acreditados [$i]['ds_clave5'].'¬'.$acreditados [$i]['ds_clave6'].'¬'.$acreditados [$i]['ds_director'].'¬'.$acreditados [$i]['cd_docente'];
		     
		fputs($fproyectos, $linea."\n");
		
	}
	fclose($fproyectos);
	
	
	$fdocente = fopen("../datos/docentes_ppid.csv", "w+") or die("Operation Failed!");
	$modificados = DocenteQuery::getModificados(2);
	$count = count ( $modificados );
	for($i = 0; $i < $count; $i ++) {	
		$nu_documento=($modificados [$i]['nu_documento'])?$modificados [$i]['nu_documento']:'0';
		
		$nu_nro=($modificados [$i]['nu_nro'])?$modificados [$i]['nu_nro']:'0';
		$nu_piso=($modificados [$i]['nu_piso'])?$modificados [$i]['nu_piso']:'0';
		$nu_dedinv=($modificados [$i]['nu_dedinv'])?$modificados [$i]['nu_dedinv']:'0';
		
		$linea = $modificados [$i]['ds_nombre'].'¬'.$modificados [$i]['ds_apellido'].'¬'.$modificados [$i]['nu_precuil'].'¬'.$modificados [$i]['nu_documento'].'¬'.$modificados [$i]['nu_postcuil'].'¬'.FuncionesComunes::fechaMysqlaPHP($modificados [$i]['dt_nacimiento']).'¬'.$modificados [$i]['ds_sexo'].'¬'.$modificados [$i]['ds_calle'].'¬'.$nu_nro.'¬'.$nu_piso.'¬'.$modificados [$i]['ds_depto'].'¬'.$modificados [$i]['ds_localidad'].'¬'.$modificados [$i]['cd_provincia'].'¬'.$modificados [$i]['nu_cp'].'¬'.$modificados [$i]['nu_telefono'].'¬'.$modificados [$i]['ds_mail'].'¬'.$modificados [$i]['cd_categoria'].'¬'.$nu_dedinv.'¬'.$modificados [$i]['cd_carrerainv'].'¬'.$modificados [$i]['cd_organismo'].'¬'.$modificados [$i]['cd_facultad'].'¬'.$modificados [$i]['cd_cargo'].'¬'.$modificados [$i]['cd_deddoc'].'¬'.$modificados [$i]['cd_titulo'].'¬'.$modificados [$i]['cd_titulopost'].'¬'.$modificados [$i][' ds_codigo'].'¬'.$modificados [$i][' ds_tipomodificacion'];
		fputs($fdocente, $linea."\n");
		
	}
	fclose($fdocente);
	$fintegrantes = fopen("../datos/integrantes_ppid.csv", "w+") or die("Operation Failed!");
	$insertados = IntegranteQuery::getInsertados(2);
	$count = count ( $insertados );
	for($i = 0; $i < $count; $i ++) {		
		$linea = $insertados [$i]['cd_proyecto'].'¬'.$insertados [$i]['cd_docente'].'¬'.$insertados [$i]['nu_documento'].'¬'.$insertados [$i]['ds_codigo'].'¬'.FuncionesComunes::fechaMysqlaPHP($insertados [$i]['dt_alta']).'¬'.FuncionesComunes::fechaMysqlaPHP($insertados [$i]['dt_baja']).'¬'.trim($insertados [$i]['nu_horasinv']).'¬'.trim($insertados [$i]['cd_tipoinvestigador']);
		/*$oIntegrante = new Integrante();
		$oIntegrante->setCd_docente($insertados [$i]['cd_docente']);
		$oIntegrante->setCd_proyecto($insertados [$i]['cd_proyecto']);
		IntegranteQuery::getIntegrantePorId($oIntegrante);
		$oIntegrante->setBl_insertado(0);
		IntegranteQuery::modificarIntegrante($oIntegrante);**/
		fputs($fintegrantes, $linea."\n");
		
	}
	fclose($fintegrantes);
	
	$fproyectos = fopen("../datos/proyectos_ppid.csv", "w+") or die("Operation Failed!");
	$sustituye = array("\r\n", "\n\r", "\n", "\r","chr(10)","chr(13)");
	$acreditados = ProyectoQuery::getProyectosAcreditados(2);
	$count = count ( $acreditados );
	for($i = 0; $i < $count; $i ++) {		
		$linea = $acreditados [$i]['cd_proyecto'].'¬'.$acreditados [$i]['ds_codigo'].'¬'.$acreditados [$i]['ds_titulo'].'¬'.FuncionesComunes::fechaMysqlaPHP($acreditados [$i]['dt_ini']).'¬'.FuncionesComunes::fechaMysqlaPHP($acreditados [$i]['dt_fin']).'¬'.FuncionesComunes::fechaMysqlaPHP($acreditados [$i]['dt_inc']).'¬'.$acreditados [$i]['cd_facultad'].'¬'.$acreditados [$i]['cd_unidad'].'¬'.$acreditados [$i]['cd_campo'].'¬'.$acreditados [$i]['cd_especialidad'].'¬'.$acreditados [$i]['cd_disciplina'].'¬'.$acreditados [$i]['cd_entidad'].'¬'.$acreditados [$i]['ds_linea'].'¬'.$acreditados [$i]['ds_tipo'].'¬'.str_replace($sustituye, '<br>', $acreditados [$i]['ds_abstract1']).'¬'.$acreditados [$i]['ds_clave1'].'¬'.$acreditados [$i]['ds_clave2'].'¬'.$acreditados [$i]['ds_clave3'].'¬'.$acreditados [$i]['ds_clave4'].'¬'.$acreditados [$i]['ds_clave5'].'¬'.$acreditados [$i]['ds_clave6'].'¬'.$acreditados [$i]['ds_director'].'¬'.$acreditados [$i]['cd_docente'];
		     
		fputs($fproyectos, $linea."\n");
		
	}
	fclose($fproyectos);
	header ( 'Location: index.php?er=1' );
} else
	header ( 'Location:../includes/accesodenegado.php' );
	