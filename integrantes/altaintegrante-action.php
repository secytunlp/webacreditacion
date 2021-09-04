<?
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Alta integrante" )) {
	$cd_proyecto = $_POST ['cd_proyecto'];
	$oIntegrante = new Integrante();
	$oDocente = new Docente ( );
	$ds_tipomodificacion='';
	if (isset ( $_POST ['nu_documento'] )){
		$ds_tipomodificacion .= ($_POST ['nu_documento'] != $oDocente->getNu_documento())?'Documento-':'';
		$oDocente->setNu_documento (  $_POST ['nu_documento'] );
		DocenteQuery::getDocentePorDocumento($oDocente);
		
		
		$oIntegrante->setCd_docente($oDocente->getCd_docente());
		$oIntegrante->setCd_proyecto($cd_proyecto);
		IntegranteQuery::getIntegrantePorId($oIntegrante);	
		$insertarInt=($oIntegrante->getDt_alta())?0:1;
	}
	if (isset ( $_POST ['cd_categoria'] )){
			$ds_tipomodificacion .= ($_POST ['cd_categoria'] != $oDocente->getCd_categoria())?'Categor?a-':'';
			$oDocente->setCd_categoria ( $_POST ['cd_categoria'] );
	}
	$oCategoria = new Categoria();
	$oCategoria->setCd_categoria($oDocente->getCd_categoria());
	CategoriaQuery::getCategoriaPorId($oCategoria);
	if (isset ( $_POST ['cd_unidad'] )){
		$ds_tipomodificacion .= ($_POST ['cd_unidad'] != $oDocente->getCd_unidad())?'Unidad-':'';
		$oDocente->setCd_unidad(  ( $_POST ['cd_unidad'] ) );
	
	}
	
	if (isset ( $_POST ['ds_apellido'] )){
		$ds_tipomodificacion .= ($_POST ['ds_apellido'] != $oDocente->getDs_apellido())?'Apellido-':'';
		$oDocente->setDs_apellido ( $_POST ['ds_apellido'] );
	}
	
	if (isset ( $_POST ['nu_nivelunidad'] )){
		$oDocente->setNu_nivelunidad(  ( $_POST ['nu_nivelunidad'] ) );
		
	}
	if (isset ( $_POST ['cd_carrerainv'] )){
		$ds_tipomodificacion .= ($_POST ['cd_carrerainv'] != $oDocente->getCd_carrerainv())?'Carrera-':'';
		$oDocente->setCd_carrerainv ( $_POST ['cd_carrerainv'] );
	}
	if (isset ( $_POST ['bl_becario'] )){
		$ds_tipomodificacion .= ($_POST ['bl_becario'] != $oDocente->getBl_becario())?'Becario-':'';
		$oDocente->setBl_becario ( $_POST ['bl_becario'] );
	}
	if (isset ( $_POST ['cd_organismo'] )){
		$ds_tipomodificacion .= ($_POST ['cd_organismo'] != $oDocente->getCd_organismo())?'Organismo-':'';
		$oDocente->setCd_organismo ( $_POST ['cd_organismo'] );
	}
	if (isset ( $_POST ['cd_tipoinvestigador'] ))
		$oIntegrante->setCd_tipoinvestigador ( $_POST ['cd_tipoinvestigador'] );
	$oUnidad = new Unidad();
	$oUnidad->setCd_unidad($oDocente->getCd_unidad());
	UnidadQuery::getUnidadPorId($oUnidad);
	$nivel=$oDocente->getNu_nivelunidad();
	/*while($nivel>0){
		UnidadQuery::getUnidadPorId($oUnidad);
		
	
		$oUnidad->setCd_unidad($oUnidad->getCd_padre());
		$nivel--;
	}*/
	$insertar=0;
	while(($oUnidad->getCd_padre()!=0)&&($insertar==0)){
		$insertar=(($oUnidad->getCd_padre()==1850)||($oUnidad->getCd_padre()==20419))?1:0;
		if (!$insertar){
			$oUnidad->setCd_unidad($oUnidad->getCd_padre());
			UnidadQuery::getUnidadPorId($oUnidad);
		}
			
		
	}
	$oProyecto = new Proyecto ( );
		$oProyecto->setCd_proyecto ( $cd_proyecto );
		ProyectoQuery::getProyectoPorId($oProyecto);
	if ((($oIntegrante->getCd_tipoinvestigador()==2)&&((in_array($oCategoria->getDs_categoria(),$categoriasPermitidas)||((in_array($oDocente->getCd_carrerainv(), $carrerainvs))&&(($oUnidad->getCd_padre()==1850)||($oUnidad->getCd_padre()==20419))||(($oProyecto->getCd_tipoacreditacion()==2)&&($oCategoria->getDs_categoria()!='V'))))))||($oIntegrante->getCd_tipoinvestigador()!=2)){
		
		
		
		
		   
			
		
		
		
		
		if (isset ( $_POST ['cd_deddoc'] )){
			$ds_tipomodificacion .= ($_POST ['cd_deddoc'] != $oDocente->getCd_deddoc())?'Dedicaci?n-':'';
			$oDocente->setCd_deddoc ( $_POST ['cd_deddoc'] );
		}
		
		$max = ((in_array($oDocente->getCd_deddoc(), $mayordedicacion))||(in_array($oDocente->getCd_carrerainv(), $carrerainvs)) ||($oDocente->getBl_becario()))?1:0;	
		if ((!IntegranteQuery::masDeUnProyecto($oDocente->getCd_docente(),$max))||($oIntegrante->getCd_tipoinvestigador()==6)){
			if ($insertarInt){
				if ($_FILES['ds_curriculum']['tmp_name']) {
		   
			
					$dir = APP_PATH.'pdfs/'.$_SESSION ["nu_yearSession"].'/';
					if (!file_exists($dir)) mkdir($dir, 0777); 
					$dir .= $oProyecto->getCd_proyecto().'/';
					if (!file_exists($dir)) mkdir($dir, 0777);
					$ds_apellido = stripslashes(str_replace("'","_",$oDocente->getDs_apellido()));
					
					$nuevo=$_FILES['ds_curriculum']['name'];
					$pos = strrpos($nuevo,'.');
					
					if ($pos)
						$extension=substr($nuevo, $pos, strlen($nuevo));
								
					$nuevo="CV_".FuncionesComunes::stripAccents($ds_apellido).'_'.$oDocente->getNu_documento().$extension;
					
			        if (!move_uploaded_file($_FILES['ds_curriculum']['tmp_name'], $dir.$nuevo)){
						echo '<script> window.top.mensajeError(\'Error al Subir el Archivo '.$dir.$nuevo.'\');</script>';
						exit;
			        }
					
			    	$oIntegrante->setDs_curriculum($nuevo);
				}
						
				$insertar=($oDocente->getNu_ident())?0:1;
				
				if (isset ( $_POST ['cd_facultad'] )){
					$ds_tipomodificacion .= ($_POST ['cd_facultad'] != $oDocente->getCd_facultad())?'Facultad-':'';
					$oDocente->setCd_facultad ( $_POST ['cd_facultad'] );
				}
				/*if (isset ( $_POST ['nu_duracion'] ))
					$oProyecto->setNu_duracion ( $_POST ['nu_duracion'] );
				$oProyecto->setBl_altapendiente(1);
				$exito = ProyectoQuery::modificarProyecto ( $oProyecto );*/
				
				
				if (isset ( $_POST ['ds_nombre'] )){
					$ds_tipomodificacion .= ($_POST ['ds_nombre'] != $oDocente->getDs_nombre())?'Nombre-':'';
					$oDocente->setDs_nombre ( $_POST ['ds_nombre'] );
				}
				if (isset ( $_POST ['nu_precuil'] )){
					$ds_tipomodificacion .= ($_POST ['nu_precuil'] != $oDocente->getNu_precuil())?'Precuil-':'';
					$oDocente->setNu_precuil ( $_POST ['nu_precuil'] );
				}
				if (isset ( $_POST ['nu_documento'] )){
					$ds_tipomodificacion .= ($_POST ['nu_documento'] != $oDocente->getNu_documento())?'Documento-':'';
					$oDocente->setNu_documento ( $_POST ['nu_documento'] );
				}
				if (isset ( $_POST ['nu_postcuil'] )){
					$ds_tipomodificacion .= ($_POST ['nu_postcuil'] != $oDocente->getNu_postcuil())?'Postcuil-':'';
					$oDocente->setNu_postcuil ( $_POST ['nu_postcuil'] );
				}
				if (isset ( $_POST ['dt_nacimiento'] )){
					
					$ds_tipomodificacion .= (FuncionesComunes::fechaPHPaMysql($_POST ['dt_nacimiento']) != $oDocente->getDt_nacimiento())?'Nacimiento-':'';
					$oDocente->setDt_nacimiento(  ( FuncionesComunes::fechaPHPaMysql($_POST ['dt_nacimiento']) ) );
				}
				if (isset ( $_POST ['ds_calle'] )){
					$ds_tipomodificacion .= ($_POST ['ds_calle'] != $oDocente->getDs_calle())?'Calle-':'';
					$oDocente->setDs_calle ( $_POST ['ds_calle'] );
				}
				if (isset ( $_POST ['nu_nro'] )){
					$ds_tipomodificacion .= ($_POST ['nu_nro'] != $oDocente->getNu_nro())?'Nro-':'';
					$oDocente->setNu_nro ( $_POST ['nu_nro'] );
				}
					
				if (isset ( $_POST ['nu_piso'] )){
					$ds_tipomodificacion .= ($_POST ['nu_piso'] != $oDocente->getNu_piso())?'Piso-':'';
					$oDocente->setNu_piso ( $_POST ['nu_piso'] );
				}
				if (isset ( $_POST ['ds_depto'] )){
					$ds_tipomodificacion .= ($_POST ['ds_depto'] != $oDocente->getDs_depto())?'Depto-':'';
					$oDocente->setDs_depto ( $_POST ['ds_depto'] );
				}
				if (isset ( $_POST ['cd_provincia'] )){
					$ds_tipomodificacion .= ($_POST ['cd_provincia'] != $oDocente->getCd_provincia())?'Provincia-':'';
					$oDocente->setCd_provincia ( $_POST ['cd_provincia'] );
				}
				if (isset ( $_POST ['ds_localidad'] )){
					$ds_tipomodificacion .= ($_POST ['ds_localidad'] != $oDocente->getDs_localidad())?'Localidad-':'';
					$oDocente->setDs_localidad ( $_POST ['ds_localidad'] );
				}
				if (isset ( $_POST ['nu_cp'] )){
					$ds_tipomodificacion .= ($_POST ['nu_cp'] != $oDocente->getNu_cp())?'CP-':'';
					$oDocente->setNu_cp ( $_POST ['nu_cp'] );
				}
				if (isset ( $_POST ['nu_telefono'] )){
					$ds_tipomodificacion .= ($_POST ['nu_telefono'] != $oDocente->getNu_telefono())?'Telefono-':'';
					$oDocente->setNu_telefono ( $_POST ['nu_telefono'] );
				}
				if (isset ( $_POST ['ds_mail'] )){
					$ds_tipomodificacion .= ($_POST ['ds_mail'] != $oDocente->getDs_mail())?'Mail-':'';
					$oDocente->setDs_mail ( $_POST ['ds_mail'] );
				}
				if (isset ( $_POST ['cd_cargo'] )){
					$ds_tipomodificacion .= ($_POST ['cd_cargo'] != $oDocente->getCd_cargo())?'Cargo-':'';
					$oDocente->setCd_cargo ( $_POST ['cd_cargo'] );
				}
				if (isset ( $_POST ['cd_deddoc'] )){
					$ds_tipomodificacion .= ($_POST ['cd_deddoc'] != $oDocente->getCd_deddoc())?'Dedicaci?n-':'';
					$oDocente->setCd_deddoc ( $_POST ['cd_deddoc'] );
				}
				if (isset ( $_POST ['cd_universidad'] )){
					$ds_tipomodificacion .= ($_POST ['cd_universidad'] != $oDocente->getCd_universidad())?'Universidad-':'';
					$oDocente->setCd_universidad ( $_POST ['cd_universidad'] );
				}
				if (isset ( $_POST ['bl_becario'] )){
					$ds_tipomodificacion .= ($_POST ['bl_becario'] != $oDocente->getBl_becario())?'Becario-':'';
					$oDocente->setBl_becario ( $_POST ['bl_becario'] );
				}
				if (isset ( $_POST ['ds_tipobeca'] )){
					$ds_tipomodificacion .= ($_POST ['ds_tipobeca'] != $oDocente->getDs_tipobeca())?'Tipo Beca-':'';
					$oDocente->setDs_tipobeca ( $_POST ['ds_tipobeca'] );
				}
				if (isset ( $_POST ['ds_orgbeca'] )){
					$ds_tipomodificacion .= ($_POST ['ds_orgbeca'] != $oDocente->getDs_orgbeca())?'Org. Beca-':'';
					$oDocente->setDs_orgbeca ( $_POST ['ds_orgbeca'] );
				}
				if (isset ( $_POST ['cd_titulogrado'] )){
					$ds_tipomodificacion .= ($_POST ['cd_titulogrado'] != $oDocente->getCd_titulo())?'T?tulo-':'';
					$oDocente->setCd_titulo ( $_POST ['cd_titulogrado'] );
				}
				if (isset ( $_POST ['cd_titulopost'] )){
					$ds_tipomodificacion .= ($_POST ['cd_titulopost'] != $oDocente->getCd_titulopost())?'T?tulo posgrado-':'';
					$oDocente->setCd_titulopost ( $_POST ['cd_titulopost'] );
				}
				$ds_tipomodificacion = ($ds_tipomodificacion)?substr($ds_tipomodificacion,0,strlen($ds_tipomodificacion)-1):$ds_tipomodificacion;	
				$ds_tipomodificacion = ($oDocente->getCd_docente()>$max_cd_docente)?'Nuevo':$ds_tipomodificacion;
				if ($ds_tipomodificacion){
					$oTipomodificacion = new Tipomodificacion();
					$oTipomodificacion->setDs_tipomodificacion($ds_tipomodificacion);
					TipomodificacionQuery::getTipomodificacionPorDs($oTipomodificacion);
					if (!$oTipomodificacion->getCd_tipomodificacion()){
						TipomodificacionQuery::insertarTipomodificacion($oTipomodificacion);
					}
					$oDocente->setCd_tipomodificacion($oTipomodificacion->getCd_tipomodificacion());
				}		
				
				
				if ($insertar){
					$db = Db::conectar ();
					$id = DocenteQuery::insert_id ( $db );
					$db->sql_close;
					$id = ($id>=90000)?$id+1:90000;
					$oDocente->setNu_ident($id);
					$oDocente->setCd_docente($id);
					$exito = DocenteQuery::insertarDocente ( $oDocente );	
					$oIntegrante->setCd_docente($oDocente->getCd_docente());		
				}
				else $exito =DocenteQuery::modificarDocente ( $oDocente );	
				
				
				if ($exito){
				 	if (isset ( $_POST ['nu_horasinv'.$oProyecto->getCd_proyecto()] ))
						$oIntegrante->setNu_horasinv ( $_POST ['nu_horasinv'.$oProyecto->getCd_proyecto()] );
					
					$oIntegrante->setDt_alta ($oProyecto->getDt_ini() );
					IntegranteQuery::insertarIntegrante ( $oIntegrante );	
					$i=0;
					$ok=1;
					while ($ok){
						if (isset ( $_POST ['p'.$i] )){
							$cd_otro = $_POST ['p'.$i];
							if ($cd_otro != $oProyecto->getCd_proyecto()){
								if (isset ( $_POST ['nu_horasinv'.$cd_otro] )){
									$oIntegrante->setCd_docente($oDocente->getCd_docente());
									$oIntegrante->setCd_proyecto($cd_otro);
									IntegranteQuery::getIntegrantePorId($oIntegrante);	
									$oIntegrante->setNu_horasinv ( $_POST ['nu_horasinv'.$cd_otro] );
									IntegranteQuery::modificarIntegrante($oIntegrante);
								}
							}
						}
						else $ok=0;
						$i++;
					}		
				}
				
				if ($exito){
					$oFuncion = new Funcion();
					$oFuncion -> setDs_funcion("Alta integrante");
					FuncionQuery::getFuncionPorDs($oFuncion);
					$oMovimiento = new Movimiento();
					$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
					$oMovimiento->setCd_usuario($cd_usuario);
					$oMovimiento->setDs_movimiento('Docente: '.$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil().' - Proyecto: '.$oProyecto->getCd_proyecto());
					//$oMovimiento->setDs_consecuencia($_POST ['ds_consecuencia']);
					MovimientoQuery::insertarMovimiento($oMovimiento);
					header ( 'Location: ../proyectos/verproyecto.php?id='.$oProyecto->getCd_proyecto() ); 
				}else
					header ( 'Location: altaintegrante.php?er=1&cd_proyecto=' . $oProyecto->getCd_proyecto() );
			}
			else
				header ( 'Location: altaintegrante.php?er=2&cd_proyecto=' . $oProyecto->getCd_proyecto() );
		}
		else
				header ( 'Location: altaintegrante.php?er=3&cd_proyecto=' . $cd_proyecto );
	}
	else
		header ( 'Location: altaintegrante.php?er=4&cd_proyecto=' . $cd_proyecto );
} else
	header ( 'Location:../includes/finsolicitud.php' );
	