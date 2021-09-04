<?php
include 'includes/include.php';
include 'includes/datosSession.php';

if (isset ( $_GET ['nu_documento'] ))
$nu_documento = $_GET ['nu_documento']; else
$nu_documento = 0;

$html = "<label align='center'>Perfil: </label>";
$html .= "<select name='perfil' id='perfil'>";
$perfiles = UsuarioperfilQuery::getPerfilesDeUsuarioPorDocumento($nu_documento);
foreach ( $perfiles as $perfil ) {
	$html .= "<option value='" . $perfil ['cd_perfil'] . "'>" . $perfil ['ds_perfil'] . "</option>
	         ";
}

$html .= "</select></p>";

echo $html;
?>