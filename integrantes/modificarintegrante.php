<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';


if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar integrante" )) {
	
	$xtpl = new XTemplate ( 'modificarintegrante.html' );
	include APP_PATH.'includes/cargarmenu.php';
	
	if ((isset ( $_GET ['cd_proyecto'] ))&&(isset ( $_GET ['cd_docente'] )))  {
		$cd_proyecto = $_GET ['cd_proyecto'];
		$oProyecto = new Proyecto ( );
		$oProyecto->setCd_proyecto ( $cd_proyecto );
		ProyectoQuery::getProyectoPorid ( $oProyecto );
		$xtpl->assign ( 'cd_proyecto',  ( $oProyecto->getCd_proyecto () ) );
		$xtpl->assign ( 'ds_codigo',  ( htmlspecialchars($oProyecto->getDs_codigo ()) ) );
		
		$cd_docente = $_GET ['cd_docente'];
		$oDocente = new Docente ( );
		$oDocente->setCd_docente ( $cd_docente );
		DocenteQuery::getDocentePorid ( $oDocente );
		$xtpl->assign ( 'cd_docente',  ( $oDocente->getCd_docente () ) );
		$xtpl->assign ( 'ds_nombre',  ( htmlspecialchars($oDocente->getDs_nombre ()) ) );
		$xtpl->assign ( 'ds_apellido',  ( htmlspecialchars($oDocente->getDs_apellido()) ) );
		$xtpl->assign ( 'nu_precuil',  ( $oDocente->getNu_precuil() ) );
		$xtpl->assign ( 'nu_documento',  ( $oDocente->getNu_documento() ) );
		$xtpl->assign ( 'nu_postcuil',  ( $oDocente->getNu_postcuil() ) );
		$xtpl->assign ( 'dt_nacimiento',  ( FuncionesComunes::fechaMysqlaPHP($oDocente->getDt_nacimiento() ) ));
		$xtpl->assign ( 'ds_calle',  ( htmlspecialchars($oDocente->getDs_calle()) ) );
		$xtpl->assign ( 'nu_nro',  ( htmlspecialchars($oDocente->getNu_nro()) ) );
		$xtpl->assign ( 'nu_piso',  ( htmlspecialchars($oDocente->getNu_piso()) ) );
		$xtpl->assign ( 'ds_depto',  ( htmlspecialchars($oDocente->getDs_depto()) ) );
		$xtpl->assign ( 'ds_localidad',  ( htmlspecialchars($oDocente->getDs_localidad()) ) );
		$xtpl->assign ( 'nu_cp',  ( htmlspecialchars($oDocente->getNu_cp())) );
		$xtpl->assign ( 'nu_telefono',  ( htmlspecialchars($oDocente->getNu_telefono()) ) );
		$xtpl->assign ( 'ds_mail',  ( $oDocente->getDs_mail() ) );
		$oIntegrante = new Integrante ( );
		$oIntegrante->setCd_docente ( $cd_docente );
		$oIntegrante->setCd_proyecto ( $cd_proyecto );
		IntegranteQuery::getIntegrantePorId($oIntegrante);
		
		
		$disabled = (PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar docente" ))?'':'disabled="disabled"';
		$disabled1 = (PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar docente" ))?'':(($oDocente->getCd_docente()>=90000)?'':'disabled="disabled"');
		$discod = ($oIntegrante->getCd_tipoinvestigador()!=1)?'':'disabled="disabled"';
		$xtpl->assign ( 'disabled',  $disabled );
		$xtpl->assign ( 'disabled1',  $disabled1 );
		$xtpl->assign ( 'discod',  $discod );
		$xtpl->assign ( 'ds_curriculumH',  $oIntegrante->getDs_curriculum() );
		$cvcargado = (( $oIntegrante->getDs_curriculum() ) OR ( $oIntegrante->getDs_curriculumT() ) ) ? 'Cargado' : '';
   		 $xtpl->assign('cvcargado', $cvcargado);
   		$bl_director = ($oDocente->getBl_director())?$oDocente->getBl_director():IntegranteQuery::fueDirCodir($oDocente->getCd_docente(),$oProyecto->getCd_proyecto());
		if (($bl_director==1)){		
				$disabled = ($oDocente->getBl_director())?'':'disabled';
				$checked = "checked='checked' ".$disabled;
				
				
			}
			
			 /*$validar=(($oIntegrante->getCd_tipoinvestigador()==1)&&($oProyecto->getCd_tipoacreditacion()==2))?"form = document.getElementById('modificarintegrante');
	form.antecedentesTXT.value = CKEDITOR.instances.ds_antecedentes.getData();":"";
			 $xtpl->assign ( 'validar',  $validar );*/
   		if (($oIntegrante->getCd_tipoinvestigador()==1)&&($oProyecto->getCd_tipoacreditacion()==2)) {
   			$antecedentesppid = '<p>Es o ha sido DIR./CODIR. de proyectos de acreditaci&oacute;n<input type="checkbox" name="bl_director" id="bl_director" '.$checked.' /><div id="divDirector" class="fValidator-msg"></div></p><p>ADMISIBILIDAD: el Director debe poseer una actividad cient&iacute;fica, tecnol&oacute;gica y/o art&iacute;stica significativa y continua en los &uacute;ltimos 5 a&ntilde;os. Detallar los proyectos acreditados en los cuales ha participado, indicando t&iacute;tulo, director y per&iacute;odo de ejecuci&oacute;n <br> <strong>Descripci&oacute;n   (*):</strong><br /><textarea name="ds_antecedentes" id="ds_antecedentes" cols="60" rows="4">'.$oIntegrante->getDs_antecedentes().'</textarea></p>';
   		 	$xtpl->assign ( 'antecedentesppid',  $antecedentesppid );
   			$dt_cargo = "Obtenci&oacute;n (*): <input type='text' name='dt_cargo' id='dt_cargo' size='10' value='".FuncionesComunes::fechaMysqlaPHP($oDocente->getDt_cargo() )."' class='fValidate[\'required\',\'date\']'/>";
   		 	$xtpl->assign ( 'dt_cargo',  $dt_cargo );
   		 	$proyectoPPID = IntegranteQuery::fueDirCodirPPID($oDocente->getCd_docente(),$oProyecto->getCd_proyecto());
   		 	if (count($proyectoPPID)>0) {
   		 		$antecedentesppidDIR = '<p>Fue '.$proyectoPPID[0]['ds_tipoinvestigador'].' del proyecto '.$proyectoPPID[0]['ds_codigo'].' '.$proyectoPPID[0]['ds_titulo'].'('.FuncionesComunes::fechaMysqlaPHP($proyectoPPID[0]['dt_ini']).' - '.FuncionesComunes::fechaMysqlaPHP($proyectoPPID[0]['dt_fin']).') Detallar brevemente la labor realizada, metas alcanzadas y resultados obtenidos. (*):</strong><br /><textarea name="ds_antecedentesPPIDDIR" id="ds_antecedentesPPIDDIR" cols="60" rows="4">'.$oIntegrante->getDs_antecedentesPPIDDIR().'</textarea></p>';
				$xtpl->assign ( 'antecedentesppidDIR',  $antecedentesppidDIR );
				$onload="window.onload = function() {	
			CKEDITOR.replace('ds_antecedentes',{toolbar:'Basic',width:'780',height:'100'});
   		 	CKEDITOR.replace('ds_antecedentesPPIDDIR',{toolbar:'Basic',width:'780',height:'100'});
   		 	}";
			 
   		 	}
   		 	else $onload="window.onload = function() {	
			CKEDITOR.replace('ds_antecedentes',{toolbar:'Basic',width:'780',height:'100'});}";
   		 	$xtpl->assign ( 'onload',  $onload );
   		} 
		
	}
	
	
	
		
	$categorias = CategoriaQuery::listar ($oDocente->getCd_categoria ());
	$rowsize = count ( $categorias );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $categorias [$i] );
		$xtpl->parse ( 'main.categoria' );
	}
	
	$cargos = CargoQuery::listar ($oDocente->getCd_cargo ());
	$rowsize = count ( $cargos );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $cargos [$i] );
		$xtpl->parse ( 'main.cargo' );
	}
	
	$provincias = ProvinciaQuery::listar ($oDocente->getCd_provincia ());
	$rowsize = count ( $provincias );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $provincias [$i] );
		$xtpl->parse ( 'main.provincia' );
	}
	
	$deddocs = DeddocQuery::listar ($oDocente->getCd_deddoc ());
	$rowsize = count ( $deddocs );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $deddocs [$i] );
		$xtpl->parse ( 'main.deddoc' );
	}
	
	$facultades = FacultadQuery::listar ($oDocente->getCd_facultad ());
	$rowsize = count ( $facultades );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $facultades [$i] );
		$xtpl->parse ( 'main.facultad' );
	}
	
	$xtpl->assign ( 'cd_unidad',  stripslashes( htmlspecialchars($oDocente->getCd_unidad()) ) );
	$nu_nivelunidad = $oDocente->getNu_nivelunidad();
	$xtpl->assign ( 'nu_nivelunidad',  stripslashes( htmlspecialchars($nu_nivelunidad) ) );
	$oUnidad = new Unidad();
		$oUnidad->setCd_unidad($oDocente->getCd_unidad());
		UnidadQuery::getUnidadPorId($oUnidad);
	
	$xtpl->assign ( 'ds_unidad',  stripslashes( htmlspecialchars($oUnidad->getDs_unidad()) ) );
	
	//$codir = ($oProyecto->getCd_tipoacreditacion()==1)?0:1;
	$codir = 0;
	$tipoinvestigadores = TipoinvestigadorQuery::listar ($oIntegrante->getCd_tipoinvestigador(), ($oIntegrante->getCd_tipoinvestigador()<>1)?1:0,$codir);
	$rowsize = count ( $tipoinvestigadores );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $tipoinvestigadores [$i] );
		$xtpl->parse ( 'main.tipoinvestigador' );
	}
	
	$bl_becario = $oDocente->getBl_becario();
	if ($bl_becario==1){		
			$xtpl->assign ( 'chksi',  "checked='checked'" );
			
		}
	if ($bl_becario==0){		
		$xtpl->assign ( 'chkno',  "checked='checked'" );
		
	}
	$xtpl->assign ( 'ds_tipobeca',  stripslashes( htmlspecialchars($oDocente->getDs_tipobeca()) ) );
	$selectedANPCyT = ($ds_orgbeca=='ANPCyT')?"selected='selected'":"";
	$selectedCIC = ($ds_orgbeca=='CIC')?"selected='selected'":"";
	$selectedCONICET = ($ds_orgbeca=='CONICET')?"selected='selected'":"";
	$selectedUNLP = ($ds_orgbeca=='UNLP')?"selected='selected'":"";
	
	$selectedANPCyT = ($oDocente->getDs_orgbeca()=='ANPCyT')?"selected='selected'":"";
	$selectedCIC = ($oDocente->getDs_orgbeca()=='CIC')?"selected='selected'":"";
	$selectedCONICET = ($oDocente->getDs_orgbeca()=='CONICET')?"selected='selected'":"";
	$selectedUNLP = ($oDocente->getDs_orgbeca()=='UNLP')?"selected='selected'":"";
	//$xtpl->assign ( 'ds_orgbeca',  stripslashes( htmlspecialchars($oDocente->getDs_orgbeca()) ) );
	
	$xtpl->assign ( 'ds_universidad',  stripslashes( htmlspecialchars($oDocente->getDs_universidad()) ) );
	$xtpl->assign ( 'cd_universidad',  $oDocente->getCd_universidad() );
	$oTitulo = new Titulo();
		$oTitulo->setCd_titulo($oDocente->getCd_titulo());
		TituloQuery::getTituloPorId($oTitulo);
		$ds_titulogrado = $oTitulo->getDs_titulo();
	$xtpl->assign ( 'ds_titulogrado',  stripslashes( htmlspecialchars($ds_titulogrado) ) );
	$xtpl->assign ( 'cd_titulogrado',  stripslashes( htmlspecialchars($oTitulo->getCd_titulo()) ) );
	
	$oTitulo = new Titulo();
		$oTitulo->setCd_titulo($oDocente->getCd_titulopost());
		TituloQuery::getTituloPorId($oTitulo);
		$ds_titulogrado = $oTitulo->getDs_titulo();
	$xtpl->assign ( 'ds_titulopost',  stripslashes( htmlspecialchars($ds_titulogrado) ) );
	$xtpl->assign ( 'cd_titulopost',  stripslashes( htmlspecialchars($oTitulo->getCd_titulo()) ) );
	
	$carrerainvs = CarrerainvQuery::listar ($oDocente->getCd_carrerainv());
	$rowsize = count ( $carrerainvs );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $carrerainvs [$i] );
		$xtpl->parse ( 'main.carrerainv' );
	}
	
	$organismos = OrganismoQuery::listar ($oDocente->getCd_organismo());
	$rowsize = count ( $organismos );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $organismos [$i] );
		$xtpl->parse ( 'main.organismo' );
	}
	
	$proyectos = ProyectoQuery::getProyectosDocentes($oDocente->getCd_docente() );
	$count = count ( $proyectos );
	for($i = 0; $i < $count; $i ++) {
		$proyectos [$i]['dt_ini']=FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini']);
		$proyectos [$i]['dt_fin']=FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin']);
		$proyectos [$i]['item']=$i;
		$proyectos [$i]['disabled']=(($proyectos [$i]['nu_horasinv'])&&($proyectos [$i]['cd_proyecto']!=$oProyecto->getCd_proyecto()))?'readonly':'';
		$xtpl->assign ( 'DATOS', $proyectos [$i] );
		$xtpl->parse ( 'main.row' );
	}
	
	if (isset ( $_GET ['er'] )) {
		if ($_GET ['er'] == 1) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "Error: No se han modificado los datos del docente";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
		if ($_GET ['er'] == 3) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "Error: El docente ya es integrante de 2 proyectos en ejecuci&oacute;n o no tiene dedicaci&oacute;n suficiente para ser integrante de m&aacute;s de un proyecto";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
		if ($_GET ['er'] == 4) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = ($oProyecto->getCd_tipoacreditacion()==1)?"Error: La categor&iacute;a del codirector debe ser I, II o III o debe tener Cargo en la Carrera del Investigador con lugar de trabajo en la U.N.L.P.":"Error: La categor&iacute;a del codirector no puede ser V";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
		
	} else {
		$xtpl->assign ( 'classMsj', '' );
		$xtpl->assign ( 'msj', '' );
	}
	$xtpl->parse ( 'main.msj' );
	$nuevaFecha = explode ( "-", $oProyecto->getDt_ini() );
		$year = $nuevaFecha [0];
		$jovenes = ($year<2014)?'j&oacute;venes investigadores':'investigadores en formaci&oacute;n';
		$ppid = ($oProyecto->getCd_tipoacreditacion()==2)?'<br>el objetivo de estos proyectos es fortalecer los antecedentes en direcci&oacute;n de proyectos de '.$jovenes.',  en el contexto de proyectos acreditados por la UNLP de los cuales formen parte':'';
		
	$xtpl->assign ( 'titulo', 'SeCyT - Modificación de integrante'.$ppid );
	
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/finsolicitud.php' );
?>