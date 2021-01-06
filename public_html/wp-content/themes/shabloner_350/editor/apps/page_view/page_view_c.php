<?php 

if(!isAuth() || !isInstalled()) redirect(WP_ADMIN_URL);

include(ROOT.'/includes_back/preview_functions.php');


$start = microtime(true); 

if($_GET['role'] == 'index') $_GET['page_id'] = api('themes.main_page_id', $_GET['theme_id']);
if($_GET['role'] && isAdmin()) 
{
	$_GET['page_id'] = db()->where('role', $_GET['role'])->where('theme_id', $_GET['theme_id'])->getValue('pages_schema', 'id');
}

if(!$_GET['page_id'] || !$_GET['theme_id']) die('');

// Взяли тему
$theme = db()->where('id', $_GET['theme_id'])->getOne('themes');
if(!$theme['id']) return error('wrong theme');
$theme_folder = ROOT.'/sources/themes/'.$theme['id'];

$source_folder = HTTP_PATH.'/sources/shabloner/';

//$theme_path = HTTP_PATH.'/../';
$theme_path = HTTP_PATH.'/sources/themes/'.$theme['id'];

$folder = $theme_folder.'/temp';

// Настройки
$data = array(
					'folder' => $folder,
					'type' => 'test',
					//'no_files' => 1,
					'theme_id' => $theme['id'],
					);

$settings = json_decode($theme['settings'],1);
$settings['site_name'] = 'Название сайта';
$settings['site_description'] = 'Описание';

$data['settings'] = $settings;

$_OPTIONS = $settings;

// Взяли страницу
$page = db()->where('id', $_GET['page_id'])->where('theme_id', $_GET['theme_id'])->getOne('pages_schema');
if(!$page['id']) return error('wrong page');

/* Начинаем с головы */
$head = file_get_contents(ROOT.'/sources/head.html');

// Подставили цвета
$palette_url = HTTP_PATH.'/sources/palette.php?colors='.urlencode(str_replace('#','',$data['settings']['color'])).'&_'.time();
$head = str_replace('[template_directory]css/palette.css', $palette_url, $head);

// Подставили шрифты
$fonts_path = HTTP_PATH.'/sources/fonts.php?fonts='.urlencode($data['settings']['font_title'].','.$data['settings']['font_text']).'&font_size='.$data['settings']['font_size'].'&_'.time();
$head = str_replace('[template_directory]css/fonts.css', $fonts_path, $head);

// Взяли шрифты
$fonts_include = '';
$fonts_include .= '<link rel="stylesheet" href="'.$data['settings']['font_title_path'].'" type="text/css" />'."\n";
$fonts_include .= '<link rel="stylesheet" href="'.$data['settings']['font_text_path'].'" type="text/css" />'."\n";
$fonts_include .= '<link rel="stylesheet" href="'.$theme_path.'/temp/css/blocks.css" type="text/css" />';


$head = str_replace('[fonts_include]', $fonts_include, $head);

// Обрабатываем настройки
if($data['settings']['stretched'] == 1) $stretched = 'stretched';
else 	$stretched = '';
$head = str_replace('[stretched]', $stretched, $head);
$head = str_replace('[page_preview]', 'page_preview', $head);

// Подставили данные страницы
$pData = array(
					  'page' => $page,
					  'theme_folder' => $theme_folder,
					  'theme' => $theme,
					  'folder' => $folder,
					  'data' => $data,
					  'settings' => $settings,
					  );
$content = api('build.page', $pData);


/* Подвал */
$bottom = file_get_contents(ROOT.'/sources/bottom.html');

$html = $content; 
$html = str_replace(array('[header]', '[footer]'), array($head, $bottom), $html);

$html = str_replace('get_template_directory()', "'".$folder."'", $html);

$html = str_replace('[template_directory]', HTTP_PATH.'/sources/theme_folder/', $html);
$html = str_replace('.css', '.css?_'.time().'', $html);
$html = str_replace('.js', '.js?_'.time().'', $html);



$html = api('build.macroses', array('str' => $html, 'type' => 'test', 'theme_id' => $theme['id']));

$file_path = $folder.'/'.$page['id'].'.php';


api('files.write', array($file_path, $html));

//echo '<pre>'; print_r($settings); echo '</pre>'; 

include(ROOT.'/sources/preview_navbar.php');
include($file_path);


/*				  
echo '<br>done.';
echo '<br>Время выполнения скрипта: '.(microtime(true) - $start).' сек.';
*/