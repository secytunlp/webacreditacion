<?php
/*****************************************************************
* Los chequeos de si existe la funcion o está definida es porque
* se necesita para el menu y para los index, y sino se redefinen
* ****************************************************************/
include('conf.php');
if (! defined ( 'CD_ACTUACIONDEFAULT' ))
	define('CD_ACTUACIONDEFAULT', 2);
	
if (! defined ( 'ROW_PER_PAGE' ))
	define('ROW_PER_PAGE', 25);

if (! defined ( 'APP_PATH' ))
	define ( 'APP_PATH', $_SERVER ['DOCUMENT_ROOT'] . '/WEBACREDITACION/' );

if (! defined ( 'WEB_PATH' ))
	define ( 'WEB_PATH', 'http://' . $_SERVER ['HTTP_HOST'] . '/WEBACREDITACION/' );


if (! function_exists ( '__autoload' )) {
	function __autoload($class_name) {
		if ($class_name != 'sql_db')
			include_once APP_PATH . 'clases/' . $class_name . '.Class.php';
	}
}

?>