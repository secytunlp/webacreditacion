<?php
class FinanciamientoitemQuery {
	
	
	function getFinanciamientoitems(Financiamientoitem $financiamientoitem) {
		$db = Db::conectar ();
		$cd_proyecto = $financiamientoitem->getCd_proyecto();
		$cd_tipo = $financiamientoitem->getCd_tipo();
		$nu_year = $financiamientoitem->getNu_year();
		$sql = "Select * FROM financiamientoitem WHERE cd_proyecto ='$cd_proyecto' AND cd_tipo = '$cd_tipo' AND nu_year = '$nu_year'";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_financiamientoitem' => $usr ['cd_financiamientoitem'], 'cd_proyecto' => $usr ['cd_proyecto'], 'nu_year' => $usr ['nu_year'], 'nu_monto' => $usr ['nu_monto'], 'cd_tipo' => $usr ['cd_tipo'], 'ds_concepto' => $usr ['ds_concepto']);
				$i ++;
			}
		}
		$db->sql_close ();
		return ($res);
	}
	
	function insertarFinanciamientoitem(Financiamientoitem $obj) {
		$db = Db::conectar ();
		$cd_proyecto = $obj->getCd_proyecto();
		$nu_year = $obj->getNu_year();
		$nu_monto = $obj->getNu_monto();
		$cd_tipo = $obj->getCd_tipo();
		$ds_concepto = $obj->getDs_concepto();
		
		
		$sql = "INSERT INTO financiamientoitem (cd_proyecto, nu_year, nu_monto, cd_tipo, ds_concepto) VALUES ('$cd_proyecto', '$nu_year', '$nu_monto', '$cd_tipo', '$ds_concepto') ";
		$result = $db->sql_query ( $sql );
		
		$id = FinanciamientoitemQuery::insert_id ( $db );
		$obj->setCd_financiamientoitem ( $id );
		$db->sql_close;
		return $result;
	}
	
	function insert_id($db) {
		$sql = "SELECT MAX(`cd_financiamientoitem`) FROM financiamientoitem ";
		$result = $db->sql_query ( $sql );
		$id = $db->sql_fetchrow ( $result, 0 );
		return ($id [0]);
	}
	
	
	
	function eliminarFinanciamientoitemPorProyecto(Financiamientoitem $obj) {
		$db = Db::conectar ();
		$cd_proyecto = $obj->getCd_proyecto();
		$sql = "DELETE FROM financiamientoitem WHERE cd_proyecto = $cd_proyecto";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}
	
	function eliminarFinanciamientoitem(Financiamientoitem $obj) {
		$db = Db::conectar ();
		$cd_financiamientoitem = $obj->getCd_financiamientoitem();
		$sql = "DELETE FROM financiamientoitem WHERE cd_financiamientoitem = $cd_financiamientoitem";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}
	
	
	
	
}
?>