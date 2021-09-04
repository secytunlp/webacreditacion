<?php
include 'includes/include.php';
/*require '../includes/chequeo.php';
 include '../includes/datosSession.php';


 if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Alta usuario" )) {*/
//include APP_PATH . 'includes/menu.php';
$xtpl = new XTemplate ( 'contacto.html' );

//include APP_PATH.'includes/cargarmenu.php';

if (isset ( $_GET ['er'] )) {
	if ($_GET ['er'] == 1) {
		$xtpl->assign ( 'classMsj', 'msjerror' );
		//$msj = "C.U.I.L. equivocado o ud. no se encuentra en nuestras bases, presione <a href=\'registro.php\'>aquí</a> si quiere registrarse como Director externo";
		$msj = "C.U.I.L. equivocado o ud. no se encuentra en nuestras bases";
		$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
	}

} else {
	$xtpl->assign ( 'classMsj', '' );
	$xtpl->assign ( 'msj', '' );
}
$xtpl->parse ( 'main.msj' );

$xtpl->assign ( 'titulo', 'SeCyT - Contacto' );



$xtpl->parse ( 'main' );
$xtpl->out ( 'main' );
/*}
 else
 header('Location:../includes/accesodenegado.php');*/
?>