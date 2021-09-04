<?php
// SQL codes
define('BEGIN_TRANSACTION', 1);
define('END_TRANSACTION', 2);

$dbType   ="mysql";
$dbhost   ="163.10.35.34";
$dbuser   ="root";
$dbpasswd ="secyt";
$dbname   ="viajes";

$categoriasPermitidas = array('I','II','III');
$categorias = array('I','II','III','IV','V');
$categoriasPermitidasEx = array('I','II');
$carrerainvs = array(1,2,3,4,5,6);
$mayordedicacion = array(1,2,5,6);
$minintegrantes=3;
$mincategorizados=2;
$minmayordedicacion=2;
$minhsdircodir=10;
$minhstotales=30;
$mailReceptor = "marcosp@presi.unlp.edu.ar";
$mailFrom = "acreditacion@presi.unlp.edu.ar";
$nameFrom = "Secretaría de Ciencia y Ténica de la U.N.L.P.";
$archivosNoEnv = array('image001.png','header.htm','filelist.xml');
$year=2014;
$max_cd_docente=91128;
$test=1;
?>
