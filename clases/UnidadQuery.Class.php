<?php

class UnidadQuery {


	function getUnidadPorDs(Unidad $obj) {
		$db = Db::conectar (  );
		$ds_unidad = $obj->getDs_unidad ();
		if ($ds_unidad){
			$sql = "SELECT cd_unidad, ds_codigo, cd_facultad FROM unidad WHERE ds_unidad = '$ds_unidad'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_unidad ( $usr ['cd_unidad'] );
					$obj->setDs_codigo ( $usr ['ds_codigo'] );
					$obj->setCd_facultad ( $usr ['cd_facultad'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function getUnidadPorCodigo(Unidad $obj) {
		$db = Db::conectar (  );
		$ds_codigo = $obj->getDs_codigo();

		$sql = "SELECT cd_unidad, cd_tipounidad, cd_padre, ds_unidad, ds_codigo, ds_direccion, ds_mail, ds_telefono, cd_facultad, bl_hijos FROM unidad WHERE ds_codigo = '$ds_codigo'";
		$result = $db->sql_query ( $sql );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$obj->setCd_unidad ( $usr ['cd_unidad'] );
				$obj->setCd_tipounidad ( $usr ['cd_tipounidad'] );
				$obj->setCd_padre ( $usr ['cd_padre'] );
				$obj->setDs_unidad ( $usr ['ds_unidad'] );
				$obj->setDs_codigo( $usr ['ds_codigo'] );
				$obj->setDs_direccion( $usr ['ds_direccion'] );
				$obj->setDs_mail( $usr ['ds_mail'] );
				$obj->setDs_telefono( $usr ['ds_telefono'] );
				$obj->setCd_facultad ( $usr ['cd_facultad'] );
				$obj->setBl_hijos ( $usr ['bl_hijos'] );
				$i ++;
			}
		}

		$db->sql_close;
		return ($result);
	}

	function getUnidadPorId(Unidad $obj) {
		$db = Db::conectar (  );
		$cd_unidad = $obj->getCd_unidad ();
		if ($cd_unidad){
			$sql = "SELECT cd_unidad, cd_tipounidad, cd_padre, ds_unidad, ds_codigo, ds_direccion, ds_mail, ds_telefono, cd_facultad, ds_sigla, bl_hijos FROM unidad WHERE cd_unidad = '$cd_unidad'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_unidad ( $usr ['cd_unidad'] );
					$obj->setCd_tipounidad ( $usr ['cd_tipounidad'] );
					$obj->setCd_padre ( $usr ['cd_padre'] );
					$obj->setDs_unidad ( $usr ['ds_unidad'] );
					$obj->setDs_codigo( $usr ['ds_codigo'] );
					$obj->setDs_direccion( $usr ['ds_direccion'] );
					$obj->setDs_mail( $usr ['ds_mail'] );
					$obj->setDs_telefono( $usr ['ds_telefono'] );
					$obj->setCd_facultad ( $usr ['cd_facultad'] );
					$obj->setDs_sigla ( $usr ['ds_sigla'] );
					$obj->setBl_hijos ( $usr ['bl_hijos'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function listar(Unidad $obj) {
		$db = Db::conectar (  );
		$cd_unidad = $obj->getCd_unidad();
		$cd_padre = $obj->getCd_padre();
		$cd_tipounidad = $obj->getCd_tipounidad();
		$sql = "SELECT cd_unidad, ds_unidad FROM unidad WHERE cd_padre = ".$cd_padre." AND cd_tipounidad = $cd_tipounidad ORDER BY ds_unidad";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_unidad'] == $cd_unidad) {
					$res [$i] = array ('cd_unidad' => "'" . $usr ['cd_unidad'] . "' selected='selected'", 'ds_unidad' => $usr ['ds_unidad']);
				} else {
					$res [$i] = array ('cd_unidad' => $usr ['cd_unidad'], 'ds_unidad' => $usr ['ds_unidad']);
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}

	function getUnidadesPorDs($ds_unidad) {
		$db = Db::conectar (  );
		$ds_unidad = str_replace(' ','%',$ds_unidad);
		$sql = "SELECT cd_unidad, ds_unidad, bl_hijos, cd_padre, ds_sigla FROM unidad WHERE ds_unidad LIKE '%$ds_unidad%' OR ds_sigla LIKE '%$ds_unidad%'  ORDER BY ds_unidad";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$ds_unidad = ($usr ['ds_sigla'])?$usr ['ds_unidad'].' ('.$usr ['ds_sigla'].')':$usr ['ds_unidad'];

				$res [$i] = array ('cd_unidad' => $usr ['cd_unidad'], 'ds_unidad' =>$ds_unidad, 'bl_hijos' => $usr ['bl_hijos'], 'cd_padre' => $usr ['cd_padre']);


				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}

	function comboUnidad($cd_padre = "", $nivel=0) {
		$db = Db::conectar ();

		$sql = "SELECT cd_unidad, ds_unidad, ds_codigo, bl_hijos, ds_sigla, cd_facultad FROM unidad ";
		$sql .= ($nivel)?"WHERE cd_padre = ".$cd_padre:"WHERE cd_tipounidad = ".$cd_padre." and cd_padre=0 ";
		$sql .= " ORDER BY ds_unidad";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$usr ['ds_unidad'] = ($usr ['ds_sigla'])?$usr ['ds_unidad'].' - '.$usr ['ds_sigla']:$usr ['ds_unidad'];
				if ($usr ['cd_unidad'] == $cd_unidad) {
					$res [$i] = array ('cd_unidad' => "'" . $usr ['cd_unidad'] . "' selected='selected'", 'ds_unidad' => $usr ['ds_unidad'], 'ds_codigo' => $usr ['ds_codigo'], 'cd_facultad' => $usr ['cd_facultad'] );
				} else {
					$res [$i] = array ('cd_unidad' => $usr ['cd_unidad'], 'ds_unidad' => $usr ['ds_unidad'], 'ds_codigo' => $usr ['ds_codigo'], 'cd_facultad' => $usr ['cd_facultad'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}

	function modificarUnidad(Unidad $obj) {
		$db = Db::conectar (  );
		$cd_unidad = $obj->getCd_unidad();
		$cd_tipounidad= $obj->getCd_tipounidad();
		$cd_padre= $obj->getCd_padre();
		$bl_hijos= $obj->getBl_hijos();
		$ds_unidad= $obj->getDs_unidad();
		$ds_codigo= $obj->getDs_codigo();
		$ds_sigla= $obj->getDs_sigla();
		$ds_direccion= $obj->getDs_direccion();
		$ds_mail= $obj->getDs_mail();
		$ds_telefono= $obj->getDs_telefono();
		$cd_facultad= $obj->getCd_facultad();
		$sql = "UPDATE unidad SET cd_tipounidad='$cd_tipounidad', cd_padre='$cd_padre', bl_hijos='$bl_hijos', ds_unidad='$ds_unidad', ds_codigo='$ds_codigo', ds_sigla='$ds_sigla', ds_direccion='$ds_direccion', ds_mail='$ds_mail', ds_telefono='$ds_telefono', cd_facultad='$cd_facultad'";
		$sql .= " WHERE cd_unidad = $cd_unidad";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}

}
?>