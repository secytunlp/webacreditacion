<?php

class TipoinvestigadorQuery {


	function getTipoinvestigadorPorDs(Tipoinvestigador $obj) {
		$db = Db::conectar (  );
		$ds_tipoinvestigador = $obj->getDs_tipoinvestigador ();
		if ($ds_tipoinvestigador){
			$sql = "SELECT cd_tipoinvestigador FROM tipoinvestigador WHERE ds_tipoinvestigador = '$ds_tipoinvestigador'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_tipoinvestigador ( $usr ['cd_tipoinvestigador'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function listar($cd_tipoinvestigador = "", $sindirector=0, $sincordirector=0) {
		$db = Db::conectar (  );
		$sql = "SELECT cd_tipoinvestigador, ds_tipoinvestigador FROM tipoinvestigador ";
		$sql .= "WHERE 1=1 ";
		$sql .= ($sindirector)?" AND cd_tipoinvestigador <> 1 ":"";
		$sql .= ($sincordirector)?" AND cd_tipoinvestigador <> 2 ":"";
		$sql .= " ORDER BY cd_tipoinvestigador ";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_tipoinvestigador'] == $cd_tipoinvestigador) {
					$res [$i] = array ('cd_tipoinvestigador' => "'" . $usr ['cd_tipoinvestigador'] . "' selected='selected'", 'ds_tipoinvestigador' => $usr ['ds_tipoinvestigador'] );
				} else {
					$res [$i] = array ('cd_tipoinvestigador' => $usr ['cd_tipoinvestigador'], 'ds_tipoinvestigador' => $usr ['ds_tipoinvestigador'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}


}
?>