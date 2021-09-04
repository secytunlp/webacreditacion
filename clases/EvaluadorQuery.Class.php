<?php

class EvaluadorQuery {


	function getEvaluadorPorDs(Evaluador $obj) {
		$db = Db::conectar (  );
		$ds_evaluador = $obj->getDs_evaluador ();
		if ($ds_evaluador){
			$sql = "SELECT cd_evaluador FROM evaluador WHERE ds_evaluador = '$ds_evaluador'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_evaluador ( $usr ['cd_evaluador'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function getEvaluadorPorId(Evaluador $obj) {
		$db = Db::conectar (  );
		$cd_evaluador = $obj->getCd_evaluador ();
		if ($cd_evaluador){
			$sql = "SELECT * FROM evaluador WHERE cd_evaluador = '$cd_evaluador'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setDs_evaluador ( $usr ['ds_evaluador'] );
					$obj->setDs_universidad ( $usr ['ds_universidad'] );
					$obj->setNu_telefono ( $usr ['nu_telefono'] );
					$obj->setDs_disciplina ( $usr ['ds_disciplina'] );
					$obj->setDs_calle ( $usr ['ds_calle'] );
					$obj->setNu_piso ( $usr ['nu_piso'] );
					$obj->setNu_nro ( $usr ['nu_nro'] );
					$obj->setDs_depto ( $usr ['ds_depto'] );
					$obj->setDs_mail ( $usr ['ds_mail'] );
					$obj->setDs_localidad ( $usr ['ds_localidad'] );
					$obj->setNu_cp ( $usr ['nu_cp'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function getEvaluadorPorDocumento(Evaluador $obj) {
		$db = Db::conectar (  );
		$nu_documento = $obj->getNu_documento();
		if ($nu_documento){
			$sql = "SELECT * FROM evaluador WHERE nu_documento = '$nu_documento'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_evaluador ( $usr ['cd_evaluador'] );
					$obj->setDs_evaluador ( $usr ['ds_evaluador'] );
					$obj->setDs_universidad ( $usr ['ds_universidad'] );
					$obj->setNu_telefono ( $usr ['nu_telefono'] );
					$obj->setDs_disciplina ( $usr ['ds_disciplina'] );
					$obj->setDs_categoria ( $usr ['ds_categoria'] );
					$obj->setDs_calle ( $usr ['ds_calle'] );
					$obj->setNu_piso ( $usr ['nu_piso'] );
					$obj->setNu_nro ( $usr ['nu_nro'] );
					$obj->setDs_depto ( $usr ['ds_depto'] );
					$obj->setDs_mail ( $usr ['ds_mail'] );
					$obj->setDs_localidad ( $usr ['ds_localidad'] );
					$obj->setNu_cp ( $usr ['nu_cp'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}



	function getEvaluadorPorApellido(Evaluador $obj, $externo) {
		$db = Db::conectar ();
		$ds_apellido = $obj->getDs_evaluador();
		$ds_apellido = str_replace(' ','%',$ds_apellido);
		$sql = "SELECT D. *
                        FROM evaluador D
                        WHERE  D.ds_evaluador LIKE '%$ds_apellido%'";
		$sql .= ($externo)?" AND D.ds_universidad NOT LIKE '%Universidad Nacional de La Plata%'":'';
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $tc = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_evaluador' => $tc ['cd_evaluador'], 'cd_evaluador' => $tc ['cd_evaluador'], 'ds_evaluador' => $tc ['ds_evaluador'], 'ds_universidad' => $tc ['ds_universidad'], 'ds_disciplina' => $tc ['ds_disciplina'], 'nu_documento' => $tc ['nu_documento'], 'ds_categoria' => $tc ['ds_categoria'] );
				$i ++;
			}
		}

		$db->sql_close;
		return ($res);
	}


}
?>