<?php

class EspecialidadQuery {


	function getEspecialidadPorDs(Especialidad $obj) {
		$db = Db::conectar (  );
		$ds_especialidad = $obj->getDs_especialidad ();
		if ($ds_especialidad){
			$sql = "SELECT cd_especialidad, ds_codigo, cd_disciplina FROM especialidad WHERE ds_especialidad = '$ds_especialidad'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_especialidad ( $usr ['cd_especialidad'] );
					$obj->setDs_codigo ( $usr ['ds_codigo'] );
					$obj->setCd_disciplina ( $usr ['cd_disciplina'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function listar($cd_especialidad = "", $cd_disciplina = 0) {
		$db = Db::conectar (  );
		$sql = "SELECT cd_especialidad, ds_especialidad, ds_codigo FROM especialidad WHERE cd_disciplina = $cd_disciplina ORDER BY ds_codigo";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_especialidad'] == $cd_especialidad) {
					$res [$i] = array ('cd_especialidad' => "'" . $usr ['cd_especialidad'] . "' selected='selected'", 'ds_especialidad' => $usr ['ds_codigo'].' - '.$usr ['ds_especialidad'] );
				} else {
					$res [$i] = array ('cd_especialidad' => $usr ['cd_especialidad'], 'ds_especialidad' => $usr ['ds_codigo'].' - '.$usr ['ds_especialidad']);
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}

	function getEspecialidadesPorDs($ds_especialidad, $cd_disciplina) {
		$db = Db::conectar (  );
		$ds_especialidad = str_replace(' ','%',$ds_especialidad);
		$sql = "SELECT cd_especialidad, ds_especialidad, ds_codigo FROM especialidad WHERE cd_disciplina = $cd_disciplina AND (ds_especialidad LIKE '%$ds_especialidad%' OR ds_codigo LIKE '%$ds_especialidad%')  ORDER BY ds_especialidad";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$ds_especialidad = ($usr ['ds_codigo'])?$usr ['ds_codigo'].' - '.$usr ['ds_especialidad']:$usr ['ds_especialidad'];

				$res [$i] = array ('cd_especialidad' => $usr ['cd_especialidad'], 'ds_especialidad' =>$ds_especialidad);


				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}

	function getEspecialidades($ds_especialidad) {
		$db = Db::conectar (  );
		$ds_especialidad = str_replace(' ','%',$ds_especialidad);
		$sql = "SELECT cd_especialidad, ds_especialidad, ds_codigo FROM especialidad WHERE (ds_especialidad LIKE '%$ds_especialidad%' OR ds_codigo LIKE '%$ds_especialidad%')  ORDER BY ds_especialidad";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$ds_especialidad = ($usr ['ds_codigo'])?$usr ['ds_codigo'].' - '.$usr ['ds_especialidad']:$usr ['ds_especialidad'];

				$res [$i] = array ('cd_especialidad' => $usr ['cd_especialidad'], 'ds_especialidad' =>$ds_especialidad);


				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}


}
?>