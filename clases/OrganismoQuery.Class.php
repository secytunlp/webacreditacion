<?php

class OrganismoQuery {


	function getOrganismoPorDs(Organismo $obj) {
		$db = Db::conectar (  );
		$ds_organismo = $obj->getDs_organismo ();
		if ($ds_organismo){
			$sql = "SELECT cd_organismo FROM organismo WHERE ds_organismo = '$ds_organismo'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_organismo ( $usr ['cd_organismo'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function listar($cd_organismo = "") {
		$db = Db::conectar (  );
		$sql = "SELECT cd_organismo, ds_organismo FROM organismo ORDER BY cd_organismo";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_organismo'] == $cd_organismo) {
					$res [$i] = array ('cd_organismo' => "'" . $usr ['cd_organismo'] . "' selected='selected'", 'ds_organismo' => $usr ['ds_organismo'] );
				} else {
					$res [$i] = array ('cd_organismo' => $usr ['cd_organismo'], 'ds_organismo' => $usr ['ds_organismo'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}


}
?>