<?php

class TituloQuery {


	function getTituloPorDs(Titulo $obj) {
		$db = Db::conectar (  );
		$ds_titulo = $obj->getDs_titulo ();
		if ($ds_titulo){
			$sql = "SELECT cd_titulo FROM titulo WHERE ds_titulo = '$ds_titulo'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_titulo ( $usr ['cd_titulo'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function getTituloPorId(Titulo $obj) {
		$db = Db::conectar (  );
		$cd_titulo = $obj->getCd_titulo ();
		if ($cd_titulo){
			$sql = "SELECT ds_titulo FROM titulo WHERE cd_titulo = '$cd_titulo'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setDs_titulo ( $usr ['ds_titulo'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}

	function listar($nu_nivel, $ds_titulo = "", $todos=0) {
		$db = Db::conectar (  );
		$titulo = explode ( ",", $ds_titulo );
		if (count($titulo)==1) {
			$ds_titulo = str_replace(' ','%',$ds_titulo);
			$ds_universidad ='%%';
		}
		else{
			$ds_titulo = str_replace(' ','%',$titulo[0]);
			$ds_universidad = str_replace(' ','%',$titulo[1]);
		}
		$sql = "SELECT cd_titulo, ds_titulo, ds_universidad FROM titulo t INNER JOIN universidad u ON t.cd_universidad = u.cd_universidad Where nu_nivel = ".$nu_nivel." AND ds_titulo LIKE '%$ds_titulo%' AND ds_universidad LIKE '%$ds_universidad%' ORDER BY nu_orden DESC, ds_titulo ASC";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		$anterior='';
		$todos=1;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if (($anterior!= trim($usr ['ds_titulo']))||($todos)){
						
					$res [$i] = array ('cd_titulo' => $usr ['cd_titulo'], 'ds_titulo' => $usr ['ds_titulo'], 'ds_universidad' => $usr ['ds_universidad'] );
						
					$i ++;
					$anterior= trim($usr ['ds_titulo']);
				}
			}
		}
		$db->sql_close ();

		return $res;
	}

	function listarSelect($nu_nivel, $cd_titulo = "") {
		$db = Db::conectar (  );
		$sql = "SELECT cd_titulo, ds_titulo FROM titulo ORDER BY ds_titulo";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_titulo'] == $cd_titulo) {
					$res [$i] = array ('cd_titulo' => "'" . $usr ['cd_titulo'] . "' selected='selected'", 'ds_titulo' => $usr ['ds_titulo'] );
				} else {
					$res [$i] = array ('cd_titulo' => $usr ['cd_titulo'], 'ds_titulo' => $usr ['ds_titulo'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}


}
?>