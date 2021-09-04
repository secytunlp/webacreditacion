<?php
include '../includes/include.php';
include '../includes/datosSession.php';

if (isset ( $_GET ['cd_unidad'] ))
	$cd_unidad = $_GET ['cd_unidad']; else
	$cd_unidad = 0;
$oUnidad = new Unidad();
$oUnidad->setCd_unidad($cd_unidad);
UnidadQuery::getUnidadPorId($oUnidad);
$html = '<div id="divdir"><p>Dir. U. Ejec: 
					  <input type="text" name="ds_direccion" id="ds_direccion" value="'.$oUnidad->getDs_direccion().'" style="width:150px" onchange="mayusculas(this)"/>
    <span style="padding-left:20px">Tel. U. Ejec:</span><input type="text" name="ds_telefono" id="ds_telefono" value="'.$oUnidad->getDs_telefono().'" onchange="mayusculas(this)"/> <span style="padding-left:20px">E-Mail U. Ejec:</span> 
    <input type="text" name="ds_mail" id="ds_mail" value="'.$oUnidad->getDs_mail().'" style="width:220px"/></p></div>';

echo $html;

?>