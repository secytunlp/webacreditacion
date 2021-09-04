<?php
include '../includes/include.php';

// Detect if there was XHR request
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $fields = array('row', 'column', 'text');
    $sqlFields = array('ds_concepto', 'nu_monto');
 
    foreach ($fields as $field) {
        if (!isset($_POST[$field]) || strlen($_POST[$field]) <= 0) {
            sendError('No correct data');
            exit();
        }
    }
 
  	$db = new mysqli($dbhost, $dbuser, $dbpasswd, $dbname);
		
		
 
    $userQuery = sprintf("UPDATE financiamientoitem SET %s='%s' WHERE cd_financiamientoitem=%d",
            $sqlFields[intval($_POST['column'])],
            $db->real_escape_string($_POST['text']),
            $db->real_escape_string(intval($_POST['row'])));
    $stmt = $db->query($userQuery);
    $db->sql_close;
 
}
