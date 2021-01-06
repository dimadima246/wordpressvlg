<?php

function bad_quote($str)
{
	$str = str_replace("'", "&#39;", $str);
	$str = str_replace(array(";", "/*"), "", $str);
	return $str;
}
function clean_no_trim($str)
{
	$str = str_replace(array("\n","\r","\t"),"",$str);
	return $str;
}

function api($method, $_P=array())
{
	
	list($app, $function) = explode('.', $method);
	
	if(file_exists(ROOT.'/api/'.$app.'.php')) require_once(ROOT.'/api/'.$app.'.php');
	else return false;
	
	$namespace = $app.'\\'.$function;
	
	return $namespace($_P);
	
}

function db()
{
	global $db;
	return $db;
}

function sdb()
{
	global $sdb;
	return $sdb;
}

function isAuth()
{
  if($_SESSION['user_id']) return true;
  else return false;
}

function isAdmin()
{
  if($_SESSION['user_id'] == 1) return true;
  else return false;
}

function isInstalled()
{
  $res = db()->tableExists ('themes');
  if($res)
  {
	  $theme = db()->where('id', THEME_ID)->getOne('themes');
	  $key = get_option_wp('license_key');
	  $hash = md5($key.$_SERVER['HTTP_HOST']);
	  
	  if(!$theme['id'] || !$key) return false;
	  
	  if($theme['license_key'] == $hash) return true;
	  
  }
  //if($id) return true;
  else return false;
}

function roles()
{
	$roles = array(
						'index' => show_text('page_role_index', THEME_LANGUAGE),
						'page' => show_text('page_role_page', THEME_LANGUAGE),
						'single' => show_text('page_role_single', THEME_LANGUAGE),
						'archive' => show_text('page_role_archive', THEME_LANGUAGE),
						'search' => show_text('page_role_search', THEME_LANGUAGE),
						'woocommerce' => show_text('page_role_woocommerce', THEME_LANGUAGE),
						'404' => show_text('page_role_404', THEME_LANGUAGE),
						'other' => show_text('page_role_other', THEME_LANGUAGE),
						);
	return $roles;					
}

function role_name($role)
{
	$roles = roles();
	return $roles[$role];
}

function wp_urlencode($str)
{
	return strtolower(urlencode($str));
}

function time_limit()
{
	global $db;
	$process_time = (microtime(true) - START_TIME);
	
	if($process_time >= MY_TIME_LIMIT)
	{
		$db->__destruct();
		die("\r\n<br>time_limit ".MY_TIME_LIMIT." exceeded");
	}
}

function get_option_wp($name)
{
	db()->setPrefix (TABLE_PREFIX);
	
	$val = db()->where('option_name', $name)->getValue('options', 'option_value'); 
	
	db()->setPrefix ('shabloner_');
	return $val;
}

function set_option_wp($name, $value)
{
	db()->setPrefix (TABLE_PREFIX);
	
	$id = db()->where('option_name', $name)->getValue('options', 'option_id');
	$data = array('option_name' => $name, 'option_value' => $value);
	if($id) db()->where('option_id', $id)->update('options', $data);
	else $id = db()->insert('options', $data);
	
	db()->setPrefix ('shabloner_');
	return $id;
}



function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

function license_check($key)
{
	if(!$key) return error('no key');
	$data = array(
						'key' => $key,
						'domain' => $_SERVER['HTTP_HOST'],
						'theme_id' => THEME_ID,
						);
	$res = postPage(SHTTP_PATH.'/license', $data);
	$res = json_decode($res, 1);
	return $res;
}

