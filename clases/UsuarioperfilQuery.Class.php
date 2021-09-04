<?php
class UsuarioperfilQuery {

	function insertUsuarioperfil(Usuarioperfil $obj) {
		$db = Db::conectar ();
		$cd_perfil = $obj->getCd_perfil ();
		$cd_usuario = $obj->getCd_usuario ();
		$sql = "INSERT INTO usuarioproyectoperfil (cd_perfil, cd_usuario) VALUES($cd_perfil, $cd_usuario)";

		$result = $db->sql_query ( $sql );

		$db->sql_close;
		return $result;
	}

	function getPerfilesDeUsuario(Usuarioperfil $obj) {
		$db = Db::conectar ();
		$cd_usuario = $obj->getCd_usuario();
		$sql = "SELECT PF.cd_perfil FROM usuarioproyectoperfil PF WHERE cd_usuario = $cd_usuario";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		while ( $pf = $db->sql_fetchassoc ( $result ) ) {
			$res [$i] = ( int ) $pf ['cd_perfil'];
			$i ++;
		}
		$db->sql_close;
		return ($res);
	}

	function getPerfilesDeUsuarioPorDocumento($nu_documento) {
		$db = Db::conectar ();

		$sql = "SELECT PF.cd_perfil, ds_perfil FROM usuarioproyectoperfil PF INNER JOIN perfilproyecto PP ON PF.cd_perfil = PP.cd_perfil INNER JOIN usuarioproyecto UP ON UP.cd_usuario = Pf.cd_usuario WHERE nu_documento = $nu_documento";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_perfil'] == $cd_perfil) {
					$res [$i] = array ('cd_perfil' => "'" . $usr ['cd_perfil'] . "' selected='selected'", 'ds_perfil' => $usr ['ds_perfil'] );
				} else {
					$res [$i] = array ('cd_perfil' => $usr ['cd_perfil'], 'ds_perfil' => $usr ['ds_perfil'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;

	}

	function modificarPerfilesDeUsuario(Usuario $obj, Array $usuarioPerfiles) {
		include '../clases/Query.php';
		//me conecto a la BD
		$db = Db::conectar ( );
		Query::b_trans ( $db );

		$cd_usuario = $obj->getCd_usuario();
		$sql = "DELETE  FROM usuarioproyectoperfil WHERE cd_usuario = $cd_usuario";
		$exito = $db->sql_query ( $sql );
		if ($exito) {
			$i = 0;
			$limit = count ( $usuarioPerfiles );
			while ( $i < $limit ) {
				$pf = $usuarioPerfiles [$i];
				$cd_perfil = $pf->getCd_perfil ();
				$cd_usuario = $pf->getCd_usuario ();
				$sql = "INSERT INTO usuarioproyectoperfil (cd_perfil, cd_usuario) VALUES($cd_perfil, $cd_usuario)";
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
	function insertarPerfilesDeUsuario(Usuario $obj, Array $usuarioPerfiles) {
		include '../clases/Query.php';
		//me conecto a la BD
		$db = Db::conectar ();
		Query::b_trans ( $db );
		$i = 0;
		$limit = count ( $usuarioPerfiles );
		while ( $i < $limit ) {
			$pf = $usuarioPerfiles [$i];
			$cd_usuario = $obj->getCd_usuario();
			$cd_perfil = $pf->getCd_perfil ();
			$sql = "INSERT INTO usuarioproyectoperfil (cd_perfil, cd_usuario) VALUES($cd_perfil, $cd_usuario)";
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

	function eliminarUsuarioperfil($cd_usuario) {

		$db = Db::conectar ();
		$sql = "DELETE  FROM usuarioproyectoperfil WHERE cd_usuario = ".$cd_usuario;
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;


	}

}
?>