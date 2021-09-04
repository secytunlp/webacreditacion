<?php

class DeddocQuery {


	function getDeddocPorDs(Deddoc $obj) {
		$db = Db::conectar (  );
		$ds_deddoc = $obj->getDs_deddoc ();
		if ($ds_deddoc){
			$sql = "SELECT cd_deddoc FROM deddoc WHERE ds_deddoc = '$ds_deddoc'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_deddoc ( $usr ['cd_deddoc'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function listar($cd_deddoc = "") {
		$db = Db::conectar (  );
		$sql = "SELECT cd_deddoc, ds_deddoc FROM deddoc ORDER BY cd_deddoc";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_deddoc'] == $cd_deddoc) {
					$res [$i] = array ('cd_deddoc' => "'" . $usr ['cd_deddoc'] . "' selected='selected'", 'ds_deddoc' => $usr ['ds_deddoc'] );
				} else {
					$res [$i] = array ('cd_deddoc' => $usr ['cd_deddoc'], 'ds_deddoc' => $usr ['ds_deddoc'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}


}
?>