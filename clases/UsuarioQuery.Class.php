<?php
class UsuarioQuery {
	function existe(Usuario $user) {
		$db = Db::conectar ();
		$nu_precuil = $user->getNu_precuil();
		$nu_documento = $user->getNu_documento();
		$nu_postcuil = $user->getNu_postcuil();
		$ds_password = MD5 ( $user->getDs_password () );
		$sql = "Select count(*) FROM usuarioproyecto WHERE nu_precuil ='$nu_precuil' AND nu_documento ='$nu_documento' AND nu_postcuil ='$nu_postcuil' AND ds_password = '$ds_password'";
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close ();
		return ($cant > 0);
	}

	function getPerfil(Usuario $user, $db) {
		$db = Db::conectar ();
		$nu_precuil = $user->getNu_precuil();
		$nu_documento = $user->getNu_documento();
		$nu_postcuil = $user->getNu_postcuil();
		$sql = "Select cd_perfil, cd_usuario, cd_facultad, ds_apynom FROM usuarioproyecto WHERE nu_precuil ='$nu_precuil' AND nu_documento ='$nu_documento' AND nu_postcuil ='$nu_postcuil'";
		$result = $db->sql_query ( $sql );
		$usuario = $db->sql_fetchassoc ( $result );
		$cd_perfil = $usuario ['cd_perfil'];
		$cd_usuario = $usuario ['cd_usuario'];
		$cd_facultad = $usuario ['cd_facultad'];
		$user->setCd_perfil ( $cd_perfil );
		$user->setCd_usuario ( $cd_usuario );
		$user->setCd_facultad ( $cd_facultad );
		$user->setDs_apynom ( $usuario ['ds_apynom'] );
		$db->sql_close ();
	}

	function insertUsuario(Usuario $obj) {
		$db = Db::conectar ();
		$nu_precuil = $obj->getNu_precuil();
		$nu_documento = $obj->getNu_documento();
		$nu_postcuil = $obj->getNu_postcuil();
		if (! UsuarioQuery::existeNombreUsuario ( $obj, $db )) {
			$ds_password = MD5 ( $obj->getDs_password () );
			$cd_perfil = $obj->getCd_perfil ();
			$cd_facultad = $obj->getCd_facultad ();
			$ds_mail = $obj->getDs_mail ();
			$ds_apynom = $obj->getDs_apynom ();
			$dt_alta = $obj->getDt_alta();
			$bl_activo = $obj->getBl_activo();
			$sql = "INSERT INTO usuarioproyecto (nu_precuil, nu_documento, nu_postcuil,ds_password, cd_perfil, ds_apynom, ds_mail, cd_facultad, dt_alta, bl_activo) VALUES ('$nu_precuil', '$nu_documento', '$nu_postcuil','$ds_password', '$cd_perfil', '$ds_apynom', '$ds_mail', '$cd_facultad', '$dt_alta', '$bl_activo') ";
			$result = $db->sql_query ( $sql );
		} else {
			$result = false;
		}
		$id = UsuarioQuery::insert_id ( $db );
		$obj->setCd_usuario ( $id );
		$db->sql_close;
		return $result;
	}

	function insert_id($db) {
		$sql = "SELECT MAX(`cd_usuario`) FROM usuarioproyecto ";
		$result = $db->sql_query ( $sql );
		$id = $db->sql_fetchrow ( $result, 0 );
		return ($id [0]);
	}

	function getusuariosConPerfil($attr, $orden, $filtro, $page, $row_per_page) {
		$db = Db::conectar ();
		$limitInf = (($page - 1) * $row_per_page);
		$limitSup = ($page * $row_per_page);
		$sql = "SELECT U.cd_usuario, U.nu_precuil, U.nu_documento, U.nu_postcuil, P.ds_perfil, U.ds_apynom, U.ds_mail, F.ds_facultad, dt_alta, bl_activo FROM usuarioproyecto U";
		$sql .= " LEFT JOIN perfilproyecto P ON (P.cd_perfil=U.cd_perfil) LEFT JOIN facultad F ON F.cd_facultad = U.cd_facultad WHERE U.ds_apynom LIKE '%$filtro%' ORDER BY $attr $orden LIMIT $limitInf,$row_per_page";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_usuario' => $usr ['cd_usuario'], 'nu_precuil' => $usr ['nu_precuil'], 'nu_documento' => $usr ['nu_documento'], 'nu_postcuil' => $usr ['nu_postcuil'], 'ds_perfil' => $usr ['ds_perfil'], 'ds_apynom' => $usr ['ds_apynom'], 'ds_mail' => $usr ['ds_mail'], 'ds_facultad' => $usr ['ds_facultad'], 'dt_alta' => $usr ['dt_alta'], 'bl_activo' => $usr ['bl_activo'] );
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}

