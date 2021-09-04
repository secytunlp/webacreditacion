<?php

class DisciplinaQuery {


	function getDisciplinaPorDs(Disciplina $obj) {
		$db = Db::conectar (  );
		$ds_disciplina = $obj->getDs_disciplina ();
		if ($ds_disciplina){
			$sql = "SELECT cd_disciplina, ds_codigo FROM disciplina WHERE ds_disciplina = '$ds_disciplina'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_disciplina ( $usr ['cd_disciplina'] );
					$obj->setDs_codigo ( $usr ['ds_codigo'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function listar($cd_disciplina = "") {
		$db = Db::conectar (  );
		$sql = "SELECT cd_disciplina, ds_disciplina, ds_codigo FROM disciplina ORDER BY ds_codigo";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_disciplina'] == $cd_disciplina) {
					$res [$i] = array ('cd_disciplina' => "'" . $usr ['cd_disciplina'] . "' selected='selected'", 'ds_disciplina' => $usr ['ds_codigo'].' - '.$usr ['ds_disciplina'] );
				} else {
					$res [$i] = array ('cd_disciplina' => $usr ['cd_disciplina'], 'ds_disciplina' => $usr ['ds_codigo'].' - '.$usr ['ds_disciplina']);
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}

	function getDisciplinasPorDs($ds_disciplina) {
		$db = Db::conectar (  );
		$ds_disciplina = str_replace(' ','%',$ds_disciplina);
		$sql = "SELECT cd_disciplina, ds_disciplina, ds_codigo FROM disciplina WHERE ds_disciplina LIKE '%$ds_disciplina%' OR ds_codigo LIKE '%$ds_disciplina%'  ORDER BY ds_disciplina";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$ds_disciplina = ($usr ['ds_codigo'])?$usr ['ds_codigo'].' - '.$usr ['ds_disciplina']:$usr ['ds_disciplina'];

				$res [$i] = array ('cd_disciplina' => $usr ['cd_disciplina'], 'ds_disciplina' =>$ds_disciplina);


				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}


}
?>