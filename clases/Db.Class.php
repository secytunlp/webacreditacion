<?php
class DB {

	function message_die($error_type, $error_message) {

		$titulo_modulo_funcion_bottom = "Error Message";
		echo "<html>";
		echo "<head>";
		echo "<title>SeCyT</title>";
		//echo "<LINK REL=\"stylesheet\" Type=\"text/css\" Href=\"estilos/principal.css\">";
		echo "</head>";
		echo "<body>";
		//include("top.php");
		echo "<br>";
		echo "<h1>&nbsp;Critical Error</h1>";
		echo "<br>";
		echo "<br>";
		echo "<br>";
		echo "<br>";
		echo "<h2 align=\"center\">$error_message</h2>";
		//include("bottom.php");
		echo "</body>";
		echo "</html>";
		exit ();
	}

	function conectar() {
		include APP_PATH.'/includes/conf.php';
		switch ( $dbType) {
			case 'mysql' :
				include (APP_PATH . 'db/mysql.php');
				break;
					
			case 'mysql4' :
				include (APP_PATH . 'db/mysql4.php');
				break;
					
			case 'postgres' :
				include (APP_PATH . 'db/postgres7.php');
				break;
					
			case 'mssql' :
				include (APP_PATH . 'db/mssql.php');
				break;
					
			case 'oracle' :
				include (APP_PATH . 'db/oracle.php');
				break;
					
			case 'msaccess' :
				include (APP_PATH . 'db/msaccess.php');
				break;
					
			case 'mssql-odbc' :
				include (APP_PATH . 'db/mssql-odbc.php');
				break;
		}
		if(isset($db))
		return $db;
		$db = new sql_db ( $dbhost, $dbuser, $dbpasswd, $dbname, false );
		if (! $db->db_connect_id) {
			Db::message_die ( CRITICAL_ERROR, "Could not connect to the database" );
		}
		return $db;
	}
}

?>