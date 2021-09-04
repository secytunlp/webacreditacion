<?php
include '../includes/include.php';
include '../includes/datosSession.php';

if (isset ( $_GET ['ds_codigootro'] ))
	$ds_codigo = $_GET ['ds_codigootro']; else
	$ds_codigo = 0;

$html = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Denominaci&oacute;n:";
$html .= "<select name='ds_titulootro' id='ds_titulootro' onKeyDown='fnKeyDownHandler(this, event);' onKeyUp='fnKeyUpHandler_A(this, event); return false;' onKeyPress = 'return fnKeyPressHandler_A(this, event);'  onChange='fnChangeHandler_A(this, event);' style='width: 300px'>";
$html .= "<option value=''> - Seleccione/tipee Uno - </option>";

$res = ProyectoQuery::listarTituloPorCodigo($ds_codigo);
foreach ( $res as $titulo ) {
	$html .= "<option value=" . $titulo ['cd_titulo'] . ">" . htmlentities($titulo ['ds_titulo']) . "</option>
	         ";
}

$html .= "</select>";

echo $html;

?>