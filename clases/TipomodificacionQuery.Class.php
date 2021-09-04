<?php

class TipomodificacionQuery {


	function getTipomodificacionPorDs(Tipomodificacion $obj) {
		$db = Db::conectar (  );
		$ds_tipomodificacion = $obj->getDs_tipomodificacion ();
		if ($ds_tipomodificacion){
			$sql = "SELECT cd_tipomodificacion FROM tipomodificacion WHERE ds_tipomodificacion = '$ds_tipomodificacion'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_tipomodificacion ( $usr ['cd_tipomodificacion'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function getTipomodificacionPorId(Tipomodificacion $obj) {
		$db = Db::conectar (  );
		$cd_tipomodificacion = $obj->getCd_tipomodificacion ();
		if ($cd_tipomodificacion){
			$sql = "SELECT ds_tipomodificacion FROM tipomodificacion WHERE cd_tipomodificacion = '$cd_tipomodificacion'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setDs_tipomodificacion ( $usr ['ds_tipomodificacion'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function listar($cd_tipomodificacion = "") {
		$db = Db::conectar (  );
		$sql = "SELECT cd_tipomodificacion, ds_tipomodificacion FROM tipomodificacion";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_tipomodificacion'] == $cd_tipomodificacion) {
					$res [$i] = array ('cd_tipomodificacion' => "'" . $usr ['cd_tipomodificacion'] . "' selected='selected'", 'ds_tipomodificacion' => $usr ['ds_tipomodificacion'] );
				} else {
					$res [$i] = array ('cd_tipomodificacion' => $usr ['cd_tipomodificacion'], 'ds_tipomodificacion' => $usr ['ds_tipomodificacion'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}

	function insertarTipomodificacion(Tipomodificacion $obj) {
		$db = Db::conectar ();

		$ds_tipomodificacion = $obj->getDs_tipomodificacion();

		$sql = "INSERT INTO tipomodificacion (ds_tipomodificacion) VALUES ('$ds_tipomodificacion') ";
		$result = $db->sql_query ( $sql );
		$id = TipomodificacionQuery::insert_id ( $db );
		$obj->setCd_tipomodificacion ( $id );
		$db->sql_close;
		return $result;
	}

	function insert_id($db) {
		$sql = "SELECT MAX(`cd_tipomodificacion`) FROM tipomodificacion ";
		$result = $db->sql_query ( $sql );
		$id = $db->sql_fetchrow ( $result, 0 );
		return ($id [0]);
	}


}
?>