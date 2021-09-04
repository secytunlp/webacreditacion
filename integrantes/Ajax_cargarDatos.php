<?php
include '../includes/include.php';
include '../includes/datosSession.php';

if (isset ( $_GET ['cd_docente1'] ))
	$cd_docente = $_GET ['cd_docente1']; else
	$cd_docente = 0;
	
if (isset ( $_GET ['cd_proyecto'] ))
	$cd_proyecto = $_GET ['cd_proyecto']; else
	$cd_proyecto = 0;

$oProyecto = new Proyecto ( );
$oProyecto->setCd_proyecto ( $cd_proyecto );
ProyectoQuery::getProyectoPorid ( $oProyecto );	

$oDocente = new Docente();	
$oDocente->setCd_docente(intval($cd_docente));
DocenteQuery::getDocentePorId ( $oDocente );	
$disabled = ((PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar docente" ))||(!$oDocente->getCd_docente())||($oDocente->getCd_docente()>=90000))?'':'disabled="disabled"';
$nu_precuil=($oDocente->getNu_precuil()==0)?'':$oDocente->getNu_precuil();
$nu_documento=($oDocente->getNu_documento()==0)?'':$oDocente->getNu_documento();
$nu_postcuil=($oDocente->getNu_postcuil()===0)?'':$oDocente->getNu_postcuil();
$html = '<p><strong>Apellido y Nombre(*): </strong>
    <input type="text" name="ds_apellido" id="ds_apellido" value="'.htmlentities($oDocente->getDs_apellido()).'" class="" style="width:300px" onchange="mayusculas(this)" />,
    <input type="text" name="ds_nombre" id="ds_nombre" value="'.htmlentities($oDocente->getDs_nombre()).'" class="" onchange="mayusculas(this)" '.$disabled.'/></p>';
$html .= " <p><strong>C.U.I.L.(*):</strong> 
    <input type='text' name='nu_precuil' id='nu_precuil' value='".$nu_precuil."' size='2' maxlength='2' class='' /> -
	<input type='text' name='nu_documento' id='nu_documento' value='".$nu_documento."' size='10' maxlength='9' class=''/> - <input type='text' name='nu_postcuil' id='nu_postcuil' value='".$nu_postcuil."' size='1' maxlength='1' class='' /> F. Nacimiento (*):
                                                                          <input type='text' name='dt_nacimiento' id='dt_nacimiento' size='10' value='".FuncionesComunes::fechaMysqlaPHP($oDocente->getDt_nacimiento())."' />
    </p>";


 $html .= " <p><strong>Calle: </strong><input type='text' name='ds_calle' id='ds_calle' size='20' value='".htmlentities($oDocente->getDs_calle())."' onchange='mayusculas(this)' /> <strong>Nro.</strong><input type='text' name='nu_nro' id='nu_nro' size='10' value='".htmlentities($oDocente->getNu_nro())."' onchange='mayusculas(this)' /><strong>Piso</strong><input type='text' name='nu_piso' id='nu_piso' size='5' value='".htmlentities($oDocente->getNu_piso())."' onchange='mayusculas(this)' /><strong>Depto.</strong><input type='text' name='ds_depto' id='ds_depto' size='5' value='".htmlentities($oDocente->getDs_depto())."' onchange='mayusculas(this)' /></p>";
 $html .= "<p><strong>Provincia:</strong><select name='cd_provincia' id='cd_provincia' style='width: 300px'><option value=''> -- Seleccione una -- </option>";
$provincias = ProvinciaQuery::listar ($oDocente->getCd_provincia());
$rowsize = count ( $provincias );

for($i = 0; $i < $rowsize; $i ++) {
	
	$html .= "<option value=" . $provincias [$i] ['cd_provincia'] . ">" . htmlentities($provincias [$i] ['ds_provincia']) . "</option>";
}							
$html .= "</select>";
$html .= "<strong>Localidad: </strong><input type='text' name='ds_localidad' id='ds_localidad' size='26' value='".htmlentities($oDocente->getDs_localidad())."' onchange='mayusculas(this)' /><strong>C.P.</strong><input type='text' name='nu_cp' id='nu_cp' size='10' value='".htmlentities($oDocente->getNu_cp())."' onchange='mayusculas(this)'/></p>"; 
$html .= "<p><strong>Tel&eacute;fono</strong><input type='text' name='nu_telefono' id='nu_telefono' size='46' value='".htmlentities($oDocente->getNu_telefono())."' onchange='mayusculas(this)' />";
$html .= "<strong>E-mail (*): </strong><input type='text' name='ds_mail' id='ds_mail' size='46' value='".htmlentities($oDocente->getDs_mail())."'/> </p>";
$html .= "<p><strong>Universidad  (*):</strong><input type='text' name='ds_universidad' id='ds_universidad' value='".$oDocente->getDs_universidad()."'  style='width:350px' onchange='mayusculas(this)'/><input type='text' id='cd_universidad' name='cd_universidad' value='".$oDocente->getCd_universidad()."' style='font-size: 10px; width: 20px;display:none' /></p>";
$html .= "<p><strong>Unidad Acad&eacute;mica (*):</strong><select name='cd_facultad' id='cd_facultad' class='' style='width: 300px' >
							<option value=''>- Seleccione Una -</option>";
$facultads = FacultadQuery::listar ($oDocente->getCd_facultad());
$rowsize = count ( $facultads );

for($i = 0; $i < $rowsize; $i ++) {
	
	$html .= "<option value=" . $facultads [$i] ['cd_facultad'] . ">" . htmlentities($facultads [$i] ['ds_facultad']) . "</option>";
}							
$html .= "</select></p>";


$nivel=$oDocente->getNu_nivelunidad();

$oUnidad = new Unidad();
$oUnidad->setCd_unidad($oDocente->getCd_unidad());
UnidadQuery::getUnidadPorId($oUnidad);








$html .= "<p><strong>Lugar de trabajo (*):</strong><input type='text' id='nu_nivelunidad' name='nu_nivelunidad' value='".$nivel."' style='font-size: 10px; width: 20px;display:none' />
                                                <input type='text' name='ds_unidad' id='ds_unidad' value='".$oUnidad->getDs_unidad()."' style='width:500px' onchange='mayusculas(this)' />
                                                <input type='text' id='cd_unidad' name='cd_unidad' value='".$oUnidad->getCd_unidad()."' style='font-size: 10px; width: 20px;display:none' /></p></div>";


$html .= "<p><strong>Cargo docente(*):</strong><select name='cd_cargo' id='cd_cargo'>
							<option value=''>- Seleccione Uno -</option>";
$cargos = CargoQuery::listar ($oDocente->getCd_cargo());
$rowsize = count ( $cargos );

for($i = 0; $i < $rowsize; $i ++) {
	
	$html .= "<option value=" . $cargos [$i] ['cd_cargo'] . ">" . htmlentities($cargos [$i] ['ds_cargo']) . "</option>";
}							
$html .= "</select>";
$html .= "<strong>Dedicaci&oacute;n(*):</strong><select name='cd_deddoc' id='cd_deddoc'>
							<option value=''>- Seleccione Uno -</option>";
							
$deddocs = DeddocQuery::listar ($oDocente->getCd_deddoc());
	$rowsize = count ( $deddocs );
	
	for($i = 0; $i < $rowsize; $i ++) {
		
		$html .= "<option value=" . $deddocs [$i] ['cd_deddoc'] . ">" . htmlentities($deddocs [$i] ['ds_deddoc']) . "</option>";
	}


$html .= "</select></p><div id='divCargo' class='fValidator-msg'></div><div id='divDed' class='fValidator-msg' align='right'></div>";
/*$html .= "<p><strong>Categor&iacute;a de Docente Investigador(*):</strong><select name='cd_categoria' id='cd_categoria'  class='' style='width: 300px'>
							<option value=''>- Seleccione Uno -</option>";
							
$categorias = CategoriaQuery::listar ($oDocente->getCd_categoria());
	$rowsize = count ( $categorias );
	
	for($i = 0; $i < $rowsize; $i ++) {
		
		$html .= "<option value=" . $categorias [$i] ['cd_categoria'] . ">" . htmlentities($categorias [$i] ['ds_categoria']) . "</option>";
	}


$html .= "</select></p>";*/
$chckSI = ($oDocente->getBl_becario())?"checked='checked'":"";
$chckNO = (!$oDocente->getBl_becario())?"checked='checked'":"";
$html .= "<p>Becario: SI    <input name='bl_becario' id='bl_becario' type='radio' value='1' ".$chckSI."/>
 No
 <input name=\"bl_becario\" type=\"radio\" value=\"0\" ".$chckNO."/>

</p>
					<p> <strong>Tipo</strong>
			        <input type='text' name='ds_tipobeca' id='ds_tipobeca' value='".htmlentities($oDocente->getDs_tipobeca())."' size='46' onchange='mayusculas(this)'/>
			        <strong>Instituci&oacute;n: </strong>
			        <input type='text' name='ds_orgbeca' id='ds_orgbeca' size='46' value='".htmlentities($oDocente->getDs_orgbeca())."' onchange='mayusculas(this)'/> </p><div id='divTipobeca' class='fValidator-msg'></div><div id='divOrgbeca' class='fValidator-msg' align='right'></div>";


$html .= "<p><strong>Cargo en la C. del  Inv.(*):</strong><select name='cd_carrerainv' id='cd_carrerainv'>
							<option value=''>- Seleccione Uno -</option>";
							
$carrerainvs = CarrerainvQuery::listar ($oDocente->getCd_carrerainv());
	$rowsize = count ( $carrerainvs );
	
	for($i = 0; $i < $rowsize; $i ++) {
		
		$html .= "<option value=" . $carrerainvs [$i] ['cd_carrerainv'] . ">" . htmlentities($carrerainvs [$i] ['ds_carrerainv']) . "</option>";
	}


$html .= "</select>";
$html .= "<strong>Organismo(*):</strong><select name='cd_organismo' id='cd_organismo'  class='' style='width: 250px'>
							<option value=''>- Seleccione Uno -</option>";
							
$organismos = OrganismoQuery::listar ($oDocente->getCd_organismo());
	$rowsize = count ( $organismos );
	
	for($i = 0; $i < $rowsize; $i ++) {
		
		$html .= "<option value=" . $organismos [$i] ['cd_organismo'] . ">" . htmlentities($organismos [$i] ['ds_organismo']) . "</option>";
	}


$html .= "</select></p><div id='divCarrera' class='fValidator-msg'></div>";
$oTitulo = new Titulo();
$oTitulo->setCd_titulo($oDocente->getCd_titulo());
TituloQuery::getTituloPorId($oTitulo);
$html .= "<p><strong>T&iacute;tulo de Grado(*):</strong><input type='text' name='ds_titulogrado' id='ds_titulogrado' value='".htmlentities($oTitulo->getDs_titulo())."'  style='width:280px' onchange='mayusculas(this)'/>
                                                       <input type='text' id='cd_titulogrado' name='cd_titulogrado' value='".$oTitulo->getCd_titulo()."'  style='font-size: 10px; width: 20px;display:none' />";
$oTitulo = new Titulo();
$oTitulo->setCd_titulo($oDocente->getCd_titulopost());
TituloQuery::getTituloPorId($oTitulo);
$html .= "<strong>T&iacute;tulo de Posgrado:</strong>
				 
				  <input type='text' name='ds_titulopost' id='ds_titulopost' value='".htmlentities($oTitulo->getDs_titulo())."' style='width:280px' onchange='mayusculas(this)'/>
				 
				  <input type='text' id='cd_titulopost' name='cd_titulopost' value='".$oTitulo->getCd_titulo()."' style='font-size: 10px; width: 20px;display:none' /></p>";
$html .= "<p><strong>Curriculum Vitae (*):</strong> 
				    <input type='file' name='ds_curriculum' id='ds_curriculum' size='32'/>
				    <input type='hidden' name='ds_curriculumH' id='ds_curriculumH' value='' />
					<div id='cv'></div></p>
				  <p>";
$html .= "<table width='100%' border='1' align='center' cellspacing='0'>
						 <caption align='top'><strong>Participaci&oacute;n en proyectos (*):</strong><span class='Estilo1'>El Director/es y cada integrante deber&aacute; especificar todos los proyectos en los que interviene (t&iacute;tulo y director) indicando claramente la participaci&oacute;n en horas semanales en cada proyecto (incluyendo el proyecto en acreditaci&oacute;n).<br />Los miembros del proyecto con mayor dedicaci&oacute;n podr&aacute;n participarhasta en 2 (dos) proyectos acreditados, y los miembros con dedicaci&oacute;n simple en un (1) proyecto.</span>
                    </caption>
  <tr>
    <th scope='col'><div align='center'>C&oacute;digo</div></th>
    <th scope='col'><div align='center'>T&iacute;tulo</div></th>
	 <th scope='col'><div align='center'>Director</div></th>
	  <th scope='col'><div align='center'>Tipo</div></th>
	  <th scope='col'><div align='center'>Inicio</div></th>
	   <th scope='col'><div align='center'>Fin</div></th>
	   <th scope='col'><div align='center'>Horas por semana</div></th>
  </tr>";
  $proyectos = ProyectoQuery::getProyectosDocentes($oDocente->getCd_docente() );
	$count = count ( $proyectos );
	for($i = 0; $i < $count; $i ++) {
		$html .= "<tr>";
		$html .= "<td>".$proyectos[$i]['ds_codigo']."</td>";
		$html .= "<td><div align='left'>".htmlentities($proyectos[$i]['ds_titulo'])."</div></td>";
		$html .= "<td><div align='left'>".htmlentities($proyectos[$i]['ds_director'])."</div></td>";
		$html .= "<td><div align='left'>".htmlentities($proyectos[$i]['ds_tipoinvestigador'])."</div></td>";
		$html .= "<td>".FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini'])."</td>";
		$html .= "<td>".FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin'])."</td>";
		$disabled = ($proyectos[$i]['nu_horasinv'])?'readonly':'';
		$nu_horasinv=($proyectos[$i]['nu_horasinv'])?$proyectos[$i]['nu_horasinv']:'0';
		$html .= "<td><input type='text' name='nu_horasinv".$proyectos[$i]['cd_proyecto']."' id='nu_horasinv".$proyectos[$i]['cd_proyecto']."' size='10' maxlength='50' value='".$nu_horasinv."' class=''".$disabled." /><div id='div".$i."' class='fValidator-msg'></div><input type='hidden' name='p".$i."' id='p".$i."' value='".$proyectos[$i]['cd_proyecto']."'/><input type='hidden' name='pTI".$i."' id='pTI".$i."' value='".$proyectos[$i]['cd_tipoinvestigador']."'/></td>";
		$html .= "</tr>";
		
	}
  
  	
	$html .= "<tr>";
	$html .= "<td>".$oProyecto->getDs_codigo()."</td>";
	$html .= "<td><div align='left'>".htmlentities($oProyecto->getDs_titulo())."</div></td>";
	$html .= "<td><div align='left'>".htmlentities($oProyecto->getDs_director())."</div></td>";
	$html .= "<td><div align='left'></div></td>";
	$html .= "<td>".FuncionesComunes::fechaMysqlaPHP($oProyecto->getDt_ini())."</td>";
	$html .= "<td>".FuncionesComunes::fechaMysqlaPHP($oProyecto->getDt_fin())."</td>";
	$html .= "<td><input type='text' name='nu_horasinv".$oProyecto->getCd_proyecto()."' id='nu_horasinv".$oProyecto->getCd_proyecto()."' size='10' maxlength='50' value='0' class='' /><div id='div".$count."' class='fValidator-msg'></div><input type='hidden' name='p".$count."' id='p".$count."' value='".$oProyecto->getCd_proyecto()."'/><input type='hidden' name='pTI".$count."' id='pTI".$count."' value='0'/></td>";
	
	$html .= "</tr>";
  $html .= "</table>";

$html .= "<input type='hidden' name='cd_docente' id='cd_docente' value='".$oDocente->getCd_docente()."' />";
echo $html;

?>