<?php
class IntegranteQuery {

	function getIntegrantePorId(Integrante $obj) {
		$db = Db::conectar ();
		$cd_proyecto = $obj->getCd_proyecto ();
		$cd_docente = $obj->getCd_docente ();
		$sql = "SELECT I.*, ds_tipoinvestigador FROM integrante I LEFT JOIN tipoinvestigador TI ON I.cd_tipoinvestigador = TI.cd_tipoinvestigador WHERE cd_proyecto = $cd_proyecto and cd_docente = $cd_docente";
		$result = $db->sql_query ( $sql );
		if ($db->sql_numrows () > 0) {
			$tc = $db->sql_fetchassoc ( $result );
			$obj->setCd_tipoinvestigador ( $tc ['cd_tipoinvestigador'] );
			$obj->setDs_tipoinvestigador ( $tc ['ds_tipoinvestigador'] );
			$obj->setDt_alta ( $tc ['dt_alta'] );
			$obj->setDt_baja ( $tc ['dt_baja'] );
			$obj->setDt_altapendiente ( $tc ['dt_altapendiente'] );
			$obj->setDt_bajapendiente ( $tc ['dt_bajapendiente'] );
			$obj->setNu_horasinv ( $tc ['nu_horasinv'] );
			$obj->setDs_curriculum( $tc ['ds_curriculum'] );
			$obj->setDs_antecedentes( $tc ['ds_antecedentes'] );
			$obj->setDs_antecedentesPPIDDIR( $tc ['ds_antecedentesPPIDDIR'] );
		}
		$db->sql_close;
		return ($result);
	}

	function getIntegrantePorTipo(Integrante $obj) {
		$db = Db::conectar ();
		$cd_proyecto = $obj->getCd_proyecto ();
		$cd_tipoinvestigador = $obj->getCd_tipoinvestigador();
		$sql = "SELECT I.*, ds_tipoinvestigador FROM integrante I LEFT JOIN tipoinvestigador TI ON I.cd_tipoinvestigador = TI.cd_tipoinvestigador WHERE cd_proyecto = $cd_proyecto and TI.cd_tipoinvestigador = $cd_tipoinvestigador";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_docente' => $usr ['cd_docente'], 'ds_tipoinvestigador' => $usr ['ds_tipoinvestigador'], 'dt_alta' => $usr ['dt_alta'], 'dt_baja' => $usr ['dt_baja'], 'dt_altapendiente' => $usr ['dt_altapendiente'], 'dt_bajapendiente' => $usr ['dt_bajapendiente'], 'dt_alta' => $usr ['dt_alta'], 'dt_baja' => $usr ['dt_baja'], 'dt_altapendiente' => $usr ['dt_altapendiente'], 'dt_bajapendiente' => $usr ['dt_bajapendiente'], 'nu_horasinv' => $usr ['nu_horasinv'], 'ds_curriculum' => $usr ['ds_curriculum'], 'ds_antecedentes' => $usr ['ds_antecedentes'], 'ds_antecedentesPPIDDIR' => $usr ['ds_antecedentesPPIDDIR']);
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}

