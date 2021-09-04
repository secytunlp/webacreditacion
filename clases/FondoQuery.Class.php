<?php
class FondoQuery {


	function getFondo(Fondo $fondo) {
		$db = Db::conectar ();
		$cd_proyecto = $fondo->getCd_proyecto();
		$bl_tramite = $fondo->getBl_tramite();
		$sql = "Select cd_fondo, cd_proyecto, nu_monto, ds_fuente, ds_resolucion, bl_tramite FROM fondo WHERE cd_proyecto ='$cd_proyecto' AND bl_tramite = '".$bl_tramite."' ORDER BY cd_fondo";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_fondo' => $usr ['cd_fondo'], 'cd_proyecto' => $usr ['cd_proyecto'], 'nu_monto' => $usr ['nu_monto'], 'ds_fuente' => $usr ['ds_fuente'], 'ds_resolucion' => $usr ['ds_resolucion'], 'bl_tramite' => $usr ['bl_tramite'] );
				$i ++;
			}
		}
		$db->sql_close ();
		return ($res);
	}

	function insertarFondo(Fondo $obj) {
		$db = Db::conectar ();
		$cd_proyecto = $obj->getCd_proyecto();
		$nu_monto = $obj->getNu_monto();
		$ds_fuente = $obj->getDs_fuente();
		$ds_resolucion = $obj->getDs_resolucion();
		$bl_tramite = $obj->getBl_tramite();

		$sql = "INSERT INTO fondo (cd_proyecto, nu_monto, ds_fuente, ds_resolucion, bl_tramite) VALUES ('$cd_proyecto', '$nu_monto', '$ds_fuente', '$ds_resolucion', '$bl_tramite') ";
		$result = $db->sql_query ( $sql );

		$id = FondoQuery::insert_id ( $db );
		$obj->setCd_fondo ( $id );
		$db->sql_close;
		return $result;
	}

	function insert_id($db) {
		$sql = "SELECT MAX(`cd_fondo`) FROM fondo ";
		$result = $db->sql_query ( $sql );
		$id = $db->sql_fetchrow ( $result, 0 );
		return ($id [0]);
	}

	function eliminarFondo(Fondo $obj) {
		$db = Db::conectar ();
		$cd_fondo = $obj->getCd_fondo();
		$sql = "DELETE FROM fondo WHERE cd_fondo = $cd_fondo";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}

	function eliminarFondoPorProyecto(Fondo $obj) {
		$db = Db::conectar ();
		$cd_proyecto = $obj->getCd_proyecto();
		$sql = "DELETE FROM fondo WHERE cd_proyecto = $cd_proyecto";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}




}
?>