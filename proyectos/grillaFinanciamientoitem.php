<?php
include_once '../includes/include.php';
include '../includes/datosSession.php';
$oProyecto = $_SESSION['proyecto'];
$year = $_GET['year'];
$tipo = $_GET['tipo'];
$oFinanciamientoitem = new Financiamientoitem();
$oFinanciamientoitem->setCd_proyecto($oProyecto->getCd_proyecto());
$oFinanciamientoitem->setNu_year($year);
$oFinanciamientoitem->setCd_tipo($tipo);
if (isset($_GET['insertar'])) {
	FinanciamientoitemQuery::insertarFinanciamientoitem($oFinanciamientoitem);
}

if (isset($_GET['eliminar'])) {
	$oFinanciamientoitem->setCd_financiamientoitem($_GET['eliminar']);
	FinanciamientoitemQuery::eliminarFinanciamientoitem($oFinanciamientoitem);
}
$xtpl = new XTemplate ( 'grillaFinanciamientoitem.html' );


$financiamientoitems = FinanciamientoitemQuery::getFinanciamientoitems( $oFinanciamientoitem);
$count = count ( $financiamientoitems );
$nu_total = 0;
for($i = 0; $i < $count; $i ++) {
	
	$nu_total += $financiamientoitems [$i]['nu_monto']; 
	$xtpl->assign ( 'DATOS', $financiamientoitems [$i] );
	$xtpl->parse ( 'main.row' );
}
$xtpl->assign ( 'year', $year );
$xtpl->assign ( 'tipo', $tipo );
$xtpl->assign ( 'nu_total', $nu_total );
$xtpl->parse ( 'main' );
$xtpl->out ( 'main' );
?>
