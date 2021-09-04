<?php
class PermisoQuery {
	function permisosDeUsuario($cd_usuario, $nombreFuncion) {
		$db = Db::conectar ();
		$sql = "SELECT f.ds_funcion nombre FROM funcionproyecto f  ";
		$sql .= " INNER JOIN perfilfuncionproyecto pf ON (f.cd_funcion = pf.cd_funcion)";
		$sql .= " INNER JOIN perfilproyecto p ON (p.cd_perfil = pf.cd_perfil)";
		$sql .= " INNER JOIN usuarioproyectoperfil u ON (u.cd_perfil = p.cd_perfil)";
		$sql .= " WHERE u.cd_usuario='$cd_usuario' AND u.cd_perfil ='".$_SESSION ["cd_perfilSession"]."'";
		$res = $db->sql_query ( $sql );
		if ($db->sql_numrows () > 0) {
			while ( $fila = $db->sql_fetchassoc ( $res ) ) {
				$vector [$fila ["nombre"]] = $fila ["nombre"];
			}
		}
		$db->sql_close ();
		return (isset ( $vector [$nombreFuncion] ));
	}
}
?>