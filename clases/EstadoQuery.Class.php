<?php

class EstadoQuery {


	function getEstadoPorDs(Estado $obj) {
		$db = Db::conectar (  );
		$ds_estado = $obj->getDs_estado ();
		if ($ds_estado){
			$sql = "SELECT cd_estado FROM estadoproyecto WHERE ds_estado = '$ds_estado'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_estado ( $usr ['cd_estado'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function listar($cd_estado = "") {
		$db = Db::conectar (  );
		$sql = "SELECT cd_estado, ds_estado FROM estadoproyecto ORDER BY cd_estado";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_estado'] == $cd_estado) {
					$res [$i] = array ('cd_estado' => "'" . $usr ['cd_estado'] . "' selected='selected'", 'ds_estado' => $usr ['ds_estado'] );
				} else {
					$res [$i] = array ('cd_estado' => $usr ['cd_estado'], 'ds_estado' => $usr ['ds_estado'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}


}
?>