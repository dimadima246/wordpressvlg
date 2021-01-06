<?php

$method = $_GET['method'];
$param = $_GET['param'];

if(!isAuth() || !isInstalled()) die('access denied');

// расставляем где нужно if(!api('sys.access', array('user_id' => $_SESSION['user_id'], 'id' => $_GET['id'], 'object' => 'theme'))) redirect(SHTTP_PATH);
if($_REQUEST['theme_id'])
{
	//if(!api('sys.access', array('user_id' => $_SESSION['user_id'], 'id' => $_REQUEST['theme_id'], 'object' => 'theme'))) die('access denied');
	
	// проверка авторизации
	
}



if($method == 'app')
{
	$html = str_replace('../', '', $_GET['html']);
	$app = str_replace('../', '', $_GET['appl']);
	$path = ROOT.'/apps/'.$app.'/html/'.str_replace('.php', '', $html).'.php';
	if(file_exists($path)) include($path);
}

if($method == 'scroll')
{
	list($app, $html) = explode('.', $param);
	$data = $_POST;
	if(!isAdmin()) $data['user_id'] = $_SESSION['user_id'];
	$data['count'] = 10;
	$data['offset'] = $_GET['page']*$data['count'];	
	
	$res = api($app.'.'.$html, $data);
	
	echo $res['total'].'[delimiter]';
	include(ROOT.'/apps/'.$app.'/html/'.$html.'.php');
}

if($method == 'api')
{
	$data = $_REQUEST;
	$data['user_id'] = $_SESSION['user_id'];
	$res = api($param, $data);
	echo json_encode($res);
}

if($method == 'default_theme')
{
	$theme = db()->where('id', $_REQUEST['theme_id'])->getOne('themes');
	
	$data = array(
						'key' => $_SESSION['key'],
						'id' => $theme['theme_source_id'],
						);

	$order = json_decode(postPage(SHTTP_PATH.'/api/order_check/', $data), 1);

	if($order['id'])
	{
		$url = ADMIN_CONST_PATH.'/export_source/?key='.$_SESSION['key'].'&id='.$theme['theme_source_id'].'&adw='.ADW;
		$data = array(
							 'zip_path' => $url,
							 'theme_id' => $_REQUEST['theme_id'],
							 'theme_source_id' => $theme['theme_source_id'],
							 'user_id' => $_SESSION['user_id'],
							 );
		$res = api('themes.import_source', $data);
	}
	else $res = error('access denied');
	
	echo json_encode($res);
}

if($method == 'dialog')
{
	$html = str_replace('../', '', $param);
	include(ROOT.'/apps/ajax/dialog.php');
}

if($method == 'build_template')
{
	$theme_id = $_POST['theme_id'];
	$data = array(
						'theme_id' => $theme_id,
						'type' => 'shabloner',
						'no_files' => $_POST['no_files'],
						);
	
	// Создали тему для WordPress				
	if($_POST['type'] == 'wordpress')
	{
		$res = api('build.wp', array('id' => $theme_id, 'theme_folder' => $data['folder']));
		//echo '<pre>'; print_r($res); echo '</pre>'; 
		
		$html = '<div class="bigger-150 bottommargin-sm"><i class="fas fa-check-circle green text-success"></i> Готово</div>';
		$html .= '<div class="bigger-120"><a href="/download?id='.$theme_id.'&hash='.randomWord(16).'" class="btn btn-primary"><i class="fas fa-download"></i> Скачать</a></div>';
		echo $html;
	}
	
	if($_POST['type'] == 'shabloner')
	{
		// Выгнали демо
		api('build.demo_site', array('id' => $theme_id));
		
		$link = $theme_id.'.wp.shabloner.ru';
		
		$html = '<div class="bigger-150 bottommargin-sm"><i class="fas fa-check-circle green text-success"></i> Готово</div>';
		$html .= '<div class="bigger-130"><a target="_blank" href="http://'.$link.'" class="">'.$link.'</a></div>';
		echo $html;
	}
		
	$data['type'] = $_POST['type']; // wordpress
	
}


