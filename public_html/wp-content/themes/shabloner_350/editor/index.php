<?php

header("X-XSS-Protection: 0");

//error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(0);

/* Базовые штуки */
set_time_limit(60);
date_default_timezone_set('Etc/GMT-3');
session_start();

define('ROOT', __DIR__);
$parts = parse_url($_SERVER['REQUEST_URI']);

$protocol = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 's' : '') . '://';
//$url = $url . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
//define('URL', $url);

define('HTTP_PATH', $protocol.$_SERVER['HTTP_HOST'].str_replace(array('/index.php'), '', $parts['path']));
define('SHTTP_PATH', 'http://shabloner.ru');


/** IP юзера */
define('USER_IP', $_SERVER['REMOTE_ADDR']);

/** Специальные блоки */
define('BLOCK_EMPTY', 18); // ID блока в БД, который подставляется как пустой
define('ROW_BLOCK', 19); // ID блока за основу которого берутся настройки ряда

define('MY_TIME_LIMIT',115);
define('START_TIME',microtime(true));

require_once(ROOT.'/../shabloner.php');

/* Получаем все необходимые инклюды */
$includes = glob("includes/*.php");
if(count($includes))
{
	foreach($includes as $include) include($include);
}

/* MySQL подключение */
$config_src = file_get_contents('../../../../wp-config.php');

foreach(array('DB_HOST', 'DB_USER', 'DB_PASSWORD', 'DB_NAME') as $field) 
{
	preg_match('/'.$field.'(\'|\")(.*?)(\'|\")(.*?)(\'|\")/is', $config_src, $match);
	
	//list($t, $field_src) = explode($field, $config_src);
	//$parts = explode('"', $field_src);
	
	$config[$field] = $match[4];
	define($field, $match[4]);
}


list($t, $TABLE_PREFIX) = explode('table_prefix', $config_src);
$parts = explode("'", $TABLE_PREFIX);
$TABLE_PREFIX = $parts[1];
define('TABLE_PREFIX', $TABLE_PREFIX);

list($t, $AUTH_KEY) = explode('AUTH_KEY', $config_src);
$parts = explode("'", $AUTH_KEY);
$AUTH_KEY = $parts[2];


list($url, $t) = explode('wp-content', curPageURL());
$url .= 'wp-admin';

define('WP_ADMIN_URL', $url);

//include('../../../../wp-config.php');

$db = new MysqliDb (Array (
                'host' => $config['DB_HOST'],
                'username' => $config['DB_USER'], 
                'password' => $config['DB_PASSWORD'],
                'db'=> $config['DB_NAME'],
                'prefix' => 'shabloner_',
                'charset' => 'utf8'));


/* Роутер */
$app = $_GET['app'];
if(!$app) $app = 'default';

$controller = ROOT.'/apps/'.$app.'/'.$app.'_c.php';
if(!file_exists($controller)) die('wrong app');

$_APP = array(
					 'folder' => ROOT.'/apps/'.$app,
					 'app' => $app,
					 
					 );

include($controller);
