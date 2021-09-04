<?php

class FacultadQuery {
	function insertarFacultad(Facultad $obj) {
		$db = Db::conectar ();
		$ds_facultad = $obj->getDs_facultad ();
		$sql = "INSERT INTO facultad (ds_facultad) VALUES ('$ds_facultad') ";
		$result = $db->sql_query ( $sql );
		$id = FacultadQuery::insert_id ( $db );
		$obj->setCd_facultad ( $id );
		$db->sql_close;
		return $result;
	}

	function insert_id($db) {
		$sql = "SELECT MAX(`cd_facultad`) FROM facultad ";
		$result = $db->sql_query ( $sql );
		$id = $db->sql_fetchrow ( $result, 0 );
		return ($id [0]);
	}

	function listar($cd_facultad = "") {
		$db = Db::conectar (  );
		$sql = "SELECT cd_facultad, ds_facultad FROM facultad ORDER BY ds_facultad";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_facultad'] == $cd_facultad) {
					$res [$i] = array ('cd_facultad' => "'" . $usr ['cd_facultad'] . "' selected='selected'", 'ds_facultad' => $usr ['ds_facultad'] );
				} else {
					$res [$i] = array ('cd_facultad' => $usr ['cd_facultad'], 'ds_facultad' => $usr ['ds_facultad'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}

	function getFacultadPorid(Facultad $obj) {
		$db = Db::conectar (  );
		$cd_facultad = $obj->getCd_facultad ();
		$sql = "SELECT ds_facultad FROM facultad WHERE cd_facultad = $cd_facultad";
		$result = $db->sql_query ( $sql );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$obj->setDs_facultad ( $usr ['ds_facultad'] );
				$i ++;
			}
		}
		$db->sql_close;
		return ($result);
	}

	function getFacultades($attr, $orden, $filtro, $page, $row_per_page) {
		$db = Db::conectar ( );
		$limitInf = (($page - 1) * $row_per_page);
		$limitSup = ($page * $row_per_page);
		$sql = "SELECT cd_facultad, ds_facultad FROM facultad";
		$sql .= " WHERE ds_facultad LIKE '%$filtro%' ORDER BY $attr $orden LIMIT $limitInf,$row_per_page";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_facultad' => $usr ['cd_facultad'], 'ds_facultad' => $usr ['ds_facultad'] );
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}

	function getCountFacultades($filtro) {
		$db = Db::conectar ( );
		$sql = "SELECT count(*) FROM facultad P";
		$sql .= " WHERE P.ds_facultad LIKE '%$filtro%'";
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close;
		return (( int ) $cant);
	}

	function modificarFacultad(Facultad $obj) {
		$db = Db::conectar (  );
		$cd_facultad = $obj->getCd_facultad ();
		$ds_facultad = $obj->getDs_facultad ();
		$sql = "UPDATE facultad SET ds_facultad='$ds_facultad'";
		$sql .= " WHERE cd_facultad = $cd_facultad";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}

	function eliminarFacultad(Facultad $obj) {
		$db = Db::conectar ();
		$cd_facultad = $obj->getCd_facultad ();
		$sql = "DELETE FROM facultad WHERE cd_facultad = $cd_facultad";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}
}
?>