	function getIntegrantes($attr, $orden, $filtro, $page, $row_per_page, $cd_proyecto){

		$limitInf = (($page - 1) * $row_per_page);
		$limitSup = ($page * $row_per_page);
		$sql = "SELECT I.cd_proyecto, I.cd_docente, CONCAT(nu_precuil,'-',nu_documento,'-', nu_postcuil) AS nu_cuil, CONCAT(ds_apellido, ', ', ds_nombre) as ds_investigador, ds_categoria, nu_dedinv, ds_deddoc, dt_alta, dt_baja, dt_altapendiente, dt_bajapendiente, F.ds_facultad, I.cd_tipoinvestigador, ds_tipoinvestigador, I.nu_horasinv, nu_documento FROM integrante I";
		$sql .= " INNER JOIN docente D ON I.cd_docente = D.cd_docente INNER JOIN categoria C ON D.cd_categoria = C.cd_categoria LEFT JOIN facultad F ON D.cd_facultad = F.cd_facultad INNER JOIN deddoc DD ON D.cd_deddoc = DD.cd_deddoc LEFT JOIN tipoinvestigador TI ON I.cd_tipoinvestigador = TI.cd_tipoinvestigador ";
		$sql .= " WHERE  CONCAT(ds_apellido, ', ', ds_nombre) LIKE '%$filtro%' AND I.cd_proyecto = $cd_proyecto";

		$sql .= " ORDER BY $attr $orden LIMIT $limitInf,$row_per_page";
		$db = Db::conectar ();
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_proyecto' => $usr ['cd_proyecto'], 'cd_docente' => $usr ['cd_docente'], 'nu_cuil' => $usr ['nu_cuil'], 'ds_investigador' => $usr ['ds_investigador'], 'ds_categoria' => $usr ['ds_categoria'], 'ds_facultad' => $usr ['ds_facultad'], 'dt_alta' => $usr ['dt_alta'], 'dt_baja' => $usr ['dt_baja'], 'dt_altapendiente' => $usr ['dt_altapendiente'], 'dt_bajapendiente' => $usr ['dt_bajapendiente'], 'nu_dedinv' => $usr ['nu_dedinv'], 'ds_deddoc' => $usr ['ds_deddoc'], 'cd_tipoinvestigador' => $usr ['cd_tipoinvestigador'], 'ds_tipoinvestigador' => $usr ['ds_tipoinvestigador'], 'nu_horasinv' => $usr ['nu_horasinv'], 'nu_documento' => $usr ['nu_documento'] );
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}





	function insertarIntegrante(Integrante $obj) {
		$db = Db::conectar ();
		$cd_docente = FuncionesComunes::formatIfNull($obj->getCd_docente(), 'null' );
		$cd_proyecto = FuncionesComunes::formatIfNull($obj->getCd_proyecto(), 'null' );
		$dt_alta = FuncionesComunes::formatDate($obj->getDt_alta());
		$dt_baja = FuncionesComunes::formatDate($obj->getDt_baja());
		$cd_tipoinvestigador = FuncionesComunes::formatIfNull($obj->getCd_tipoinvestigador(), 'null' );
		$dt_altapendiente = FuncionesComunes::formatDate($obj->getDt_altapendiente());
		$dt_bajapendiente = FuncionesComunes::formatDate($obj->getDt_bajapendiente());
		$nu_horasinv = FuncionesComunes::formatIfNull($obj->getNu_horasinv(), 'null' );
		$ds_curriculum = FuncionesComunes::formatString($obj->getDs_curriculum());
		$ds_antecedentes = FuncionesComunes::formatString($obj->getDs_antecedentes());
		$ds_antecedentesPPIDDIR = FuncionesComunes::formatString($obj->getDs_antecedentesPPIDDIR());

		$sql = "INSERT INTO integrante (cd_proyecto, dt_alta, dt_baja, cd_tipoinvestigador, cd_docente, dt_altapendiente, dt_bajapendiente, nu_horasinv, ds_curriculum, ds_antecedentes,ds_antecedentesPPIDDIR) VALUES ($cd_proyecto, $dt_alta, $dt_baja, $cd_tipoinvestigador, $cd_docente, $dt_altapendiente, $dt_bajapendiente, $nu_horasinv, $ds_curriculum, $ds_antecedentes,$ds_antecedentesPPIDDIR) ";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}

	function eliminarIntegrante(Integrante $obj){
		$db = Db::conectar ();
		$cd_docente = $obj->getCd_docente();
		$cd_proyecto = $obj->getCd_proyecto();
		$sql = "DELETE FROM integrante WHERE cd_proyecto = $cd_proyecto and cd_docente = $cd_docente";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}

	function eliminarIntegrantePorProyecto($cd_proyecto){
		$db = Db::conectar ();
		$sql = "DELETE FROM integrante WHERE cd_proyecto = $cd_proyecto";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}

