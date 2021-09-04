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


	
	
	
	$aInfo = array(Da3);
	//for ($i = 1; $i < 5500; $i++)$aInfo [$i]=ucfirst("" . randVowel() . "" . "" . randConsonant() . "" . randVowel() . "" . "" . randConsonant() . "" . randVowel() . "" . randVowel() . "");

	
	$input = strtolower( utf8_decode($_GET['input']) );
	$aUsers = CampoQuery::getCamposPorDs($input);
	$len = strlen($input);
	$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 0;
	
	
	/*$aResults = array();
	$count = 0;
	
	if ($len)
	{
		for ($i=0;$i<count($aUsers);$i++)
		{
			// had to use utf_decode, here
			// not necessary if the results are coming from mysql
			//
			if (strtolower(substr(utf8_decode($aUsers[$i]['ds_unidad']),0,$len)) == $input)
			{
				$count++;
				$aResults[] = array( "id"=>($i+1) ,"value"=>htmlentities($aUsers[$i]['ds_unidad']), "info"=>htmlentities($aInfo[$i]) );
			}
			
			if ($limit && $count==$limit)
				break;
		}
	}*/
	
	
	
	
	
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header ("Pragma: no-cache"); // HTTP/1.0
	
	
	
	
		header("Content-Type: text/xml");

		echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><results>";
		$max = (count($aUsers)<=10)?count($aUsers):10;
		for ($i=0;$i<$max;$i++)
		{
			echo "<rs id=\"".$aUsers[$i]['cd_campo']."\" info=\"\">".utf8_encode($aUsers[$i]['ds_campo'])."</rs>";
		}
		echo "</results>";
	
?>