<?php
include_once '../includes/include.php';
include '../includes/datosSession.php';
$oProyecto = $_SESSION['proyecto'];

$oFinanciamientoanterior = new Financiamientoanterior();
$oFinanciamientoanterior->setCd_proyecto($oProyecto->getCd_proyecto());


$xtpl = new XTemplate ( 'grillaFinanciamientoanterior.html' );


$financiamientoanteriores = FinanciamientoanteriorQuery::getFinanciamientoanteriors( $oFinanciamientoanterior);
$count = count ( $financiamientoanteriores );
if (!$count) {
	$year = $_SESSION['nu_yearSession'];
	for ($i = $year-4; $i < $year-1; $i++) {
		$oFinanciamientoanterior->setNu_year($i);
		FinanciamientoanteriorQuery::insertarFinanciamientoanterior($oFinanciamientoanterior);
	}
	$financiamientoanteriores = FinanciamientoanteriorQuery::getFinanciamientoanteriors( $oFinanciamientoanterior);
	$count = count ( $financiamientoanteriores );
}
for($i = 0; $i < $count; $i ++) {
	
	$financiamientoanteriores [$i]['nu_total'] = $financiamientoanteriores [$i]['nu_unlp']+$financiamientoanteriores [$i]['nu_nacionales']+$financiamientoanteriores [$i]['nu_extranjeras']; 
	$xtpl->assign ( 'DATOS', $financiamientoanteriores [$i] );
	$xtpl->parse ( 'main.row' );
}

$xtpl->parse ( 'main' );
$xtpl->out ( 'main' );
?>