	function modificarIntegrante(Integrante $obj){
		$db = Db::conectar ();
		$cd_docente = FuncionesComunes::formatIfNull($obj->getCd_docente(), 'null' );
		$cd_proyecto = FuncionesComunes::formatIfNull($obj->getCd_proyecto(), 'null' );
		$dt_alta = FuncionesComunes::formatDate($obj->getDt_alta());
		$dt_baja = FuncionesComunes::formatDate($obj->getDt_baja());
		$cd_tipoinvestigador = FuncionesComunes::formatIfNull($obj->getCd_tipoinvestigador(), 'null' );
		$dt_altapendiente = FuncionesComunes::formatDate($obj->getDt_altapendiente());
		$dt_bajapendiente = FuncionesComunes::formatDate($obj->getDt_bajapendiente());
		$nu_horasinv = FuncionesComunes::formatIfNull($obj->getNu_horasinv(), 'null' );
		$ds_curriculum = FuncionesComunes::formatString($obj->getDs_curriculum());
		$ds_antecedentes = FuncionesComunes::formatString($obj->getDs_antecedentes());
		$ds_antecedentesPPIDDIR = FuncionesComunes::formatString($obj->getDs_antecedentesPPIDDIR());
		$sql = "UPDATE integrante SET dt_alta=$dt_alta, dt_baja=$dt_baja, cd_tipoinvestigador=$cd_tipoinvestigador, dt_altapendiente=$dt_altapendiente, dt_bajapendiente=$dt_bajapendiente, nu_horasinv=$nu_horasinv, ds_curriculum=$ds_curriculum, ds_antecedentes=$ds_antecedentes, ds_antecedentesPPIDDIR=$ds_antecedentesPPIDDIR";
		$sql .= " WHERE cd_proyecto = $cd_proyecto and cd_docente = $cd_docente";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}

	function tieneAltasPendientes($cd_proyecto) {
		$db = Db::conectar ();

		$sql = "SELECT count( * )FROM integrante WHERE cd_proyecto = '$cd_proyecto' AND NOT dt_altapendiente IS NULL AND dt_altapendiente <> '0000-00-00'";
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close ();
		return ($cant > 0);
	}

	function tieneBajasPendientes($cd_proyecto) {
		$db = Db::conectar ();

		$sql = "SELECT count( * )FROM integrante WHERE cd_proyecto = '$cd_proyecto' AND NOT dt_bajapendiente IS NULL AND dt_bajapendiente <> '0000-00-00'";
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close ();
		return ($cant > 0);
	}

	function masDeUnProyecto($cd_docente, $max) {
		$db = Db::conectar ();
		$year = $_SESSION ["nu_yearSession"];
		//$dt_fecha = date('m-d');
		$dt_fecha = '10-01';
		$sql = "SELECT count( * )FROM integrante I INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto WHERE P.dt_fin >= '".$year."-".$dt_fecha."' AND P.cd_tipoacreditacion <> '3' AND cd_docente = '$cd_docente' AND (`dt_altapendiente` IS NULL OR `dt_altapendiente` = '0000-00-00') AND (`dt_baja` IS NULL OR `dt_baja` = '0000-00-00' OR `dt_baja` >= '".$year."-".$dt_fecha."' OR I.cd_estado = 4 OR I.cd_estado = 5) AND I.cd_tipoinvestigador <> 6 AND P.cd_estado <> 4 AND P.cd_estado <> 7";
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close ();
		return ($cant > $max);
	}

	function masDeTresIntegrantes($cd_proyecto) {
		$db = Db::conectar ();

		$sql = "SELECT count( * )FROM integrante WHERE cd_proyecto = '$cd_proyecto' AND (dt_baja IS NULL OR dt_baja = '0000-00-00') AND I.cd_tipoinvestigador <> 6";
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close ();
		return ($cant > 3);
	}

	function getModificados($attr, $orden, $filtroModificacion, $page, $row_per_page){

		$limitInf = (($page - 1) * $row_per_page);
		$limitSup = ($page * $row_per_page);
		$year = $_SESSION ["nu_yearSession"];
		$sql = "SELECT I.cd_proyecto, I.cd_docente, CONCAT(nu_precuil,'-',nu_documento,'-', nu_postcuil) AS nu_cuil, CONCAT(ds_apellido, ', ', ds_nombre) as ds_investigador, dt_alta, P.ds_codigo, TM.ds_tipomodificacion FROM integrante I";
		$sql .= " INNER JOIN docente D ON I.cd_docente = D.cd_docente LEFT JOIN tipomodificacion TM ON D.cd_tipomodificacion = TM.cd_tipomodificacion INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto";
		$sql .= " WHERE P.cd_estado = 5 AND P.dt_ini = '".$year."-01-01'";
		if (($filtroModificacion != 0)) {
			$sql .= " AND D.cd_tipomodificacion='$filtroModificacion'";
		}
		$sql .= " ORDER BY $attr $orden LIMIT $limitInf,$row_per_page";

		$db = Db::conectar ();
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_proyecto' => $usr ['cd_proyecto'], 'cd_docente' => $usr ['cd_docente'], 'nu_cuil' => $usr ['nu_cuil'], 'ds_investigador' => $usr ['ds_investigador'], 'ds_tipomodificacion' => $usr ['ds_tipomodificacion'], 'dt_alta' => $usr ['dt_alta'], 'ds_codigo' => $usr ['ds_codigo']);
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}

