<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Ver proyecto" )) {
	
	//include APP_PATH . 'includes/menu.php';
	/*******************************************************
	 * La variable er por GET indica el tipo de error por el
	 * que se redireccionó al login
	 *******************************************************/
	
	$xtpl = new XTemplate ( 'verproyecto.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	if (isset ( $_GET ['id'] )) {
		$cd_proyecto = $_GET ['id'];
		$oProyecto = new Proyecto ( );
		$oProyecto->setCd_proyecto ( $cd_proyecto );
		ProyectoQuery::getProyectoPorid ( $oProyecto );
		$xtpl->assign ( 'cd_proyecto',  ( $oProyecto->getCd_proyecto () ) );
		$xtpl->assign ( 'ds_codigo',  ( $oProyecto->getDs_codigo () ) );
		$xtpl->assign ( 'ds_titulo',  ( $oProyecto->getDs_titulo () ) );
		$xtpl->assign ( 'ds_director',  ( $oProyecto->getDs_director () ) );
		$xtpl->assign ( 'dt_ini',  FuncionesComunes::fechaMysqlaPHP( $oProyecto->getDt_ini () ) );
		$xtpl->assign ( 'dt_fin',  FuncionesComunes::fechaMysqlaPHP( $oProyecto->getDt_fin () ) );
		$xtpl->assign ( 'ds_facultad',  ( $oProyecto->getDs_facultad () ) );
		
	}
	
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
		$campo = 'ds_investigador';
	
	$query_string = "?filtro=$filtro&id=$cd_proyecto&";
	$xtpl->assign ( 'query_string', $query_string );
	
	
	
	$nuevoIntegrante = (($oProyecto->getCd_estado()==1)&&(PermisoQuery::permisosDeUsuario( $cd_usuario, "Alta integrante" )))?'<a href="../integrantes/altaintegrante.php?cd_proyecto='.$cd_proyecto.'" title="Agregar Integrante"><img src="../img/add.jpg" class="imgAlta">Nuevo integrante</a>':'';
	$xtpl->assign ( 'nuevoIntegrante', $nuevoIntegrante );
	
	$nuevaFecha = explode ( "-", $oProyecto->getDt_ini() );
		$year = $nuevaFecha [0];
		$jovenes = ($year<2014)?'j&oacute;venes investigadores':'investigadores en formaci&oacute;n';
		$ppid = ($oProyecto->getCd_tipoacreditacion()==2)?'<br>el objetivo de estos proyectos es fortalecer los antecedentes en direcci&oacute;n de proyectos de '.$jovenes.',  en el contexto de proyectos acreditados por la UNLP de los cuales formen parte':'';
		
	
	$xtpl->assign ( 'titulo', 'SeCyT - Detalle de proyecto'.$ppid );
	$row_per_page = 50;
	$integrantes = IntegranteQuery::getIntegrantes( $campo, $orden, $filtro, $page, $row_per_page, $cd_proyecto );
	$count = count ( $integrantes );
	for($i = 0; $i < $count; $i ++) {
		$integrantes [$i]['ds_investigadorElim']=addslashes($integrantes [$i]['ds_investigador']);
		$integrantes [$i]['nu_cuil']=($integrantes [$i]['cd_tipoinvestigador']==1)?'<span class="Director">'.$integrantes [$i]['nu_cuil'].'</span>':(($integrantes [$i]['cd_tipoinvestigador']==2)?'<span class="Codirector">'.$integrantes [$i]['nu_cuil'].'</span>':$integrantes [$i]['nu_cuil']);
		$integrantes [$i]['ds_investigador']=($integrantes [$i]['cd_tipoinvestigador']==1)?'<span class="Director">'.$integrantes [$i]['ds_investigador'].'</span>':(($integrantes [$i]['cd_tipoinvestigador']==2)?'<span class="Codirector">'.$integrantes [$i]['ds_investigador'].'</span>':$integrantes [$i]['ds_investigador']);
		$integrantes [$i]['ds_categoria']=($integrantes [$i]['cd_tipoinvestigador']==1)?'<span class="Director">'.$integrantes [$i]['ds_categoria'].'</span>':(($integrantes [$i]['cd_tipoinvestigador']==2)?'<span class="Codirector">'.$integrantes [$i]['ds_categoria'].'</span>':$integrantes [$i]['ds_categoria']);
		$integrantes [$i]['ds_tipoinvestigador']=($integrantes [$i]['cd_tipoinvestigador']==1)?'<span class="Director">'.$integrantes [$i]['ds_tipoinvestigador'].'</span>':(($integrantes [$i]['cd_tipoinvestigador']==2)?'<span class="Codirector">'.$integrantes [$i]['ds_tipoinvestigador'].'</span>':$integrantes [$i]['ds_tipoinvestigador']);
		$integrantes [$i]['ds_deddoc']=($integrantes [$i]['cd_tipoinvestigador']==1)?'<span class="Director">'.$integrantes [$i]['ds_deddoc'].'</span>':(($integrantes [$i]['cd_tipoinvestigador']==2)?'<span class="Codirector">'.$integrantes [$i]['ds_deddoc'].'</span>':$integrantes [$i]['ds_deddoc']);
		$dt=(FuncionesComunes::fechaMysqlaPHP($integrantes [$i]['dt_alta'])!='00/00/0000')?FuncionesComunes::fechaMysqlaPHP($integrantes [$i]['dt_alta']):'';
		$integrantes [$i]['dt_alta']=($integrantes [$i]['cd_tipoinvestigador']==1)?'<span class="Director">'.$dt.'</span>':(($integrantes [$i]['cd_tipoinvestigador']==2)?'<span class="Codirector">'.$dt.'</span>':$dt);
		$dt=(FuncionesComunes::fechaMysqlaPHP($integrantes [$i]['dt_baja'])!='00/00/0000')?FuncionesComunes::fechaMysqlaPHP($integrantes [$i]['dt_baja']):'';
		$integrantes [$i]['dt_baja']=($integrantes [$i]['cd_tipoinvestigador']==1)?'<span class="Director">'.$dt.'</span>':(($integrantes [$i]['cd_tipoinvestigador']==2)?'<span class="Codirector">'.$dt.'</span>':$dt);
		$integrantes [$i]['ds_facultad']=($integrantes [$i]['cd_tipoinvestigador']==1)?'<span class="Director">'.$integrantes [$i]['ds_facultad'].'</span>':(($integrantes [$i]['cd_tipoinvestigador']==2)?'<span class="Codirector">'.$integrantes [$i]['ds_facultad'].'</span>':$integrantes [$i]['ds_facultad']);
		$integrantes [$i]['linkeditar'] = (((PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar integrante" ))&&($oProyecto->getCd_estado()==1)))?'<a href="../integrantes/modificarintegrante.php?cd_proyecto='.$cd_proyecto.'&cd_docente='.$integrantes [$i]['cd_docente'].'"><img class="hrefImg"
			src="../img/edit.jpg" title="Editar integrante" /></a>':'';
		$integrantes [$i]['linkebajar'] = (($integrantes [$i]['cd_tipoinvestigador']!=1)&&(((PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar integrante" ))&&($oProyecto->getCd_estado()==1))))?'<a href="" onclick="confirmaElim(\''.$integrantes [$i]['ds_investigadorElim'].'\', this,\'../integrantes/eliminarintegrante.php?cd_proyecto='.$cd_proyecto.'&cd_docente='.$integrantes [$i]['cd_docente'].'\')"><img class="hrefImg"
			src="../img/del.jpg" title="Eliminar integrante" /></a>':'';
		$nuevaFecha = explode ( "-", $oProyecto->getDt_ini() );
		
		$year = $nuevaFecha [0];
		$dir = APP_PATH.'pdfs/'.$year.'/'.$oProyecto->getCd_proyecto().'/';
		$dirREL = 'pdfs/'.$year.'/'.$oProyecto->getCd_proyecto().'/';
		if (file_exists($dir)){
				
		      $adjuntos = '';
		     $handle=opendir($dir);
				while ($archivo = readdir($handle))
				{
			        if (strchr($archivo,$integrantes [$i]['nu_documento']))
			         {
			         	//if (!in_array($archivo,$archivosNoEnv)){
				         	//$adjuntos .= $dir.$archivo;
				         	$adjuntos .='<a href="../'.$dirREL.$archivo.'" target="_blank"><img class="hrefImg" src="../img/file.jpg"
			title="'.$archivo.'" /></a>';
			         	}
						//$adjuntos .= "--Message-Boundary--\n"; 
			        // }
				}
			closedir($handle);
			}
			
			
		$integrantes [$i]['adjuntos']=$adjuntos;
		
		
		$xtpl->assign ( 'DATOS', $integrantes [$i] );
		$xtpl->parse ( 'main.row' );
	}
	
	/***************************************************
	 * PAGINADOR
	 **************************************************/
	
	
	
	$url = 'index.php?orden=' . $orden . '&campo=' . $campo . '&filtro=' . $filtro. '&filtroFacultad=' . $filtroFacultad;
	$cssclassotherpage = 'paginadorOtraPagina';
	$cssclassactualpage = 'paginadorPaginaActual';
	$ds_pag_anterior = 0; //$gral['pag_ant'];
	$ds_pag_siguiente = 2; //$gral['pag_sig'];
	$imp_pag = new Paginador ( $url, $num_pages, $page, $cssclassotherpage, $cssclassactualpage, $num_rows );
	$paginador = $imp_pag->imprimirPaginado ();
	$resultados = $imp_pag->imprimirResultados ();
	
	$imgCUILAsc = (($campo=='nu_cuil')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por CUIL asc" src="../img/asc.jpg" />':'';
	$imgCUILDesc = (($campo=='nu_cuil')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por CUIL desc" src="../img/desc.jpg" />':'';
	
	$imgINVAsc = (($campo=='ds_investigador')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por investigador asc" src="../img/asc.jpg" />':'';
	$imgINVDesc = (($campo=='ds_investigador')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por investigador desc" src="../img/desc.jpg" />':'';
	
	$imgCATAsc = (($campo=='ds_categoria')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por categoria asc" src="../img/asc.jpg" />':'';
	$imgCATDesc = (($campo=='ds_categoria')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por categoria desc" src="../img/desc.jpg" />':'';
	
	$imgDINVAsc = (($campo=='ds_tipoinvestigador')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por ded inv asc" src="../img/asc.jpg" />':'';
	$imgDINVDesc = (($campo=='ds_tipoinvestigador')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por ded inv desc" src="../img/desc.jpg" />':'';
	
	$imgDDOCAsc = (($campo=='ds_deddoc')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por ded doc asc" src="../img/asc.jpg" />':'';
	$imgDDOCDesc = (($campo=='ds_deddoc')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por ded doc desc" src="../img/desc.jpg" />':'';
	
	$imgALTAAsc = (($campo=='dt_alta')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por alta asc" src="../img/asc.jpg" />':'';
	$imgALTADesc = (($campo=='dt_alta')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por alta desc" src="../img/desc.jpg" />':'';
	
	$imgBAJAAsc = (($campo=='dt_baja')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por baja asc" src="../img/asc.jpg" />':'';
	$imgBAJADesc = (($campo=='dt_baja')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por baja desc" src="../img/desc.jpg" />':'';
	
	$imgFACAsc = (($campo=='ds_facultad')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por facultad asc" src="../img/asc.jpg" />':'';
	$imgFACDesc = (($campo=='ds_facultad')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por facultad desc" src="../img/desc.jpg" />':'';
	
	$imgCUIL=($imgCUILAsc!='')?$imgCUILAsc:(($imgCUILDesc!='')?$imgCUILDesc:'');
	$imgINV=($imgINVAsc!='')?$imgINVAsc:(($imgINVDesc!='')?$imgINVDesc:'');
	$imgCAT=($imgCATAsc!='')?$imgCATAsc:(($imgCATDesc!='')?$imgCATDesc:'');
	$imgDINV=($imgDINVAsc!='')?$imgDINVAsc:(($imgDINVDesc!='')?$imgDINVDesc:'');
	$imgDDOC=($imgDDOCAsc!='')?$imgDDOCAsc:(($imgDDOCDesc!='')?$imgDDOCDesc:'');
	$imgALTA=($imgALTAAsc!='')?$imgALTAAsc:(($imgALTADesc!='')?$imgALTADesc:'');
	$imgBAJA=($imgBAJAAsc!='')?$imgBAJAAsc:(($imgBAJADesc!='')?$imgBAJADesc:'');
	$imgFAC=($imgFACAsc!='')?$imgFACAsc:(($imgFACDesc!='')?$imgFACDesc:'');
	
	$inverso=($orden=='DESC')?'ASC':'DESC';
	
	$xtpl->assign ( 'imgCUIL', $imgCUIL );
	$xtpl->assign ( 'imgINV', $imgINV );
	$xtpl->assign ( 'imgCAT', $imgCAT );
	$xtpl->assign ( 'imgDINV', $imgDINV );
	$xtpl->assign ( 'imgDDOC', $imgDDOC );
	$xtpl->assign ( 'imgALTA', $imgALTA );
	$xtpl->assign ( 'imgBAJA', $imgBAJA );
	$xtpl->assign ( 'imgFAC', $imgFAC );
	$xtpl->assign ( 'orden', $inverso );
	$xtpl->assign ( 'filtro', $filtro );
	$xtpl->assign ( 'filtroDir', $filtroDir );
	$xtpl->assign ( 'resultado', $resultados );
	$xtpl->parse ( 'main.resultado' );
	
	$xtpl->assign ( 'PAG', $paginador );
	$xtpl->parse ( 'main.PAG' );
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/accesodenegado.php' );
?>
