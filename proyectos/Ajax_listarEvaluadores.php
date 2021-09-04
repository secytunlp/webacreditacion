<?php
include '../includes/include.php';
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


	
	
	
	$aInfo = array(Da3);
	//for ($i = 1; $i < 5500; $i++)$aInfo [$i]=ucfirst("" . randVowel() . "" . "" . randConsonant() . "" . randVowel() . "" . "" . randConsonant() . "" . randVowel() . "" . randVowel() . "");

	
	$input = strtolower( utf8_decode($_GET['input']) );
	$oEvaluador = new Evaluador();
	$externo = (isset($_GET['externos']))?1:0;
	$oEvaluador->setDs_evaluador($input);
	$evaluadors = EvaluadorQuery::getEvaluadorPorApellido($oEvaluador,$externo);
	
	$len = strlen($input);
	$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 0;
	
	
	
	
	
	
	
	
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header ("Pragma: no-cache"); // HTTP/1.0
	
	
	
	
		header("Content-Type: text/xml");

		echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><results>";
		$max = (count($evaluadors)<=10)?count($evaluadors):10;
		for ($i=0;$i<$max;$i++)
		{
			
			echo "<rs id=\"".$evaluadors[$i]['cd_evaluador']."\" info=\"".utf8_encode(str_replace('"',"'",str_replace(" & "," and ",$evaluadors[$i]['ds_universidad'].' - '.$evaluadors[$i]['ds_disciplina'].' - '.$evaluadors[$i]['ds_categoria'])))."\">".utf8_encode(str_replace(" & "," and ",$evaluadors[$i]['ds_evaluador']))."</rs>";
			
		}
		echo "</results>";
	
?>