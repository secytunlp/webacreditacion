<?php
include '../includes/include.php';
include '../includes/datosSession.php';

if (isset ( $_GET ['cd_tipounidad'] ))
	$cd_tipounidad = $_GET ['cd_tipounidad']; else
	$cd_tipounidad = 0;
$formname = $_GET ['formname'];
$nivel = $_GET ['nivel'];
$cd_padre = ($nivel)?$_GET ['cd_unidad'.($nivel-1)]:$_GET ['cd_tipounidad'];
$html = "<p><strong>Lugar de Trabajo nivel ".$nivel.":</strong>";
$html .= "<select name='cd_unidad".$nivel."' id='cd_unidad".$nivel."' onchange=\"cargarUnidad('".$formname."', '".($nivel+1)."', '0');\" style='width: 300px'>"; 
$html .= "<option value=''> -- Seleccione una -- </option>";

$res = UnidadQuery::comboUnidad ( $cd_padre, $nivel );
foreach ( $res as $unidad ) {
	$html .= "<option value=" . $unidad ['cd_unidad'] . ">" . $unidad ['ds_unidad'] . "</option>
	         ";
}

$html .= "</select></p>";
$html .= "<div id='unidad".($nivel+1)."'></div>";
if (count($res)==0) $html ="<div id='unidad".($nivel+1)."'></div>";
echo $html;

?>