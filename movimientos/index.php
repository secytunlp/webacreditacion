<?php
include_once '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';


if (PermisoQuery::permisosDeUsuario ( $cd_usuario, 'Listar movimiento' )) {
	$xtpl = new XTemplate ( 'index.html' );
	
	include APP_PATH . 'includes/cargarmenu.php';
	
	
	
	
	
	if (isset ( $_GET ['filtroUsuario'] ))
		$filtroUsuario = $_GET ['filtroUsuario']; else
		$filtroUsuario = "";
		
	if (isset ( $_GET ['filtroFuncion'] ))
		$filtroFuncion = $_GET ['filtroFuncion']; else
		$filtroFuncion = 0;
	
	if (( $_GET ['filtroDesde'] !='')&&( $_GET ['filtroDesde'] != '//'))
		$filtroDesde = FuncionesComunes::fechaPHPaMysql1($_GET ['filtroDesde']); else
		$filtroDesde = "";
		
	if (( $_GET ['filtroHasta'] != '')&&( $_GET ['filtroHasta'] != '//'))
		$filtroHasta = FuncionesComunes::fechaPHPaMysql1($_GET ['filtroHasta']); else
		$filtroHasta = "";		
		
	if (isset ( $_GET ['page'] ))
		$page = $_GET ['page']; else
		$page = 1;
	
	if (isset ( $_GET ['orden'] ))
		$orden = $_GET ['orden']; else
		$orden = 'DESC';
	
	if (isset ( $_GET ['campo'] ))
		$campo = $_GET ['campo']; else
		$campo = 'dt_fecha';
	
	$query_string = "?filtroFuncion=$filtroFuncion&filtroUsuario=$filtroUsuario&filtroDesde=".FuncionesComunes::fechaMysqlaPHP1($filtroDesde)."&filtroHasta=".FuncionesComunes::fechaMysqlaPHP1($filtroHasta)."&";
	$xtpl->assign ( 'query_string', $query_string );
	
	if (isset ( $_GET ['er'] ))
		$er = $_GET ['er'];
	if ($er == 1) {
		$xtpl->assign ( 'msj', 'Error: No se pudo eliminar el proyecto seleccionado.' );
		$xtpl->assign ( 'classMsj', 'msjerror' );
		$xtpl->parse ( 'main.msj' );
	
	}
	
	$funciones = FuncionQuery::listar ($cd_usuario, $filtroFuncion);
	$rowsize = count ( $funciones );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $funciones [$i] );
		$xtpl->parse ( 'main.funcion' );
	}
	
	$usuarios = UsuarioQuery::listar ($filtroUsuario);
	$rowsize = count ( $usuarios );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $usuarios [$i] );
		$xtpl->parse ( 'main.usuario' );
	}
	
	$xtpl->assign ( 'filtroDesde', ($filtroDesde)?FuncionesComunes::fechaMysqlaPHP1($filtroDesde):'' );
	$xtpl->assign ( 'filtroHasta', ($filtroHasta)?FuncionesComunes::fechaMysqlaPHP1($filtroHasta):'' );
	$xtpl->assign ( 'titulo', 'Movimientos' );
	
	$row_per_page = 25;
	$movimientos = MovimientoQuery::getMovimientos( $campo, $orden, $filtroDesde, $filtroHasta, $filtroFuncion, $filtroUsuario, $page, $row_per_page, $cd_usuario);
	$count = count ( $movimientos );
	for($i = 0; $i < $count; $i ++) {		
		
		$movimientos [$i]['dt_fecha'] = FuncionesComunes::fechaHoraMysqlaPHP($movimientos [$i]['dt_fecha']);
		$xtpl->assign ( 'DATOS', $movimientos [$i] );
		$xtpl->parse ( 'main.row' );
	}
	
	/***************************************************
	 * PAGINADOR
	 **************************************************/
	
	$num_rows = MovimientoQuery::getCountMovimientos($filtroDesde, $filtroHasta, $filtroFuncion, $filtroUsuario, $cd_usuario);
	$num_pages = ceil ( $num_rows / $row_per_page );
	
	$url = 'index.php?orden=' . $orden . '&campo=' . $campo . '&filtroDesde=' . $filtroDesde. '&filtroHasta=' . $filtroHasta. '&filtroFuncion=' . $filtroFuncion. '&filtroUsuario=' . $filtroUsuario;
	$cssclassotherpage = 'paginadorOtraPagina';
	$cssclassactualpage = 'paginadorPaginaActual';
	$ds_pag_anterior = 0; //$gral['pag_ant'];
	$ds_pag_siguiente = 2; //$gral['pag_sig'];
	$imp_pag = new Paginador ( $url, $num_pages, $page, $cssclassotherpage, $cssclassactualpage, $num_rows );
	$paginador = $imp_pag->imprimirPaginado ();
	$resultados = $imp_pag->imprimirResultados ();
	
	$imgCDAsc = (($campo=='cd_movimiento')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por codigo asc" src="../img/asc.jpg" />':'';
	$imgCDDesc = (($campo=='cd_movimiento')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por codigo desc" src="../img/desc.jpg" />':'';
	
	$imgUSUAsc = (($campo=='ds_apynom')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por usuario asc" src="../img/asc.jpg" />':'';
	$imgUSUDesc = (($campo=='ds_apynom')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por usuario desc" src="../img/desc.jpg" />':'';
	
	$imgFUNAsc = (($campo=='ds_funcion')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por funcion asc" src="../img/asc.jpg" />':'';
	$imgFUNDesc = (($campo=='ds_funcion')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por funcion desc" src="../img/desc.jpg" />':'';
	
	$imgFECAsc = (($campo=='dt_fecha')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por fecha asc" src="../img/asc.jpg" />':'';
	$imgFECDesc = (($campo=='dt_fecha')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por fecha desc" src="../img/desc.jpg" />':'';
	
	$imgDSAsc = (($campo=='ds_movimiento')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por movimiento asc" src="../img/asc.jpg" />':'';
	$imgDSDesc = (($campo=='ds_movimiento')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por movimiento desc" src="../img/desc.jpg" />':'';
	
	
	
	$imgCD=($imgCDAsc!='')?$imgCDAsc:(($imgCDDesc!='')?$imgCDDesc:'');
	$imgUSU=($imgUSUAsc!='')?$imgUSUAsc:(($imgUSUDesc!='')?$imgUSUDesc:'');
	$imgFUN=($imgFUNAsc!='')?$imgFUNAsc:(($imgFUNDesc!='')?$imgFUNDesc:'');
	$imgFEC=($imgFECAsc!='')?$imgFECAsc:(($imgFECDesc!='')?$imgFECDesc:'');
	$imgDS=($imgDSAsc!='')?$imgDSAsc:(($imgDSDesc!='')?$imgDSDesc:'');
	
	
	$inverso=($orden=='DESC')?'ASC':'DESC';
	
	$xtpl->assign ( 'imgCD', $imgCD );
	$xtpl->assign ( 'imgUSU', $imgUSU );
	$xtpl->assign ( 'imgFUN', $imgFUN );
	$xtpl->assign ( 'imgFEC', $imgFEC );
	$xtpl->assign ( 'imgDS', $imgDS );

	$xtpl->assign ( 'orden', $inverso );
	$xtpl->assign ( 'filtroUsuario', $filtroUsuario );
	$xtpl->assign ( 'resultado', $resultados );
	$xtpl->parse ( 'main.resultado' );
	
	$xtpl->assign ( 'PAG', $paginador );
	$xtpl->parse ( 'main.PAG' );
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );

} else
	header ( 'Location:../includes/accesodenegado.php' );
?>