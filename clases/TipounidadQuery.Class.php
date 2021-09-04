<?php

class TipounidadQuery {


	function getTipounidadPorDs(Tipounidad $obj) {
		$db = Db::conectar (  );
		$ds_tipounidad = $obj->getDs_tipounidad ();
		if ($ds_tipounidad){
			$sql = "SELECT cd_tipounidad FROM tipounidad WHERE ds_tipounidad = '$ds_tipounidad'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_tipounidad ( $usr ['cd_tipounidad'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function getTipounidadPorId(Tipounidad $obj) {
		$db = Db::conectar (  );
		$cd_tipounidad = $obj->getCd_tipounidad ();
		if ($cd_tipounidad){
			$sql = "SELECT ds_tipounidad FROM tipounidad WHERE cd_tipounidad = '$cd_tipounidad'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setDs_tipounidad ( $usr ['ds_tipounidad'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function listar($cd_tipounidad = "") {
		$db = Db::conectar (  );
		$sql = "SELECT cd_tipounidad, ds_tipounidad FROM tipounidad ORDER BY cd_tipounidad";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_tipounidad'] == $cd_tipounidad) {
					$res [$i] = array ('cd_tipounidad' => "'" . $usr ['cd_tipounidad'] . "' selected='selected'", 'ds_tipounidad' => $usr ['ds_tipounidad'] );
				} else {
					$res [$i] = array ('cd_tipounidad' => $usr ['cd_tipounidad'], 'ds_tipounidad' => $usr ['ds_tipounidad'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}


}
?>