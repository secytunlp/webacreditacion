<?php
include '../includes/include.php';
include '../includes/datosSession.php';
/*
note:
this is just a static test version using a hard-coded countries array.
normally you would be populating the array out of a database

the returned xml has the following structure
<results>
	<rs>foo</rs>
	<rs>bar</rs>
</results>
*/


	
	
	
		
	$input = strtolower( utf8_decode($_GET['input']) );
	$aUsers = EspecialidadQuery::getEspecialidades($input);
	$len = strlen($input);
	$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 0;
	
	
	
	
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header ("Pragma: no-cache"); // HTTP/1.0
	
	
	
	
		header("Content-Type: text/xml");

		echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><results>";
		$max = (count($aUsers)<=10)?count($aUsers):10;
		for ($i=0;$i<$max;$i++)
		{
			echo "<rs id=\"".$aUsers[$i]['cd_especialidad']."\" info=\"\">".utf8_encode($aUsers[$i]['ds_especialidad'])."</rs>";
		}
		echo "</results>";
	
?>