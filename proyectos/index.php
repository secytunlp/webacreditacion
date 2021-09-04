<?php
include_once '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';
$funcion = (isset($_GET['pendiente']))?'Admitir solicitud':'Listar proyecto';

if (PermisoQuery::permisosDeUsuario ( $cd_usuario, $funcion )) {
	$xtpl = new XTemplate ( 'index.html' );
	
	include APP_PATH . 'includes/cargarmenu.php';
	
	
	
	/*$fp = fopen ("../datos/ultimos_5.txt","r");
	$cd_anterior = -1;
	$years=array();
	while ($data = fgetcsv ($fp, 1000, ",")) {
	    $num = count ($data);
	    $oDocente = new Docente();
		$oDocente->setCd_docente($data[0]);
		$oDocente->setDs_apellido($data[1]);
		$oDocente->setDs_nombre($data[2]);
		$oDocente->setNu_documento($data[3]);
		$oDocente->setDs_categoria($data[4]);
		$oDocente->setDt_nacimiento(FuncionesComunes::fechaPHPaMysql($data[5]));
		$oDocente->setDs_titulo(FuncionesComunes::fechaPHPaMysql($data[6]));
		$oDocente->setDs_titulootro(FuncionesComunes::fechaPHPaMysql($data[7]));
		if ($oDocente->getDt_nacimiento()=='--'){
			$oDocente->setDt_nacimiento($oDocente->getDs_titulootro());
		}
		$yearini = (substr($oDocente->getDs_titulo(),0,4)<2005)?2005:intval(substr($oDocente->getDs_titulo(),0,4));
		$yearfin = (substr($oDocente->getDt_nacimiento(),0,4)>2009)?2009:intval(substr($oDocente->getDt_nacimiento(),0,4));
		if (($cd_anterior!=-1)&&($oDocente->getCd_docente()!=$cd_anterior)){
			$yearsant=$years;
			$years=array();
		}
		for ($i=$yearini; $i<=$yearfin; $i++){
			if (!in_array($i,$years)){
				array_push($years, $i);
			}
		}
		
		if (($cd_anterior==-1)||($oDocente->getCd_docente()==$cd_anterior)){
			
			
		}
		else{
			
			if (count($yearsant)>4){
				DocenteQuery::insertarAux($oDocenteAnt);
			}
		}
		$cd_anterior = $oDocente->getCd_docente();
		$oDocenteAnt = $oDocente;
	}
	fclose ($fp);*/
	
	
	/*$fp = fopen ("../datos/proyectos.txt","r");
	$_Log = fopen ("../datos/sin_unidad.txt","w+");
	while ($data = fgetcsv ($fp, 1000, ",")) {
	    $num = count ($data);
	    $oProyecto = new Proyecto ( );
			
		//$oProyecto->setCd_proyecto ( intval($data[0]) );
		//ProyectoQuery::getProyectoPorId ( $oProyecto );
		//$insertar=($oProyecto->getDs_codigo())?0:1;
		$oProyecto->setDs_codigo ( trim($data[1]) );
		ProyectoQuery::getProyectoPorCodigo ( $oProyecto );
	    $insertar=($oProyecto->getCd_proyecto())?0:1;
	    $oProyecto->setCd_facultad(intval($data[6]));
	    
	    $oProyecto->setDs_codigo ( trim($data[1]) );
	    $oProyecto->setDs_titulo(trim($data[2]));
	    $oProyecto->setDt_fin(FuncionesComunes::fechaPHPaMysql($data[4]));
	    $oProyecto->setDt_ini(FuncionesComunes::fechaPHPaMysql($data[3]));
	    $oProyecto->setDt_inc(FuncionesComunes::fechaPHPaMysql($data[5]));
	    $oProyecto->setCd_campo($data[7]);
	    $oProyecto->setCd_especialidad($data[8]);
	    $oProyecto->setCd_disciplina($data[9]);
	    $oProyecto->setCd_entidad($data[10]);
	    $oProyecto->setDs_linea($data[11]);
		
	    if ($data[12]){
	    	$oUnidad = new Unidad();
	    	$oUnidad->setDs_codigo($data[12]);
	    	UnidadQuery::getUnidadPorCodigo($oUnidad);
	    	$cd_unidad = $oUnidad->getCd_unidad();
	    	$oProyecto->setCd_unidad($cd_unidad);
	    	if ($cd_unidad){
	    		$nivel=0;
	    		$oUnidadPadre = $oUnidad;
	    		while ($oUnidadPadre->getCd_padre()){
	    			$oUnidadPadre->setCd_unidad($oUnidadPadre->getCd_padre());
	    			UnidadQuery::getUnidadPorId($oUnidadPadre);
	    			if ($oUnidadPadre->getCd_unidad())
	    				$nivel++;
	    		}
	    	}
	    	else 
	    		FuncionesComunes::_log($oProyecto->getDs_codigo().' - '.$data[12], $_Log);
	    	$oProyecto->setNu_nivelunidad($nivel);
	    }
	    else{
	    	$oProyecto->setCd_unidad(0);
	    	$oProyecto->setNu_nivelunidad(0);
	    }
	    
	    
	    $oProyecto->setDs_tipo($data[13]);
	    $oProyecto->setCd_tipoacreditacion(1);
		if ($insertar){
			$oProyecto->setCd_estado(5);
			ProyectoQuery::insertarProyecto ( $oProyecto );			
		}
		else ProyectoQuery::modificarProyecto ( $oProyecto );	
				
				
				
	
	}
	fclose ($_Log);
	fclose ($fp);*/
	/*$_Log = fopen("../datos/docentes_insertados.log", "w+") or die("Operation Failed!");
	$fp = fopen ("../datos/docentes.txt","r");
	while ($data = fgetcsv ($fp, 1000, ",")) {
	    $num = count ($data);
	    $oDocente = new Docente ( );
		$oDocente->setCd_docente ( intval($data[0]) );
		$oDocente->setNu_documento(intval($data[5]));
		if (strlen($oDocente->getNu_documento())<6){
			FuncionesComunes::_log('CORTO Investigador: '.$data[3].', '.$data[2].' - DNI: '.$data[5],$_Log);
		}
		else{
			DocenteQuery::getDocentePorDocumento ( $oDocente );
		    $insertar=($oDocente->getNu_ident())?0:1;
		    $oDocente->setNu_ident(intval($data[1]));
		    $oDocente->setDs_nombre($data[2]);
		    $oDocente->setDs_apellido($data[3]);
		    $oDocente->setNu_precuil(intval($data[4]));
		    $oDocente->setNu_postcuil(intval($data[6]));
		    $oDocente->setDt_nacimiento(FuncionesComunes::fechaPHPaMysql($data[7]));
		    $oDocente->setDs_sexo($data[8]);
		    $oDocente->setCd_categoria(intval($data[9]));
		    $oDocente->setNu_dedinv(intval($data[10]));
		    $oDocente->setCd_carrerainv(intval($data[12]));
		    $oDocente->setCd_organismo(intval($data[11]));
		    $oDocente->setNu_horasinv(intval($data[13]));
		    $oDocente->setNu_semanasinv(intval($data[14]));
		    $oDocente->setNu_horasspu;(intval($data[15]));
		    $oDocente->setNu_semanasspu(intval($data[16]));
		    $oDocente->setCd_facultad(intval($data[17]));
		    $oDocente->setCd_cargo(intval($data[18]));
		    $oDocente->setCd_deddoc(intval($data[19]));
		    $oDocente->setNu_horasdoc2c(intval($data[20]));
		    $oDocente->setNu_horasdoc1c(intval($data[21]));
		    $oDocente->setNu_semanasdoc1c(intval($data[22]));
		    $oDocente->setNu_semanasdoc2c(intval($data[23]));
		    $oDocente->setCd_titulo(intval($data[24]));
		    $oDocente->setDs_calle($data[25]);
		    $oDocente->setNu_nro($data[26]);
		    $oDocente->setNu_piso($data[27]);
		    $oDocente->setDs_depto($data[28]);
		    $oDocente->setDs_localidad($data[29]);
		    $oDocente->setNu_cp($data[30]);
		    $oDocente->setDs_mail($data[31]);
		    $oDocente->setNu_telefono($data[32]);
		    $oDocente->setCd_provincia(intval($data[33]));
		   	$oDocente->setCd_titulopost(intval($data[34]));
		    $oDocente->setBl_becario((trim($data[35])=='S')?1:0);
		    if (intval($data[12])==7){
		    	$oDocente->setBl_becario(1);
		    	$oOrganismo = new Organismo();
		    	$oOrganismo->setCd_organismo(intval($data[11]));
		    	OrganismoQuery::getOrganismoPorCd($oOrganismo);
		    	$oDocente->setDs_orgbeca(addslashes($oOrganismo->getDs_organismo()));
		    }
			if ($insertar){
				DocenteQuery::insertarDocente ( $oDocente );	
				FuncionesComunes::_log('Insertado Investigador: '.$data[3].', '.$data[2].' - DNI: '.$data[5],$_Log);		
			}
			else {DocenteQuery::modificarDocente ( $oDocente );	
				FuncionesComunes::_log('Actualizado Investigador: '.$data[3].', '.$data[2].' - DNI: '.$data[5],$_Log);		
			}
		}
				
				
				
	
	}
	fclose ($fp);
	fclose($_Log);*/

	/*$_Log = fopen("../datos/integrantes_procesados_2009.log", "w+") or die("Operation Failed!");
	$fp = fopen ("../datos/Integrantes_2009.txt","r");
	while ($data = fgetcsv ($fp, 1000, ",")) {
		$item++;
	    $num = count ($data);
	    $oDocente = new Docente ( );
		$oDocente->setNu_documento ( intval($data[0]) );
		if (strlen($oDocente->getNu_documento())<6){
			FuncionesComunes::_log('NO Insertado DNI corto: '.$data[0].' - Proyecto: '.$data[1],$_Log);
		}
		else{
			DocenteQuery::getDocentePorDocumento ( $oDocente );
			$oProyecto = new Proyecto ( );
			$oProyecto->setDs_codigo ( $data[1] );
			ProyectoQuery::getProyectoPorCodigo ( $oProyecto );
			if (($oDocente->getNu_ident())&&($oProyecto->getCd_proyecto())){
		    	$oIntegrante = new Integrante ( );
		    	$oIntegrante->setCd_docente ( $oDocente->getCd_docente() );
				$oIntegrante->setCd_proyecto ( $oProyecto->getCd_proyecto() );
				IntegranteQuery::getIntegrantePorId ( $oIntegrante );
			    $insertar=($oIntegrante->getDt_alta())?0:1;
			    if ($insertar){
				    $tipo = ($data[4]==1)?1:0;
				    $oIntegrante->setCd_tipoinvestigador($tipo);
			    }
			    $oIntegrante->setDt_alta(FuncionesComunes::fechaPHPaMysql($data[2]));
			    $oIntegrante->setDt_baja(FuncionesComunes::fechaPHPaMysql($data[3]));
			    $oIntegrante->setNu_horasinv($data[5]);
				if ($insertar){
					FuncionesComunes::_log('Insertado DNI: '.$data[0].' - Proyecto: '.$data[1],$_Log);
					IntegranteQuery::insertarIntegrante ( $oIntegrante );			
				}
				else {
					FuncionesComunes::_log('Actualizado DNI: '.$data[0].' - Proyecto: '.$data[1],$_Log);
					IntegranteQuery::modificarIntegrante ( $oIntegrante );
				}
			}	
			else{
				FuncionesComunes::_log('NO Insertado DNI: '.$data[0].' - Proyecto: '.$data[1],$_Log);
			}
		}
				
				
				
	
	}
	fclose ($fp);*/
	/*$_Log = fopen("../datos/codir_no_encontrados.log", "w+") or die("Operation Failed!");
	$_LogB = fopen("../datos/borrar_docentes.log", "w+") or die("Operation Failed!");		
			
	$fp = fopen ("../datos/Codirectores.txt","r");
	while ($data = fgetcsv ($fp, 1000, ",")) {
	    $num = count ($data);
	    $oDocente = new Docente ( );
		$oDocente->setNu_documento ( intval($data[0]) );
		if (strlen($oDocente->getNu_documento())<6){
			FuncionesComunes::_log('CORTO Proyecto: '.$data[1].' - Investigador: '.$data[2].', '.$data[3].' - DNI: '.$data[0].' - Tipo: '.$data[9]. ' - Univ: '.$data[4].' - Obs: '.$data[5].' - Categoria: '.$data[6].' - Alta: '.$data[7].' - Baja: '.$data[8],$_Log);
		}
		else{
		
		DocenteQuery::getDocentePorDocumento ( $oDocente );
		$oIntegrante = new Integrante ( );
	    $oIntegrante->setCd_docente ( $oDocente->getCd_docente() );
	    $oIntegrante->setCd_tipoinvestigador( intval($data[9]) );
	    if ($oIntegrante->getCd_tipoinvestigador()!=0){
			$oProyecto = new Proyecto ( );
			$oProyecto->setDs_codigo ( $data[1] );
			ProyectoQuery::getProyectoPorCodigo ( $oProyecto );
			if (($oDocente->getNu_ident())&&($oProyecto->getCd_proyecto())){
			
		    	
				$oIntegrante->setCd_proyecto ( $oProyecto->getCd_proyecto() );
				IntegranteQuery::getIntegrantePorId ( $oIntegrante );
				$oIntegrante->setCd_tipoinvestigador( intval($data[9]) );
				$insertar=($oIntegrante->getDt_alta())?0:1;
				 //if($oIntegrante->getCd_tipoinvestigador()==2){
				$oIntegrante->setDt_alta(FuncionesComunes::fechaPHPaMysql($data[7]));
			    $oIntegrante->setDt_baja(FuncionesComunes::fechaPHPaMysql($data[8]));	
						if ($insertar){
							IntegranteQuery::insertarIntegrante ( $oIntegrante );		
							FuncionesComunes::_log('Proyecto: '.$oProyecto->getDs_codigo().' - Investigador: '.$data[2].', '.$data[3].' - DNI: '.$data[0].' - Tipo: '.$data[9]. ' - Univ: '.$data[4].' - Obs: '.$data[5].' - Categoria: '.$data[6].' - Alta: '.$data[7].' - Baja: '.$data[8],$_Log);	
						}
						else IntegranteQuery::modificarIntegrante ( $oIntegrante );
				//  }
			    
			}
			elseif ($oProyecto->getCd_proyecto())	{
				$oCategoria = new Categoria();
				$oCategoria->setDs_categoria($data[6]);
				CategoriaQuery::getCategoriaPorDs($oCategoria);
				$cd_categoria = ($oCategoria->getCd_categoria())?$oCategoria->getCd_categoria():1;
				$db = Db::conectar ();
				$id = DocenteQuery::insert_id ( $db );
				$db->sql_close;
				$id = ($id>=90000)?$id+1:90000;
				$oDocente->setNu_ident($id);
				$oDocente->setCd_docente($id);
				$oDocente->setCd_categoria($cd_categoria);
				$oDocente->setDs_nombre($data[3]);
			    $oDocente->setDs_apellido($data[2]);
			    DocenteQuery::insertarDocente($oDocente); 
			    $oIntegrante->setCd_docente($id);
			    $oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
			    $oIntegrante->setDt_alta(FuncionesComunes::fechaPHPaMysql($data[7]));
			    $oIntegrante->setDt_baja(FuncionesComunes::fechaPHPaMysql($data[8]));
			    IntegranteQuery::insertarIntegrante($oIntegrante);
			    if($oIntegrante->getCd_tipoinvestigador()==2){
					FuncionesComunes::_log('Proyecto: '.$oProyecto->getDs_codigo().' - Investigador: '.$data[2].', '.$data[3].' - DNI: '.$data[0].' - Tipo: '.$data[9]. ' - Univ: '.$data[4].' - Obs: '.$data[5].' - Categoria: '.$data[6].' - Alta: '.$data[7].' - Baja: '.$data[8],$_Log);
					FuncionesComunes::_log('DELETE FROM DOCENTE WHERE nu_documento = '.$data[0].';',$_LogB);
			    }
				
			}
	    }
		
		}		
				
				
	
	}
	fclose ($fp);
	fclose ($_Log);
	fclose ($_LogB);*/

	/*$_Log = fopen("../datos/integrantes_no_cat_no_insertados.log", "w+") or die("Operation Failed!");
	$fp = fopen ("../datos/integrantes_no_cat.txt","r");
	while ($data = fgetcsv ($fp, 1000, ",")) {
	    $num = count ($data);
	    $oDocente = new Docente ( );
		$oDocente->setNu_documento ( intval($data[0]) );
		if (strlen($oDocente->getNu_documento())<6){
			FuncionesComunes::_log('CORTO Proyecto: '.$data[1].' - Investigador: '.$data[2].', '.$data[3].' - DNI: '.$data[0]. ' - Univ: '.$data[4].' - Obs: '.$data[5].' - Categoria: '.$data[6].' - Alta: '.$data[7].' - Baja: '.$data[8],$_Log);
		}
		else{
		DocenteQuery::getDocentePorDocumento ( $oDocente );
		$oProyecto = new Proyecto ( );
		$oProyecto->setCd_proyecto ( intval($data[1]) );
		ProyectoQuery::getProyectoPorId ( $oProyecto );
		
		if (($oDocente->getNu_ident())&&($oProyecto->getDs_codigo())){
	    	
		}
		elseif ($oProyecto->getDs_codigo())	{
			$oCategoria = new Categoria();
			$oCategoria->setDs_categoria($data[6]);
			CategoriaQuery::getCategoriaPorDs($oCategoria);
			$cd_categoria = ($oCategoria->getCd_categoria())?$oCategoria->getCd_categoria():1;
			$db = Db::conectar ();
			$id = DocenteQuery::insert_id ( $db );
			$db->sql_close;
			$id = ($id>=90000)?$id+1:90000;
			$oDocente->setNu_ident($id);
			$oDocente->setCd_docente($id);
			$oDocente->setCd_categoria($cd_categoria);
			$oDocente->setDs_nombre($data[3]);
		    $oDocente->setDs_apellido($data[2]);
		    DocenteQuery::insertarDocente($oDocente); 
		   	$oIntegrante = new Integrante();
		   	$oIntegrante->setBl_codirector(0);
		   	$oIntegrante->setBl_director(0);
		    $oIntegrante->setCd_docente($id);
		    $oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
		    $oIntegrante->setDt_alta(FuncionesComunes::fechaPHPaMysql($data[7]));
		    $oIntegrante->setDt_baja(FuncionesComunes::fechaPHPaMysql($data[8]));
		    IntegranteQuery::insertarIntegrante($oIntegrante);
			
			
		}
		}
				
				
				
	
	}
	fclose ($fp);
	fclose ($_Log);*/
	
	if (isset ( $_GET ['filtro'] ))
		$filtro = $_GET ['filtro']; else
		$filtro = "";
		
	if (isset ( $_GET ['filtroDir'] ))
		$filtroDir = $_GET ['filtroDir']; else
		$filtroDir = "";
		
	if (isset ( $_GET ['filtroFacultad'] ))
		$filtroFacultad = $_GET ['filtroFacultad']; else
		$filtroFacultad = 0;
		
	if (isset ( $_GET ['filtroEstado'] ))
		$filtroEstado = $_GET ['filtroEstado']; else
		$filtroEstado = 0;	
	
	if (isset ( $_GET ['filtroAcreditacion'] ))
		$filtroAcreditacion = $_GET ['filtroAcreditacion']; else
		$filtroAcreditacion = 'actual';		
	
	if (isset ( $_GET ['page'] ))
		$page = $_GET ['page']; else
		$page = 1;
	
	if (isset ( $_GET ['orden'] ))
		$orden = $_GET ['orden']; else
		$orden = 'ASC';
	
	if (isset ( $_GET ['campo'] ))
		$campo = $_GET ['campo']; else
		$campo = 'ds_codigo';
	if (isset ( $_GET ['filtroTipoacreditacion'] ))
		$filtroTipoacreditacion = $_GET ['filtroTipoacreditacion']; else
		$filtroTipoacreditacion = 0;	
	$pendientes = ($filtroAcreditacion=='anterior')?1:0;
	$actual = ($filtroAcreditacion=='actual')?1:0;
	$selectPendiente = ($pendientes)?"selected='selected'":"";
	$selectActual = ($actual)?"selected='selected'":"";
	$query_string = "?filtro=$filtro&filtroFacultad=$filtroFacultad&filtroEstado=$filtroEstado&filtroDir=$filtroDir&filtroAcreditacion=".$filtroAcreditacion."&filtroTipoacreditacion=".$filtroTipoacreditacion."&";
	$xtpl->assign ( 'query_string', $query_string );
	$oDocente = new Docente();
	$oDocente->setNu_documento($_SESSION['nu_documentoSession']);
	DocenteQuery::getDocentePorDocumento($oDocente);
	$max = (($oDocente->getCd_docente())&&((in_array($oDocente->getCd_deddoc(), $mayordedicacion))||($oDocente->getBl_becario())||(in_array($oDocente->getCd_carrerainv(), $carrerainvs))))?1:0;	
	//$altaProyecto = ((PermisoQuery::permisosDeUsuario( $cd_usuario, 'Alta proyecto' ))&&($oDocente->getCd_docente())&&(!IntegranteQuery::masDeUnProyecto($oDocente->getCd_docente(),$max)))?'<a href="altaproyecto1.php?insertar=1&ini=1&cd_tipoacreditacion=1"	title="Agregar Proyecto"><img src="../img/add.jpg"	class="imgAlta">Nuevo I+D</a><a href="altaproyecto1.php?insertar=1&ini=1&cd_tipoacreditacion=2"	title="Agregar Proyecto"><img src="../img/add.jpg"	class="imgAlta">Nuevo PPID</a>':'';
	$altaProyecto = ((PermisoQuery::permisosDeUsuario( $cd_usuario, 'Alta proyecto' ))&&($oDocente->getCd_docente())&&(!IntegranteQuery::masDeUnProyecto($oDocente->getCd_docente(),$max)))?'<a href="altaproyecto1.php?insertar=1&ini=1&cd_tipoacreditacion=2"	title="Agregar Proyecto"><img src="../img/add.jpg"	class="imgAlta">Nuevo PPID</a>':'';
	//$altaProyecto = (($oDocente->getCd_docente())&&(!IntegranteQuery::masDeUnProyecto($oDocente->getCd_docente(),$max)))?'<a href="altaproyecto1.php?insertar=1&ini=1&cd_tipoacreditacion=1"	title="Agregar Proyecto"><img src="../img/add.jpg"	class="imgAlta">Nuevo incentivos</a>':'';
	$xtpl->assign ( 'altaProyecto', $altaProyecto );
	if (isset ( $_GET ['er'] ))
		$er = $_GET ['er'];
	if ($er == 1) {
		$msj = "Error: No se pudo eliminar el proyecto";
		$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		$xtpl->assign ( 'classMsj', 'msjerror' );
		$xtpl->parse ( 'main.msj' );
	
	}
	
	if ($er == 5) {
		$msj = "No hay evaluadores asignados";
		$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		
	}
	
	if ($er == 6) {
		$msj = "Se envi&oacute; la solicitud por mail a los evaluadores";
		$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		
	}
	
	if ($er == 7) {
		$msj = "Se envi&oacute; la evaluaci&oacute;n por mail";
		$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		
	}
	
	if ($er == 8) {
		$msj = "Todos los &iacute;tems en 0 (cero)";
		$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		
	}
	if ($er == 9) {
		$msj = "Como el resultado es NO APROBADO, se requiere en el &iacute;tem Obervaciones, un comentario breve (pero claro) de las razones que lo llevaron a tomar tal determinaci&oacute;n";
		$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		
	}
	if (isset ( $_GET ['err'] )){
		$err = FuncionesComunes::array_recibe($_GET ['err']);
		$msjerror = '';
		foreach ($err as $error)
			$msjerror .= $error.'<br>';
		$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msjerror.'\')"' );
		$xtpl->assign ( 'classMsj', 'msjerror' );
		$xtpl->parse ( 'main.msj' );
	}
	
	$facultades = FacultadQuery::listar ($filtroFacultad);
	$rowsize = count ( $facultades );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $facultades [$i] );
		$xtpl->parse ( 'main.facultad' );
	}
	
	$estados = EstadoQuery::listar ($filtroEstado);
	$rowsize = count ( $estados );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $estados [$i] );
		$xtpl->parse ( 'main.estado' );
	}
	
	$tipoacreditacions = TipoacreditacionQuery::listar ($filtroTipoacreditacion);
	$rowsize = count ( $tipoacreditacions );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $tipoacreditacions [$i] );
		$xtpl->parse ( 'main.tipoacreditacion' );
	}
	
	
	
	$xtpl->assign ( 'titulo', 'Administraci&oacute;n de proyectos' );
	$xtpl->assign ( 'year', $_SESSION ["nu_yearSession"] );
	$xtpl->assign ( 'selectPendiente', $selectPendiente );
	$xtpl->assign ( 'selectActual', $selectActual );
	
	$row_per_page = 25;
	$proyectos = ProyectoQuery::getProyectos( $campo, $orden, $filtro, $filtroFacultad, $filtroEstado, $filtroDir, $page, $row_per_page, $cd_usuario, $pendientes, $actual,$filtroTipoacreditacion );
	$count = count ( $proyectos );
	for($i = 0; $i < $count; $i ++) {
		$proyectos [$i]['ds_tituloElim']=addslashes($proyectos [$i]['ds_titulo']);
		$versolicitud = ($proyectos [$i]['dt_ini']>='2012-01-01')?1:0;
		$proyectos [$i]['ds_tipoacreditacion']=(($proyectos [$i]['cd_estado']==2))?'<span class="Alta">'.$proyectos [$i]['ds_tipoacreditacion'].'</span>':((($proyectos [$i]['cd_estado']==1))?'<span class="Director">'.$proyectos [$i]['ds_tipoacreditacion'].'</span>':((($proyectos [$i]['cd_estado']==4))?'<span class="Baja">'.$proyectos [$i]['ds_tipoacreditacion'].'</span>':$proyectos [$i]['ds_tipoacreditacion']));
		$proyectos [$i]['ds_codigo']=(($proyectos [$i]['cd_estado']==2))?'<span class="Alta">'.$proyectos [$i]['ds_codigo'].'</span>':((($proyectos [$i]['cd_estado']==1))?'<span class="Director">'.$proyectos [$i]['ds_codigo'].'</span>':((($proyectos [$i]['cd_estado']==4))?'<span class="Baja">'.$proyectos [$i]['ds_codigo'].'</span>':$proyectos [$i]['ds_codigo']));
		$proyectos [$i]['ds_titulo']=(($proyectos [$i]['cd_estado']==2))?'<span class="Alta">'.$proyectos [$i]['ds_titulo'].'</span>':((($proyectos [$i]['cd_estado']==1))?'<span class="Director">'.$proyectos [$i]['ds_titulo'].'</span>':((($proyectos [$i]['cd_estado']==4))?'<span class="Baja">'.$proyectos [$i]['ds_titulo'].'</span>':$proyectos [$i]['ds_titulo']));
		$proyectos [$i]['ds_director']=(($proyectos [$i]['cd_estado']==2))?'<span class="Alta">'.$proyectos [$i]['ds_director'].'</span>':((($proyectos [$i]['cd_estado']==1))?'<span class="Director">'.$proyectos [$i]['ds_director'].'</span>':((($proyectos [$i]['cd_estado']==4))?'<span class="Baja">'.$proyectos [$i]['ds_director'].'</span>':$proyectos [$i]['ds_director']));
		$proyectos [$i]['dt_ini']=(($proyectos [$i]['cd_estado']==2))?'<span class="Alta">'.FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini']).'</span>':((($proyectos [$i]['cd_estado']==1))?'<span class="Director">'.FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini']).'</span>':((($proyectos [$i]['cd_estado']==4))?'<span class="Baja">'.FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini']).'</span>':FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini'])));
		$proyectos [$i]['dt_fin']=(($proyectos [$i]['cd_estado']==2))?'<span class="Alta">'.FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin']).'</span>':((($proyectos [$i]['cd_estado']==1))?'<span class="Director">'.FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin']).'</span>':((($proyectos [$i]['cd_estado']==4))?'<span class="Baja">'.FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin']).'</span>':FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin'])));
		$proyectos [$i]['ds_facultad']=(($proyectos [$i]['cd_estado']==2))?'<span class="Alta">'.$proyectos [$i]['ds_facultad'].'</span>':((($proyectos [$i]['cd_estado']==1))?'<span class="Director">'.$proyectos [$i]['ds_facultad'].'</span>':((($proyectos [$i]['cd_estado']==4))?'<span class="Baja">'.$proyectos [$i]['ds_facultad'].'</span>':$proyectos [$i]['ds_facultad']));
		$proyectos [$i]['ds_estado']=(($proyectos [$i]['cd_estado']==2))?'<span class="Alta">'.$proyectos [$i]['ds_estado'].'</span>':((($proyectos [$i]['cd_estado']==1))?'<span class="Director">'.$proyectos [$i]['ds_estado'].'</span>':((($proyectos [$i]['cd_estado']==4))?'<span class="Baja">'.$proyectos [$i]['ds_estado'].'</span>':$proyectos [$i]['ds_estado']));
		$proyectos [$i]['linkeditar'] = ((PermisoQuery::permisosDeUsuario( $cd_usuario, "Proyectos propios" ))&&($proyectos [$i]['cd_estado']==1))?'<a href="altaproyecto1.php?ini=1&cd_proyecto='.$proyectos [$i]['cd_proyecto'].'"><img class="hrefImg"
			src="../img/edit.jpg" title="Editar proyecto" /></a>&nbsp;':'';
		$proyectos [$i]['linkebajar'] = ((PermisoQuery::permisosDeUsuario( $cd_usuario, "Proyectos propios" ))&&($proyectos [$i]['cd_estado']==1))?'<a href="" onclick="confirmaElim(\''.$proyectos [$i]['ds_tituloElim'].'\', this,\'eliminarproyecto.php?cd_proyecto='.$proyectos [$i]['cd_proyecto'].'\')"><img	class="hrefImg" src="../img/del.jpg" title="Eliminar Proyecto" /></a>&nbsp;':'';
		$proyectos [$i]['linkenviar'] = ((PermisoQuery::permisosDeUsuario( $cd_usuario, "Proyectos propios" ))&&($proyectos [$i]['cd_estado']==1))?'<a href="" onclick="confirmaEnviar(this,\'verproyectoPDF.php?enviar=1&id='.$proyectos [$i]['cd_proyecto'].'\')"><img	class="hrefImg" src="../img/send.jpg" title="Enviar Proyecto" /></a>&nbsp;':'';
		$proyectos [$i]['linkconfirmar'] = (($proyectos [$i]['cd_estado']==2)&&(PermisoQuery::permisosDeUsuario( $cd_usuario, "Admitir solicitud" )))?'<a href="" onclick="confirmaConfir(this,\'confirmar.php?cd_proyecto='.$proyectos [$i]['cd_proyecto'].'\')"><img
			class="hrefImg" src="../img/chk_on.png" title="Admitir solicitud" /></a>&nbsp;':'';
		$proyectos [$i]['linkrechazar'] = (($proyectos [$i]['cd_estado']==2)&&(PermisoQuery::permisosDeUsuario( $cd_usuario, "Rechazar solicitud" )))?'<a href="rechazar.php?cd_proyecto='.$proyectos [$i]['cd_proyecto'].'"><img
			class="hrefImg" src="../img/chk_off.png" title="Rechazar solicitud" /></a>&nbsp;':'';
		/*$proyectos [$i]['linkacreditar'] = (($proyectos [$i]['cd_estado']==8)&&(PermisoQuery::permisosDeUsuario( $cd_usuario, "Confirmar acreditación" )))?'<a href="" onclick="confirmaAcred(this,\'confirmar.php?acreditar=1&cd_proyecto='.$proyectos [$i]['cd_proyecto'].'\')"><img
			class="hrefImg" src="../img/chk_on.png" title="Confirmar acreditación" /></a>&nbsp;':'';*/
		$proyectos [$i]['linkacreditar'] = (($proyectos [$i]['cd_estado']==8)&&(PermisoQuery::permisosDeUsuario( $cd_usuario, "Confirmar acreditación" )))?'<a href="confirmaracreditacion.php?acreditar=1&cd_proyecto='.$proyectos [$i]['cd_proyecto'].'"><img
			class="hrefImg" src="../img/chk_on.png" title="Confirmar acreditación" /></a>&nbsp;':'';
		/*$proyectos [$i]['linknoacreditar'] = (($proyectos [$i]['cd_estado']==8)&&(PermisoQuery::permisosDeUsuario( $cd_usuario, "Rechazar acreditación" )))?'<a href="" onclick="confirmaRechazo(this,\'rechazaracreditacion.php?cd_proyecto='.$proyectos [$i]['cd_proyecto'].'\')"><img
			class="hrefImg" src="../img/chk_off.png" title="Rechazar acreditación" /></a>&nbsp;':'';*/
		$proyectos [$i]['linknoacreditar'] = (($proyectos [$i]['cd_estado']==8)&&(PermisoQuery::permisosDeUsuario( $cd_usuario, "Rechazar acreditación" )))?'<a href="rechazaracreditacion.php?cd_proyecto='.$proyectos [$i]['cd_proyecto'].'" ><img
			class="hrefImg" src="../img/chk_off.png" title="Rechazar acreditación" /></a>&nbsp;':'';
		$proyectos [$i]['verproyecto'] = ($versolicitud)?'<a href="verproyectoPDF.php?id='.$proyectos [$i]['cd_proyecto'].'" target="_blank"><img class="hrefImg" src="../img/pdf.jpg"
			title="Ver proyecto"/></a>&nbsp;':'';
		$proyectos [$i]['linkobservaciones'] = (($proyectos [$i]['cd_estado']==5)&&(PermisoQuery::permisosDeUsuario( $cd_usuario, "Ver Observaciones SeCyT" )))?'<a href="verobservaciones.php?acreditar=1&cd_proyecto='.$proyectos [$i]['cd_proyecto'].'"><img
			class="hrefImg" src="../img/search.jpg" title="Ver Observaciones" /></a>&nbsp;':'';
		$proyectos [$i]['verreducido'] = (($versolicitud)&&(!PermisoQuery::permisosDeUsuario( $cd_usuario, "Evaluar proyecto" )))?'<a href="verproyectoPDF.php?id='.$proyectos [$i]['cd_proyecto'].'&reducido=1" target="_blank"><img class="hrefImg" src="../img/pdfA.jpg"
			title="Ver car&aacute;tula"/></a>':'';
		$proyectos [$i]['verplanilla'] = (($proyectos [$i]['cd_estado']==2)&&($versolicitud)&&(PermisoQuery::permisosDeUsuario( $cd_usuario, "Ver Planilla Admisibilidad" )))?'<a href="verplanillaPDF.php?id='.$proyectos [$i]['cd_proyecto'].'" target="_blank"><img class="hrefImg" src="../img/pdf0.jpg"
			title="Ver car&aacute;tula"/></a>':'';
	$oEvaluacion = new Evaluacion();
		$oEvaluacion->setCd_proyecto($proyectos [$i]['cd_proyecto']);
		$evaluaciones=EvaluacionQuery::getEvaluacionPorProyecto($oEvaluacion);
		$noEnviada=((EvaluacionQuery::controlEstado($oEvaluacion,6)||(count($evaluaciones)<2)));
		$proyectos [$i]['linkasignarevaluador'] = ((($proyectos [$i]['cd_estado']==3)||($proyectos [$i]['cd_estado']==6))&&(PermisoQuery::permisosDeUsuario( $cd_usuario, "Asignar Evaluador" )))?'<a href="../evaluadores/asignarevaluador.php?cd_proyecto='.$proyectos [$i]['cd_proyecto'].'"><img
			class="hrefImg" src="../img/asignarevaluador.jpg" title="Asignar evaluador" /></a>&nbsp;':'';
		$proyectos [$i]['linkenviarevaluador'] = ((($proyectos [$i]['cd_estado']==3)||($proyectos [$i]['cd_estado']==6))&&($noEnviada)&&(PermisoQuery::permisosDeUsuario( $cd_usuario, "Enviar a evaluador" )))?'<a href="" onclick="confirmaEnviarE(this,\'verproyectoPDF.php?enviarE=1&id='.$proyectos [$i]['cd_proyecto'].'\')"><img
			class="hrefImg" src="../img/enviaraevaluador.jpg" title="Enviar a evaluadores" /></a>&nbsp;':'';
		
		
		$oEvaluacion->setCd_usuario($cd_usuario);
		EvaluacionQuery::getEvaluacionPorProyectoEvaluador($oEvaluacion);
		$linkeval = ($proyectos[$i]['ds_tipoacreditacion']=='Proyectos I+D')?'evaluarproyecto':'evaluarproyectoPPID';
		$proyectos [$i]['linkevaluar'] = ((PermisoQuery::permisosDeUsuario( $cd_usuario, "Evaluar proyecto" ))&&($oEvaluacion->getCd_estado()!=8))?'<a href="'.$linkeval.'.php?cd_proyecto='.$proyectos [$i]['cd_proyecto'].'"><img class="hrefImg"
			src="../img/evaluarproyecto.jpg" title="Evaluar proyecto" /></a>&nbsp;':'';
		if (!PermisoQuery::permisosDeUsuario( $cd_usuario, "Ver evaluaciones" )){
			$proyectos [$i]['linkverevaluacion'] = ((PermisoQuery::permisosDeUsuario( $cd_usuario, "Ver evaluacion" ))&&(($proyectos [$i]['cd_estado']==6)||($proyectos [$i]['cd_estado']==8)))?'<a href="verevaluacionPDF.php?cd_proyecto='.$proyectos [$i]['cd_proyecto'].'&'.time().'"  target="_blank"><img class="hrefImg"
				src="../img/pdf0.jpg" title="Ver evaluacion"/></a>&nbsp;':'';
			$proyectos [$i]['linkenviarevaluacion'] = (($oEvaluacion->getCd_estado()!=8)&&(PermisoQuery::permisosDeUsuario( $cd_usuario, "Enviar evaluacion" )))?'<a href="" onclick="confirmaEnviarEv(this,\'verevaluacionPDF.php?enviar=1&cd_proyecto='.$proyectos [$i]['cd_proyecto'].'\')"><img
				class="hrefImg" src="../img/enviaraevaluador.jpg" title="Enviar evaluacion" /></a>&nbsp;':'';
			$proyectos [$i]['ds_estado']=(PermisoQuery::permisosDeUsuario( $cd_usuario, "Ver evaluacion" ))?$oEvaluacion->getDs_estado():$proyectos [$i]['ds_estado'];
		}
		else{
			
			
		$proyectos[$i]['ds_evaluaciones']='';
			for($j = 0; $j < count ( $evaluaciones ); $j ++) {
				$proyectos[$i]['ds_evaluaciones'] .= ((PermisoQuery::permisosDeUsuario( $cd_usuario, "Ver evaluacion" ))&&($evaluaciones [$j]['cd_estado']==8))?'<a href="verevaluacionPDF.php?cd_evaluacion='.$evaluaciones [$j]['cd_evaluacion'].'&cd_proyecto='.$proyectos [$i]['cd_proyecto'].'"  target="_blank"><img class="hrefImg"
				src="../img/pdf'.$j.'.jpg" title="Ver evaluacion"/></a>&nbsp;':'';
				
			}
		}
		if ((PermisoQuery::permisosDeUsuario( $cd_usuario, "Ver evaluaciones" ))){
			/*$proyectos [$i]['nu_puntaje']=(($proyectos [$i]['cd_estado']==2))?'<span class="Alta">'.FuncionesComunes::Format_toDecimal($proyectos [$i]['nu_puntaje']).'</span>':((($proyectos [$i]['cd_estado']==1))?'<span class="Director">'.FuncionesComunes::Format_toDecimal($proyectos [$i]['nu_puntaje']).'</span>':((($proyectos [$i]['cd_estado']==4))?'<span class="Baja">'.FuncionesComunes::Format_toDecimal($proyectos [$i]['nu_puntaje']).'</span>':FuncionesComunes::Format_toDecimal($proyectos [$i]['nu_puntaje'])));	
			$proyectos [$i]['nu_diferencia']=(($proyectos [$i]['cd_estado']==2))?'<span class="Alta">'.FuncionesComunes::Format_toDecimal($proyectos [$i]['nu_diferencia']).'</span>':((($proyectos [$i]['cd_estado']==1))?'<span class="Director">'.FuncionesComunes::Format_toDecimal($proyectos [$i]['nu_diferencia']).'</span>':((($proyectos [$i]['cd_estado']==4))?'<span class="Baja">'.FuncionesComunes::Format_toDecimal($proyectos [$i]['nu_diferencia']).'</span>':((($proyectos [$i]['nu_diferencia']>=10))?'<span class="Baja">'.FuncionesComunes::Format_toDecimal($proyectos [$i]['nu_diferencia']).'</span>':FuncionesComunes::Format_toDecimal($proyectos [$i]['nu_diferencia']))));
			$proyectos [$i]['nu_puntaje'] ='<td>'.$proyectos [$i]['nu_puntaje'].'</td>';
			$proyectos [$i]['nu_diferencia'] ='<td>'.$proyectos [$i]['nu_diferencia'].'</td>';*/
			if ($evaluaciones[0]['ds_usuario']){
				$aprobado = ($evaluaciones[0]['nu_puntaje'])?'NO APROBADO':(($evaluaciones[0]['cd_estado']!=8)?'':'APROBADO');
				$proyectos [$i]['ds_interno']=(($evaluaciones [0]['cd_estado']==6))?'<span class="Baja">'.$evaluaciones[0]['ds_usuario'].' / '.$evaluaciones[0]['ds_estado'].' / '.$aprobado.'</span><a href="" onclick="confirmaDesa(\'\', this,\'eliminarevaluacion.php?cd_evaluacion='.$evaluaciones[0]['cd_evaluacion'].'\')"><img	class="hrefImg" src="../img/del.jpg" title="Desasignar Evaluador" /></a>':$evaluaciones[0]['ds_usuario'].' / '.$evaluaciones[0]['ds_estado'].' / '.$aprobado;	
			}			
			$externo=0;
			if($evaluaciones[0]['bl_interno'])
				$proyectos [$i]['ds_interno'] ='<td>'.$proyectos [$i]['ds_interno'].'</td>';
			else {$proyectos [$i]['ds_externo'] ='<td>'.$proyectos [$i]['ds_interno'].'</td>';$proyectos [$i]['ds_interno']='<td></td>';$externo=1;};
			
			if ($evaluaciones[1]['ds_usuario']){
				$aprobado = ($evaluaciones[1]['nu_puntaje'])?'NO APROBADO':(($evaluaciones[1]['cd_estado']!=8)?'':'APROBADO');
				$proyectos [$i]['ds_externo']=(($evaluaciones [1]['cd_estado']==6))?'<span class="Baja">'.$evaluaciones[1]['ds_usuario'].' / '.$evaluaciones[1]['ds_estado'].' / '.$aprobado.'</span><a href="" onclick="confirmaDesa(\'\', this,\'eliminarevaluacion.php?cd_evaluacion='.$evaluaciones[1]['cd_evaluacion'].'\')"><img	class="hrefImg" src="../img/del.jpg" title="Desasignar Evaluador" /></a>':$evaluaciones[1]['ds_usuario'].' / '.$evaluaciones[1]['ds_estado'].' / '.$aprobado;	
			}			
			if(!$externo)
				$proyectos [$i]['ds_externo'] ='<td>'.$proyectos [$i]['ds_externo'].'</td>';
			if ($evaluaciones[2]['ds_usuario']){
				$aprobado = ($evaluaciones[2]['nu_puntaje'])?'NO APROBADO':(($evaluaciones[2]['cd_estado']!=8)?'':'APROBADO');
				$proyectos [$i]['ds_tercero']=(($evaluaciones [2]['cd_estado']==6))?'<span class="Baja">'.$evaluaciones[2]['ds_usuario'].' / '.$evaluaciones[2]['ds_estado'].' / '.$aprobado.'</span><a href="" onclick="confirmaDesa(\'\', this,\'eliminarevaluacion.php?cd_evaluacion='.$evaluaciones[2]['cd_evaluacion'].'\')"><img	class="hrefImg" src="../img/del.jpg" title="Desasignar Evaluador" /></a>':$evaluaciones[2]['ds_usuario'].' / '.$evaluaciones[2]['ds_estado'].' / '.$aprobado;		
			}			
			$proyectos [$i]['ds_tercero'] ='<td>'.$proyectos [$i]['ds_tercero'].'</td>';
		}
		else{
			
			$proyectos [$i]['ds_interno'] ='';
			$proyectos [$i]['ds_externo'] ='';
			$proyectos [$i]['ds_tercero'] ='';
			
		}
		$xtpl->assign ( 'DATOS', $proyectos [$i] );
		$xtpl->parse ( 'main.row' );
	}
	
	/***************************************************
	 * PAGINADOR
	 **************************************************/
	
	$num_rows = ProyectoQuery::getCountProyectos ( $filtro, $filtroFacultad, $filtroEstado, $filtroDir, $cd_usuario, $pendientes, $actual, $filtroTipoacreditacion );
	$num_pages = ceil ( $num_rows / $row_per_page );
	
	$url = 'index.php?orden=' . $orden . '&campo=' . $campo . '&filtro=' . $filtro. '&filtroFacultad=' . $filtroFacultad. '&filtroDir=' . $filtroDir. '&filtroTipoacreditacion=' . $filtroTipoacreditacion. '&filtroAcreditacion=' . $filtroAcreditacion. '&filtroEstado=' . $filtroEstado;
	$cssclassotherpage = 'paginadorOtraPagina';
	$cssclassactualpage = 'paginadorPaginaActual';
	$ds_pag_anterior = 0; //$gral['pag_ant'];
	$ds_pag_siguiente = 2; //$gral['pag_sig'];
	$imp_pag = new Paginador ( $url, $num_pages, $page, $cssclassotherpage, $cssclassactualpage, $num_rows );
	$paginador = $imp_pag->imprimirPaginado ();
	$resultados = $imp_pag->imprimirResultados ();
	
	$imgTIPAsc = (($campo=='ds_tipoacreditacion')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por tipo asc" src="../img/asc.jpg" />':'';
	$imgTIPDesc = (($campo=='ds_tipoacreditacion')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por tipo desc" src="../img/desc.jpg" />':'';
	
	$imgCODAsc = (($campo=='ds_codigo')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por codigo asc" src="../img/asc.jpg" />':'';
	$imgCODDesc = (($campo=='ds_codigo')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por codigo desc" src="../img/desc.jpg" />':'';
	
	$imgTITAsc = (($campo=='ds_titulo')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por titulo asc" src="../img/asc.jpg" />':'';
	$imgTITDesc = (($campo=='ds_titulo')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por titulo desc" src="../img/desc.jpg" />':'';
	
	$imgDIRAsc = (($campo=='ds_director')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por director asc" src="../img/asc.jpg" />':'';
	$imgDIRDesc = (($campo=='ds_director')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por director desc" src="../img/desc.jpg" />':'';
	
	$imgINIAsc = (($campo=='dt_ini')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por inicio asc" src="../img/asc.jpg" />':'';
	$imgINIDesc = (($campo=='dt_ini')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por inicio desc" src="../img/desc.jpg" />':'';
	
	$imgFINAsc = (($campo=='dt_fin')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por fin asc" src="../img/asc.jpg" />':'';
	$imgFINDesc = (($campo=='dt_fin')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por fin desc" src="../img/desc.jpg" />':'';
	
	$imgFACAsc = (($campo=='ds_facultad')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por facultad asc" src="../img/asc.jpg" />':'';
	$imgFACDesc = (($campo=='ds_facultad')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por facultad desc" src="../img/desc.jpg" />':'';
	
	$imgESTAsc = (($campo=='ds_estado')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por estado asc" src="../img/asc.jpg" />':'';
	$imgESTDesc = (($campo=='ds_estado')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por estado desc" src="../img/desc.jpg" />':'';
	
	$imgTIP=($imgTIPAsc!='')?$imgTIPAsc:(($imgTIPDesc!='')?$imgTIPDesc:'');
	$imgCOD=($imgCODAsc!='')?$imgCODAsc:(($imgCODDesc!='')?$imgCODDesc:'');
	$imgTIT=($imgTITAsc!='')?$imgTITAsc:(($imgTITDesc!='')?$imgTITDesc:'');
	$imgDIR=($imgDIRAsc!='')?$imgDIRAsc:(($imgDIRDesc!='')?$imgDIRDesc:'');
	$imgINI=($imgINIAsc!='')?$imgINIAsc:(($imgINIDesc!='')?$imgINIDesc:'');
	$imgFIN=($imgFINAsc!='')?$imgFINAsc:(($imgFINDesc!='')?$imgFINDesc:'');
	$imgFAC=($imgFACAsc!='')?$imgFACAsc:(($imgFACDesc!='')?$imgFACDesc:'');
	$imgEST=($imgESTAsc!='')?$imgESTAsc:(($imgESTDesc!='')?$imgESTDesc:'');
	
	$inverso=($orden=='DESC')?'ASC':'DESC';
	
	
	if ((PermisoQuery::permisosDeUsuario( $cd_usuario, "Ver evaluaciones" ))){
		
		$ds_thinterno = '<th>Evaluador 1</th>';
		$xtpl->assign ( 'ds_interno', $ds_thinterno);	
		$ds_thexterno = '<th>Evaluador 2</th>';
		$xtpl->assign ( 'ds_externo', $ds_thexterno);	
		$ds_thtercero = '<th>Evaluador 3</th>';
		$xtpl->assign ( 'ds_tercero', $ds_thtercero);	
		
	}
	
	$xtpl->assign ( 'imgTIP', $imgTIP );
	$xtpl->assign ( 'imgCOD', $imgCOD );
	$xtpl->assign ( 'imgTIT', $imgTIT );
	$xtpl->assign ( 'imgDIR', $imgDIR );
	$xtpl->assign ( 'imgINI', $imgINI );
	$xtpl->assign ( 'imgFIN', $imgFIN );
	$xtpl->assign ( 'imgFAC', $imgFAC );
	$xtpl->assign ( 'imgEST', $imgEST );
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