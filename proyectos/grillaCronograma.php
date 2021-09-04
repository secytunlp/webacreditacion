<?php
include_once '../includes/include.php';
include '../includes/datosSession.php';
$oProyecto = $_SESSION['proyecto'];
$year = $_GET['year'];
$oCronograma = new Cronograma();
$oCronograma->setCd_proyecto($oProyecto->getCd_proyecto());
$oCronograma->setNu_year($year);
if (isset($_GET['insertar'])) {
	CronogramaQuery::insertarCronograma($oCronograma);
}

if (isset($_GET['eliminar'])) {
	$oCronograma->setCd_cronograma($_GET['eliminar']);
	CronogramaQuery::eliminarCronograma($oCronograma);
}
$xtpl = new XTemplate ( 'grillaCronograma.html' );


$cronogramas = CronogramaQuery::getCronogramas( $oCronograma);
$count = count ( $cronogramas );
for($i = 0; $i < $count; $i ++) {
	$cronogramas [$i]['bl_checked1'] = ($cronogramas [$i]['bl_mes1'])?' CHECKED ':''; 
    $cronogramas [$i]['bl_value1'] = ($cronogramas [$i]['bl_mes1'])?'0':'1'; 
    $cronogramas [$i]['bl_checked2'] = ($cronogramas [$i]['bl_mes2'])?' CHECKED ':''; 
    $cronogramas [$i]['bl_value2'] = ($cronogramas [$i]['bl_mes2'])?'0':'1'; 
    $cronogramas [$i]['bl_checked3'] = ($cronogramas [$i]['bl_mes3'])?' CHECKED ':''; 
    $cronogramas [$i]['bl_value3'] = ($cronogramas [$i]['bl_mes3'])?'0':'1'; 
    $cronogramas [$i]['bl_checked4'] = ($cronogramas [$i]['bl_mes4'])?' CHECKED ':''; 
    $cronogramas [$i]['bl_value4'] = ($cronogramas [$i]['bl_mes4'])?'0':'1'; 
    $cronogramas [$i]['bl_checked5'] = ($cronogramas [$i]['bl_mes5'])?' CHECKED ':''; 
    $cronogramas [$i]['bl_value5'] = ($cronogramas [$i]['bl_mes5'])?'0':'1'; 
    $cronogramas [$i]['bl_checked6'] = ($cronogramas [$i]['bl_mes6'])?' CHECKED ':''; 
    $cronogramas [$i]['bl_value6'] = ($cronogramas [$i]['bl_mes6'])?'0':'1'; 
    $cronogramas [$i]['bl_checked7'] = ($cronogramas [$i]['bl_mes7'])?' CHECKED ':''; 
    $cronogramas [$i]['bl_value7'] = ($cronogramas [$i]['bl_mes7'])?'0':'1'; 
    $cronogramas [$i]['bl_checked8'] = ($cronogramas [$i]['bl_mes8'])?' CHECKED ':''; 
    $cronogramas [$i]['bl_value8'] = ($cronogramas [$i]['bl_mes8'])?'0':'1'; 
    $cronogramas [$i]['bl_checked9'] = ($cronogramas [$i]['bl_mes9'])?' CHECKED ':''; 
    $cronogramas [$i]['bl_value9'] = ($cronogramas [$i]['bl_mes9'])?'0':'1'; 
    $cronogramas [$i]['bl_checked10'] = ($cronogramas [$i]['bl_mes10'])?' CHECKED ':''; 
    $cronogramas [$i]['bl_value10'] = ($cronogramas [$i]['bl_mes10'])?'0':'1'; 
    $cronogramas [$i]['bl_checked11'] = ($cronogramas [$i]['bl_mes11'])?' CHECKED ':''; 
    $cronogramas [$i]['bl_value11'] = ($cronogramas [$i]['bl_mes11'])?'0':'1'; 
    $cronogramas [$i]['bl_checked12'] = ($cronogramas [$i]['bl_mes12'])?' CHECKED ':''; 
    $cronogramas [$i]['bl_value12'] = ($cronogramas [$i]['bl_mes12'])?'0':'1'; 
	$cronogramas [$i]['year'] = $year; 
	$xtpl->assign ( 'DATOS', $cronogramas [$i] );
	$xtpl->parse ( 'main.row' );
}
$xtpl->assign ( 'year', $year );
$xtpl->parse ( 'main' );
$xtpl->out ( 'main' );
?>
