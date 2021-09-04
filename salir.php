<?php
include 'clases/Usuario.Class.php';
$oUsuario = new Usuario ( );
if (unserialize ( $_SESSION ['usuario'] )) {
	$oUsuario = unserialize ( $_SESSION ['usuario'] );
}

$oUsuario->cerrarSesion ();


header ( 'location:index.php' );

?>