function install_check()
{
	global $_RETURN;
	
	// Проверка ключа
	if(!stristr($_SERVER['HTTP_HOST'], '.') || stristr($_SERVER['HTTP_HOST'], 'shabloner.ru'))
	{
		uninstall();
		install($_POST['license_key']);
		redirect(HTTP_PATH.'/index.php?app=themes&act=show'); 
	}
	else
	{
		$res = license_check($_POST['license_key']);
		if($res['error']) $_RETURN = $res;
		else
		{
		//echo '<pre>'; print_r($_RETURN); echo '</pre>'; 
			uninstall();
			install($_POST['license_key']);
			redirect(HTTP_PATH.'/index.php?app=themes&act=show'); 
			//echo '<pre>'; print_r($res); echo '</pre>'; 
		}
	}
	//return $_RETURN;
}

function show_text($key, $lang)
{
	if(stristr($_SERVER['REQUEST_URI'], '/editor')) $lang_file = file(ROOT.'/files/language/'.$lang.'.lang');
	else $lang_file = file(get_template_directory().'/editor/files/language/'.$lang.'.lang'); 
	
	foreach($lang_file as $line)
	{
		list($var, $text) = explode('|', clean($line));
		if($var == $key) return $text;
	}
	return 'NO_WORD';
}

function install($key)
{
	$arr = json_decode(file_get_contents(ROOT.'/../install.json'), 1);
	
	//echo '<pre>'; print_r($arr); echo '</pre>'; 
	
	// Connect to MySQL server
	//@mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('Error connecting to MySQL server: ' . mysqli_error());
	
	//echo DB_USER.' '.DB_PASSWORD.' '.DB_HOST.'<br>';
	
	// Select database
	//mysql_select_db(DB_NAME) or die('Error selecting MySQL database `'.DB_NAME.'`: ' . mysqli_error());
	
	// Создаем таблицы
	$filename = ROOT.'/install.sql';
	
	// Temporary variable, used to store current query
	$templine = '';
	// Read in entire file
	$lines = file($filename);
	// Loop through each line
	foreach ($lines as $line)
	{
		// Skip it if it's a comment
		if (substr($line, 0, 2) == '--' || $line == '')
			continue;

		// Add this line to the current segment
		$templine .= $line;
		// If it has a semicolon at the end, it's the end of the query
		if (substr(trim($line), -1, 1) == ';')
		{
			// Perform the query
			//mysqli_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error() . '<br /><br />');
			db()->rawQuery($templine);
			// Reset temp variable to empty
			$templine = '';
		}
	}
	
	// Вставляем тему
	$data = $arr['theme'];
	$data['license_key'] = md5($key.$_SERVER['HTTP_HOST']);
	db()->insert('themes', $data);
	
	// Лицензия в БД WP
	$key_hash = md5($key.$_SERVER['HTTP_HOST']);
	set_option_wp('license_key', $key);
	set_option_wp('license_key_hash', $key_hash);
	set_option_wp('shabloner_theme_id', $arr['theme']['id']);
	
	api('files.write', array(ROOT.'/../license.key', base64_encode($key_hash)));
	
	// Данные компании
	set_option_wp('address', show_text('default_address', THEME_LANGUAGE));
	set_option_wp('phone', show_text('default_phone', THEME_LANGUAGE));
	set_option_wp('prdvg_email', show_text('default_email', THEME_LANGUAGE));
	set_option_wp('schedule', show_text('default_schedule', THEME_LANGUAGE));
	
	// Вставляем блоки
	foreach($arr['blocks'] as $block) db()->insert('blocks_schema', $block);
	
	// Вставляем страницы
	foreach($arr['pages'] as $block) db()->insert('pages_schema', $block);
	
	// Файлы
	@mkdir(ROOT.'/sources/themes/'.$arr['theme']['id']);
	@mkdir(ROOT.'/sources/themes/'.$arr['theme']['id'].'/files');
	api('files.recurse_copy', array(ROOT.'/../files', ROOT.'/sources/themes/'.$arr['theme']['id'].'/files'));
	
	@mkdir(ROOT.'/sources/themes/'.$arr['theme']['id'].'/temp');
	@mkdir(ROOT.'/sources/themes/'.$arr['theme']['id'].'/temp/css');
	@mkdir(ROOT.'/sources/themes/'.$arr['theme']['id'].'/temp/js');
	@mkdir(ROOT.'/sources/themes/'.$arr['theme']['id'].'/temp/blocks');
}

