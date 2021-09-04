<?php
class ProyectoQuery {

	function getProyectoPorId(Proyecto $obj) {
		$db = Db::conectar ();
		$cd_proyecto = $obj->getCd_proyecto ();
		$sql = "SELECT P.cd_proyecto, ds_titulo, P.ds_codigo, CONCAT(ds_apellido, ', ', ds_nombre) as ds_director, dt_ini, dt_fin, F.cd_facultad, F.ds_facultad, nu_duracion, P.cd_unidad, ds_unidad, P.nu_nivelunidad, P.cd_campo, ds_campo, C.ds_codigo AS ds_codigocampo, P.cd_especialidad, ds_especialidad, E.ds_codigo AS ds_codigoespecialidad, P.cd_disciplina, ds_disciplina, DI.ds_codigo AS ds_codigodisciplina, P.cd_entidad, ds_entidad, ds_linea, ds_tipo, bl_altapendiente, bl_bajapendiente, P.cd_estado, ds_estado, ds_abstract1, ds_abstract2, ds_abstracteng, ds_clave1, ds_clave2, ds_clave3, ds_clave4, ds_clave5, ds_clave6, ds_claveeng1, ds_claveeng2, ds_claveeng3, ds_claveeng4, ds_claveeng5, ds_claveeng6, bl_transferencia, ds_marco, ds_aporte, ds_objectivos, ds_metodologia, ds_metas, P.ds_antecedentes, ds_avance, ds_formacion, ds_transferencia, ds_plan, ds_disponible, ds_necesario, ds_fuentes, nu_ano1, nu_ano2, nu_ano3, nu_ano4, ds_factibilidad, nu_consumo1, nu_consumo2, nu_consumo3, nu_consumo4, nu_servicios1, nu_servicios2, nu_servicios3, nu_servicios4, nu_bibliografia1, nu_bibliografia2, nu_bibliografia3, nu_bibliografia4, nu_cientifico1, nu_cientifico2, nu_cientifico3, nu_cientifico4, nu_computacion1, nu_computacion2, nu_computacion3, nu_computacion4, nu_otros1, nu_otros2, nu_otros3, nu_otros4, ds_fondotramite, P.cd_tipoacreditacion, ds_tipoacreditacion, bl_publicar, bl_notificacion, ds_cronograma FROM proyecto P";
		$sql .= " LEFT JOIN estadoproyecto ES ON P.cd_estado = ES.cd_estado LEFT JOIN facultad F ON P.cd_facultad = F.cd_facultad LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto LEFT JOIN docente D ON I.cd_docente = D.cd_docente LEFT JOIN unidad U ON P.cd_unidad = U.cd_unidad LEFT JOIN campo C ON P.cd_campo = C.cd_campo LEFT JOIN especialidad E ON P.cd_especialidad = E.cd_especialidad LEFT JOIN disciplina DI ON P.cd_disciplina = DI.cd_disciplina LEFT JOIN entidad EN ON P.cd_entidad = EN.cd_entidad LEFT JOIN tipoacreditacion TA ON P.cd_tipoacreditacion = TA.cd_tipoacreditacion ";
		$sql .= " WHERE I.cd_tipoinvestigador = 1 AND P.cd_proyecto = $cd_proyecto";
		$result = $db->sql_query ( $sql );
		if ($db->sql_numrows () > 0) {
			$tc = $db->sql_fetchassoc ( $result );
			$obj->setCd_proyecto ( $tc ['cd_proyecto'] );
			$obj->setCd_facultad ( $tc ['cd_facultad'] );
			$obj->setDs_facultad ( $tc ['ds_facultad'] );
			$obj->setDs_codigo ( $tc ['ds_codigo'] );
			$obj->setDs_titulo ( $tc ['ds_titulo'] );
			$obj->setDt_fin ( $tc ['dt_fin'] );
			$obj->setDt_ini ( $tc ['dt_ini'] );
			$obj->setDs_director ( $tc ['ds_director'] );
			$obj->setNu_duracion( $tc ['nu_duracion'] );
			$obj->setCd_unidad( $tc ['cd_unidad'] );
			$obj->setDs_unidad( $tc ['ds_unidad'] );
			$obj->setNu_nivelunidad( $tc ['nu_nivelunidad'] );
			$obj->setCd_campo( $tc ['cd_campo'] );
			$obj->setDs_campo( $tc ['ds_campo'] );
			$obj->setDs_codigocampo( $tc ['ds_codigocampo'] );
			$obj->setCd_especialidad( $tc ['cd_especialidad'] );
			$obj->setDs_especialidad( $tc ['ds_especialidad'] );
			$obj->setDs_codigoespecialidad( $tc ['ds_codigoespecialidad'] );
			$obj->setCd_disciplina( $tc ['cd_disciplina'] );
			$obj->setDs_disciplina( $tc ['ds_disciplina'] );
			$obj->setDs_codigodisciplina( $tc ['ds_codigodisciplina'] );
			$obj->setCd_entidad( $tc ['cd_entidad'] );
			$obj->setDs_entidad( $tc ['ds_entidad'] );
			$obj->setDs_linea( $tc ['ds_linea'] );
			$obj->setDs_tipo( $tc ['ds_tipo'] );
			$obj->setBl_altapendiente( $tc ['bl_altapendiente'] );
			$obj->setBl_bajapendiente( $tc ['bl_bajapendiente'] );
			$obj->setCd_estado( $tc ['cd_estado'] );
			$obj->setDs_estado( $tc ['ds_estado'] );
			$obj->setDs_abstract1( $tc ['ds_abstract1'] );
			$obj->setDs_abstract2( $tc ['ds_abstract2'] );
			$obj->setDs_abstracteng( $tc ['ds_abstracteng'] );
			$obj->setDs_clave1( $tc ['ds_clave1'] );
			$obj->setDs_clave2( $tc ['ds_clave2'] );
			$obj->setDs_clave3( $tc ['ds_clave3'] );
			$obj->setDs_clave4( $tc ['ds_clave4'] );
			$obj->setDs_clave5( $tc ['ds_clave5'] );
			$obj->setDs_clave6( $tc ['ds_clave6'] );
			$obj->setDs_claveeng1( $tc ['ds_claveeng1'] );
			$obj->setDs_claveeng2( $tc ['ds_claveeng2'] );
			$obj->setDs_claveeng3( $tc ['ds_claveeng3'] );
			$obj->setDs_claveeng4( $tc ['ds_claveeng4'] );
			$obj->setDs_claveeng5( $tc ['ds_claveeng5'] );
			$obj->setDs_claveeng6( $tc ['ds_claveeng6'] );
			$obj->setBl_transferencia( $tc ['bl_transferencia'] );
			$obj->setDs_marco( $tc ['ds_marco'] );
			$obj->setBl_publicar( $tc ['bl_publicar'] );
			$obj->setBl_notificacion( $tc ['bl_notificacion'] );
			$obj->setDs_cronograma( $tc ['ds_cronograma'] );
			$obj->setDs_aporte( $tc ['ds_aporte'] );
			$obj->setDs_objetivos( $tc ['ds_objectivos'] );
			$obj->setDs_metodologia( $tc ['ds_metodologia'] );
			$obj->setDs_metas( $tc ['ds_metas'] );
			$obj->setDs_antecedentes( $tc ['ds_antecedentes'] );
			$obj->setDs_avance( $tc ['ds_avance'] );
			$obj->setDs_formacion( $tc ['ds_formacion'] );
			$obj->setDs_transferencia( $tc ['ds_transferencia'] );
			$obj->setDs_plan( $tc ['ds_plan'] );
			$obj->setDs_necesario( $tc ['ds_necesario'] );
			$obj->setDs_disponible( $tc ['ds_disponible'] );
			$obj->setDs_fuentes( $tc ['ds_fuentes'] );
			$obj->setNu_ano1( $tc ['nu_ano1'] );
			$obj->setNu_ano2( $tc ['nu_ano2'] );
			$obj->setNu_ano3( $tc ['nu_ano3'] );
			$obj->setNu_ano4( $tc ['nu_ano4'] );
			$obj->setDs_factibilidad( $tc ['ds_factibilidad'] );
			$obj->setNu_consumo1( $tc ['nu_consumo1'] );
			$obj->setNu_consumo2( $tc ['nu_consumo2'] );
			$obj->setNu_consumo3( $tc ['nu_consumo3'] );
			$obj->setNu_consumo4( $tc ['nu_consumo4'] );
			$obj->setNu_servicios1( $tc ['nu_servicios1'] );
			$obj->setNu_servicios2( $tc ['nu_servicios2'] );
			$obj->setNu_servicios3( $tc ['nu_servicios3'] );
			$obj->setNu_servicios4( $tc ['nu_servicios4'] );
			$obj->setNu_bibliografia1( $tc ['nu_bibliografia1'] );
			$obj->setNu_bibliografia2( $tc ['nu_bibliografia2'] );
			$obj->setNu_bibliografia3( $tc ['nu_bibliografia3'] );
			$obj->setNu_bibliografia4( $tc ['nu_bibliografia4'] );
			$obj->setNu_cientifico1( $tc ['nu_cientifico1'] );
			$obj->setNu_cientifico2( $tc ['nu_cientifico2'] );
			$obj->setNu_cientifico3( $tc ['nu_cientifico3'] );
			$obj->setNu_cientifico4( $tc ['nu_cientifico4'] );
			$obj->setNu_computacion1( $tc ['nu_computacion1'] );
			$obj->setNu_computacion2( $tc ['nu_computacion2'] );
			$obj->setNu_computacion3( $tc ['nu_computacion3'] );
			$obj->setNu_computacion4( $tc ['nu_computacion4'] );
			$obj->setNu_otros1( $tc ['nu_otros1'] );
			$obj->setNu_otros2( $tc ['nu_otros2'] );
			$obj->setNu_otros3( $tc ['nu_otros3'] );
			$obj->setNu_otros4( $tc ['nu_otros4'] );
			$obj->setDs_fondotramite( $tc ['ds_fondotramite'] );
			$obj->setDs_tipoacreditacion( $tc ['ds_tipoacreditacion'] );
			$obj->setCd_tipoacreditacion( $tc ['cd_tipoacreditacion'] );
		}
		$db->sql_close;
		return ($result);
	}

