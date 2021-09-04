<?php

class CarrerainvQuery {


	function getCarrerainvPorDs(Carrerainv $obj) {
		$db = Db::conectar (  );
		$ds_carrerainv = $obj->getDs_carrerainv ();
		if ($ds_carrerainv){
			$sql = "SELECT cd_carrerainv FROM carrerainv WHERE ds_carrerainv = '$ds_carrerainv'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_carrerainv ( $usr ['cd_carrerainv'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function listar($cd_carrerainv = "") {
		$db = Db::conectar (  );
		$sql = "SELECT cd_carrerainv, ds_carrerainv FROM carrerainv ORDER BY cd_carrerainv";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_carrerainv'] == $cd_carrerainv) {
					$res [$i] = array ('cd_carrerainv' => "'" . $usr ['cd_carrerainv'] . "' selected='selected'", 'ds_carrerainv' => $usr ['ds_carrerainv'] );
				} else {
					$res [$i] = array ('cd_carrerainv' => $usr ['cd_carrerainv'], 'ds_carrerainv' => $usr ['ds_carrerainv'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}


}
?>