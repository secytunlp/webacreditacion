<?php

class ProvinciaQuery {


	function getProvinciaPorDs(Provincia $obj) {
		$db = Db::conectar (  );
		$ds_provincia = $obj->getDs_provincia ();
		if ($ds_provincia){
			$sql = "SELECT cd_provincia FROM provincia WHERE ds_provincia = '$ds_provincia'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_provincia ( $usr ['cd_provincia'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function listar($cd_provincia = "") {
		$db = Db::conectar (  );
		$sql = "SELECT cd_provincia, ds_provincia FROM provincia ORDER BY ds_provincia";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_provincia'] == $cd_provincia) {
					$res [$i] = array ('cd_provincia' => "'" . $usr ['cd_provincia'] . "' selected='selected'", 'ds_provincia' => $usr ['ds_provincia'] );
				} else {
					$res [$i] = array ('cd_provincia' => $usr ['cd_provincia'], 'ds_provincia' => $usr ['ds_provincia'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}


}
?>