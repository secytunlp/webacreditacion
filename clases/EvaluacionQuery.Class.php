<?php

class EvaluacionQuery {


	function getEvaluacionPorProyectoEvaluador(Evaluacion $obj) {
		$db = Db::conectar (  );
		$cd_usuario = $obj->getCd_usuario();
		$cd_proyecto = $obj->getCd_proyecto();
		if (($cd_usuario)&&($cd_proyecto)){
			$sql = "SELECT cd_evaluacion, EP.cd_estado, dt_fecha, nu_puntaje, bl_interno, ds_observacion, ds_observacionsecyt, ds_estado FROM evaluacionproyecto EP INNER JOIN estadoproyecto E ON EP.cd_estado = E.cd_estado WHERE cd_usuario = '$cd_usuario' AND cd_proyecto = '$cd_proyecto'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_evaluacion ( $usr ['cd_evaluacion'] );
					$obj->setCd_estado ( $usr ['cd_estado'] );
					$obj->setDt_fecha ( $usr ['dt_fecha'] );
					$obj->setNu_puntaje ( $usr ['nu_puntaje'] );
					$obj->setBl_interno ( $usr ['bl_interno'] );
					$obj->setDs_observacion( $usr ['ds_observacion'] );
					$obj->setDs_observacionsecyt( $usr ['ds_observacionsecyt'] );
					$obj->setDs_estado( $usr ['ds_estado'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}



	function getEvaluacionPorId(Evaluacion $obj) {
		$db = Db::conectar (  );

		$cd_evaluacion = $obj->getCd_evaluacion();
		if ($cd_evaluacion){
			$sql = "SELECT cd_usuario, cd_proyecto, cd_estado, dt_fecha, nu_puntaje, bl_interno, ds_observacion, ds_observacionsecyt FROM evaluacionproyecto WHERE cd_evaluacion = '$cd_evaluacion' ";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_usuario ( $usr ['cd_usuario'] );
					$obj->setCd_proyecto ( $usr ['cd_proyecto'] );
					$obj->setCd_estado ( $usr ['cd_estado'] );
					$obj->setDt_fecha ( $usr ['dt_fecha'] );
					$obj->setNu_puntaje ( $usr ['nu_puntaje'] );
					$obj->setBl_interno ( $usr ['bl_interno'] );
					$obj->setDs_observacion( $usr ['ds_observacion'] );
					$obj->setDs_observacionsecyt( $usr ['ds_observacionsecyt'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function getEvaluacionPorProyecto(Evaluacion $obj) {
		$db = Db::conectar (  );
		$cd_proyecto = $obj->getCd_proyecto();
		$sql = "SELECT cd_evaluacion, E.cd_usuario, E.cd_estado, dt_fecha, nu_puntaje, bl_interno, ds_observacion, ds_observacionsecyt, U.ds_apynom, ES.ds_estado FROM evaluacionproyecto E INNER JOIN usuarioproyecto U ON E.cd_usuario = U.cd_usuario LEFT JOIN estadoproyecto ES ON E.cd_estado = ES.cd_estado WHERE cd_proyecto = $cd_proyecto ORDER BY bl_interno DESC, cd_evaluacion";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_evaluacion' => $usr ['cd_evaluacion'], 'cd_usuario' => $usr ['cd_usuario'], 'cd_estado' => $usr ['cd_estado'], 'dt_fecha' => $usr ['dt_fecha'], 'nu_puntaje' => $usr ['nu_puntaje'], 'bl_interno' => $usr ['bl_interno'], 'ds_observacion' => $usr ['ds_observacion'], 'ds_observacionsecyt' => $usr ['ds_observacionsecyt'], 'ds_usuario' => $usr ['ds_apynom'], 'ds_estado' => $usr ['ds_estado'] );
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}

	function insertEvaluacion(Evaluacion $obj) {
		$db = Db::conectar ();
		$cd_proyecto = $obj->getCd_proyecto();
		$cd_usuario = $obj->getCd_usuario();
		$cd_estado = $obj->getCd_estado();
		$dt_fecha = $obj->getDt_fecha();
		$nu_puntaje = $obj->getNu_puntaje();
		$bl_interno = $obj->getBl_interno();
		$ds_observacion = $obj->getDs_observacion();
		$ds_observacionsecyt = $obj->getDs_observacionsecyt();
		$sql = "INSERT INTO evaluacionproyecto (cd_proyecto, cd_usuario, cd_estado, dt_fecha, nu_puntaje, bl_interno, ds_observacion, ds_observacionsecyt) VALUES ('$cd_proyecto', '$cd_usuario', '$cd_estado', '$dt_fecha', '$nu_puntaje', '$bl_interno', '$ds_observacion', '$ds_observacionsecyt') ";
		$result = $db->sql_query ( $sql );

		$id = EvaluacionQuery::insert_id ( $db );
		$obj->setCd_evaluacion ( $id );
		$db->sql_close;
		return $result;
	}

	function insert_id($db) {
		$sql = "SELECT MAX(`cd_evaluacion`) FROM evaluacionproyecto ";
		$result = $db->sql_query ( $sql );
		$id = $db->sql_fetchrow ( $result, 0 );
		return ($id [0]);
	}

	function modificarEvaluacion(Evaluacion $obj) {
		$db = Db::conectar ();
		$cd_evaluacion = $obj->getCd_evaluacion();
		$cd_proyecto = $obj->getCd_proyecto();
		$cd_usuario = $obj->getCd_usuario();
		$cd_estado = $obj->getCd_estado();
		$dt_fecha = $obj->getDt_fecha();
		$nu_puntaje = $obj->getNu_puntaje();
		$bl_interno = $obj->getBl_interno();
		$ds_observacion = $obj->getDs_observacion();
		$ds_observacionsecyt = $obj->getDs_observacionsecyt();
		$sql = "UPDATE evaluacionproyecto SET cd_proyecto = $cd_proyecto, cd_usuario = $cd_usuario, cd_estado = $cd_estado, dt_fecha = '$dt_fecha', nu_puntaje = '$nu_puntaje', bl_interno = '$bl_interno', ds_observacion = '$ds_observacion', ds_observacionsecyt = '$ds_observacionsecyt' WHERE cd_evaluacion = $cd_evaluacion";
		$result = $db->sql_query ( $sql );


		$db->sql_close;
		return $result;
	}

	function controlEstado(Evaluacion $obj, $cd_estado) {
		$db = Db::conectar ();
		$cd_proyecto = $obj->getCd_proyecto();
		$sql = "Select count(*) FROM evaluacionproyecto WHERE cd_estado != $cd_estado AND cd_proyecto = $cd_proyecto";
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close ();
		return ($cant > 0);
	}


	function eliminarEvaluacion(Evaluacion $obj){
		$db = Db::conectar ();
		$cd_evaluacion = $obj->getCd_evaluacion ();
		$sql = "DELETE FROM evaluacionproyecto WHERE cd_evaluacion = $cd_evaluacion";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}





}
?>