if($method == 'check_connection' && api('sys.access', array('object' => 'theme', 'user_id' => $_SESSION['user_id'], 'id' => $_REQUEST['theme_id'])))
{
	$theme = db()->where('id', $_REQUEST['theme_id'])->getOne('themes');
	$settings = json_decode($theme['settings'], 1);
	
	//echo '<pre>'; print_r($settings); echo '</pre>'; 
	
	// Проверка API
	$url = $theme['api_path'].'?key='.$_SESSION['key'].'&act=test';
	
	$ctx = stream_context_create(array('http'=>
		array(
			'timeout' => 30,  //1200 Seconds is 20 Minutes
		)
	));	
	
	$src = @file_get_contents($url, false, $ctx);
	preg_match('/\<shabloner\>(.*?)\<\/shabloner\>/is', $src, $match);
	
	$html = 'Проверка соединения по API...<br>';
	$res = json_decode($match[1], 1);
	if($res['result'] == 'ok') $html .= 'Соединение по API <b class="text-success">успешно</b> установлено!<br>';
	else $html .= 'Возникла <b class="text-danger">ошибка</b> во время установки соединения по API. Убедитесь, в правильности пути файла синхронизации и в том, что сайт доступен из Интернета.<br>';
	
	// Проверка FTP
	if($settings['ftp_path'] && $settings['ftp_host'] && $settings['ftp_login'] && $settings['ftp_pass'])
	{
		$html .= '<br>';
		$html .= 'Проверка соединения по FTP...<br>';
		$res = api('files.ftp_check', $settings);
		if($res) $html .= 'Соединение по FTP <b class="text-success">успешно</b> установлено!<br>';
		else $html .= 'Возникла <b class="text-danger">ошибка</b> во время установки соединения по FTP. Проверьте данные для доступа по FTP.<br>';
	}
	//else $html .= 'Соединение по FTP не проверяем.<br>';
	
	echo $html;
}

if($method == 'synch' && api('sys.access', array('object' => 'theme', 'user_id' => $_SESSION['user_id'], 'id' => $_REQUEST['theme_id'])))
{
	// Данные темы
	$theme = db()->where('id', $_REQUEST['theme_id'])->getOne('themes');
	$settings = json_decode($theme['settings'], 1);
	
	if(!$theme['api_path'] && !$settings['ftp_path']) die('Настройте параметры синхронизации!');
	
	
	// Создали тему для WordPress				
	$theme_id = $_POST['theme_id'];
	$data = array(
						'theme_id' => $theme_id,
						'type' => 'wordpress',
						'no_files' => $_POST['no_files'],
						);
	$res = api('build.wp', array('id' => $theme_id));
	
	// Обновленные данные темы
	$theme = db()->where('id', $_REQUEST['theme_id'])->getOne('themes');
	$settings = json_decode($theme['settings'], 1);
	
	// Если выбрано API
	if($settings['synchronization'] == 'api')
	{
		$url = $theme['api_path'].'?key='.$_SESSION['key'].'&act=download';
		
		$data = array('url' => base64_encode(HTTP_PATH.'/themes_archives/'.$theme['wp_archive']));
		
		$src = postPage($url, $data);
		
		preg_match('/\<shabloner\>(.*?)\<\/shabloner\>/is', $src, $match);
		
		if($match[1] == 'ok') 
		{
			$html = 'Синхронизация по <b>API</b> прошла <b class="text-success">успешно</b>!<br>';
			list($link, $t) = explode('wp-content', $theme['api_path']);
			$html .= '<a href="'.$link.'" target="_blank">'.$link.'</a>';
		}
		else 
		{
			$html = 'Во время синхронизации по <b>API</b> произошла <b class="text-danger">ошибка</b>!<br>';
			$html .= $match[1];
		}
		
	}
	
	// Если выбрано FTP
	if($settings['synchronization'] == 'ftp')
	{
		list($path, $t)  = explode('/themes', $settings['ftp_path']); 
		$path .= '/themes';
		
		// Загружаем
		$data = array(
					  'ftp_server' => $settings['ftp_host'],
					  'ftp_user_name' => $settings['ftp_login'],
					  'ftp_user_pass' => $settings['ftp_pass'],
					  'file' => WP_THEMES_PATH.'/'.$theme['wp_archive'],
					  'remote_file' => $path.'/'.$_SESSION['key'].'.zip',
					  );

		$res = api('files.file_upload_by_ftp', $data);
		
		if($res) $html = 'Архив с темой <b class="text-success">успешно загружен</b> по <b>FTP</b>...<br>';
		else $html = 'Произошла <b class="text-danger">ошибка</b> во время загрузки файла по <b>FTP</b>! Проверьте правильность указанных данных для доступа по FTP!<br><br>';
		
		// Распаковываем
		$url = $theme['api_path'].'?key='.$_SESSION['key'].'&act=unzip';
		$src = file_get_contents($url);

		preg_match('/\<shabloner\>(.*?)\<\/shabloner\>/is', $src, $match);
		
		if($match[1] == 'ok') 
		{
			$html .= 'Распаковка архива прошла <b class="text-success">успешно</b>! Синхронизация завершена.<br>';
			list($link, $t) = explode('wp-content', $theme['api_path']);
			$html .= '<a href="'.$link.'" target="_blank">'.$link.'</a>';
		}
		else 
		{
			$html .= 'Во время распаковки архива произошла <b class="text-danger">ошибка</b>!<br>';
			$html .= $match[1];
		}
		
	}
	
	echo $html;
	
}

if($method == 'build.wp_page')
{
	$res = api('build.wp_page', $_REQUEST['page_id']);
	
	if($res['error'] == 0) $html = '<div><i class="fas fa-check-circle green text-success"></i> Изменения сохранены!</div>';
	else $html = '<div><i class="fas fa-times-circle green text-danger"></i> Произошла ошибка! Авторизуйтесь на сайте.</div>';
	echo $html;
}