function uninstall()
{
	db()->rawQuery('DROP table `shabloner_themes`');
	db()->rawQuery('DROP table `shabloner_blocks_schema`');
	db()->rawQuery('DROP table `shabloner_pages_schema`');
	db()->rawQuery('DROP table `shabloner_fonts`');
	db()->rawQuery('DROP table `shabloner_blocks`');
	db()->rawQuery('DROP table `shabloner_blocks_cats`');
	db()->rawQuery('DROP table `shabloner_macroses`');
	
	// Лицензия в БД WP
	set_option_wp('license_key', '0');
	
	// Файлы
	@unlink(ROOT.'/../license.key');
	api('files.delete_directory', ROOT.'/sources/themes/'.THEME_ID);
}

function wp_route()
{
	if(!stristr($_SERVER['HTTP_HOST'], '.') || stristr($_SERVER['HTTP_HOST'], 'shabloner.ru')) return true;
	require_once(get_template_directory().'/shabloner.php');
	//$file_key = base64_decode(@file_get_contents(get_template_directory().'/license.key'));
	
	$key = get_option('license_key');
	$shabloner_theme_id = get_option('shabloner_theme_id');
	$key_hash = get_option('license_key_hash');
	$file_key = md5($key.$_SERVER['HTTP_HOST']);
	
	
	if(($file_key != $key_hash || !$key_hash || !$file_key || $shabloner_theme_id != THEME_ID) && !stristr($_SERVER['REQUEST_URI'], 'wp-admin') && !stristr($_SERVER['REQUEST_URI'], 'wp-login')) 
	{
header('Content-Type: text/html; charset=utf-8');		
die('<title>'.show_text('theme_no_activate', THEME_LANGUAGE).'</title>
	<link href="'.get_template_directory_uri().'/editor/interface/proximanova/stylesheet.css" rel="stylesheet">
	<link href="'.get_template_directory_uri().'/editor/interface/css/bootstrap.css" rel="stylesheet">
	<style>body, h1 {font-family: \'Proxima Nova Rg\', sans-serif !important;}</style>
	<center style="margin-top:150px;">
	<a href="http://shabloner.ru" target="_blank"><img src="'.get_template_directory_uri().'/inc/logo_150.png" /></a>
	<div style="margin-top:50px;">
	<a class="btn btn-primary btn-lg" href="'.get_template_directory_uri().'/editor/index.php">'.show_text('activate_theme', THEME_LANGUAGE).'</a>
	</div>
	</center>');
	}
}
function clean($str)
{
	$str = str_replace(array("\n","\r","\t"),"",$str);
	return trim($str);
}


function redirect($url)
{
	$urlParts = parse_url($url);
	if(!$urlParts['host']) $url = HTTP_PATH.str_replace("&amp;", "&", $url);
	header("Location: $url");
	die("<script type=\"text/javascript\">window.location = '$url';</script>");
}

function error($str)
{
	return array("error"=>$str);
}

function randomWord($number) {

$letters = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
for($i=0;$i<$number;$i++) {
$word .= $letters[mt_rand(0,count($letters)-1)];
}
return $word;
}

function randomElement($array)
{
	return $array[mt_rand(0, count($array)-1)];
}

function xml2array ( $xmlObject, $out = array () )
{
    foreach ( (array) $xmlObject as $index => $node )
        $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

    return $out;
}

function postPage($url, $post=array(), $cookie='') 
{
  //$url = "http://".str_replace("http://","",$url);
  $ch = curl_init(); 
  curl_setopt($ch, CURLOPT_URL, $url);
  //curl_setopt($ch, CURLOPT_HEADER, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
  //curl_setopt($ch, CURLOPT_USERAGENT,USER_AGENT);
  if(count($post))
  {
	  curl_setopt($ch, CURLOPT_POST, 1);
	  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  }
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,30);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  
  if($cookie)
  {
	  curl_setopt( $ch, CURLOPT_COOKIEJAR,  $cookie );
	  curl_setopt( $ch, CURLOPT_COOKIEFILE, $cookie );
  }
  
  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
}

function addFolderToZip($path, $zipFileName, $root_path='')
{
	require_once(ROOT.'/includes_back/pclzip.lib.php');
	$name_arch = $zipFileName;
	$files_dir = rtrim($path, '/');
	$files_to_arch = array();
	//$files_to_arch[]= $root_path;

	for($d = @opendir($files_dir); $file = @readdir($d);)
	{      
		if($file!='.' && $file!='..')
		{
			//$files_to_arch[]= $root_path. '/'. $file;
			$files_to_arch[]= $file;
		}
	}

	chdir($files_dir);

	$archive = new PclZip($name_arch);
	$v_list = $archive->create(implode(',', $files_to_arch), PCLZIP_OPT_ADD_PATH, $root_path);

	//print_r($files_to_arch);
	//$v_list=$archive->create(
	//    implode(',', $files_to_arch),
	//    PCLZIP_OPT_REMOVE_PATH,
	//    $files_dir
	//);

	if($v_list == 0)
	{
	   return false; //("Error : ".$archive->errorInfo(true));
	}
	else
	{
	   return true;
	}
}




function getPage($url) 
{
  //$url = "http://".str_replace("http://","",$url);
  $ch = curl_init(); 
  curl_setopt($ch, CURLOPT_URL, $url);
  //curl_setopt($ch, CURLOPT_HEADER, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch, CURLOPT_USERAGENT,USER_AGENT);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,30);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  $result = curl_exec($ch);
  
  curl_close($ch);
  return $result;
}

function get_encoding($str){
    $cp_list = array('utf-8', 'windows-1251');
    foreach ($cp_list as $k=>$codepage){
        if (md5($str) === md5(iconv($codepage, $codepage, $str))){
            return $codepage;
        }
    }
    return null;
}

function showUrlCorrect($current_url, $url)
{
	list($link_href, $trash) = explode("#", $url);
	$current_url_data = parse_url($current_url);
	$link_data = parse_url($link_href);
	//echo '<pre>'; print_r($current_url_data); echo '</pre>'; 
	
	
	$link_domain = show_website_clear($link_data['host']);
	
	if(substr($link_data['path'], 0, 2) == './') 
	{
		$link_href = ltrim($link_href, '.');
	}
	
	if(strstr($link_href, '../'))
	{
		$orig_parts = explode('/', $current_url_data['path']);
		unset($orig_parts[count($orig_parts)-1]);
		unset($orig_parts[count($orig_parts)-1]);
		
		$link_href = implode('/', $orig_parts).str_replace('..','',$link_href);
	}
	elseif(substr($link_data['path'], 0, 1) != '/' && !$link_data['host'])
	{
		$parts = explode('/', $current_url_data['path']);
		unset($parts[count($parts)-1]);
		
		$parts[] = $link_data['path'];
		$current_url_data['path'] = implode('/', $parts);
		return $current_url_data['scheme'].'://'.$current_url_data['host'].'/'.ltrim($current_url_data['path'],'/');
	}
	
	if(!$link_data['host']) $link_href = $current_url_data['scheme'].'://'.$current_url_data['host'].'/'.ltrim($link_href,'/');
	return $link_href;
}

function show_website_clear($domain)
{
	$domain = trim($domain);
	$domain = trim($domain,"/");
	$domain = str_replace("www.","",$domain);
	$domain = str_replace(array("http://", "https://"),"",$domain);
	return $domain;
}


function file_get_name($url)
{
	$data = array();
	list($url, $q) = explode('?', $url);
	$parts = explode('/', $url);
	$data['name'] = $parts[count($parts)-1];
	
	$ext_parts = explode('.', $data['name']);
	$data['ext'] = $ext_parts[count($ext_parts)-1];
	return $data;
}

function file_save($path, $content)
{
	$f = fopen($path, 'w');
	fwrite($f, $content);
	fclose($f);
}


function recurse_find_new($src, $days=1) { 
	$dir = opendir($src); 
	$f = fopen($_SERVER['DOCUMENT_ROOT'].'/today_changes_file.txt', 'a');
	while(false !== ( $file = readdir($dir)) ) { 
		if (( $file != '.' ) && ( $file != '..' )) { 
			if ( is_dir($src . '/' . $file) ) { 
				recurse_find_new($src . '/' . $file, $days); 
			} 
			else { 
				if(filemtime($src . '/' . $file) > strtotime(showChangedTime(-$days, 'd')) || filectime($src . '/' . $file) > strtotime(showChangedTime(-$days, 'd'))) // date('Y-m-d')
				{
					fwrite($f, $src . '/' . $file."\n");
					//echo $src . '/' . $file.' | '.date('d.m.Y H:i:s', filemtime($src . '/' . $file)).'<br>';
				}
					//copy($src . '/' . $file,$dst . '/' . $file); 
			} 
		} 
	} 
	closedir($dir); 
}



function showChangedTime($diff, $type='H', $simple=0)
{
	if($type == 'Y') $factor = 3600*24*365;
	if($type == 'm') $factor = 3600*24*30;
	if($type == 'd') $factor = 3600*24;
	if($type == 'H') $factor = 3600;
	if($type == 'i') $factor = 60;
	if($type == 's') $factor = 1;
	$time = time();
	//if(LOCAL_SERVER == 1) $time -= 3600;
	$res_time = $time+($diff*$factor);
	
	if($simple == 0) return date("Y-m-d H:i:s", $res_time);
	else return date("Y-m-d", $res_time);
}



function str_replace_limit($oldpattern, $new, $where, $limit = false, $reverse = false) {
     
    $result = '';
     
    if ($reverse) { // переворачиваем строку, если требуется начать с концы
        $where = strrev($where);
    }
     
    if ($limit) {
        $result = preg_replace($oldpattern, $new, $where, $limit);
    } else {
        $result = preg_replace($oldpattern, $new, $where);
    }
     
    if ($reverse) { // переворачиваем строку обратно
        $result = strrev($result);
    }
     
    return $result;
}

function cut_link($text)
{
	$text = preg_replace('/href=\"(.*?)\"/is','',$text);
	$text = preg_replace("/href=\'(.*?)\'/is",'',$text);
	$text = preg_replace('/<[^>]*>/','',$text);
	return $text;
}

function cut_html($text)
{
	$text = preg_replace('/\s+/u', ' ', $text);
	return strip_tags($text, '<br>');
}

function cut_spaces($text)
{
	$text = preg_replace('/ +/', ' ', $text);
	return $text;
}

function coin($chance = 50)
{
	$seed = mt_rand(1,100);
	if($seed <= $chance) return true;
	else return false;
}

function text_correct($text)
{
	//$text = mb_strtolower($text, 'utf-8');
	$text = ucfirst_utf8($text);
	$text = str_replace(array('москв'), array('Москв'), $text);
	$text = str_replace(array('росси'), array('Росси'), $text);
	return $text;
}

function ucfirst_utf8($str)
{
    return mb_substr(mb_strtoupper($str, 'utf-8'), 0, 1, 'utf-8') . mb_substr($str, 1, mb_strlen($str)-1, 'utf-8');
}

function to_utf_8($str)
{
	return iconv('windows-1251', 'utf-8', $str);
}
function from_utf_8($str)
{
	return iconv('utf-8', 'windows-1251', $str);
}

