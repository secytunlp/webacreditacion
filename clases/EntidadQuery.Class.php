<?php

class EntidadQuery {


	function getEntidadPorDs(Entidad $obj) {
		$db = Db::conectar (  );
		$ds_entidad = $obj->getDs_entidad ();
		if ($ds_entidad){
			$sql = "SELECT cd_entidad, ds_codigo FROM entidad WHERE ds_entidad = '$ds_entidad'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_entidad ( $usr ['cd_entidad'] );
					$obj->setDs_codigo ( $usr ['ds_codigo'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function listar($cd_entidad = "") {
		$db = Db::conectar (  );
		$sql = "SELECT cd_entidad, ds_entidad, ds_codigo FROM entidad ORDER BY cd_entidad";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_entidad'] == $cd_entidad) {
					$res [$i] = array ('cd_entidad' => "'" . $usr ['cd_entidad'] . "' selected='selected'", 'ds_entidad' => $usr ['ds_entidad'], 'ds_codigo' => $usr ['ds_codigo'] );
				} else {
					$res [$i] = array ('cd_entidad' => $usr ['cd_entidad'], 'ds_entidad' => $usr ['ds_entidad'], 'ds_codigo' => $usr ['ds_codigo'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}


}
?>