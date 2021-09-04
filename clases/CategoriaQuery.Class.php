<?php

class CategoriaQuery {


	function getCategoriaPorDs(Categoria $obj) {
		$db = Db::conectar (  );
		$ds_categoria = $obj->getDs_categoria ();
		if ($ds_categoria){
			$sql = "SELECT cd_categoria FROM categoria WHERE ds_categoria = '$ds_categoria'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_categoria ( $usr ['cd_categoria'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function getCategoriaPorId(Categoria $obj) {
		$db = Db::conectar (  );
		$cd_categoria = $obj->getCd_categoria ();
		if ($cd_categoria){
			$sql = "SELECT ds_categoria FROM categoria WHERE cd_categoria = '$cd_categoria'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setDs_categoria ( $usr ['ds_categoria'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function listar($cd_categoria = "") {
		$db = Db::conectar (  );
		$sql = "SELECT cd_categoria, ds_categoria FROM categoria ORDER BY cd_categoria";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_categoria'] == $cd_categoria) {
					$res [$i] = array ('cd_categoria' => "'" . $usr ['cd_categoria'] . "' selected='selected'", 'ds_categoria' => $usr ['ds_categoria'] );
				} else {
					$res [$i] = array ('cd_categoria' => $usr ['cd_categoria'], 'ds_categoria' => $usr ['ds_categoria'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}


}
?>