	function getusuarios($attr, $orden, $filtro, $page, $row_per_page) {
		$db = Db::conectar ();
		$limitInf = (($page - 1) * $row_per_page);
		$limitSup = ($page * $row_per_page);
		$sql = "SELECT U.cd_usuario, U.nu_precuil, U.nu_documento, U.nu_postcuil, U.ds_apynom, U.ds_mail, F.ds_facultad, dt_alta, bl_activo FROM usuarioproyecto U";
		$sql .= " LEFT JOIN facultad F ON F.cd_facultad = U.cd_facultad WHERE U.ds_apynom LIKE '%$filtro%' ORDER BY $attr $orden LIMIT $limitInf,$row_per_page";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_usuario' => $usr ['cd_usuario'], 'nu_precuil' => $usr ['nu_precuil'], 'nu_documento' => $usr ['nu_documento'], 'nu_postcuil' => $usr ['nu_postcuil'], 'ds_apynom' => $usr ['ds_apynom'], 'ds_mail' => $usr ['ds_mail'], 'ds_facultad' => $usr ['ds_facultad'], 'dt_alta' => $usr ['dt_alta'], 'bl_activo' => $usr ['bl_activo'] );
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}

	function getCantUsuarios($filtro) {
		$db = Db::conectar ();
		$sql = "SELECT count(*) FROM usuarioproyecto U";
		$sql .= " WHERE U.ds_apynom LIKE '%$filtro%'";
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close;
		return (( int ) $cant);
	}

	function eliminarUsuario(Usuario $obj) {
		$db = Db::conectar ();
		$cd_usuario = $obj->getCd_usuario ();
		$sql = "DELETE FROM usuarioproyecto WHERE cd_usuario = $cd_usuario";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}

	function getUsuarioPorId(Usuario $obj) {
		$db = Db::conectar ();
		$cd_usuario = $obj->getCd_usuario ();
		$sql = "SELECT U.nu_precuil, U.nu_documento, U.nu_postcuil, U.cd_perfil, U.ds_apynom, U.ds_mail, U.ds_password, U.cd_facultad, U.bl_activo FROM usuarioproyecto U ";
		$sql .= " WHERE U.cd_usuario = $cd_usuario";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		if ($db->sql_numrows () > 0) {
			$usr = $db->sql_fetchassoc ( $result );
			$obj->setNu_precuil ( $usr ['nu_precuil'] );
			$obj->setNu_documento ( $usr ['nu_documento'] );
			$obj->setNu_postcuil ( $usr ['nu_postcuil'] );
			//$obj->setCd_perfil ( $usr ['cd_perfil'] );
			$obj->setCd_facultad ( $usr ['cd_facultad'] );
			$obj->setDs_apynom ( $usr ['ds_apynom'] );
			$obj->setDs_mail ( $usr ['ds_mail'] );
			$obj->setDs_password ( $usr ['ds_password'] );
			$obj->setBl_activo ( $usr ['bl_activo'] );
		}
		$db->sql_close;
		return ($res);
	}

	function getUsuarioPorDocumento(Usuario $obj) {
		$db = Db::conectar ();
		$nu_documento = $obj->getNu_documento();
		$sql = "SELECT U.nu_precuil, U.cd_usuario, U.nu_postcuil, U.cd_perfil, U.ds_apynom, U.ds_mail, U.ds_password, U.cd_facultad, U.bl_activo FROM usuarioproyecto U ";
		$sql .= " WHERE U.nu_documento = $nu_documento";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		if ($db->sql_numrows () > 0) {
			$usr = $db->sql_fetchassoc ( $result );
			$obj->setNu_precuil ( $usr ['nu_precuil'] );
			$obj->setCd_usuario ( $usr ['cd_usuario'] );
			$obj->setNu_postcuil ( $usr ['nu_postcuil'] );
			//$obj->setCd_perfil ( $usr ['cd_perfil'] );
			$obj->setCd_facultad ( $usr ['cd_facultad'] );
			$obj->setDs_apynom ( $usr ['ds_apynom'] );
			$obj->setDs_mail ( $usr ['ds_mail'] );
			$obj->setDs_password ( $usr ['ds_password'] );
			$obj->setBl_activo ( $usr ['bl_activo'] );
		}
		$db->sql_close;
		return ($res);
	}

