<?php
include '../includes/include.php';

// Detect if there was XHR request
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $fields = array('row', 'column', 'text');
    $sqlFields = array('ds_actividad', 'bl_mes1', 'bl_mes2', 'bl_mes3', 'bl_mes4', 'bl_mes5', 'bl_mes6', 'bl_mes7', 'bl_mes8', 'bl_mes9', 'bl_mes10', 'bl_mes11', 'bl_mes12');
 
    foreach ($fields as $field) {
        if (!isset($_POST[$field]) || strlen($_POST[$field]) <= 0) {
            sendError('No correct data');
            exit();
        }
    }
 
  	$db = new mysqli($dbhost, $dbuser, $dbpasswd, $dbname);
		
		
 
    $userQuery = sprintf("UPDATE cronograma SET %s='%s' WHERE cd_cronograma=%d",
            $sqlFields[intval($_POST['column'])],
            $db->real_escape_string($_POST['text']),
            $db->real_escape_string(intval($_POST['row'])));
    $stmt = $db->query($userQuery);
    $db->sql_close;
 
}