	function getCountModificados($filtroModificacion) {
		$db = Db::conectar ( );
		$year = $_SESSION ["nu_yearSession"];
		$sql = "SELECT count(*) FROM integrante I";
		$sql .= " INNER JOIN docente D ON I.cd_docente = D.cd_docente LEFT JOIN tipomodificacion TM ON D.cd_tipomodificacion = TM.cd_tipomodificacion INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto";
		$sql .= " WHERE P.cd_estado = 5 AND P.dt_ini = '".$year."-01-01'";
		if (($filtroModificacion != 0)) {
			$sql .= " AND D.cd_tipomodificacion='$filtroModificacion'";
		}
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close;
		return (( int ) $cant);
	}

	function getInsertados($cd_tipoacreditacion){

		$year = $_SESSION ["nu_yearSession"];
		$sql = "SELECT I.cd_proyecto, I.cd_docente, nu_documento, dt_alta, dt_baja, P.ds_codigo, I.nu_horasinv, I.cd_tipoinvestigador FROM integrante I";
		$sql .= " INNER JOIN docente D ON I.cd_docente = D.cd_docente INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto";
		$sql .= " WHERE P.cd_estado = 5 AND P.dt_ini = '".$year."-01-01' AND P.cd_tipoacreditacion = $cd_tipoacreditacion";

		$db = Db::conectar ();
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_proyecto' => $usr ['cd_proyecto'], 'cd_docente' => $usr ['cd_docente'], 'nu_documento' => $usr ['nu_documento'], 'dt_alta' => $usr ['dt_alta'], 'dt_baja' => $usr ['dt_baja'], 'ds_codigo' => $usr ['ds_codigo'], 'nu_horasinv' => $usr ['nu_horasinv'], 'cd_tipoinvestigador' => $usr ['cd_tipoinvestigador']);
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}

	function fueDirCodir($cd_docente, $cd_proyecto) {
		$db = Db::conectar ();

		$sql = "SELECT count( * )FROM integrante I INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto  WHERE P.cd_tipoacreditacion <> 2 AND I.cd_proyecto <> '$cd_proyecto' AND I.cd_docente = '$cd_docente' AND (I.cd_tipoinvestigador = 1 OR I.cd_tipoinvestigador = 2)";
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close ();
		return ($cant > 0);
	}
	
	function fueDirCodirPPID($cd_docente, $cd_proyecto) {
		$db = Db::conectar ();

		$sql = "SELECT P.cd_proyecto, P.ds_titulo, P.ds_codigo, P.dt_ini, P.dt_fin, TI.ds_tipoinvestigador FROM integrante I INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto INNER JOIN tipoinvestigador TI ON I.cd_tipoinvestigador = TI.cd_tipoinvestigador WHERE P.cd_estado = 5 AND P.cd_tipoacreditacion = 2 AND I.cd_proyecto <> '$cd_proyecto' AND I.cd_docente = '$cd_docente' AND (I.cd_tipoinvestigador = 1 OR I.cd_tipoinvestigador = 2) ORDER BY P.cd_proyecto DESC";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_proyecto' => $usr ['cd_proyecto'], 'ds_titulo' => $usr ['ds_titulo'], 'dt_ini' => $usr ['dt_ini'], 'dt_fin' => $usr ['dt_fin'], 'ds_codigo' => $usr ['ds_codigo'], 'ds_tipoinvestigador' => $usr ['ds_tipoinvestigador']);
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}



}
?>