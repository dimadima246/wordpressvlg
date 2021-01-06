<?php 

include(ROOT.'/includes_back/preview_functions.php');

$start = microtime(true); 


if(!$_GET['page_id'] || !$_GET['theme_id']) die('');

// Взяли тему
$theme = db()->where('id', $_GET['theme_id'])->getOne('themes');
if(!$theme['id']) return error('wrong theme');
$theme_folder = ROOT.'/sources/themes/'.$theme['id'];

$source_folder = HTTP_PATH.'/sources/shabloner/';

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
$data['settings'] = $settings;
$_OPTIONS = $settings;

// Взяли страницу
$page = db()->where('id', $_GET['page_id'])->where('theme_id', $_GET['theme_id'])->getOne('pages_schema');
if(!$page['id']) return error('wrong page');


// Подставили данные страницы
$pData = array(
					  'page' => $page,
					  'theme_folder' => $theme_folder,
					  'folder' => $folder,
					  'data' => $data,
					  'settings' => $settings,
					  'block_schema_id' => $_GET['block_schema_id'],
					  );
$html = api('build.page', $pData);

$file_path = $folder.'/'.$page['id'].'_temp.php';
api('files.write', array($file_path, $html));

include($file_path);

?>
