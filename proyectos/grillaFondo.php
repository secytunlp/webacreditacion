<?php
include_once '../includes/include.php';
include '../includes/datosSession.php';
$oProyecto = $_SESSION['proyecto'];


$oFondo = new Fondo();
$oFondo->setCd_proyecto($oProyecto->getCd_proyecto());
$oFondo->setBl_tramite(0);
if (isset($_GET['insertar'])) {
	FondoQuery::insertarFondo($oFondo);
}

if (isset($_GET['eliminar'])) {
	$oFondo->setCd_fondo($_GET['eliminar']);
	FondoQuery::eliminarFondo($oFondo);
}
$xtpl = new XTemplate ( 'grillaFondo.html' );


$fondos = FondoQuery::getFondo( $oFondo);
$count = count ( $fondos );

for($i = 0; $i < $count; $i ++) {
	
	 
	$xtpl->assign ( 'DATOS', $fondos [$i] );
	$xtpl->parse ( 'main.row' );
}


$xtpl->parse ( 'main' );
$xtpl->out ( 'main' );
?>
