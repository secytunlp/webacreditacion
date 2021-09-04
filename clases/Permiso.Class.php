<?php
class Permiso {
	function usuarioAutorizadoFuncion($cd_usuario,$nombreFuncion) {
		include '../clases/PermisoQuery.Class.php';
		$tienePermiso = PermisoQuery::permisosDeUsuario ( $cd_usuario, $nombreFuncion );
		return $tienePermiso;
	}
}
?>