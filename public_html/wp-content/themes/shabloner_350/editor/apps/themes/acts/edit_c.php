<?php



$data = db()->where('id', THEME_ID)->getOne('themes');
if(!$data['id']) redirect('/themes?act=show');


$_BREAD[] = array('', 'Редактирование проекта');

$settings = json_decode($data['settings'], 1);

$title = $data['name'];
	
$theme_path = ROOT.'/sources/themes/'.THEME_ID;


if($_POST)
{
	require_once(ROOT.'/includes_back/pclzip.lib.php');
	
	// Проверяем, нужно ли скачивать шрифт
	foreach(array('font_title_path', 'font_text_path') as $font_type)
	{
		if($settings[$font_type] != $_POST['settings'][$font_type])
		{
			$old_dir = ROOT.'/files/fonts/'.str_replace('.css', '', api('files.getFileName', $settings[$font_type]));
			$slug = str_replace('.css', '', api('files.getFileName', $_POST['settings'][$font_type]));

			if(file_exists($old_dir)) api('files.delete_directory', $old_dir);
			
			// Скачиваем
			api('files.write', array(ROOT.'/files/fonts/'.$slug.'.zip', file_get_contents(SHTTP_PATH.'/fonts/'.$slug.'.zip')));
			
			// Распаковали
			$archive = new PclZip(ROOT.'/files/fonts/'.$slug.'.zip');
			if ($archive->extract(PCLZIP_OPT_PATH, ROOT.'/files/fonts/') == 0) $res = "Error : ".$archive->errorInfo(true);
			else $res = 'ok';
			
			// удалили архив
			unlink(ROOT.'/files/fonts/'.$slug.'.zip');
		}
	}
	
	
	$_RETURN = api('themes.edit', $_POST);
	$data = db()->where('id', THEME_ID)->getOne('themes');
	$theme = $data;
	$folder = ROOT.'/../';
	
	/* Начинаем с головы */
	$head = file_get_contents(ROOT.'/sources/head.html');

	// Подставили цвета
	$palette_url = HTTP_PATH.'/sources/palette.php?colors='.urlencode(str_replace('#','',$_POST['settings']['color']));
	$palette_src = file_get_contents($palette_url);
	api('files.write', array($folder.'/css/palette.css', $palette_src));

	// Подставили шрифты
	$fonts_path = HTTP_PATH.'/sources/fonts.php?fonts='.urlencode($_POST['settings']['font_title'].','.$_POST['settings']['font_text']).'&font_size='.$_POST['settings']['font_size'];

	$fonts_src = file_get_contents($fonts_path);
	api('files.write', array($folder.'/css/fonts.css', $fonts_src));

	// Скачали шрифты в папку темы
	$fonts_include = '';

	$font_css_file = api('download.css_url', array($_POST['settings']['font_title_path'], $_POST['settings']['font_title_path'], $folder.'/fonts'));
	$fonts_include .= '<link rel="stylesheet" href="[template_directory]fonts/'.$font_css_file['name'].'" type="text/css" />'."\n";

	$font_css_file = api('download.css_url', array($_POST['settings']['font_text_path'], $_POST['settings']['font_text_path'], $folder.'/fonts'));
	$fonts_include .= '<link rel="stylesheet" href="[template_directory]fonts/'.$font_css_file['name'].'" type="text/css" />';

	// Дополнительный CSS
	api('files.write', array($folder.'/manual_css.css', $theme['css']));
	if($_POST['css']) $fonts_include .= "\n".'<link rel="stylesheet" href="[template_directory]manual_css.css" type="text/css" />';

	$head = str_replace('[fonts_include]', $fonts_include, $head);

	// Обрабатываем настройки
	if($settings['stretched'] == 1) $stretched = 'stretched';
	else 	$stretched = '';
	$head = str_replace('[stretched]', $stretched, $head);

	$head = str_replace('.css', '.css?_'.time(), $head);
			
	api('files.write', array($folder.'/header.php', api('build.macroses', array('str' => $head, 'type' => 'wordpress', 'theme_id' => $theme['id']))));
	
	// Из-за кнопок надо все страницы пересобирать
	if($_POST['settings']['default_button_class'] != $settings['default_button_class'])
	{
		$pages = db()->where('theme_id', THEME_ID)->get('pages_schema');
		foreach($pages as $page) api('build.wp_page', $page['id']);
	}
	
	$settings = json_decode($data['settings'], 1);

	// Копируем файлы
	api('files.recurse_copy', array(ROOT.'/sources/themes/'.$theme['id'].'/temp/css', $folder.'/css'));
	
	// Если есть фон, нам нужно его копировать
	if($theme['bg_image']) api('build.wp_page', db()->where('theme_id', THEME_ID)->where('role', 'index')->getValue('pages_schema', 'id'));
	
	/************** Старые настройки **************/
	if($_POST['options'])
	{
		db()->setPrefix (TABLE_PREFIX);
		foreach($_POST['options'] as $name => $value)
		{
			$id = db()->where('option_name', $name)->getValue('options', 'option_id');
			$data = array('option_name' => $name, 'option_value' => $value);
			if($id) db()->where('option_id', $id)->update('options', $data);
			else db()->insert('options', $data);
			
			// Если это почты
			if($name == 'emails')
			{
				api('files.write', array(ROOT.'/../emails.txt', $value));
			}
			
			// Если это код
			if($name == 'shcode')
			{
				api('files.write', array(ROOT.'/../shcode.txt', $value));
			}
			
			// Если это главный шрифт
			/*if($name == 'font_title' || $name == 'font_text')
			{
				$font = db()->where('name', $value)->getOne('fonts');
				if($font['id'])
				{
					$options[$name.'_path'] = 'http://shabloner.ru/fonts/'.$font['slug'].'/'.$font['slug'].'.css';
				}
			}*/
			
		}
		$saved = 1;
		db()->setPrefix ('shabloner_');
	}
	
}

	

	
	
?>