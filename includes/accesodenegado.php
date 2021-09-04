<?php
include_once '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';
$xtpl = new XTemplate ( 'accesodenegado.html' );

include APP_PATH . 'includes/cargarmenu.php';
$xtpl->parse ( 'main' );
$xtpl->out ( 'main' );
?>