<?php
include '../includes/include.php';
include '../includes/datosSession.php';

$input = strtolower( utf8_decode($_GET['input']) );
$universidades = UniversidadQuery::listarPorDs($input);
$len = strlen($input);
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 0;

header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header ("Pragma: no-cache"); // HTTP/1.0

        header("Content-Type: text/xml");

        echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><results>";
        $max = (count($universidades)<=10)?count($universidades):10;
        for ($i=0;$i<$max;$i++)
        {

                echo "<rs id=\"".$universidades[$i]['cd_universidad']."\" info=\"\">".str_replace(" & "," and ",utf8_encode($universidades[$i]['ds_universidad']))."</rs>";

        }
        echo "</results>";

?>