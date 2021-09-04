<?php

class EvaluacionproyectoplanillaQuery {


	function getEvaluacionproyectoplanillaPorSubgrupo(Evaluacionproyectoplanilla $obj) {
		$db = Db::conectar (  );

		$cd_subgrupo = $obj->getCd_subgrupo();


		$sql = "SELECT EPP.*, ds_subgrupo FROM evaluacionproyectoplanilla EPP INNER JOIN evaluacionproyectosubgrupo EPS ON EPP.cd_subgrupo = EPS.cd_subgrupo WHERE EPP.cd_subgrupo = '$cd_subgrupo'";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_evaluacionproyectoplanilla' => $usr ['cd_evaluacionproyectoplanilla'], 'ds_evaluacionproyectoplanilla' => $usr ['ds_evaluacionproyectoplanilla'], 'cd_subgrupo' => $usr ['cd_subgrupo'], 'ds_letra' => $usr ['ds_letra'], 'ds_subgrupo' => $usr ['ds_subgrupo'] );
				$i ++;
			}
		}
		$db->sql_close ();
		return ($res);
			
	}
	
	function getEvaluacionproyectoPPIDplanillaPorSubgrupo(Evaluacionproyectoplanilla $obj) {
		$db = Db::conectar (  );

		$cd_subgrupo = $obj->getCd_subgrupo();


		$sql = "SELECT EPP.*, ds_subgrupo FROM evaluacionproyectoplanillappid EPP INNER JOIN evaluacionproyectosubgrupo EPS ON EPP.cd_subgrupo = EPS.cd_subgrupo WHERE EPP.cd_subgrupo = '$cd_subgrupo'";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_evaluacionproyectoplanilla' => $usr ['cd_evaluacionproyectoplanilla'], 'ds_evaluacionproyectoplanilla' => $usr ['ds_evaluacionproyectoplanilla'], 'cd_subgrupo' => $usr ['cd_subgrupo'], 'ds_letra' => $usr ['ds_letra'], 'ds_subgrupo' => $usr ['ds_subgrupo'] );
				$i ++;
			}
		}
		$db->sql_close ();
		return ($res);
			
	}


	function ultimo_id() {
		$db = Db::conectar (  );
		$sql = "SELECT MAX(`cd_evaluacionproyectoplanilla`) FROM evaluacionproyectoplanilla ";
		$result = $db->sql_query ( $sql );
		$id = $db->sql_fetchrow ( $result, 0 );
		return ($id [0]);
	}
	
	function ultimo_idPPID() {
		$db = Db::conectar (  );
		$sql = "SELECT MAX(`cd_evaluacionproyectoplanilla`) FROM evaluacionproyectoplanillappid ";
		$result = $db->sql_query ( $sql );
		$id = $db->sql_fetchrow ( $result, 0 );
		return ($id [0]);
	}





}
?>