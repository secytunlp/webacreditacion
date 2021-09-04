<?php

class PerfilQuery {
	function insertarPerfil(Perfil $obj) {
		$db = Db::conectar ();
		$ds_perfil = $obj->getDs_perfil ();
		$sql = "INSERT INTO perfilproyecto (ds_perfil) VALUES ('$ds_perfil') ";
		$result = $db->sql_query ( $sql );
		$id = PerfilQuery::insert_id ( $db );
		$obj->setCd_perfil ( $id );
		$db->sql_close;
		return $result;
	}

	function insert_id($db) {
		$sql = "SELECT MAX(`cd_perfil`) FROM perfilproyecto ";
		$result = $db->sql_query ( $sql );
		$id = $db->sql_fetchrow ( $result, 0 );
		return ($id [0]);
	}

	function listarPerfiles(Array $perfiles) {
		$db = Db::conectar ();
		$sql = "SELECT cd_perfil, ds_perfil FROM perfilproyecto ORDER BY ds_perfil";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if (in_array ( ( int ) $usr ['cd_perfil'], $perfiles )) {
					$res [$i] = array ('cd_perfil' => "'" . $usr ['cd_perfil'] . "'  checked", 'ds_perfil' => $usr ['ds_perfil'] );
				} else {
					$res [$i] = array ('cd_perfil' => "'".$usr ['cd_perfil']."'", 'ds_perfil' => $usr ['ds_perfil'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}

	function listar($cd_perfil = "") {
		$db = Db::conectar (  );
		$sql = "SELECT cd_perfil, ds_perfil FROM perfilproyecto";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_perfil'] == $cd_perfil) {
					$res [$i] = array ('cd_perfil' => "'" . $usr ['cd_perfil'] . "' selected='selected'", 'ds_perfil' => $usr ['ds_perfil'] );
				} else {
					$res [$i] = array ('cd_perfil' => $usr ['cd_perfil'], 'ds_perfil' => $usr ['ds_perfil'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}

	function getPerfilPorid(Perfil $obj) {
		$db = Db::conectar (  );
		$cd_perfil = $obj->getCd_perfil ();
		$sql = "SELECT ds_perfil FROM perfilproyecto WHERE cd_perfil = $cd_perfil";
		$result = $db->sql_query ( $sql );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$obj->setDs_perfil ( $usr ['ds_perfil'] );
				$i ++;
			}
		}
		$db->sql_close;
		return ($result);
	}

	function getPerfiles($attr, $orden, $filtro, $page, $row_per_page) {
		$db = Db::conectar ( );
		$limitInf = (($page - 1) * $row_per_page);
		$limitSup = ($page * $row_per_page);
		$sql = "SELECT cd_perfil, ds_perfil FROM perfilproyecto";
		$sql .= " WHERE ds_perfil LIKE '%$filtro%' ORDER BY $attr $orden LIMIT $limitInf,$row_per_page";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_perfil' => $usr ['cd_perfil'], 'ds_perfil' => $usr ['ds_perfil'] );
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}

	function getCountPerfiles($filtro) {
		$db = Db::conectar ( );
		$sql = "SELECT count(*) FROM perfilproyecto P";
		$sql .= " WHERE P.ds_perfil LIKE '%$filtro%'";
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close;
		return (( int ) $cant);
	}

	function modificarPerfil(Perfil $obj) {
		$db = Db::conectar (  );
		$cd_perfil = $obj->getCd_perfil ();
		$ds_perfil = $obj->getDs_perfil ();
		$sql = "UPDATE perfilproyecto SET ds_perfil='$ds_perfil'";
		$sql .= " WHERE cd_perfil = $cd_perfil";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}

	function eliminarPerfil(Perfil $obj) {
		$db = Db::conectar ();
		$cd_perfil = $obj->getCd_perfil ();
		$sql = "DELETE FROM perfilproyecto WHERE cd_perfil = $cd_perfil";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}
}
?>