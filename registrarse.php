<?php
include 'includes/include.php';


$oUsuario = new Usuario ( );
//$oUsuarioQuery = new Usuario


if (isset ( $_POST ['nu_precuil'] ))
	$oUsuario->setNu_precuil ( $_POST ['nu_precuil'] ); else
	$oUsuario->setNu_precuil ( '' );
	
if (isset ( $_POST ['nu_documento'] ))
	$oUsuario->setNu_documento ( $_POST ['nu_documento'] ); else
	$oUsuario->setNu_documento ( '' );
	
if (isset ( $_POST ['nu_postcuil'] ))
	$oUsuario->setNu_postcuil ( $_POST ['nu_postcuil'] ); else
	$oUsuario->setNu_postcuil ( '' );

if (isset ( $_POST ['pass'] ))
	$oUsuario->setDs_password ( $_POST ['pass'] ); else
	$oUsuario->setDs_password ( "" );

if (isset ( $_POST ['perfil'] ))
	$oUsuario->setCd_perfil ( $_POST ['perfil'] ); else
	$oUsuario->setCd_perfil ( "" );	

$existeUsuario = UsuarioQuery::existe ( $oUsuario, $db );
if ($existeUsuario) {
	UsuarioQuery::getUsuarioPorDocumento($oUsuario);
	$oUsuario->iniciarSesion($year);
	header('location:./proyectos/index.php');
} else
	header('location:./index.php?er=1');
?>