	function getProyectoPorCodigo(Proyecto $obj) {
		$db = Db::conectar ();
		$ds_codigo = $obj->getDs_codigo();
		$sql = "SELECT P.cd_proyecto, ds_titulo, P.ds_codigo, CONCAT(ds_apellido, ', ', ds_nombre) as ds_director, dt_ini, dt_fin, F.cd_facultad, F.ds_facultad, nu_duracion, P.cd_unidad, ds_unidad, P.nu_nivelunidad, P.cd_campo, ds_campo, C.ds_codigo AS ds_codigocampo, P.cd_especialidad, ds_especialidad, E.ds_codigo AS ds_codigoespecialidad, P.cd_disciplina, ds_disciplina, DI.ds_codigo AS ds_codigodisciplina, P.cd_entidad, ds_entidad, ds_linea, ds_tipo, bl_altapendiente, bl_bajapendiente, P.cd_estado, ds_estado, ds_abstract1, ds_abstract2, ds_abstracteng, ds_clave1, ds_clave2, ds_clave3, ds_clave4, ds_clave5, ds_clave6, ds_claveeng1, ds_claveeng2, ds_claveeng3, ds_claveeng4, ds_claveeng5, ds_claveeng6, bl_transferencia, ds_marco, ds_aporte, ds_objectivos, ds_metodologia, ds_metas, P.ds_antecedentes, ds_avance, ds_formacion, ds_transferencia, ds_plan, ds_disponible, ds_necesario, ds_fuentes, nu_ano1, nu_ano2, nu_ano3, nu_ano4, ds_factibilidad, nu_consumo1, nu_consumo2, nu_consumo3, nu_consumo4, nu_servicios1, nu_servicios2, nu_servicios3, nu_servicios4, nu_bibliografia1, nu_bibliografia2, nu_bibliografia3, nu_bibliografia4, nu_cientifico1, nu_cientifico2, nu_cientifico3, nu_cientifico4, nu_computacion1, nu_computacion2, nu_computacion3, nu_computacion4, nu_otros1, nu_otros2, nu_otros3, nu_otros4, ds_fondotramite, P.cd_tipoacreditacion, ds_tipoacreditacion, bl_publicar, bl_notificacion, ds_cronograma FROM proyecto P";
		$sql .= " LEFT JOIN estadoproyecto ES ON P.cd_estado = ES.cd_estado LEFT JOIN facultad F ON P.cd_facultad = F.cd_facultad LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto LEFT JOIN docente D ON I.cd_docente = D.cd_docente LEFT JOIN unidad U ON P.cd_unidad = U.cd_unidad LEFT JOIN campo C ON P.cd_campo = C.cd_campo LEFT JOIN especialidad E ON P.cd_especialidad = E.cd_especialidad LEFT JOIN disciplina DI ON P.cd_disciplina = DI.cd_disciplina LEFT JOIN entidad EN ON P.cd_entidad = EN.cd_entidad LEFT JOIN tipoacreditacion TA ON P.cd_tipoacreditacion = TA.cd_tipoacreditacion ";
		$sql .= " WHERE P.ds_codigo = '$ds_codigo'";
		$result = $db->sql_query ( $sql );
		if ($db->sql_numrows () > 0) {
			$tc = $db->sql_fetchassoc ( $result );
			$obj->setCd_proyecto ( $tc ['cd_proyecto'] );
			$obj->setCd_facultad ( $tc ['cd_facultad'] );
			$obj->setDs_facultad ( $tc ['ds_facultad'] );
			$obj->setDs_codigo ( $tc ['ds_codigo'] );
			$obj->setDs_titulo ( $tc ['ds_titulo'] );
			$obj->setDt_fin ( $tc ['dt_fin'] );
			$obj->setDt_ini ( $tc ['dt_ini'] );
			$obj->setDs_director ( $tc ['ds_director'] );
			$obj->setNu_duracion( $tc ['nu_duracion'] );
			$obj->setCd_unidad( $tc ['cd_unidad'] );
			$obj->setDs_unidad( $tc ['ds_unidad'] );
			$obj->setNu_nivelunidad( $tc ['nu_nivelunidad'] );
			$obj->setCd_campo( $tc ['cd_campo'] );
			$obj->setDs_campo( $tc ['ds_campo'] );
			$obj->setDs_codigocampo( $tc ['ds_codigocampo'] );
			$obj->setCd_especialidad( $tc ['cd_especialidad'] );
			$obj->setDs_especialidad( $tc ['ds_especialidad'] );
			$obj->setDs_codigoespecialidad( $tc ['ds_codigoespecialidad'] );
			$obj->setCd_disciplina( $tc ['cd_disciplina'] );
			$obj->setDs_disciplina( $tc ['ds_disciplina'] );
			$obj->setDs_codigodisciplina( $tc ['ds_codigodisciplina'] );
			$obj->setCd_entidad( $tc ['cd_entidad'] );
			$obj->setDs_entidad( $tc ['ds_entidad'] );
			$obj->setDs_linea( $tc ['ds_linea'] );
			$obj->setDs_tipo( $tc ['ds_tipo'] );
			$obj->setBl_altapendiente( $tc ['bl_altapendiente'] );
			$obj->setBl_bajapendiente( $tc ['bl_bajapendiente'] );
			$obj->setCd_estado( $tc ['cd_estado'] );
			$obj->setDs_estado( $tc ['ds_estado'] );
			$obj->setDs_abstract1( $tc ['ds_abstract1'] );
			$obj->setDs_abstract2( $tc ['ds_abstract2'] );
			$obj->setDs_abstracteng( $tc ['ds_abstracteng'] );
			$obj->setDs_clave1( $tc ['ds_clave1'] );
			$obj->setDs_clave2( $tc ['ds_clave2'] );
			$obj->setDs_clave3( $tc ['ds_clave3'] );
			$obj->setDs_clave4( $tc ['ds_clave4'] );
			$obj->setDs_clave5( $tc ['ds_clave5'] );
			$obj->setDs_clave6( $tc ['ds_clave6'] );
			$obj->setDs_claveeng1( $tc ['ds_claveeng1'] );
			$obj->setDs_claveeng2( $tc ['ds_claveeng2'] );
			$obj->setDs_claveeng3( $tc ['ds_claveeng3'] );
			$obj->setDs_claveeng4( $tc ['ds_claveeng4'] );
			$obj->setDs_claveeng5( $tc ['ds_claveeng5'] );
			$obj->setDs_claveeng6( $tc ['ds_claveeng6'] );
			$obj->setBl_transferencia( $tc ['bl_transferencia'] );
			$obj->setDs_marco( $tc ['ds_marco'] );
			$obj->setBl_publicar( $tc ['bl_publicar'] );
			$obj->setBl_notificacion( $tc ['bl_notificacion'] );
			$obj->setDs_cronograma( $tc ['ds_cronograma'] );
			$obj->setDs_aporte( $tc ['ds_aporte'] );
			$obj->setDs_objetivos( $tc ['ds_objectivos'] );
			$obj->setDs_metodologia( $tc ['ds_metodologia'] );
			$obj->setDs_metas( $tc ['ds_metas'] );
			$obj->setDs_antecedentes( $tc ['ds_antecedentes'] );
			$obj->setDs_avance( $tc ['ds_avance'] );
			$obj->setDs_formacion( $tc ['ds_formacion'] );
			$obj->setDs_transferencia( $tc ['ds_transferencia'] );
			$obj->setDs_plan( $tc ['ds_plan'] );
			$obj->setDs_necesario( $tc ['ds_necesario'] );
			$obj->setDs_disponible( $tc ['ds_disponible'] );
			$obj->setDs_fuentes( $tc ['ds_fuentes'] );
			$obj->setNu_ano1( $tc ['nu_ano1'] );
			$obj->setNu_ano2( $tc ['nu_ano2'] );
			$obj->setNu_ano3( $tc ['nu_ano3'] );
			$obj->setNu_ano4( $tc ['nu_ano4'] );
			$obj->setDs_factibilidad( $tc ['ds_factibilidad'] );
			$obj->setNu_consumo1( $tc ['nu_consumo1'] );
			$obj->setNu_consumo2( $tc ['nu_consumo2'] );
			$obj->setNu_consumo3( $tc ['nu_consumo3'] );
			$obj->setNu_consumo4( $tc ['nu_consumo4'] );
			$obj->setNu_servicios1( $tc ['nu_servicios1'] );
			$obj->setNu_servicios2( $tc ['nu_servicios2'] );
			$obj->setNu_servicios3( $tc ['nu_servicios3'] );
			$obj->setNu_servicios4( $tc ['nu_servicios4'] );
			$obj->setNu_bibliografia1( $tc ['nu_bibliografia1'] );
			$obj->setNu_bibliografia2( $tc ['nu_bibliografia2'] );
			$obj->setNu_bibliografia3( $tc ['nu_bibliografia3'] );
			$obj->setNu_bibliografia4( $tc ['nu_bibliografia4'] );
			$obj->setNu_cientifico1( $tc ['nu_cientifico1'] );
			$obj->setNu_cientifico2( $tc ['nu_cientifico2'] );
			$obj->setNu_cientifico3( $tc ['nu_cientifico3'] );
			$obj->setNu_cientifico4( $tc ['nu_cientifico4'] );
			$obj->setNu_computacion1( $tc ['nu_computacion1'] );
			$obj->setNu_computacion2( $tc ['nu_computacion2'] );
			$obj->setNu_computacion3( $tc ['nu_computacion3'] );
			$obj->setNu_computacion4( $tc ['nu_computacion4'] );
			$obj->setNu_otros1( $tc ['nu_otros1'] );
			$obj->setNu_otros2( $tc ['nu_otros2'] );
			$obj->setNu_otros3( $tc ['nu_otros3'] );
			$obj->setNu_otros4( $tc ['nu_otros4'] );
			$obj->setDs_fondotramite( $tc ['ds_fondotramite'] );
			$obj->setDs_tipoacreditacion( $tc ['ds_tipoacreditacion'] );
			$obj->setCd_tipoacreditacion( $tc ['cd_tipoacreditacion'] );
		}
		$db->sql_close;
		return ($result);
	}



