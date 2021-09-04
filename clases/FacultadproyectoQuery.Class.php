<?php
class FacultadproyectoQuery {

	function getFacultadproyecto(Facultadproyecto $facultadproyecto) {
		$db = Db::conectar ();
		$cd_proyecto = $facultadproyecto->getCd_proyecto();
		//$cd_tipoevaluador = $proyectoevaluador->getCd_tipoevaluador();
		$sql = "Select cd_facultadproyecto, cd_facultad, cd_proyecto FROM facultadproyecto WHERE cd_proyecto ='$cd_proyecto' ";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_facultadevaluador' => $usr ['cd_facultadevaluador'], 'cd_facultad' => $usr ['cd_facultad'], 'cd_proyecto' => $usr ['cd_proyecto'] );
				$i ++;
			}
		}
		$db->sql_close ();
		return ($res);
	}


	function insertarFacultadproyecto(Facultadproyecto $obj) {
		$db = Db::conectar ();
		$cd_facultad = $obj->getCd_facultad();
		$cd_proyecto = $obj->getCd_proyecto();


		$sql = "INSERT INTO facultadproyecto (cd_facultad, cd_proyecto) VALUES ('$cd_facultad', '$cd_proyecto') ";
		$result = $db->sql_query ( $sql );

		$id = FacultadproyectoQuery::insert_id ( $db );
		$obj->setCd_facultadproyecto ( $id );
		$db->sql_close;
		return $result;
	}

	function insert_id($db) {
		$sql = "SELECT MAX(`cd_facultadproyecto`) FROM facultadproyecto ";
		$result = $db->sql_query ( $sql );
		$id = $db->sql_fetchrow ( $result, 0 );
		return ($id [0]);
	}



	function eliminarFacultadproyectoPorFacultad(Facultadproyecto $obj) {
		$db = Db::conectar ();
		$cd_proyecto = $obj->getCd_proyecto();
		$sql = "DELETE FROM facultadproyecto WHERE cd_proyecto = $cd_proyecto";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}
	
	





}
?>