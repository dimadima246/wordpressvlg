<?php

// Если установлена - отправляем в редактор
if(isInstalled()) redirect(HTTP_PATH.'/index.php?app=themes&act=show'); // Отправляем в редактор

// Проверили авторизацию
//if(!isAuth()) redirect(WP_ADMIN_URL);

$title = 'Шаблонер: активация темы № '.THEME_ID;

$_APP['view'] = $_APP['folder'].'/'.$app.'_v.php';

if($_POST)
{
	install_check();
}

include(ROOT.'/interface/index.php');

?>