	function getProyectos($attr, $orden, $filtro, $filtroFacultad, $filtroEstado, $filtroDir, $page, $row_per_page, $cd_usuario, $pendientes, $actual, $filtroTipoAcreditacion){

		$limitInf = (($page - 1) * $row_per_page);
		$limitSup = ($page * $row_per_page);
		$sql = "SELECT P.cd_proyecto, ds_titulo, ds_codigo, CONCAT(ds_apellido, ', ', ds_nombre) as ds_director, dt_ini, dt_fin, bl_bajapendiente, bl_altapendiente, P.cd_estado, ds_estado, F.ds_facultad, ds_tipoacreditacion FROM proyecto P";
		$sql .= " LEFT JOIN estadoproyecto ES ON P.cd_estado = ES.cd_estado LEFT JOIN facultad F ON P.cd_facultad = F.cd_facultad LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto LEFT JOIN docente D ON I.cd_docente = D.cd_docente LEFT JOIN tipoacreditacion TA ON P.cd_tipoacreditacion = TA.cd_tipoacreditacion ";
		$sql .= (PermisoQuery::permisosDeUsuario( $cd_usuario, "Proyectos propios" ))?' LEFT JOIN usuarioproyecto U ON U.nu_documento = D.nu_documento':'';
		$sql .= (PermisoQuery::permisosDeUsuario( $cd_usuario, "Evaluar proyecto" ))?' LEFT JOIN evaluacionproyecto ON P.cd_proyecto = evaluacionproyecto.cd_proyecto':'';
		$year = ($pendientes)?$_SESSION ["nu_yearSession"]-1:$_SESSION ["nu_yearSession"];
		$sql .= " WHERE I.cd_tipoinvestigador = 1 AND P.cd_tipoacreditacion <> '3' AND ds_codigo LIKE '%$filtro%' AND dt_fin > '".($year)."-05-01'";
		if (($filtroFacultad != 0)) {
			$sql .= " AND F.cd_facultad='$filtroFacultad'";
		}
		if (($filtroEstado != 0)) {
			$sql .= " AND P.cd_estado='$filtroEstado'";
		}
		if (($filtroDir != '')) {
			$sql .= " AND CONCAT(ds_apellido, ', ', ds_nombre) LIKE '%$filtroDir%'";
		}
		$sql .=(PermisoQuery::permisosDeUsuario( $cd_usuario, "Todos los proyectos" ))?'':((PermisoQuery::permisosDeUsuario( $cd_usuario, "Proyectos propios" ))?' AND U.cd_usuario = '.$cd_usuario:((PermisoQuery::permisosDeUsuario( $cd_usuario, "Evaluar proyecto" ))?' AND evaluacionproyecto.cd_usuario = '.$cd_usuario:' AND F.cd_facultad = '.$_SESSION ["cd_facultadSession"]));

		/*if ($pendientes) {
			$sql .= " AND ((P.cd_estado=1) OR (P.cd_estado=2))";
			}*/
		if (($actual)||($pendientes)) {
			$sql .= " AND (dt_ini = '".($year)."-01-01' OR dt_ini = '".($year)."-08-01' OR dt_ini = '".($year)."-10-01')";
		}
		if (($filtroTipoAcreditacion != 0)) {
			$sql .= " AND P.cd_tipoacreditacion='$filtroTipoAcreditacion'";
		}
		$sql .= " ORDER BY $attr $orden, P.cd_proyecto LIMIT $limitInf,$row_per_page";

		$db = Db::conectar ();
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		$cd_proyectoAnt = '';
		$facultades = '';
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				/*if ($cd_proyectoAnt == $usr ['cd_proyecto']) {
					$res [$i-1]['ds_facultad'] .= ' - '.$usr ['ds_facultad'];
						
				}
				else{*/
					$res [$i] = array ('cd_proyecto' => $usr ['cd_proyecto'], 'ds_codigo' => $usr ['ds_codigo'], 'ds_titulo' => $usr ['ds_titulo'], 'ds_director' => $usr ['ds_director'], 'ds_facultad' => $usr ['ds_facultad'], 'dt_ini' => $usr ['dt_ini'], 'dt_fin' => $usr ['dt_fin'], 'bl_altapendiente' => $usr ['bl_altapendiente'], 'bl_bajapendiente' => $usr ['bl_bajapendiente'], 'ds_estado' => $usr ['ds_estado'], 'cd_estado' => $usr ['cd_estado'], 'ds_tipoacreditacion' => $usr ['ds_tipoacreditacion'] );
					$cd_proyectoAnt = $usr ['cd_proyecto'];
					$i ++;
				}

