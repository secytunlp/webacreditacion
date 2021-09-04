<?php

class FuncionQuery {
	function insertFuncion(Funcion $obj) {
		$cd_funcion = $obj->getCd_funcion ();
		$ds_funcion = $obj->getDs_funcion ();
		$sql = "INSERT INTO funcionproyecto ('cd_funcion' ,'ds_funcion') VALUES ('$cd_funcion' ,'$ds_funcion') ";
		mysql_query ( $sql );
	}

	function listarFunciones(Array $funciones) {
		$db = Db::conectar ();
		$sql = "SELECT cd_funcion, ds_funcion FROM funcionproyecto ORDER BY ds_funcion";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if (in_array ( ( int ) $usr ['cd_funcion'], $funciones )) {
					$res [$i] = array ('cd_funcion' => "'" . $usr ['cd_funcion'] . "'  checked", 'ds_funcion' => $usr ['ds_funcion'] );
				} else {
					$res [$i] = array ('cd_funcion' => "'".$usr ['cd_funcion']."'", 'ds_funcion' => $usr ['ds_funcion'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}

	function listar($cd_usuario, $cd_funcion = "") {
		$db = Db::conectar (  );
		$sql = "SELECT F.cd_funcion, ds_funcion FROM funcionproyecto F ORDER BY ds_funcion";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_funcion'] == $cd_funcion) {
					$res [$i] = array ('cd_funcion' => "'" . $usr ['cd_funcion'] . "' selected='selected'", 'ds_funcion' => $usr ['ds_funcion'] );
				} else {
					$res [$i] = array ('cd_funcion' => $usr ['cd_funcion'], 'ds_funcion' => $usr ['ds_funcion'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}


	function getDs_funcion(Funcion $obj) {
		$db = Db::conectar ();
		$cd_funcion = $obj->getCd_funcion ();
		$sql = "SELECT ds_funcion FROM funcionproyecto WHERE cd_funcion = $cd_funcion";
		$result = $db->sql_query ( $sql );
		if ($db->sql_numrows () > 0) {
			$usr = $db->sql_fetchassoc ( $result );
			$res = $usr ['ds_funcion'];
		}
		$db->sql_close ();
		return $res;
	}

	function getFuncionPorDs(Funcion $obj) {
		$db = Db::conectar (  );
		$ds_funcion = $obj->getDs_funcion ();
		if ($ds_funcion){
			$sql = "SELECT cd_funcion FROM funcionproyecto WHERE ds_funcion = '$ds_funcion'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_funcion ( $usr ['cd_funcion'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function listarCheckFunciones() {
		$db = Db::conectar ();
		$sql = "SELECT cd_funcion, ds_funcion FROM funcionproyecto ORDER BY ds_funcion";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_funcion' => $usr ['cd_funcion'], 'ds_funcion' => $usr ['ds_funcion'] );
				$i ++;
			}
		}
		$db->sql_close ();
		return $res;
	}
}
?>