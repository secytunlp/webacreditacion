<?php

include '../includes/include.php';

$menu = new XTemplate(APP_PATH.'includes/menu.html');

$menu->assign('cssmenu', WEB_PATH.'css/chromestyle.css');
$menu->assign('cssgral', WEB_PATH.'css/estilos.css');
$menu->assign('js', WEB_PATH.'js/menu.js');


//REEMPLAZO DE LOS HREF DE LOS LINKS
$menu->assign('salir', WEB_PATH.'salir.php');
$menu->assign('usuarios', WEB_PATH.'usuarios/index.php');
$menu->assign('perfiles', WEB_PATH.'perfiles/index.php');
$menu->assign('cambiarClave', WEB_PATH.'usuarios/cambiarClave.php');
$menu->assign('proyectos', WEB_PATH.'proyectos/index.php');
$menu->assign('abpendientes', WEB_PATH.'proyectos/index.php?pendiente=1');
$menu->assign('movimientos', WEB_PATH.'movimientos/index.php');
$menu->assign('exportar', WEB_PATH.'exportar/index.php');
$menu->assign('contacto', WEB_PATH.'contacto.php');
$menu->assign('modificardisciplinas', WEB_PATH.'evaluadores/modificardisciplinas.php');

//$menu->assign('ds_apynom', $_SESSION ["ds_apynomSession"]);
$menu->parse('main');
$menu->out ( 'main' );
?>