	function modificarUsuario(Usuario $obj) {
		$db = Db::conectar ();
		$nu_precuil = $obj->getNu_precuil();
		$nu_documento = $obj->getNu_documento();
		$nu_postcuil = $obj->getNu_postcuil();
		$cd_usuario = $obj->getCd_usuario ();
		if (! UsuarioQuery::existeNombreUsuario ( $obj, $db )) {
			$cd_perfil = $obj->getCd_perfil ();
			$cd_facultad = $obj->getCd_facultad ();
			$ds_mail = $obj->getDs_mail ();
			$ds_apynom = $obj->getDs_apynom ();
			$dt_alta = $obj->getDt_alta();
			$bl_activo = $obj->getBl_activo();
			$sql = "UPDATE usuarioproyecto SET nu_precuil='$nu_precuil', nu_documento='$nu_documento', nu_postcuil='$nu_postcuil', cd_perfil=$cd_perfil,cd_facultad='$cd_facultad',ds_apynom='$ds_apynom', ds_mail= '$ds_mail', bl_activo= '$bl_activo'";
			if ($obj->getDs_password () != "") {
				$ds_password = MD5 ( $obj->getDs_password () );
				$sql .= ", ds_password = '$ds_password'";
			}
			$sql .= " WHERE cd_usuario = $cd_usuario";
			$result = $db->sql_query ( $sql );
		} else {
			$result = false;
		}
		$db->sql_close;
		return $result;
	}

	function existeNombreUsuario(Usuario $user, $db) {
		$nu_precuil = $user->getNu_precuil();
		$nu_documento = $user->getNu_documento();
		$nu_postcuil = $user->getNu_postcuil();
		$cd_usuario = $user->getCd_usuario();
		$sql = "Select count(*) FROM usuarioproyecto WHERE nu_precuil ='$nu_precuil' AND nu_documento ='$nu_documento' AND nu_postcuil ='$nu_postcuil' AND cd_usuario <> '$cd_usuario'";
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		return ($cant > 0);
	}

	function estaAsignadoAPerfil(Usuario $obj) {
		$db = Db::conectar ();
		$cd_perfil = $obj->getCd_perfil();
		$sql = "Select count(*) FROM usuarioproyecto WHERE cd_perfil ='$cd_perfil'";
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close ();
		return ($cant > 0);
	}

	function listar($cd_usuario = "") {
		$db = Db::conectar (  );
		$sql = "SELECT cd_usuario, ds_apynom FROM usuarioproyecto ORDER BY cd_usuario";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_usuario'] == $cd_usuario) {
					$res [$i] = array ('cd_usuario' => "'" . $usr ['cd_usuario'] . "' selected='selected'", 'ds_apynom' => $usr ['ds_apynom'] );
				} else {
					$res [$i] = array ('cd_usuario' => $usr ['cd_usuario'], 'ds_apynom' => $usr ['ds_apynom'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}

	function getUsuariosPorFac(Usuario $obj) {
		$db = Db::conectar (  );
		$cd_facultad = $obj->getCd_facultad();
		$sql = "SELECT ds_mail FROM funcionproyecto f ";
		$sql .= " INNER JOIN perfilfuncionproyecto pf ON (f.cd_funcion = pf.cd_funcion)";
		$sql .= " INNER JOIN perfilproyecto p ON (p.cd_perfil = pf.cd_perfil)";
		$sql .= " INNER JOIN usuarioproyecto u ON (u.cd_perfil = p.cd_perfil)";
		$sql .= " WHERE u.cd_facultad='$cd_facultad' AND f.ds_funcion = 'Recibir Proyectos Facultad'";
		$result = $db->sql_query ( $sql );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('ds_mail' => $usr ['ds_mail'] );
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}
	
	function getUsuariosEvaluadores(Usuario $obj, $interno) {
		$db = Db::conectar (  );
		$cd_facultad = $obj->getCd_facultad();
		
		$ds_apynom = $obj->getDs_apynom();
		$sql = "SELECT U.nu_precuil, U.cd_usuario, U.nu_postcuil, U.cd_perfil, U.ds_apynom, U.nu_documento, F.ds_facultad, E.ds_categoria FROM usuarioproyecto U LEFT JOIN facultad F on U.cd_facultad = F.cd_facultad LEFT JOIN evaluador E on U.nu_documento = E.nu_documento ";
		$sql .= " WHERE U.cd_perfil = 10 and U.bl_activo = 1 AND ds_apynom LIKE '%".$ds_apynom."%'";
		//$sql .= ($interno==1)?" AND U.cd_facultad = ".$cd_facultad:(($interno==0)?" AND U.cd_facultad <> ".$cd_facultad:'');
		$sql .= " ORDER BY U.ds_apynom";
		$result = $db->sql_query ( $sql );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_usuario' => $usr ['cd_usuario'], 'nu_precuil' => $usr ['nu_precuil'], 'nu_documento' => $usr ['nu_documento'], 'nu_postcuil' => $usr ['nu_postcuil'], 'ds_apynom' => $usr ['ds_apynom'], 'ds_mail' => $usr ['ds_mail'], 'ds_facultad' => $usr ['ds_facultad'], 'ds_categoria' => $usr ['ds_categoria'] );
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}
}
?>