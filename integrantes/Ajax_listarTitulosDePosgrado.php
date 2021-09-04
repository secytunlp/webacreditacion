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

        $titulos = TituloQuery::listar (2,$input,0);

	$len = strlen($input);
	$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 0;

	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header ("Pragma: no-cache"); // HTTP/1.0




		header("Content-Type: text/xml");

		echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><results>";
		$max = (count($titulos)<=20)?count($titulos):20;
		for ($i=0;$i<$max;$i++)
		{
			echo "<rs id=\"".$titulos[$i]['cd_titulo']."\" info=\"".utf8_encode($titulos[$i]['ds_universidad'])."\">".utf8_encode($titulos[$i]['ds_titulo'])."</rs>";
		}
		echo "</results>";
/*ucwords(strtolower())*/
?>