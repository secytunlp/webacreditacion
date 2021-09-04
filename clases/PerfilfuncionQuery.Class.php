<?php
class PerfilFuncionQuery {

	function insertPerfilfuncion(Perfilfuncion $obj) {
		$cd_perfil = $obj->getCd_perfil ();
		$cd_funcion = $obj->getCd_funcion ();
		$sql = "INSERT INTO 'perfilfuncionproyecto' ('cd_perfil' ,'cd_funcion') VALUES ('$cd_perfil' ,'$cd_funcion') ";
		mysql_query ( $sql );
	}

	function getFuncionesDePerfil(Perfilfuncion $obj) {
		$db = Db::conectar ();
		$cd_perfil = $obj->getCd_perfil ();
		$sql = "SELECT PF.cd_funcion FROM perfilfuncionproyecto PF WHERE cd_perfil = $cd_perfil";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		while ( $pf = $db->sql_fetchassoc ( $result ) ) {
			$res [$i] = ( int ) $pf ['cd_funcion'];
			$i ++;
		}
		$db->sql_close;
		return ($res);
	}

	function modificarFuncionesDePerfil(Perfil $obj, Array $perfilFunciones) {
		include '../clases/Query.php';
		//me conecto a la BD
		$db = Db::conectar ( );
		Query::b_trans ( $db );
		//Borro todas las filas de ese perfil
		$cd_perfil = $obj->getCd_perfil ();
		$sql = "DELETE  FROM perfilfuncionproyecto WHERE cd_perfil = $cd_perfil";
		$exito = $db->sql_query ( $sql );
		if ($exito) {
			$i = 0;
			$limit = count ( $perfilFunciones );
			while ( $i < $limit ) {
				$pf = $perfilFunciones [$i];
				$cd_perfil = $pf->getCd_perfil ();
				$cd_funcion = $pf->getCd_funcion ();
				$sql = "INSERT INTO perfilfuncionproyecto (cd_perfil, cd_funcion) VALUES($cd_perfil, $cd_funcion)";
				$exitoPF = $db->sql_query ( $sql );
				if (! $exitoPF) {
					Query::r_trans ( $db );
					return false;
				}
				$i ++;
			}
			Query::c_trans ( $db );
		} else {
			Query::r_trans ( $db );
			return false;
		}
		$db->sql_close;
		return true;
	}
	function insertarFuncionesDePerfil(Perfil $obj, Array $perfilFunciones) {
		include '../clases/Query.php';
		//me conecto a la BD
		$db = Db::conectar ();
		Query::b_trans ( $db );
		$i = 0;
		$limit = count ( $perfilFunciones );
		while ( $i < $limit ) {
			$pf = $perfilFunciones [$i];
			$cd_perfil = $obj->getCd_perfil();
			$cd_funcion = $pf->getCd_funcion ();
			$sql = "INSERT INTO perfilfuncionproyecto (cd_perfil, cd_funcion) VALUES($cd_perfil, $cd_funcion)";
			$exitoPF = $db->sql_query ( $sql );
			if (! $exitoPF) {
				Query::r_trans ( $db );
				return false;
			}
			$i ++;
		}
		Query::c_trans ( $db );
		$db->sql_close;
		return true;
	}

	function eliminarPerfilfuncion($cd_perfil) {

		$db = Db::conectar ();
		$sql = "DELETE  FROM perfilfuncionproyecto WHERE cd_perfil = ".$cd_perfil;
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;


	}

}
?>