<?php
include_once '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario ( $cd_usuario, "Listar usuario" )) {
	
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
		$campo = 'ds_apynom';
	
	$query_string = "?filtro=$filtro&";
	$xtpl->assign ( 'query_string', $query_string );
	
	if (isset ( $_GET ['er'] ))
		$er = $_GET ['er'];
	if ($er == 1) {
		
		$xtpl->assign ( 'classMsj', 'msjerror' );
		$msj = "Error: No se pudo eliminar el Usuario";
		$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		$xtpl->parse ( 'main.msj' );
	
	}
	$xtpl->assign ( 'titulo', 'Administraci&oacute;n de Usuarios' );
	
	$row_per_page = 25;
	//$page=1;
	$usuarios = UsuarioQuery::getUsuariosConPerfil ( $campo, $orden, $filtro, $page, $row_per_page );
	$count = count ( $usuarios );
	for($i = 0; $i < $count; $i ++) {
		$usuarios [$i] ['chequeado'] = ($usuarios [$i] ['bl_activo'])?"checked='checked'":"";
		$usuarios[$i]['nu_cuil'] = $usuarios[$i]['nu_precuil'].'-'.$usuarios[$i]['nu_documento'].'-'.$usuarios[$i]['nu_postcuil'];
		$usuarios[$i]['dt_alta'] = FuncionesComunes::fechaMysqlaPHP($usuarios[$i]['dt_alta']);
		$usuarios [$i] ['ds_usuarioElim'] = addslashes($usuarios [$i] ['ds_apynom']);
		$xtpl->assign ( 'DATOS', $usuarios [$i] );
		$xtpl->parse ( 'main.row' );
	}
	
	/***************************************************
	 * PAGINADOR
	 **************************************************/
	
	$num_rows = UsuarioQuery::getCantUsuarios ( $filtro );
	$num_pages = ceil ( $num_rows / $row_per_page );
	
	$url = 'index.php?orden=' . $orden . '&campo=' . $campo . '&filtro=' . $filtro;
	$cssclassotherpage = 'paginadorOtraPagina';
	$cssclassactualpage = 'paginadorPaginaActual';
	$ds_pag_anterior = 0; //$gral['pag_ant'];
	$ds_pag_siguiente = 2; //$gral['pag_sig'];
	$imp_pag = new Paginador ( $url, $num_pages, $page, $cssclassotherpage, $cssclassactualpage, $num_rows );
	$paginador = $imp_pag->imprimirPaginado ();
	$resultados = $imp_pag->imprimirResultados ();
	$imgDSAsc = (($campo=='nu_documento')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por documento asc" src="../img/asc.jpg" />':'';
	$imgDSDesc = (($campo=='nu_documento')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por documento desc" src="../img/desc.jpg" />':'';
	
	$imgPERAsc = (($campo=='ds_perfil')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por perfil asc" src="../img/asc.jpg" />':'';
	$imgPERDesc = (($campo=='ds_perfil')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por perfil desc" src="../img/desc.jpg" />':'';
	
	$imgFACAsc = (($campo=='ds_facultad')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por facultad asc" src="../img/asc.jpg" />':'';
	$imgFACDesc = (($campo=='ds_facultad')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por facultad desc" src="../img/desc.jpg" />':'';
	
	$imgNYAPAsc = (($campo=='ds_apynom')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por usuario asc" src="../img/asc.jpg" />':'';
	$imgNYAPDesc = (($campo=='ds_apynom')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por usuario desc" src="../img/desc.jpg" />':'';
	
	$imgMAILAsc = (($campo=='ds_mail')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por mail asc" src="../img/asc.jpg" />':'';
	$imgMAILDesc = (($campo=='ds_mail')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por mail desc" src="../img/desc.jpg" />':'';
	
	$imgDTAsc = (($campo=='dt_alta')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por alta asc" src="../img/asc.jpg" />':'';
	$imgDTDesc = (($campo=='dt_alta')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por alta desc" src="../img/desc.jpg" />':'';
	
	$imgDS=($imgDSAsc!='')?$imgDSAsc:(($imgDSDesc!='')?$imgDSDesc:'');
	$imgPER=($imgPERAsc!='')?$imgPERAsc:(($imgPERDesc!='')?$imgPERDesc:'');
	$imgFAC=($imgFACAsc!='')?$imgFACAsc:(($imgFACDesc!='')?$imgFACDesc:'');
	$imgNYAP=($imgNYAPAsc!='')?$imgNYAPAsc:(($imgNYAPDesc!='')?$imgNYAPDesc:'');
	$imgDT=($imgDTAsc!='')?$imgDTAsc:(($imgDTDesc!='')?$imgDTDesc:'');
	$imgMAIL=($imgMAILAsc!='')?$imgMAILAsc:(($imgMAILDesc!='')?$imgMAILDesc:'');
	
	$inverso=($orden=='DESC')?'ASC':'DESC';
	$xtpl->assign ( 'imgDS', $imgDS );
	$xtpl->assign ( 'imgPER', $imgPER );
	$xtpl->assign ( 'imgFAC', $imgFAC );
	$xtpl->assign ( 'imgNYAP', $imgNYAP );
	$xtpl->assign ( 'imgMAIL', $imgMAIL );
	$xtpl->assign ( 'imgDT', $imgDT );
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