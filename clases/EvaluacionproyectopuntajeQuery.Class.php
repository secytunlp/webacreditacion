<?php

class EvaluacionproyectopuntajeQuery {

	function getEvaluacionproyectopuntajePorEvaluacion(Evaluacionproyectopuntaje $obj) {
		$db = Db::conectar (  );
		$cd_evaluacion = $obj->getCd_evaluacion();
		$cd_evaluacionproyectoplanilla = $obj->getCd_evaluacionproyectoplanilla();
		if ($cd_evaluacion){
			$sql = "SELECT cd_evaluacionproyectopuntaje, cd_evaluacionproyectoplanilla, nu_puntaje FROM evaluacionproyectopuntaje WHERE cd_evaluacion = '$cd_evaluacion' AND cd_evaluacionproyectoplanilla = '$cd_evaluacionproyectoplanilla'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_evaluacionproyectopuntaje ( $usr ['cd_evaluacionproyectopuntaje'] );
						
					$obj->setNu_puntaje ( $usr ['nu_puntaje'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}


	function insertEvaluacionproyectopuntaje(Evaluacionproyectopuntaje $obj) {
		$db = Db::conectar ();
		$cd_evaluacion = $obj->getCd_evaluacion();
		$cd_evaluacionproyectoplanilla = $obj->getCd_evaluacionproyectoplanilla();
		$nu_puntaje = $obj->getNu_puntaje();
		$sql = "INSERT INTO evaluacionproyectopuntaje (cd_evaluacion, cd_evaluacionproyectoplanilla, nu_puntaje) VALUES ('$cd_evaluacion', '$cd_evaluacionproyectoplanilla', '$nu_puntaje') ";
		$result = $db->sql_query ( $sql );

		$id = EvaluacionproyectopuntajeQuery::insert_id ( $db );
		$obj->setCd_evaluacionproyectopuntaje ( $id );
		$db->sql_close;
		return $result;
	}

	function insert_id($db) {
		$sql = "SELECT MAX(`cd_evaluacionproyectopuntaje`) FROM evaluacionproyectopuntaje ";
		$result = $db->sql_query ( $sql );
		$id = $db->sql_fetchrow ( $result, 0 );
		return ($id [0]);
	}

	function modificarEvaluacionproyectopuntaje(Evaluacionproyectopuntaje $obj) {
		$db = Db::conectar ();
		$cd_evaluacionproyectopuntaje = $obj->getCd_evaluacionproyectopuntaje();
		$cd_evaluacion = $obj->getCd_evaluacion();
		$cd_evaluacionproyectoplanilla = $obj->getCd_evaluacionproyectoplanilla();
		$nu_puntaje = $obj->getNu_puntaje();
		$sql = "UPDATE evaluacionproyectopuntaje SET cd_evaluacion = $cd_evaluacion, cd_evaluacionproyectoplanilla = $cd_evaluacionproyectoplanilla, nu_puntaje = $nu_puntaje WHERE cd_evaluacionproyectopuntaje = $cd_evaluacionproyectopuntaje";
		$result = $db->sql_query ( $sql );


		$db->sql_close;
		return $result;
	}

	function eliminarEvaluacionproyectopuntajePorEvaluacion(Evaluacionproyectopuntaje $obj){
		$db = Db::conectar ();
		$cd_evaluacion = $obj->getCd_evaluacion ();
		$sql = "DELETE FROM evaluacionproyectopuntaje WHERE cd_evaluacion = $cd_evaluacion";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}



}
?>