<?php
class CronogramaQuery {
	
	
	function getCronogramas(Cronograma $cronograma) {
		$db = Db::conectar ();
		$cd_proyecto = $cronograma->getCd_proyecto();
		$nu_year = $cronograma->getNu_year();
		$sql = "Select * FROM cronograma WHERE cd_proyecto ='$cd_proyecto' AND nu_year ='$nu_year'";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_cronograma' => $usr ['cd_cronograma'], 'cd_proyecto' => $usr ['cd_proyecto'], 'nu_year' => $usr ['nu_year'], 'ds_actividad' => $usr ['ds_actividad'], 'bl_mes1' => $usr ['bl_mes1'], 'bl_mes2' => $usr ['bl_mes2'], 'bl_mes3' => $usr ['bl_mes3'], 'bl_mes4' => $usr ['bl_mes4'], 'bl_mes5' => $usr ['bl_mes5'], 'bl_mes6' => $usr ['bl_mes6'], 'bl_mes7' => $usr ['bl_mes7'], 'bl_mes8' => $usr ['bl_mes8'], 'bl_mes9' => $usr ['bl_mes9'], 'bl_mes10' => $usr ['bl_mes10'], 'bl_mes11' => $usr ['bl_mes11'], 'bl_mes12' => $usr ['bl_mes12'] );
				$i ++;
			}
		}
		$db->sql_close ();
		return ($res);
	}
	
	function insertarCronograma(Cronograma $obj) {
		$db = Db::conectar ();
		$cd_proyecto = $obj->getCd_proyecto();
		$nu_year = $obj->getNu_year();
		$ds_actividad = $obj->getDs_actividad();
		$bl_mes1 = $obj->getBl_mes1();
		$bl_mes2 = $obj->getBl_mes2();
		$bl_mes3 = $obj->getBl_mes3();
		$bl_mes4 = $obj->getBl_mes4();
		$bl_mes5 = $obj->getBl_mes5();
		$bl_mes6 = $obj->getBl_mes6();
		$bl_mes7 = $obj->getBl_mes7();
		$bl_mes8 = $obj->getBl_mes8();
		$bl_mes9 = $obj->getBl_mes9();
		$bl_mes10 = $obj->getBl_mes10();
		$bl_mes11 = $obj->getBl_mes11();
		$bl_mes12 = $obj->getBl_mes12();
		
		$sql = "INSERT INTO cronograma (cd_proyecto, nu_year, ds_actividad, bl_mes1, bl_mes2, bl_mes3, bl_mes4, bl_mes5, bl_mes6, bl_mes7, bl_mes8, bl_mes9, bl_mes10, bl_mes11, bl_mes12) VALUES ('$cd_proyecto', '$nu_year', '$ds_actividad', '$bl_mes1', '$bl_mes2', '$bl_mes3', '$bl_mes4', '$bl_mes5', '$bl_mes6', '$bl_mes7', '$bl_mes8', '$bl_mes9', '$bl_mes10', '$bl_mes11', '$bl_mes12') ";
		$result = $db->sql_query ( $sql );
		
		$id = CronogramaQuery::insert_id ( $db );
		$obj->setCd_cronograma ( $id );
		$db->sql_close;
		return $result;
	}
	
	function insert_id($db) {
		$sql = "SELECT MAX(`cd_cronograma`) FROM cronograma ";
		$result = $db->sql_query ( $sql );
		$id = $db->sql_fetchrow ( $result, 0 );
		return ($id [0]);
	}
	
	
	
	function eliminarCronogramaPorProyecto(Cronograma $obj) {
		$db = Db::conectar ();
		$cd_proyecto = $obj->getCd_proyecto();
		$sql = "DELETE FROM cronograma WHERE cd_proyecto = $cd_proyecto";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}
	
	function eliminarCronograma(Cronograma $obj) {
		$db = Db::conectar ();
		$cd_cronograma = $obj->getCd_cronograma();
		$sql = "DELETE FROM cronograma WHERE cd_cronograma = $cd_cronograma";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}
	
	
	
	
}
?>