			//}
		}
		$db->sql_close;
		return ($res);
	}
	
function getCountProyectos($filtro, $filtroFacultad, $filtroEstado, $filtroDir, $cd_usuario, $pendientes, $actual, $filtroTipoAcreditacion) {

		$sql = "SELECT count(*) FROM proyecto P ";
		$sql .= " LEFT JOIN estadoproyecto ES ON P.cd_estado = ES.cd_estado LEFT JOIN facultad F ON P.cd_facultad = F.cd_facultad LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto LEFT JOIN docente D ON I.cd_docente = D.cd_docente LEFT JOIN tipoacreditacion TA ON P.cd_tipoacreditacion = TA.cd_tipoacreditacion ";
		$sql .= (PermisoQuery::permisosDeUsuario( $cd_usuario, "Proyectos propios" ))?' LEFT JOIN usuarioproyecto U ON U.nu_documento = D.nu_documento':'';
		$sql .= (PermisoQuery::permisosDeUsuario( $cd_usuario, "Evaluar proyecto" ))?' LEFT JOIN evaluacionproyecto ON P.cd_proyecto = evaluacionproyecto.cd_proyecto':'';
		$year = ($pendientes)?$_SESSION ["nu_yearSession"]-1:$_SESSION ["nu_yearSession"];
		$sql .= " WHERE I.cd_tipoinvestigador = 1 AND P.cd_tipoacreditacion <> '3' AND ds_codigo LIKE '%$filtro%' AND dt_fin > '".($year)."-05-01' ";
		if (($filtroFacultad != 0)) {
			$sql .= " AND P.cd_facultad='$filtroFacultad'";
		}
		if (($filtroEstado != 0)) {
			$sql .= " AND P.cd_estado='$filtroEstado'";
		}
		if (($filtroDir != '')) {
			$sql .= " AND CONCAT(ds_apellido, ', ', ds_nombre) LIKE '%$filtroDir%'";
		}
		$sql .=(PermisoQuery::permisosDeUsuario( $cd_usuario, "Todos los proyectos" ))?'':((PermisoQuery::permisosDeUsuario( $cd_usuario, "Proyectos propios" ))?' AND U.cd_usuario = '.$cd_usuario:((PermisoQuery::permisosDeUsuario( $cd_usuario, "Evaluar proyecto" ))?' AND evaluacionproyecto.cd_usuario = '.$cd_usuario:' AND F.cd_facultad = '.$_SESSION ["cd_facultadSession"]));
		/*if ($pendientes) {
			$sql .= " AND ((cd_estado=1) OR (cd_estado=2))";
			}*/
		if (($actual)||($pendientes)) {
			$sql .= " AND (dt_ini = '".($year)."-01-01' OR dt_ini = '".($year)."-08-01' OR dt_ini = '".($year)."-10-01')";
		}
		if (($filtroTipoAcreditacion != 0)) {
			$sql .= " AND P.cd_tipoacreditacion='$filtroTipoAcreditacion'";
		}
		//echo $sql;
		$db = Db::conectar ();
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close;
		return (( int ) $cant);
	}

	function getProyectosDocentes($cd_docente, $cd_tipoacreditacion=0){


		$sql = " SELECT P.cd_proyecto, ds_titulo, ds_codigo, CONCAT( DOCDIR.ds_apellido, ', ', DOCDIR.ds_nombre ) AS ds_director, dt_ini, dt_fin, I.nu_horasinv, ds_tipoinvestigador, I.cd_tipoinvestigador
FROM proyecto P";
		$sql .= " LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto LEFT JOIN docente D ON I.cd_docente = D.cd_docente LEFT JOIN integrante DIR ON P.cd_proyecto = DIR.cd_proyecto
LEFT JOIN docente DOCDIR ON DIR.cd_docente = DOCDIR.cd_docente LEFT JOIN tipoinvestigador TI ON I.cd_tipoinvestigador = TI.cd_tipoinvestigador";
		$year = intval($_SESSION ["nu_yearSession"]);
		//$dt_fecha = date('Y-m-d');
		
		$sql .= " WHERE DIR.cd_tipoinvestigador = 1 AND P.cd_tipoacreditacion <> '3' AND P.cd_estado <>4 AND P.cd_estado <>7 AND I.cd_docente = ".$cd_docente." AND dt_fin > '".$year."-10-01' AND (I.dt_baja IS NULL OR I.dt_baja = '0000-00-00' OR I.dt_baja >  '".$year."-01-01')";
		if ($cd_tipoacreditacion != 0) {
			$sql .= " AND P.cd_tipoacreditacion='$cd_tipoacreditacion'";
		}
		$sql .= " ORDER BY ds_codigo";
		//echo $sql;
		$db = Db::conectar ();
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_proyecto' => $usr ['cd_proyecto'], 'ds_codigo' => $usr ['ds_codigo'], 'ds_titulo' => $usr ['ds_titulo'], 'ds_director' => $usr ['ds_director'], 'ds_facultad' => $usr ['ds_facultad'], 'dt_ini' => $usr ['dt_ini'], 'dt_fin' => $usr ['dt_fin'], 'nu_horasinv' => $usr ['nu_horasinv'], 'ds_tipoinvestigador' => $usr ['ds_tipoinvestigador'], 'cd_tipoinvestigador' => $usr ['cd_tipoinvestigador']);
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}

	function getProyectosAcreditados($cd_tipoacreditacion){

		$year = $_SESSION ["nu_yearSession"];
		$sql = " SELECT P.*, CONCAT( ds_apellido, ', ', ds_nombre ) AS ds_director, D.cd_docente, U.ds_codigo AS Unidad FROM proyecto P";
		$sql .= " LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto LEFT JOIN docente D ON I.cd_docente = D.cd_docente";
		$sql .= " LEFT JOIN unidad U ON P.cd_unidad = U.cd_unidad";
		$sql .= " WHERE I.cd_tipoinvestigador = 1 AND P.cd_tipoacreditacion <> '3' AND P.cd_estado = 5 AND P.dt_ini = '".$year."-01-01' AND P.cd_tipoacreditacion = $cd_tipoacreditacion";
		//echo $sql;
		$db = Db::conectar ();
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_proyecto' => $usr ['cd_proyecto'], 'ds_codigo' => $usr ['ds_codigo'], 'ds_titulo' => $usr ['ds_titulo'],  'dt_ini' => $usr ['dt_ini'], 'dt_fin' => $usr ['dt_fin'], 'dt_inc' => $usr ['dt_inc'], 'cd_facultad' => $usr ['cd_facultad'], 'cd_unidad' => $usr ['Unidad'], 'cd_campo' => $usr ['cd_campo'], 'cd_especialidad' => $usr ['cd_especialidad'], 'cd_disciplina' => $usr ['cd_disciplina'], 'cd_entidad' => $usr ['cd_entidad'], 'ds_linea' => $usr ['ds_linea'], 'ds_tipo' => $usr ['ds_tipo'], 'ds_abstract1' => $usr ['ds_abstract1'], 'ds_clave1' => $usr ['ds_clave1'], 'ds_clave2' => $usr ['ds_clave2'], 'ds_clave3' => $usr ['ds_clave3'], 'ds_clave4' => $usr ['ds_clave4'], 'ds_clave5' => $usr ['ds_clave5'], 'ds_clave6' => $usr ['ds_clave6'], 'ds_director' => $usr ['ds_director'], 'cd_docente' => $usr ['cd_docente']);
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}


	

	function insertarProyecto(Proyecto $obj) {
		$db = Db::conectar ();
		$id = ProyectoQuery::insert_id ( $db );
		$obj->setCd_proyecto ( $id+1 );
		$ds_titulo = addslashes($obj->getDs_titulo ());
		$ds_codigo = addslashes($obj->getDs_codigo ());
		$cd_facultad = $obj->getCd_facultad();
		$cd_proyecto = $obj->getCd_proyecto();
		$dt_ini = $obj->getDt_ini();
		$dt_fin = $obj->getDt_fin();
		$dt_inc = $obj->getDt_inc();
		$nu_duracion = $obj->getNu_duracion();
		$cd_unidad = $obj->getCd_unidad();
		$nu_nivelunidad = $obj->getNu_nivelunidad();
		$cd_campo = $obj->getCd_campo();
		$cd_especialidad = $obj->getCd_especialidad();
		$cd_disciplina = $obj->getCd_disciplina();
		$cd_entidad = $obj->getCd_entidad();
		$ds_linea = addslashes($obj->getDs_linea());
		$ds_tipo = addslashes($obj->getDs_tipo());
		$bl_altapendiente = $obj->getBl_altapendiente();
		$bl_bajapendiente = $obj->getBl_bajapendiente();
		$cd_estado = $obj->getCd_estado();
		$ds_abstract1 = strtoupper(addslashes($obj->getDs_abstract1()));
		$ds_abstract2 = strtoupper(addslashes($obj->getDs_abstract2()));
		$ds_abstracteng = strtoupper(addslashes($obj->getDs_abstracteng()));
		$ds_clave1 = addslashes($obj->getDs_clave1());
		$ds_clave2 = addslashes($obj->getDs_clave2());
		$ds_clave3 = addslashes($obj->getDs_clave3());
		$ds_clave4 = addslashes($obj->getDs_clave4());
		$ds_clave5 = addslashes($obj->getDs_clave5());
		$ds_clave6 = addslashes($obj->getDs_clave6());
		$ds_claveeng1 = addslashes($obj->getDs_claveeng1());
		$ds_claveeng2 = addslashes($obj->getDs_claveeng2());
		$ds_claveeng3 = addslashes($obj->getDs_claveeng3());
		$ds_claveeng4 = addslashes($obj->getDs_claveeng4());
		$ds_claveeng5 = addslashes($obj->getDs_claveeng5());
		$ds_claveeng6 = addslashes($obj->getDs_claveeng6());
		$bl_transferencia = $obj->getBl_transferencia();
		$ds_marco = addslashes($obj->getDs_marco());
		$bl_publicar = $obj->getBl_publicar();
		$bl_notificacion = $obj->getBl_notificacion();
		$ds_cronograma = addslashes($obj->getDs_cronograma());
		$ds_aporte = addslashes($obj->getDs_aporte());
		$ds_objectivos = addslashes($obj->getDs_objetivos());
		$ds_metodologia = addslashes($obj->getDs_metodologia());
		$ds_metas = addslashes($obj->getDs_metas());
		$ds_antecedentes = addslashes($obj->getDs_antecedentes());
		$ds_avance = addslashes($obj->getDs_avance());
		$ds_formacion = addslashes($obj->getDs_formacion());
		$ds_transferencia = addslashes($obj->getDs_transferencia());
		$ds_plan = addslashes($obj->getDs_plan());
		$ds_disponible = addslashes($obj->getDs_disponible());
		$ds_necesario = addslashes($obj->getDs_necesario());
		$ds_fuentes = addslashes($obj->getDs_fuentes());
		$nu_ano1 = $obj->getNu_ano1();
		$nu_ano2 = $obj->getNu_ano2();
		$nu_ano3 = $obj->getNu_ano3();
		$nu_ano4 = $obj->getNu_ano4();
		$ds_factibilidad = addslashes($obj->getDs_factibilidad());
		$nu_consumo1 = $obj->getNu_consumo1();
		$nu_consumo2 = $obj->getNu_consumo2();
		$nu_consumo3 = $obj->getNu_consumo3();
		$nu_consumo4 = $obj->getNu_consumo4();
		$nu_servicios1 = $obj->getNu_servicios1();
		$nu_servicios2 = $obj->getNu_servicios2();
		$nu_servicios3 = $obj->getNu_servicios3();
		$nu_servicios4 = $obj->getNu_servicios4();
		$nu_bibliografia1 = $obj->getNu_bibliografia1();
		$nu_bibliografia2 = $obj->getNu_bibliografia2();
		$nu_bibliografia3 = $obj->getNu_bibliografia3();
		$nu_bibliografia4 = $obj->getNu_bibliografia4();
		$nu_cientifico1 = $obj->getNu_cientifico1();
		$nu_cientifico2 = $obj->getNu_cientifico2();
		$nu_cientifico3 = $obj->getNu_cientifico3();
		$nu_cientifico4 = $obj->getNu_cientifico4();
		$nu_computacion1 = $obj->getNu_computacion1();
		$nu_computacion2 = $obj->getNu_computacion2();
		$nu_computacion3 = $obj->getNu_computacion3();
		$nu_computacion4 = $obj->getNu_computacion4();
		$nu_otros1 = $obj->getNu_otros1();
		$nu_otros2 = $obj->getNu_otros2();
		$nu_otros3 = $obj->getNu_otros3();
		$nu_otros4 = $obj->getNu_otros4();
		$ds_fondotramite = addslashes($obj->getDs_fondotramite());
		$cd_tipoacreditacion = $obj->getCd_tipoacreditacion();
		$sql = "INSERT INTO proyecto (cd_proyecto, ds_codigo, ds_titulo, dt_ini, dt_fin, dt_inc, cd_facultad, nu_duracion, cd_unidad, nu_nivelunidad,
cd_campo, cd_especialidad, cd_disciplina, cd_entidad, ds_linea, ds_tipo, bl_altapendiente, bl_bajapendiente, cd_estado, ds_abstract1, ds_abstract2, ds_abstracteng, ds_clave1, ds_clave2, ds_clave3, ds_clave4, ds_clave5, ds_clave6, ds_claveeng1, ds_claveeng2, ds_claveeng3, ds_claveeng4, ds_claveeng5, ds_claveeng6, bl_transferencia, ds_marco, ds_aporte, ds_objectivos, ds_metodologia, ds_metas, ds_antecedentes, ds_avance, ds_formacion, ds_transferencia, ds_plan, ds_disponible, ds_necesario, ds_fuentes, nu_ano1, nu_ano2, nu_ano3, nu_ano4, ds_factibilidad, nu_consumo1, nu_consumo2, nu_consumo3, nu_consumo4, nu_servicios1, nu_servicios2, nu_servicios3, nu_servicios4, nu_bibliografia1, nu_bibliografia2, nu_bibliografia3, nu_bibliografia4, nu_cientifico1, nu_cientifico2, nu_cientifico3, nu_cientifico4, nu_computacion1, nu_computacion2, nu_computacion3, nu_computacion4, nu_otros1, nu_otros2, nu_otros3, nu_otros4, ds_fondotramite, cd_tipoacreditacion, bl_publicar, bl_notificacion, ds_cronograma) VALUES ('$cd_proyecto', '$ds_codigo', '$ds_titulo', '$dt_ini', '$dt_fin', '$dt_inc', '$cd_facultad', '$nu_duracion', '$cd_unidad', '$nu_nivelunidad', '$cd_campo', '$cd_especialidad', '$cd_disciplina', '$cd_entidad', '$ds_linea', '$ds_tipo', '$bl_altapendiente', '$bl_bajapendiente', '$cd_estado', '$ds_abstract1', '$ds_abstract2', '$ds_abstracteng', '$ds_clave1', '$ds_clave2', '$ds_clave3', '$ds_clave4', '$ds_clave5', '$ds_clave6', '$ds_claveeng1', '$ds_claveeng2', '$ds_claveeng3', '$ds_claveeng4', '$ds_claveeng5', '$ds_claveeng6', '$bl_transferencia', '$ds_marco', '$ds_aporte', '$ds_objectivos', '$ds_metodologia', '$ds_metas', '$ds_antecedentes', '$ds_avance', '$ds_formacion', '$ds_transferencia', '$ds_plan', '$ds_disponible', '$ds_necesario', '$ds_fuentes', '$nu_ano1', '$nu_ano2', '$nu_ano3', '$nu_ano4', '$ds_factibilidad', '$nu_consumo1', '$nu_consumo2', '$nu_consumo3', '$nu_consumo4', '$nu_servicios1', '$nu_servicios2', '$nu_servicios3', '$nu_servicios4', '$nu_bibliografia1', '$nu_bibliografia2', '$nu_bibliografia3', '$nu_bibliografia4', '$nu_cientifico1', '$nu_cientifico2', '$nu_cientifico3', '$nu_cientifico4', '$nu_computacion1', '$nu_computacion2', '$nu_computacion3', '$nu_computacion4', '$nu_otros1', '$nu_otros2', '$nu_otros3', '$nu_otros4', '$ds_fondotramite', '$cd_tipoacreditacion', '$bl_publicar', '$bl_notificacion', '$ds_cronograma') ";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}

	function eliminarProyecto(Proyecto $obj){
		$db = Db::conectar ();
		$cd_proyecto = $obj->getCd_proyecto ();
		$sql = "DELETE FROM proyecto WHERE cd_proyecto = $cd_proyecto";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}

	function dameCodigo(Proyecto $obj){
		$db = Db::conectar ();
		$cd_facultad = $obj->getCd_facultad();
		$cd_tipoacreditacion = $obj->getCd_tipoacreditacion();
		$sql = "SELECT MAX(ds_codigo) AS ds_codigo FROM proyecto WHERE cd_facultad = $cd_facultad AND cd_tipoacreditacion = '$cd_tipoacreditacion' AND ds_codigo NOT LIKE '20/%'";
		$result = $db->sql_query ( $sql );
		if ($db->sql_numrows () > 0) {
			$tc = $db->sql_fetchassoc ( $result );
			$cant = ($cd_tipoacreditacion==1)?4:6;
			$pre = substr($tc ['ds_codigo'],0,$cant);
			$ds_codigo = substr($tc ['ds_codigo'],$cant);
			$ds_codigo = $ds_codigo+1;
			while (strlen($ds_codigo)<3){
				$ds_codigo = '0'.$ds_codigo;
			}
			$obj->setDs_codigo( $pre.$ds_codigo );
		}
		$db->sql_close;
		return ($result);
	}

	function modificarProyecto(Proyecto $obj){
		$db = Db::conectar ();
		$ds_titulo = addslashes($obj->getDs_titulo ());
		$ds_codigo = addslashes($obj->getDs_codigo ());
		$cd_facultad = $obj->getCd_facultad();
		$cd_proyecto = $obj->getCd_proyecto();
		$dt_ini = $obj->getDt_ini();
		$dt_fin = $obj->getDt_fin();
		$dt_inc = $obj->getDt_inc();
		$nu_duracion = $obj->getNu_duracion();
		$cd_unidad = $obj->getCd_unidad();
		$nu_nivelunidad = $obj->getNu_nivelunidad();
		$cd_campo = $obj->getCd_campo();
		$cd_especialidad = $obj->getCd_especialidad();
		$cd_disciplina = $obj->getCd_disciplina();
		$cd_entidad = $obj->getCd_entidad();
		$ds_linea = addslashes($obj->getDs_linea());
		$ds_tipo = addslashes($obj->getDs_tipo());
		$bl_altapendiente = $obj->getBl_altapendiente();
		$bl_bajapendiente = $obj->getBl_bajapendiente();
		$cd_estado = $obj->getCd_estado();
		$ds_abstract1 = strtoupper(addslashes($obj->getDs_abstract1()));
		$ds_abstract2 = strtoupper(addslashes($obj->getDs_abstract2()));
		$ds_abstracteng = strtoupper(addslashes($obj->getDs_abstracteng()));
		$ds_clave1 = addslashes($obj->getDs_clave1());
		$ds_clave2 = addslashes($obj->getDs_clave2());
		$ds_clave3 = addslashes($obj->getDs_clave3());
		$ds_clave4 = addslashes($obj->getDs_clave4());
		$ds_clave5 = addslashes($obj->getDs_clave5());
		$ds_clave6 = addslashes($obj->getDs_clave6());
		$ds_claveeng1 = addslashes($obj->getDs_claveeng1());
		$ds_claveeng2 = addslashes($obj->getDs_claveeng2());
		$ds_claveeng3 = addslashes($obj->getDs_claveeng3());
		$ds_claveeng4 = addslashes($obj->getDs_claveeng4());
		$ds_claveeng5 = addslashes($obj->getDs_claveeng5());
		$ds_claveeng6 = addslashes($obj->getDs_claveeng6());
		$bl_transferencia = $obj->getBl_transferencia();
		$ds_marco = addslashes($obj->getDs_marco());
		$bl_publicar = $obj->getBl_publicar();
		$bl_notificacion = $obj->getBl_notificacion();
		$ds_cronograma = addslashes($obj->getDs_cronograma());
		$ds_aporte = addslashes($obj->getDs_aporte());
		$ds_objectivos = addslashes($obj->getDs_objetivos());
		$ds_metodologia = addslashes($obj->getDs_metodologia());
		$ds_metas = addslashes($obj->getDs_metas());
		$ds_antecedentes = addslashes($obj->getDs_antecedentes());
		$ds_avance = addslashes($obj->getDs_avance());
		$ds_formacion = addslashes($obj->getDs_formacion());
		$ds_transferencia = addslashes($obj->getDs_transferencia());
		$ds_plan = addslashes($obj->getDs_plan());
		$ds_disponible = addslashes($obj->getDs_disponible());
		$ds_necesario = addslashes($obj->getDs_necesario());
		$ds_fuentes = addslashes($obj->getDs_fuentes());
		$nu_ano1 = $obj->getNu_ano1();
		$nu_ano2 = $obj->getNu_ano2();
		$nu_ano3 = $obj->getNu_ano3();
		$nu_ano4 = $obj->getNu_ano4();
		$ds_factibilidad = addslashes($obj->getDs_factibilidad());
		$nu_consumo1 = $obj->getNu_consumo1();
		$nu_consumo2 = $obj->getNu_consumo2();
		$nu_consumo3 = $obj->getNu_consumo3();
		$nu_consumo4 = $obj->getNu_consumo4();
		$nu_servicios1 = $obj->getNu_servicios1();
		$nu_servicios2 = $obj->getNu_servicios2();
		$nu_servicios3 = $obj->getNu_servicios3();
		$nu_servicios4 = $obj->getNu_servicios4();
		$nu_bibliografia1 = $obj->getNu_bibliografia1();
		$nu_bibliografia2 = $obj->getNu_bibliografia2();
		$nu_bibliografia3 = $obj->getNu_bibliografia3();
		$nu_bibliografia4 = $obj->getNu_bibliografia4();
		$nu_cientifico1 = $obj->getNu_cientifico1();
		$nu_cientifico2 = $obj->getNu_cientifico2();
		$nu_cientifico3 = $obj->getNu_cientifico3();
		$nu_cientifico4 = $obj->getNu_cientifico4();
		$nu_computacion1 = $obj->getNu_computacion1();
		$nu_computacion2 = $obj->getNu_computacion2();
		$nu_computacion3 = $obj->getNu_computacion3();
		$nu_computacion4 = $obj->getNu_computacion4();
		$nu_otros1 = $obj->getNu_otros1();
		$nu_otros2 = $obj->getNu_otros2();
		$nu_otros3 = $obj->getNu_otros3();
		$nu_otros4 = $obj->getNu_otros4();
		$ds_fondotramite = addslashes($obj->getDs_fondotramite());
		$cd_tipoacreditacion = $obj->getCd_tipoacreditacion();
		$sql = "UPDATE proyecto SET cd_proyecto='$cd_proyecto', ds_codigo='$ds_codigo', ds_titulo='$ds_titulo', dt_ini='$dt_ini', dt_fin='$dt_fin', dt_inc='$dt_inc', cd_facultad='$cd_facultad', nu_duracion='$nu_duracion', cd_unidad='$cd_unidad', nu_nivelunidad='$nu_nivelunidad'";
		$sql .= " WHERE cd_proyecto = $cd_proyecto";
		$result = $db->sql_query ( $sql );
		$sql = "UPDATE proyecto SET cd_campo='$cd_campo', cd_especialidad='$cd_especialidad', cd_disciplina='$cd_disciplina', cd_entidad='$cd_entidad', ds_linea='$ds_linea', ds_tipo='$ds_tipo', bl_altapendiente='$bl_altapendiente', bl_bajapendiente='$bl_bajapendiente', cd_estado='$cd_estado', ds_abstract1='$ds_abstract1', ds_abstract2='$ds_abstract2', ds_abstracteng='$ds_abstracteng', ds_clave1='$ds_clave1', ds_clave2='$ds_clave2', ds_clave3='$ds_clave3', ds_clave4='$ds_clave4', ds_clave5='$ds_clave5', ds_clave6='$ds_clave6', ds_claveeng1='$ds_claveeng1', ds_claveeng2='$ds_claveeng2', ds_claveeng3='$ds_claveeng3', ds_claveeng4='$ds_claveeng4', ds_claveeng5='$ds_claveeng5', ds_claveeng6='$ds_claveeng6', bl_transferencia='$bl_transferencia', bl_publicar='$bl_publicar', bl_notificacion='$bl_notificacion'";
		$sql .= " WHERE cd_proyecto = $cd_proyecto";
		$result = $db->sql_query ( $sql );
		$sql = "UPDATE proyecto SET	ds_marco='$ds_marco', ds_aporte='$ds_aporte', ds_objectivos='$ds_objectivos', ds_metodologia='$ds_metodologia', ds_metas='$ds_metas', ds_antecedentes='$ds_antecedentes'";
		$sql .= " WHERE cd_proyecto = $cd_proyecto";
		$result = $db->sql_query ( $sql );
		$sql = "UPDATE proyecto SET ds_avance='$ds_avance', ds_formacion='$ds_formacion', ds_transferencia='$ds_transferencia', ds_plan='$ds_plan', ds_cronograma='$ds_cronograma', ds_disponible='$ds_disponible', ds_necesario='$ds_necesario'";
		$sql .= " WHERE cd_proyecto = $cd_proyecto";
		$result = $db->sql_query ( $sql );
		$sql = "UPDATE proyecto SET ds_fuentes='$ds_fuentes', nu_ano1='$nu_ano1', nu_ano2='$nu_ano2', nu_ano3='$nu_ano3', nu_ano4='$nu_ano4', ds_factibilidad='$ds_factibilidad', nu_consumo1='$nu_consumo1', nu_consumo2='$nu_consumo2', nu_consumo3='$nu_consumo3', nu_consumo4='$nu_consumo4', nu_servicios1='$nu_servicios1', nu_servicios2='$nu_servicios2', nu_servicios3='$nu_servicios3', nu_servicios4='$nu_servicios4', nu_bibliografia1='$nu_bibliografia1', nu_bibliografia2='$nu_bibliografia2', nu_bibliografia3='$nu_bibliografia3', nu_bibliografia4='$nu_bibliografia4', nu_cientifico1='$nu_cientifico1', nu_cientifico2='$nu_cientifico2', nu_cientifico3='$nu_cientifico3', nu_cientifico4='$nu_cientifico4', nu_computacion1='$nu_computacion1', nu_computacion2='$nu_computacion2', nu_computacion3='$nu_computacion3', nu_computacion4='$nu_computacion4', nu_otros1='$nu_otros1', nu_otros2='$nu_otros2', nu_otros3='$nu_otros3', nu_otros4='$nu_otros4', ds_fondotramite='$ds_fondotramite', cd_tipoacreditacion='$cd_tipoacreditacion'";
		$sql .= " WHERE cd_proyecto = $cd_proyecto";
		$result = $db->sql_query ( $sql );

		$db->sql_close;
		return $result;
	}

	function listarCodigo($ds_codigo = "") {
		$db = Db::conectar (  );
		$sql = "SELECT ds_codigo FROM proyecto ORDER BY ds_codigo";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		$ok=0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['ds_codigo'] == $ds_codigo) {
					$res [$i] = array ('cd_codigo' => "'" . $usr ['ds_codigo'] . "' selected='selected'", 'ds_codigo' => $usr ['ds_codigo'] );
					$ok=1;
				} else {
					$res [$i] = array ('cd_codigo' => $usr ['ds_codigo'], 'ds_codigo' => $usr ['ds_codigo'] );
				}
				$i ++;
			}
		}
		if (($ds_codigo)&&(!$ok)) $res [$i] = array ('cd_codigo' => "'" . $ds_codigo . "' selected='selected'", 'ds_codigo' => $ds_codigo );
		$db->sql_close ();

		return $res;
	}

	function listarTituloPorCodigo($ds_codigo = "", $ds_titulo="") {
		$db = Db::conectar (  );
		$sql = "SELECT ds_titulo FROM proyecto WHERE ds_codigo = '$ds_codigo' ORDER BY ds_titulo";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		$ok=0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['ds_titulo'] == $ds_titulo) {
					$res [$i] = array ('cd_titulo' => "'" . $usr ['ds_titulo'] . "' selected='selected'", 'ds_titulo' => $usr ['ds_titulo'] );
					$ok=1;
				} else {
					$res [$i] = array ('cd_titulo' => "'" . $usr ['ds_titulo'] . "'", 'ds_titulo' => $usr ['ds_titulo'] );
				}
				$i ++;

			}
		}
		if (($ds_titulo)&&(!$ok)) $res [$i] = array ('cd_titulo' => "'" . $ds_titulo . "' selected='selected'", 'ds_titulo' => $ds_titulo );
		$db->sql_close ();

		return $res;
	}

	function insert_id($db) {
		$sql = "SELECT MAX(`cd_proyecto`) FROM proyecto ";
		$result = $db->sql_query ( $sql );
		$id = $db->sql_fetchrow ( $result, 0 );
		return ($id [0]);
	}


}
?>