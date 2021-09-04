<?php

class EvaluadorespecialidadQuery {

	function getEvaluadorespecialidadPorUsuario(Evaluadorespecialidad $obj) {
		$db = Db::conectar (  );
		$cd_usuario = $obj->getCd_usuario();

		if ($cd_usuario){
			$sql = "SELECT cd_evaluadorespecialidad, EE.cd_especialidad, ds_especialidad, ds_codigo FROM evaluadorespecialidad EE LEFT JOIN especialidad D ON EE.cd_especialidad = D.cd_especialidad WHERE cd_usuario = '$cd_usuario'";
			$result = $db->sql_query ( $sql );
			$res = array ( );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$res [$i] = array ('cd_evaluadorespecialidad' => $usr ['cd_evaluadorespecialidad'], 'cd_especialidad' => $usr ['cd_especialidad'], 'ds_especialidad' => $usr ['ds_especialidad'], 'ds_codigo' => $usr ['ds_codigo'] );
						
					$i ++;
				}
			}
		}
		$db->sql_close ();

		return $res;
	}


	function insertEvaluadorespecialidad(Evaluadorespecialidad $obj) {
		$db = Db::conectar ();
		$cd_usuario = $obj->getCd_usuario();
		$cd_especialidad = $obj->getCd_especialidad();

		$sql = "INSERT INTO evaluadorespecialidad (cd_usuario, cd_especialidad) VALUES ('$cd_usuario', '$cd_especialidad') ";
		$result = $db->sql_query ( $sql );

		$id = EvaluadorespecialidadQuery::insert_id ( $db );
		$obj->setCd_evaluadorespecialidad ( $id );
		$db->sql_close;
		return $result;
	}

	function insert_id($db) {
		$sql = "SELECT MAX(`cd_evaluadorespecialidad`) FROM evaluadorespecialidad ";
		$result = $db->sql_query ( $sql );
		$id = $db->sql_fetchrow ( $result, 0 );
		return ($id [0]);
	}

	function modificarEvaluadorespecialidad(Evaluadorespecialidad $obj) {
		$db = Db::conectar ();
		$cd_evaluadorespecialidad = $obj->getCd_evaluadorespecialidad();
		$cd_usuario = $obj->getCd_usuario();
		$cd_especialidad = $obj->getCd_especialidad();

		$sql = "UPDATE evaluadorespecialidad SET cd_usuario = $cd_usuario, cd_especialidad = $cd_especialidad WHERE cd_evaluadorespecialidad = $cd_evaluadorespecialidad";
		$result = $db->sql_query ( $sql );


		$db->sql_close;
		return $result;
	}

	function eliminarEvaluadorespecialidadPorUsuario(Evaluadorespecialidad $obj){
		$db = Db::conectar ();
		$cd_usuario = $obj->getCd_usuario ();
		$sql = "DELETE FROM evaluadorespecialidad WHERE cd_usuario = $cd_usuario";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}



}
?>