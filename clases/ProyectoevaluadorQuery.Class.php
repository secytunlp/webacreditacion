<?php
class ProyectoevaluadorQuery {


	function getProyectoevaluador(Proyectoevaluador $proyectoevaluador) {
		$db = Db::conectar ();
		$cd_proyecto = $proyectoevaluador->getCd_proyecto();
		//$cd_tipoevaluador = $proyectoevaluador->getCd_tipoevaluador();
		$sql = "Select cd_proyectoevaluador, cd_proyecto, ds_evaluador, ds_universidad, ds_disciplina, ds_categoria, PE.cd_tipoevaluador, ds_tipoevaluador, E.cd_evaluador FROM proyectoevaluador PE INNER JOIN evaluador E ON PE.cd_evaluador = E.cd_evaluador INNER JOIN tipoevaluador TE ON PE.cd_tipoevaluador = TE.cd_tipoevaluador WHERE cd_proyecto ='$cd_proyecto' ";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_proyectoevaluador' => $usr ['cd_proyectoevaluador'], 'cd_proyecto' => $usr ['cd_proyecto'], 'ds_evaluador' => $usr ['ds_evaluador'], 'cd_evaluador' => $usr ['cd_evaluador'], 'ds_disciplina' => $usr ['ds_disciplina'], 'ds_categoria' => $usr ['ds_categoria'], 'ds_universidad' => $usr ['ds_universidad'], 'ds_tipoevaluador' => $usr ['ds_tipoevaluador'], 'cd_tipoevaluador' => $usr ['cd_tipoevaluador'] );
				$i ++;
			}
		}
		$db->sql_close ();
		return ($res);
	}

	function getProyectoevaluadorPorTipo(Proyectoevaluador $proyectoevaluador) {
		$db = Db::conectar ();
		$cd_proyecto = $proyectoevaluador->getCd_proyecto();
		$cd_tipoevaluador = $proyectoevaluador->getCd_tipoevaluador();
		$sql = "Select cd_proyectoevaluador, cd_proyecto, ds_evaluador, ds_universidad, ds_disciplina, ds_categoria, PE.cd_tipoevaluador, ds_tipoevaluador, E.cd_evaluador FROM proyectoevaluador PE INNER JOIN evaluador E ON PE.cd_evaluador = E.cd_evaluador INNER JOIN tipoevaluador TE ON PE.cd_tipoevaluador = TE.cd_tipoevaluador WHERE cd_proyecto ='$cd_proyecto' AND TE.cd_tipoevaluador='$cd_tipoevaluador'";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_proyectoevaluador' => $usr ['cd_proyectoevaluador'], 'cd_proyecto' => $usr ['cd_proyecto'], 'ds_evaluador' => $usr ['ds_evaluador'], 'cd_evaluador' => $usr ['cd_evaluador'], 'ds_disciplina' => $usr ['ds_disciplina'], 'ds_categoria' => $usr ['ds_categoria'], 'ds_universidad' => $usr ['ds_universidad'], 'ds_tipoevaluador' => $usr ['ds_tipoevaluador'], 'cd_tipoevaluador' => $usr ['cd_tipoevaluador'] );
				$i ++;
			}
		}
		$db->sql_close ();
		return ($res);
	}

	function insertarProyectoevaluador(Proyectoevaluador $obj) {
		$db = Db::conectar ();
		$cd_proyecto = $obj->getCd_proyecto();
		$cd_evaluador = $obj->getCd_evaluador();
		$cd_tipoevaluador = $obj->getCd_tipoevaluador();

		$sql = "INSERT INTO proyectoevaluador (cd_proyecto, cd_evaluador, cd_tipoevaluador) VALUES ('$cd_proyecto', '$cd_evaluador', '$cd_tipoevaluador') ";
		$result = $db->sql_query ( $sql );

		$id = ProyectoevaluadorQuery::insert_id ( $db );
		$obj->setCd_proyectoevaluador ( $id );
		$db->sql_close;
		return $result;
	}

	function insert_id($db) {
		$sql = "SELECT MAX(`cd_proyectoevaluador`) FROM proyectoevaluador ";
		$result = $db->sql_query ( $sql );
		$id = $db->sql_fetchrow ( $result, 0 );
		return ($id [0]);
	}



	function eliminarProyectoevaluadorPorProyecto(Proyectoevaluador $obj) {
		$db = Db::conectar ();
		$cd_proyecto = $obj->getCd_proyecto();
		$sql = "DELETE FROM proyectoevaluador WHERE cd_proyecto = $cd_proyecto";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}

	function fueRecusado($cd_proyecto, $nu_documento) {
		$db = Db::conectar ();

		$sql = "Select count(*) FROM proyectoevaluador PE INNER JOIN evaluador E ON PE.cd_evaluador = E.cd_evaluador INNER JOIN usuarioproyecto U ON E.nu_documento = U.nu_documento WHERE (PE.cd_tipoevaluador =1 OR PE.cd_tipoevaluador =2) AND PE.cd_proyecto = $cd_proyecto AND U.nu_documento = $nu_documento";
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close ();
		return ($cant > 0);
	}




}
?>