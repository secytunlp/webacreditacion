<?php
include_once '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario ( $cd_usuario, "Listar perfil" )) {
	
	$xtpl = new XTemplate ( 'index.html' );
	
	include APP_PATH . 'includes/cargarmenu.php';
	
	if (isset ( $_GET ['filtro'] ))
		$filtro = $_GET ['filtro']; else
		$filtro = "";
	
	if (isset ( $_GET ['page'] ))
		$page = $_GET ['page']; else
		$page = 1;
	
	if (isset ( $_GET ['orden'] ))
		$orden = $_GET ['orden']; else
		$orden = 'ASC';
	
	if (isset ( $_GET ['campo'] ))
		$campo = $_GET ['campo']; else
		$campo = 'ds_perfil';
	
	$query_string = "?filtro=$filtro&";
	$xtpl->assign ( 'query_string', $query_string );
	
	if (isset ( $_GET ['er'] ))
		$er = $_GET ['er'];
	if ($er == 1) {
		
		$xtpl->assign ( 'classMsj', 'msjerror' );
		$msj = "Error: No se pudo eliminar el Perfil. Verifique que no exista ningún usuario con dicho perfil";
		$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		$xtpl->parse ( 'main.msj' );
	
	}
	$xtpl->assign ( 'titulo', 'Administración de Perfiles' );
	
	$row_per_page = 10;
	$perfiles = PerfilQuery::getPerfiles ( $campo, $orden, $filtro, $page, $row_per_page );
	$count = count ( $perfiles );
	for($i = 0; $i < $count; $i ++) {
		$xtpl->assign ( 'DATOS', $perfiles [$i] );
		$xtpl->assign ( 'ROW_NR', $i );
		$xtpl->parse ( 'main.row' );
	}
	
	/***************************************************
	 * PAGINADOR
	 **************************************************/
	
	$num_rows = PerfilQuery::getCountPerfiles ( $filtro );
	$num_pages = ceil ( $num_rows / $row_per_page );
	
	$url = 'index.php?orden=' . $orden . '&campo=' . $campo . '&filtro=' . $filtro;
	$cssclassotherpage = 'paginadorOtraPagina';
	$cssclassactualpage = 'paginadorPaginaActual';
	$ds_pag_anterior = 0; //$gral['pag_ant'];
	$ds_pag_siguiente = 2; //$gral['pag_sig'];
	$imp_pag = new Paginador ( $url, $num_pages, $page, $cssclassotherpage, $cssclassactualpage, $num_rows );
	$paginador = $imp_pag->imprimirPaginado ();
	$resultados = $imp_pag->imprimirResultados ();
	$imgCDAsc = (($campo=='cd_perfil')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por Ident asc" src="../img/asc.jpg" />':'';
	$imgCDDesc = (($campo=='cd_perfil')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por Ident desc" src="../img/desc.jpg" />':'';
	
	$imgDSAsc = (($campo=='ds_perfil')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por perfil asc" src="../img/asc.jpg" />':'';
	$imgDSDesc = (($campo=='ds_perfil')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por perfil desc" src="../img/desc.jpg" />':'';
	
	$imgCD=($imgCDAsc!='')?$imgCDAsc:(($imgCDDesc!='')?$imgCDDesc:'');
	$imgDS=($imgDSAsc!='')?$imgDSAsc:(($imgDSDesc!='')?$imgDSDesc:'');
	
	$inverso=($orden=='DESC')?'ASC':'DESC';
	
	$xtpl->assign ( 'imgCD', $imgCD );
	$xtpl->assign ( 'imgDS', $imgDS );
	$xtpl->assign ( 'orden', $inverso );
	$xtpl->assign ( 'resultado', $resultados );
	$xtpl->parse ( 'main.resultado' );
	
	$xtpl->assign ( 'PAG', $paginador );
	$xtpl->parse ( 'main.PAG' );
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/accesodenegado.php' );
?>