<?php
include 'includes/include.php';
require 'includes/chequeo.php';



/*******************************************************
 * La variable er por GET indica el tipo de error por el
 * que se redireccionó al login
 *******************************************************/
$xtpl = new XTemplate ( 'inicio.html' );

include APP_PATH.'includes/cargarmenu.php';

$xtpl->assign ( 'titulo', 'SeCyT' );
$xtpl->parse ( 'main' );
$xtpl->out ( 'main' );
?>