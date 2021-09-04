<?php
class FinanciamientoanteriorQuery {
	
	
	function getFinanciamientoanteriors(Financiamientoanterior $financiamientoanterior) {
		$db = Db::conectar ();
		$cd_proyecto = $financiamientoanterior->getCd_proyecto();
		
		$sql = "Select * FROM financiamientoanterior WHERE cd_proyecto ='$cd_proyecto'";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_financiamientoanterior' => $usr ['cd_financiamientoanterior'], 'cd_proyecto' => $usr ['cd_proyecto'], 'nu_year' => $usr ['nu_year'], 'nu_unlp' => $usr ['nu_unlp'], 'nu_nacionales' => $usr ['nu_nacionales'], 'nu_extranjeras' => $usr ['nu_extranjeras']);
				$i ++;
			}
		}
		$db->sql_close ();
		return ($res);
	}
	
	function insertarFinanciamientoanterior(Financiamientoanterior $obj) {
		$db = Db::conectar ();
		$cd_proyecto = $obj->getCd_proyecto();
		$nu_year = $obj->getNu_year();
		$nu_unlp = $obj->getNu_unlp();
		$nu_nacionales = $obj->getNu_nacionales();
		$nu_extranjeras = $obj->getNu_extranjeras();
		
		
		$sql = "INSERT INTO financiamientoanterior (cd_proyecto, nu_year, nu_unlp, nu_nacionales, nu_extranjeras) VALUES ('$cd_proyecto', '$nu_year', '$nu_unlp', '$nu_nacionales', '$nu_extranjeras') ";
		$result = $db->sql_query ( $sql );
		
		$id = FinanciamientoanteriorQuery::insert_id ( $db );
		$obj->setCd_financiamientoanterior ( $id );
		$db->sql_close;
		return $result;
	}
	
	function insert_id($db) {
		$sql = "SELECT MAX(`cd_financiamientoanterior`) FROM financiamientoanterior ";
		$result = $db->sql_query ( $sql );
		$id = $db->sql_fetchrow ( $result, 0 );
		return ($id [0]);
	}
	
	
	
	function eliminarFinanciamientoanteriorPorProyecto(Financiamientoanterior $obj) {
		$db = Db::conectar ();
		$cd_proyecto = $obj->getCd_proyecto();
		$sql = "DELETE FROM financiamientoanterior WHERE cd_proyecto = $cd_proyecto";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}
	
	function eliminarFinanciamientoanterior(Financiamientoanterior $obj) {
		$db = Db::conectar ();
		$cd_financiamientoanterior = $obj->getCd_financiamientoanterior();
		$sql = "DELETE FROM financiamientoanterior WHERE cd_financiamientoanterior = $cd_financiamientoanterior";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}
	
	
	
	
}
?>