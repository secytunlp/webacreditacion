<?php
$menu = file_get_contents ( WEB_PATH . 'includes/menu.php' );
$menu = str_replace('ds_apynom',$_SESSION ["ds_usuario"], $menu);
$xtpl->assign ( 'menu', $menu );
$xtpl->parse ( 'main.menu' );
?>