<?php
include '../includes/include.php';

// Detect if there was XHR request
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $fields = array('row', 'column', 'text');
    $sqlFields = array('nu_monto', 'ds_fuente', ds_resolucion);
 
    foreach ($fields as $field) {
        if (!isset($_POST[$field]) || strlen($_POST[$field]) <= 0) {
            sendError('No correct data');
            exit();
        }
    }
 
  	$db = new mysqli($dbhost, $dbuser, $dbpasswd, $dbname);
		
		
 
    $userQuery = sprintf("UPDATE fondo SET %s='%s' WHERE cd_fondo=%d",
            $sqlFields[intval($_POST['column'])],
            $db->real_escape_string($_POST['text']),
            $db->real_escape_string(intval($_POST['row'])));
    $stmt = $db->query($userQuery);
    $db->sql_close;
 
}
