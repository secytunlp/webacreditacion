<?php

class TipoacreditacionQuery {


	function getTipoacreditacionPorDs(Tipoacreditacion $obj) {
		$db = Db::conectar (  );
		$ds_tipoacreditacion = $obj->getDs_tipoacreditacion ();
		if ($ds_tipoacreditacion){
			$sql = "SELECT cd_tipoacreditacion FROM tipoacreditacion WHERE ds_tipoacreditacion = '$ds_tipoacreditacion'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_tipoacreditacion ( $usr ['cd_tipoacreditacion'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function getTipoacreditacionPorCd(Tipoacreditacion $obj) {
		$db = Db::conectar (  );
		$cd_tipoacreditacion = $obj->getCd_tipoacreditacion ();
		if ($cd_tipoacreditacion){
			$sql = "SELECT ds_tipoacreditacion FROM tipoacreditacion WHERE cd_tipoacreditacion = '$cd_tipoacreditacion'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setDs_tipoacreditacion ( $usr ['ds_tipoacreditacion'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function listar($cd_tipoacreditacion = "", $sindirector=0) {
		$db = Db::conectar (  );
		$sql = "SELECT cd_tipoacreditacion, ds_tipoacreditacion FROM tipoacreditacion ";
		$sql .= " WHERE cd_tipoacreditacion <> 3 ";
		$sql .= ($sindirector)?" AND cd_tipoacreditacion <> 1 ":"";
		$sql .= " ORDER BY cd_tipoacreditacion ";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_tipoacreditacion'] == $cd_tipoacreditacion) {
					$res [$i] = array ('cd_tipoacreditacion' => "'" . $usr ['cd_tipoacreditacion'] . "' selected='selected'", 'ds_tipoacreditacion' => $usr ['ds_tipoacreditacion'] );
				} else {
					$res [$i] = array ('cd_tipoacreditacion' => $usr ['cd_tipoacreditacion'], 'ds_tipoacreditacion' => $usr ['ds_tipoacreditacion'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}


}
?>