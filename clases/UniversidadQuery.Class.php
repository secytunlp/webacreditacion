<?php

class UniversidadQuery {


	function getUniversidadPorDs(Universidad $obj) {
		$db = Db::conectar (  );
		$ds_universidad = $obj->getDs_universidad ();
		if ($ds_universidad){
			$sql = "SELECT cd_universidad FROM universidad WHERE ds_universidad = '$ds_universidad'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_universidad ( $usr ['cd_universidad'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function listar($cd_universidad = "") {
		$db = Db::conectar (  );
		$sql = "SELECT cd_universidad, ds_universidad FROM universidad ORDER BY ds_universidad";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_universidad'] == $cd_universidad) {
					$res [$i] = array ('cd_universidad' => "'" . $usr ['cd_universidad'] . "' selected='selected'", 'ds_universidad' => $usr ['ds_universidad'] );
				} else {
					$res [$i] = array ('cd_universidad' => $usr ['cd_universidad'], 'ds_universidad' => $usr ['ds_universidad'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}

	function listarPorDs($ds_universidad) {
		$db = Db::conectar (  );
		$sql = "SELECT cd_universidad, ds_universidad FROM universidad where ds_universidad LIKE '%$ds_universidad%' ORDER BY ds_universidad";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_universidad' => $usr ['cd_universidad'], 'ds_universidad' => $usr ['ds_universidad'] );
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}


}
?>