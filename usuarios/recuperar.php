<?php
include '../includes/include.php';

	$xtpl = new XTemplate ( 'recuperar.html' );
	
	
	
	if (isset ( $_GET ['er'] )) {
		if ($_GET ['er'] == 1) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "C.U.I.L. equivocado o ud. no se ha registrado";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
		
	} else {
		$xtpl->assign ( 'classMsj', '' );
		$xtpl->assign ( 'msj', '' );
	}
	$xtpl->parse ( 'main.msj' );
	
	$xtpl->assign ( 'titulo', 'SeCyT - Recuperar password' );
	
	
	
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );

?>