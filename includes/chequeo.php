<?php
session_start ();
$path = WEB_PATH . "index.php?er=2";
if (! isset ( $_SESSION ["cd_usuarioSession"] ) || ($_SESSION ['cd_usuarioSession'] == "")) {
	header ( 'Location: ' . $path );
	die();
}
?>