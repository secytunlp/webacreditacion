<?php

class CampoQuery {


	function getCampoPorDs(Campo $obj) {
		$db = Db::conectar (  );
		$ds_campo = $obj->getDs_campo ();
		if ($ds_campo){
			$sql = "SELECT cd_campo, ds_codigo FROM campo WHERE ds_campo = '$ds_campo'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_campo ( $usr ['cd_campo'] );
					$obj->setDs_codigo ( $usr ['ds_codigo'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function listar($cd_campo = "") {
		$db = Db::conectar (  );
		$sql = "SELECT cd_campo, ds_campo, ds_codigo FROM campo ORDER BY ds_codigo";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_campo'] == $cd_campo) {
					$res [$i] = array ('cd_campo' => "'" . $usr ['cd_campo'] . "' selected='selected'", 'ds_campo' => $usr ['ds_codigo'].' - '.$usr ['ds_campo'] );
				} else {
					$res [$i] = array ('cd_campo' => $usr ['cd_campo'], 'ds_campo' => $usr ['ds_codigo'].' - '.$usr ['ds_campo'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}

	function getCamposPorDs($ds_campo) {
		$db = Db::conectar (  );
		$ds_campo = str_replace(' ','%',$ds_campo);
		$sql = "SELECT cd_campo, ds_campo, ds_codigo FROM campo WHERE ds_campo LIKE '%$ds_campo%' OR ds_codigo LIKE '%$ds_campo%'  ORDER BY ds_campo";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$ds_campo = ($usr ['ds_codigo'])?$usr ['ds_codigo'].' - '.$usr ['ds_campo']:$usr ['ds_campo'];

				$res [$i] = array ('cd_campo' => $usr ['cd_campo'], 'ds_campo' =>$ds_campo);


				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}

}
?>