<?php
class Query{

	//Función que comienza una transacción.
	function b_trans($db) {
		$query = "BEGIN TRANSACTION";
		$result = $db->sql_query ( $query );
		return ($result);
	}

	//Función que realiza el commit de una transacción.
	function c_trans($db) {
		$query = "COMMIT TRANSACTION";
		$result = $db->sql_query ( $query );
		return ($result);
	}

	//Función que realiza el rollback de una transacción.
	function r_trans($db) {
		$query = "ROLLBACK TRANSACTION";
		$result = $db->sql_query ( $query );
		return ($result);
	}
}
?>