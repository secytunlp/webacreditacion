<?
include 'includes/include.php';
/*require '../includes/chequeo.php';
 include '../includes/datosSession.php';


 if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Alta usuario" )) {*/


$ds_investigador = str_replace(',','',$_POST ['apynom']);
$cabeceras="From: ".$ds_investigador."<".$_POST ['mail'].">\nReply-To: ".$_POST ['mail']."\nReturn-path: ".$_POST ['mail']."\n";
//$cabeceras="From: ".$_POST ['mail']."\nReply-To: ".$_POST ['mail']."\n";

$cabeceras .="X-Mailer:PHP/".phpversion()."\n";
$cabeceras .="Mime-Version: 1.0\n";
$cabeceras .= "Content-type: multipart/mixed; ";
$cabeceras .= "boundary=\"Message-Boundary\"\n";
$cabeceras .= "Content-transfer-encoding: 7BIT\n";
$body_top = "--Message-Boundary\n";
$body_top .= "Content-type: text/html; charset=iso-8859-1\n";
$body_top .= "Content-transfer-encoding: 7BIT\n";
$body_top .= "Content-description: Mail message body\n\n";


$shtml = $body_top. "<html><body><div style='padding-left: 30px; padding-right: 30px; padding-top: 30px ; padding-bottom: 30px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #666666; background-color:#FFFFFF'><img src=\"".WEB_PATH."img/image002.gif\" alt=\"Logo\" longdesc=\"Logo\"><br>PROYECTOS DE INVESTIGACION<hr style= 'color: #999999; text-decoration: none;'><p><strong>Director</strong>: ".$_POST ['apynom']." (".$_POST ['nu_precuil'].'-'.$_POST ['nu_documento'].'-'.$_POST ['nu_postcuil'].")<br><strong>Consulta</strong>: ".$_POST ['ds_consulta']."</p><hr style= 'color: #999999; text-decoration: none;'></body></html>";
$shtml .= "\n\n--Message-Boundary\n";
if (!$test) {
	mail($mailReceptor,"Contacto consulta",$shtml,$cabeceras);
}
header('location:./proyectos/index.php');

/*} else
 header ( 'Location:../includes/accesodenegado.php' );*/



