<?php

if($_GET['act'] == 'logout') session_destroy();

// Установка
if(!isInstalled()) redirect(HTTP_PATH.'/index.php?app=install');

// Проверили авторизацию
if(isAuth()) redirect(HTTP_PATH.'/index.php');

// Проверка хэша
$hash = md5($config['DB_HOST'].$config['DB_USER'].$config['DB_PASSWORD'].$config['DB_NAME'].$AUTH_KEY);
if($_GET['hash'] == $hash) 
{
	$_SESSION['user_id'] = 1;
	redirect(HTTP_PATH.'/index.php?app=themes&act=edit');
}
				  
