<?php

// Проверили авторизацию
if(!isAuth()) redirect(WP_ADMIN_URL);
if(!isAdmin()) exit;


$title = 'Блоки';

$act = $_GET['act'];

if(!$act || !file_exists($_APP['folder'].'/acts/'.$act.'_c.php')) redirect('/blocks?act=show');

$_BREAD[] = array('/blocks?act=show', 'Блоки');

include($_APP['folder'].'/acts/'.$act.'_c.php');
$_APP['view'] = $_APP['folder'].'/acts/'.$act.'_v.php';


include(ROOT.'/interface/index.php');

?>