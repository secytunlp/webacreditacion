<?php
include_once '../includes/include.php';
include '../includes/datosSession.php';
$xtpl = new XTemplate ( 'finsolicitud.html' );

include APP_PATH . 'includes/cargarmenu.php';
$xtpl->parse ( 'main' );
$xtpl->out ( 'main' );
?>