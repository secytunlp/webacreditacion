<?php
include_once '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';


if (PermisoQuery::permisosDeUsuario ( $cd_usuario, 'Exportar datos' )) {
	$xtpl = new XTemplate ( 'index.html' );
	
	include APP_PATH . 'includes/cargarmenu.php';
	
	
	
	
	
	
		
	if (isset ( $_GET ['filtroModificacion'] ))
		$filtroModificacion = $_GET ['filtroModificacion']; else
		$filtroModificacion = 0;
	
	
		
	if (isset ( $_GET ['page'] ))
		$page = $_GET ['page']; else
		$page = 1;
	
	if (isset ( $_GET ['orden'] ))
		$orden = $_GET ['orden']; else
		$orden = 'ASC';
	
	if (isset ( $_GET ['campo'] ))
		$campo = $_GET ['campo']; else
		$campo = 'ds_codigo';
	
	$query_string = "?filtroModificacion=$filtroModificacion&";
	$xtpl->assign ( 'query_string', $query_string );
	
	if (isset ( $_GET ['er'] ))
		$er = $_GET ['er'];
	if ($er == 1) {
		$msj = 'Datos exportados con &eacute;xito';
		
		$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		
	}
	
	
	
	$tipomodificaciones = TipomodificacionQuery::listar ($filtroModificacion);
	$rowsize = count ( $tipomodificaciones );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $tipomodificaciones [$i] );
		$xtpl->parse ( 'main.tipomodificacion' );
	}
	
	
	$xtpl->assign ( 'titulo', 'Exportar datos' );
	
	$row_per_page = 25;
	$modificados = IntegranteQuery::getModificados( $campo, $orden, $filtroModificacion, $page, $row_per_page);
	$count = count ( $modificados );
	for($i = 0; $i < $count; $i ++) {		
		
		$modificados [$i]['dt_alta'] = FuncionesComunes::fechaMysqlaPHP($modificados [$i]['dt_alta']);
		$xtpl->assign ( 'DATOS', $modificados [$i] );
		$xtpl->parse ( 'main.row' );
	}
	
	/***************************************************
	 * PAGINADOR
	 **************************************************/
	
	$num_rows = IntegranteQuery::getCountModificados($filtroModificacion);
	$num_pages = ceil ( $num_rows / $row_per_page );
	
	$url = 'index.php?orden=' . $orden . '&campo=' . $campo . '&filtroModificacion=' . $filtroModificacion;
	$cssclassotherpage = 'paginadorOtraPagina';
	$cssclassactualpage = 'paginadorPaginaActual';
	$ds_pag_anterior = 0; //$gral['pag_ant'];
	$ds_pag_siguiente = 2; //$gral['pag_sig'];
	$imp_pag = new Paginador ( $url, $num_pages, $page, $cssclassotherpage, $cssclassactualpage, $num_rows );
	$paginador = $imp_pag->imprimirPaginado ();
	$resultados = $imp_pag->imprimirResultados ();
	
	$imgPROAsc = (($campo=='ds_codigo')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por codigo asc" src="../img/asc.jpg" />':'';
	$imgPRODesc = (($campo=='ds_codigo')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por codigo desc" src="../img/desc.jpg" />':'';
	
	$imgINVAsc = (($campo=='ds_apellido')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por investigador asc" src="../img/asc.jpg" />':'';
	$imgINVDesc = (($campo=='ds_apellido')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por investigador desc" src="../img/desc.jpg" />':'';
	
	$imgMODAsc = (($campo=='ds_tipomodificacion')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por modificacion asc" src="../img/asc.jpg" />':'';
	$imgMODDesc = (($campo=='ds_tipomodificacion')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por modificacion desc" src="../img/desc.jpg" />':'';
	
	$imgFECAsc = (($campo=='dt_alta')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por fecha asc" src="../img/asc.jpg" />':'';
	$imgFECDesc = (($campo=='dt_alta')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por fecha desc" src="../img/desc.jpg" />':'';
	
	
	
	
	$imgPRO=($imgPROAsc!='')?$imgPROAsc:(($imgPRODesc!='')?$imgPRODesc:'');
	$imgINV=($imgINVAsc!='')?$imgINVAsc:(($imgINVDesc!='')?$imgINVDesc:'');
	$imgMOD=($imgMODAsc!='')?$imgMODAsc:(($imgMODDesc!='')?$imgMODDesc:'');
	$imgFEC=($imgFECAsc!='')?$imgFECAsc:(($imgFECDesc!='')?$imgFECDesc:'');
	
	
	
	$inverso=($orden=='DESC')?'ASC':'DESC';
	
	$xtpl->assign ( 'imgPRO', $imgPRO );
	$xtpl->assign ( 'imgINV', $imgINV );
	$xtpl->assign ( 'imgMOD', $imgMOD );
	$xtpl->assign ( 'imgFEC', $imgFEC );
	

	$xtpl->assign ( 'orden', $inverso );
	$xtpl->assign ( 'filtroModificacion', $filtroModificacion );
	$xtpl->assign ( 'resultado', $resultados );
	$xtpl->parse ( 'main.resultado' );
	
	$xtpl->assign ( 'PAG', $paginador );
	$xtpl->parse ( 'main.PAG' );
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );

} else
	header ( 'Location:../includes/accesodenegado.php' );
?>