<?php

// Проверили авторизацию
if(!isAuth() || !isInstalled()) redirect(WP_ADMIN_URL);

$title = 'Темы';

$act = $_GET['act'];

if(!$act || !file_exists($_APP['folder'].'/acts/'.$act.'_c.php')) redirect(HTTP_PATH.'/index.php?app=themes&act=edit');

//$_BREAD[] = array('/index.php?app=themes&act=edit', 'Проекты');

include($_APP['folder'].'/acts/'.$act.'_c.php');
$_APP['view'] = $_APP['folder'].'/acts/'.$act.'_v.php';


include(ROOT.'/interface/index.php');

?>