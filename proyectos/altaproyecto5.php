<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';


$insertar = ($_SESSION ['insertar'])?$_SESSION ['insertar']:(($_GET['insertar'])?$_GET['insertar']:0);
$_SESSION ['insertar'] = $insertar;
$funcion = ($insertar)?"Alta proyecto":"Modificar proyecto";
if (PermisoQuery::permisosDeUsuario( $cd_usuario, $funcion )) {
	//include APP_PATH . 'includes/menu.php';
	$xtpl = new XTemplate ( 'altaproyecto5.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	
		
		$oProyecto = $_SESSION['proyecto'];
		if ($oProyecto->getCd_estado()==1) {
				
			$oIntegrante = (isset ( $_SESSION ['integrante'] ))?$_SESSION ['integrante']:new Integrante( );
			
			$oDocente =(isset ( $_SESSION ['docente'] ))?$_SESSION ['docente']:new Docente ( );
			
			$oProyecto->iniEvaluadores();
				$i=0;
				while ( ( $_POST ['cd_excusado'.($i+1)] )){
					
						$oProyecto->setEvaluadores( $_POST ['cd_excusado'.($i+1)], $i, 'cd_evaluador');
						$oProyecto->setEvaluadores( $_POST ['ds_excusado'.($i+1)], $i, 'ds_evaluador');
						
						$oProyecto->setEvaluadores( 1, $i, 'cd_tipoevaluador');
					
					$i++;
				}
				$j=$i;
				$i=0;
				while ( ( $_POST ['cd_recusado'.($i+1)] )){
					
						$oProyecto->setEvaluadores( $_POST ['cd_recusado'.($i+1)], $j, 'cd_evaluador');
						$oProyecto->setEvaluadores( $_POST ['ds_recusado'.($i+1)], $j, 'ds_evaluador');
						
						$oProyecto->setEvaluadores( 2, $j, 'cd_tipoevaluador');
					
					$i++;
					$j++;
				}
				//$j=$i;
				$i=0;
				while ( ( $_POST ['cd_sugerido'.($i+1)] )){
					
						$oProyecto->setEvaluadores( $_POST ['cd_sugerido'.($i+1)], $j, 'cd_evaluador');
						$oProyecto->setEvaluadores( $_POST ['ds_sugerido'.($i+1)], $j, 'ds_evaluador');
						
						$oProyecto->setEvaluadores( 3, $j, 'cd_tipoevaluador');
					
					$i++;
					$j++;
				}
			
			/*$cvcargado = (( $oIntegrante->getDs_curriculum() ) OR ( $oIntegrante->getDs_curriculumT() ) ) ? 'Cargado' : '';
	   		 $xtpl->assign('cvcargado', $cvcargado);
			$xtpl->assign ( 'ds_curriculumH',  ( $oIntegrante->getDs_curriculum() ) );
			$xtpl->assign ( 'ds_curriculumT',  ( $oIntegrante->getDs_curriculumT() ) );
			$xtpl->assign ( 'nu_horasinv',  ( $oIntegrante->getNu_horasinv() ) );
			$xtpl->assign ( 'cd_deddoc',  ( $oDocente->getCd_deddoc() ) );*/
			$ds_costo = "Primer a&ntilde;o:
				              <input type='text' name='nu_ano1' id='nu_ano1' size='10' maxlength='50' class=\"fValidate['real','required']\" value='".$oProyecto->getNu_ano1()."' onchange='mayusculas(this)'/>
				              Segundo a&ntilde;o
				              <input type='text' name='nu_ano2' id='nu_ano2' size='10' maxlength='50' class=\"fValidate['real','required']\" value='".$oProyecto->getNu_ano2()."' onchange='mayusculas(this)'/>";
			$ds_costo .= ($oProyecto->getNu_duracion()==4)?"Tercer a&ntilde;o
				              <input type='text' name='nu_ano3' id='nu_ano3' size='10' maxlength='50' value='".$oProyecto->getNu_ano3()."' onchange='mayusculas(this)' class=\"fValidate['real','required']\"/>
				              Cuarto a&ntilde;o
				              <input type='text' name='nu_ano4' id='nu_ano4' size='10' maxlength='50' value='".$oProyecto->getNu_ano4()."' onchange='mayusculas(this)' class=\"fValidate['real','required']\"/>":"";
			
			$xtpl->assign ( 'ds_costo',  $ds_costo );
			
			$xtpl->assign ( 'nu_duracion',  ( htmlspecialchars($oProyecto->getNu_duracion()) ) );
			$xtpl->assign ( 'ds_factibilidad',  stripslashes( htmlspecialchars($oProyecto->getDs_factibilidad()) ) );
			$xtpl->assign ( 'ds_fondotramite',  stripslashes( htmlspecialchars($oProyecto->getDs_fondotramite() ) ));
			$year = $_SESSION ["nu_yearSession"];
			
			
			$ds_presupuesto = " <tr>
	                      <th  scope=\"col\"><div align=\"center\"></div></th>
				          <th  scope=\"col\"><div align=\"center\">Importe ".$year."</div></th>
				         <th  scope=\"col\"><div align=\"center\">Importe ".($year+1)."</div></th>";
			$ds_presupuesto .=($oProyecto->getNu_duracion()==4)?"<th width=\"74\" scope=\"col\"><div align=\"center\">Importe ".($year+2)."</div></th>
				          <th  scope=\"col\"><div align=\"center\">Importe ".($year+3)."</div></th>":"";
			$ds_presupuesto .="<th  scope=\"col\"><div align=\"center\">Total</div></th></tr>
	                    <tr>
	                      <td><div align=\"left\"><strong>Inciso 2 - Bienes de consumo (papeler&iacute;a, insumos de computaci&oacute;n o laboratorio, etc.)</strong></div></td>
	                      <td><input type=\"text\" name=\"nu_consumo1\" id=\"nu_consumo1\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_consumo1()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>
	                      <td><input type=\"text\" name=\"nu_consumo2\" id=\"nu_consumo2\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_consumo2()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>";
	        $ds_presupuesto .=($oProyecto->getNu_duracion()==4)?"<td><input type=\"text\" name=\"nu_consumo3\" id=\"nu_consumo3\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_consumo3()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>
	                      <td><input type=\"text\" name=\"nu_consumo4\" id=\"nu_consumo4\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_consumo4()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>":"";
	        $totalrow=$oProyecto->getNu_consumo1()+$oProyecto->getNu_consumo2()+$oProyecto->getNu_consumo3()+$oProyecto->getNu_consumo4();
	         $ds_presupuesto .="<td><div id=\"divTotalconsumo\">".$totalrow."</div></td></tr>
	                    <tr>
	                      <td><div align=\"left\"><strong>Inciso 3 - Servicios no personales (vi&aacute;ticos, pasajes, etc.) </strong></div></td>
	                      <td><input type=\"text\" name=\"nu_servicios1\" id=\"nu_servicios1\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_servicios1()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>
	                      <td><input type=\"text\" name=\"nu_servicios2\" id=\"nu_servicios2\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_servicios2()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>";
	           $ds_presupuesto .=($oProyecto->getNu_duracion()==4)?"           <td><input type=\"text\" name=\"nu_servicios3\" id=\"nu_servicios3\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_servicios3()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>
	                      <td><input type=\"text\" name=\"nu_servicios4\" id=\"nu_servicios4\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_servicios4()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>":"";
	           $totalrow=$oProyecto->getNu_servicios1()+$oProyecto->getNu_servicios2()+$oProyecto->getNu_servicios3()+$oProyecto->getNu_servicios4();
	         $ds_presupuesto .="<td><div id=\"divTotalservicios\">".$totalrow."</div></td></tr>
	                    <tr>
	                      <td><div align=\"left\"><strong>Inciso 4 - Bienes de uso (equipamiento, bibliograf&iacute;a, etc.)</strong></div></td>
	                     <td><input type=\"text\" name=\"nu_bibliografia1\" id=\"nu_bibliografia1\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_bibliografia1()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>
	                      <td><input type=\"text\" name=\"nu_bibliografia2\" id=\"nu_bibliografia2\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_bibliografia2()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>";
	           $ds_presupuesto .=($oProyecto->getNu_duracion()==4)?"           <td><input type=\"text\" name=\"nu_bibliografia3\" id=\"nu_bibliografia3\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_bibliografia3()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>
	                      <td><input type=\"text\" name=\"nu_bibliografia4\" id=\"nu_bibliografia4\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_bibliografia4()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>":"";
	                $totalrow=$oProyecto->getNu_bibliografia1()+$oProyecto->getNu_bibliografia2()+$oProyecto->getNu_bibliografia3()+$oProyecto->getNu_bibliografia4();
	         $ds_presupuesto .="<td><div id=\"divTotalbibliografia\">".$totalrow."</div></td></tr>";
	                    /*<tr>
	                      <td><div align=\"left\"><strong>Equipamiento cient&iacute;fico espec&iacute;fico </strong></div></td>
	                     <td><input type=\"text\" name=\"nu_cientifico1\" id=\"nu_cientifico1\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_cientifico1()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>
	                      <td><input type=\"text\" name=\"nu_cientifico2\" id=\"nu_cientifico2\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_cientifico2()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>";
	                $ds_presupuesto .=($oProyecto->getNu_duracion()==4)?"       <td><input type=\"text\" name=\"nu_cientifico3\" id=\"nu_cientifico3\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_cientifico3()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>
	                      <td><input type=\"text\" name=\"nu_cientifico4\" id=\"nu_cientifico4\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_cientifico4()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>":"";
	                    $ds_presupuesto .="</tr>
	                    <tr>
	                      <td><div align=\"left\"><strong>Equipo de computaci&oacute;n </strong></div></td>
	                      <td><input type=\"text\" name=\"nu_computacion1\" id=\"nu_computacion1\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_computacion1()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>
	                      <td><input type=\"text\" name=\"nu_computacion2\" id=\"nu_computacion2\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_computacion2()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>";
	                 $ds_presupuesto .=($oProyecto->getNu_duracion()==4)?"     <td><input type=\"text\" name=\"nu_computacion3\" id=\"nu_computacion3\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_computacion3()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>
	                      <td><input type=\"text\" name=\"nu_computacion4\" id=\"nu_computacion4\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_computacion4()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>":"";
	                   $ds_presupuesto .=" </tr>
	                    <tr>
	                      <td><div align=\"left\"><strong>Otros</strong></div></td>
	                     <td><input type=\"text\" name=\"nu_otros1\" id=\"nu_otros1\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_otros1()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>
	                      <td><input type=\"text\" name=\"nu_otros2\" id=\"nu_otros2\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_otros2()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>";
	                     $ds_presupuesto .=($oProyecto->getNu_duracion()==4)?" <td><input type=\"text\" name=\"nu_otros3\" id=\"nu_otros3\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_otros3()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>
	                      <td><input type=\"text\" name=\"nu_otros4\" id=\"nu_otros4\" size='10' maxlength=\"50\" value=\"".$oProyecto->getNu_otros4()."\" class=\"fValidate['real']\" onblur=\"totales();validarArea();\"/></td>":"";
	                    $ds_presupuesto .=" </tr>
	                    <tr>";*/
	                     $ds_presupuesto .=" <td><div align=\"right\"><strong>Total</strong></div></td>
	                      <td><div id=\"total1\"></div><input name=\"htotal1\" id=\"htotal1\" type=\"hidden\" value=\"\" /><div id=\"divTotal1\" class=\"fValidator-msg\"></div></td>
	                      <td><div id=\"total2\"></div><input name=\"htotal2\" id=\"htotal2\" type=\"hidden\" value=\"\" /><div id=\"divTotal2\" class=\"fValidator-msg\"></div></td>";
	                   $ds_presupuesto .=($oProyecto->getNu_duracion()==4)?"   <td><div id=\"total3\"></div><input name=\"htotal3\" id=\"htotal3\" type=\"hidden\" value=\"\" /><div id=\"divTotal3\" class=\"fValidator-msg\"></div></td>
	                      <td><div id=\"total4\"></div><input name=\"htotal4\" id=\"htotal4\" type=\"hidden\" value=\"\" /><div id=\"divTotal4\" class=\"fValidator-msg\"></div></td>":"";
	                 $ds_presupuesto .=" <td><div id=\"divTotaltotal\"></div></td>  </tr>";
			
			$xtpl->assign ( 'ds_presupuesto',  $ds_presupuesto );
			
			
			/*$oFondo = new Fondo();
			$oFondo->setCd_proyecto($oProyecto->getCd_proyecto());
			$oFondo->setBl_tramite(0);
			$fondos = ($oProyecto->getFondos())?$oProyecto->getFondos():FondoQuery::getFondo($oFondo);
			$count = count ( $fondos );
			$ds_fondos='';
			$j=0;
			for($i = 0; $i < $count; $i ++) {
				if (!$fondos[$i]['bl_tramite']){
					$ds_fondos .='<tr>';
					//$ds_fondos .='<td align="left"><input type="text" name="nu_monto'.$j.'" id="nu_monto'.$j.'" size=\'10\' maxlength="50" value="'.$fondos[$i]['nu_monto'].'" onchange="mayusculas(this)" class="fValidate[\'real\']"/></td>';
					$ds_fondos .='<td align="left"><input type="text" name="nu_monto'.$j.'" id="nu_monto'.$j.'" size=\'10\' maxlength="50" value="'.$fondos[$i]['nu_monto'].'" onchange="mayusculas(this)" jVal="{valid:function (val) { return isReal(val,\' Ingrese un número\'); }}"/></td>';
					 
					$ds_fondos .='<td align="left"><input type="text" name="ds_fuente'.$j.'" id="ds_fuente'.$j.'" size=\'20\' value="'.stripslashes($fondos[$i]['ds_fuente']).'" onchange="mayusculas(this)"/></td>';
					$ds_fondos .='<td align="left"><input type="text" name="ds_resolucion'.$j.'" id="ds_resolucion'.$j.'" size=\'20\' value="'.stripslashes($fondos[$i]['ds_resolucion']).'" onchange="mayusculas(this)" onblur="agregarFila(\'0\',\''.$j.'\')"/></td>';
					$ds_fondos .='</tr>';
					$j++;
				}
				
			}
			if ($count==0){
				$ds_fondos .='<tr>';
				//$ds_fondos .='<td align="left"><input type="text" name="nu_monto0" id="nu_monto0" size=\'10\' maxlength="50" value="" onchange="mayusculas(this)" class="fValidate[\'real\']"/></td>';
				$ds_fondos .='<td align="left"><input type="text" name="nu_monto0" id="nu_monto0" size=\'10\' maxlength="50" value="" onchange="mayusculas(this)" jVal="{valid:function (val) { return isReal(val,\' Ingrese un número\'); }}"/></td>';
				 
				$ds_fondos .='<td align="left"><input type="text" name="ds_fuente0" id="ds_fuente0" size=\'20\' value="" onchange="mayusculas(this)"/></td>';
				$ds_fondos .='<td align="left"><input type="text" name="ds_resolucion0" id="ds_resolucion0" size=\'20\' value="" onchange="mayusculas(this)" onblur="agregarFila(\'0\',\'0\')"/></td>';
				$ds_fondos .='</tr>';
			}
			$xtpl->assign ( 'fondos',  $ds_fondos );
			
			$oFondo = new Fondo();
			$oFondo->setCd_proyecto($oProyecto->getCd_proyecto());
			$oFondo->setBl_tramite(1);
			$fondos = ($oProyecto->getFondos())?$oProyecto->getFondos():FondoQuery::getFondo($oFondo);
			$count = count ( $fondos );
			$ds_fondos='';
			$j=0;
			for($i = 0; $i < $count; $i ++) {
				if ($fondos[$i]['bl_tramite']){
					$ds_fondos .='<tr>';
					//$ds_fondos .='<td align="left"><input type="text" name="nu_montoT'.$j.'" id="nu_montoT'.$j.'" size=\'10\' maxlength="50" value="'.$fondos[$i]['nu_monto'].'" onchange="mayusculas(this)" class="fValidate[\'real\']"/></td>';
					$ds_fondos .='<td align="left"><input type="text" name="nu_montoT'.$j.'" id="nu_montoT'.$j.'" size=\'10\' maxlength="50" value="'.$fondos[$i]['nu_monto'].'" onchange="mayusculas(this)" jVal="{valid:function (val) { return isReal(val,\' Ingrese un número\'); }}"/></td>'; 
					
					$ds_fondos .='<td align="left"><input type="text" name="ds_fuenteT'.$j.'" id="ds_fuenteT'.$j.'" size=\'20\' value="'.stripslashes($fondos[$i]['ds_fuente']).'" onchange="mayusculas(this)" onblur="agregarFila(\'1\',\''.$j.'\')"/></td>';
					
					$ds_fondos .='</tr>';
					$j++;
				}
				
			}
			if ($count==0){
				$ds_fondos .='<tr>';
				//$ds_fondos .='<td align="left"><input type="text" name="nu_montoT0" id="nu_montoT0" size=\'10\' maxlength="50" value="" onchange="mayusculas(this)" class="fValidate[\'real\']"/></td>';
				$ds_fondos .='<td align="left"><input type="text" name="nu_montoT0" id="nu_montoT0" size=\'10\' maxlength="50" value="" onchange="mayusculas(this)" jVal="{valid:function (val) { return isReal(val,\' Ingrese un número\'); }}"/></td>';
				 
				$ds_fondos .='<td align="left"><input type="text" name="ds_fuenteT0" id="ds_fuenteT0" size=\'20\' value="" onchange="mayusculas(this)" onblur="agregarFila(\'1\',\'0\')"/></td>';
				
				$ds_fondos .='</tr>';
			}
			$xtpl->assign ( 'fondostramite',  $ds_fondos );*/
			
		
		
		
			
		
		$grillaFondo = '<div id="divGridFondo"></div><div id="buttonGrid"><input type="button" value="Insertar fondo" onclick="insertarF()"></div><br><br>';
		
		
	
		$xtpl->assign ( 'grillaFondo',  $grillaFondo);
		$xtpl->assign ( 'grillasFinanciamientoitem',  $grillasFinanciamientoitem);
		$xtpl->assign ( 'doGrillas',  $doGrillas);	
		if ($oProyecto->getBl_publicar()==1){		
				$xtpl->assign ( 'chequeado1',  "checked='checked'" );
				$xtpl->assign ( 'publicarTXT',  1 );
			}
		if ($oProyecto->getBl_publicar()==0){		
			$xtpl->assign ( 'chequeado0',  "checked='checked'" );
			$xtpl->assign ( 'publicarTXT',  0 );
		}

		if ($oProyecto->getBl_notificacion()==1){		
				$xtpl->assign ( 'chequeado1',  "checked='checked'" );
				$xtpl->assign ( 'notificacionTXT',  1 );
			}
		if ($oProyecto->getBl_notificacion()==0){		
			$xtpl->assign ( 'chequeado0',  "checked='checked'" );
			$xtpl->assign ( 'notificacionTXT',  0 );
		}
		$oUsuario = new Usuario();
		$oUsuario->setCd_usuario($cd_usuario);
		UsuarioQuery::getUsuarioPorId($oUsuario);
		$xtpl->assign ( 'ds_mail', $oUsuario->getDs_mail()  );	
		$_SESSION['proyecto']=$oProyecto;	
		$_SESSION['integrante']=$oIntegrante;
		$_SESSION['docente']=$oDocente;
		
		$oTipoacreditacion = new Tipoacreditacion();
		$oTipoacreditacion->setCd_tipoacreditacion($oProyecto->getCd_tipoacreditacion());
		TipoacreditacionQuery::getTipoacreditacionPorCd($oTipoacreditacion);
		$titulo = ($_SESSION ['insertando'])?'SeCyT - Alta proyecto ':'SeCyT - Modificar proyecto ';
		$titulo .=$oTipoacreditacion->getDs_tipoacreditacion();
		if (isset ( $_GET ['er'] )) {
			if ($_GET ['er'] == 1) {
				$xtpl->assign ( 'classMsj', 'msjerror' );
				$msj = "Error: El proyecto no se ha dado de alta. Intente nuevamente";
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
		
		$xtpl->assign ( 'titulo', $titulo.$ppid );
		
		
		$grillasFinanciamientoitem = '';
		$doGrillas = '';
		$divsRequeridos = '';
		$arrayFinanciamiento = array("Inciso 2 - Bienes de consumo","Inciso 3 - Servicios no personales","Inciso 4 - Bienes de uso");
		for ($j = 1; $j < 4; $j++) {
			
			for ($i = 1; $i <= $oProyecto->getNu_duracion(); $i++) {
				$grillasFinanciamientoitem .= $arrayFinanciamiento[$j-1].'<br>Año '.$i.'<div id="divGrid'.$i.$j.'"></div><div id="buttonGrid"><input type="button" value="Insertar &iacute;tem" onclick="insertar(\''.$i.'\',\''.$j.'\')"></div><div id="divGridRequerido'.$i.$j.'" class="fValidator-msg"></div><br><br>';
				$doGrillas .= 'doGrid(\''.$i.'\',\''.$j.'\');';
				$divsRequeridos .= 'if(($("#ds_concepto'.$i.$j.'").val()===\'\')||(!$("#ds_concepto'.$i.$j.'").val())){$( "#divGridRequerido'.$i.$j.'" ).html(\'Ingrese al menos un &iacute;tem\');return false}else{$( "#divGridRequerido'.$i.$j.'" ).html(\'\');}';
			}
		}
		
		$xtpl->assign ( 'grillasFinanciamientoitem',  $grillasFinanciamientoitem);
		$xtpl->assign ( 'doGrillas',  $doGrillas);
		//$xtpl->assign ( 'divsRequeridos',  $divsRequeridos);
		
		
		/*$xtpl->assign ( 'cd_unidad',  stripslashes( htmlspecialchars($oDocente->getCd_unidad()) ) );
		$nu_nivelunidad = $oDocente->getNu_nivelunidad();
		$xtpl->assign ( 'nu_nivelunidad',  stripslashes( htmlspecialchars($nu_nivelunidad) ) );
		$oUnidad = new Unidad();
			$oUnidad->setCd_unidad($oDocente->getCd_unidad());
			UnidadQuery::getUnidadPorId($oUnidad);
		
		$xtpl->assign ( 'ds_unidad',  stripslashes( htmlspecialchars($oUnidad->getDs_unidad()) ) );*/
		
		
		
			
		
		
		$xtpl->parse ( 'main' );
		$xtpl->out ( 'main' );
	}
	else 
		header('Location:../includes/accesodenegado.php');
}
else 
	header('Location:../includes/finsolicitud.php');
?>