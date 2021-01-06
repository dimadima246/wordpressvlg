<?php

namespace download;

function css_url($_P = array())
{
	list($link, /* ссылка по которой скачиваем */ 
	$url, /* текущий адрес страницы */ 
	$folder /* папка в которую скачиваем */) = $_P;
	
	// Открываем файл
	$css_url = showUrlCorrect($url, $link);
	
	$css_file = file_get_name($css_url);
	$css_file_path = $folder.'/'.$css_file['name'];

	//if(file_exists($css_file_path)) return $css_file;
	
	$css_file['name'] = urldecode($css_file['name']);
	$css_src = getPage($css_url);
	
	// Шрифты
	preg_match_all('/\@import (\"|\')(.*?)(\"|\')/is', $css_src, $matches, PREG_SET_ORDER);
	if($matches)
	{
		foreach($matches as $match)
		{
			$file_url = $match[2];
			css_url(array($file_url, $css_url, $folder));
		}
	}
	
	// Скачиваем файлы из CSS
	//echo '<pre>'; print_r($css_file); echo '</pre>'; 
	//if($css_file['name'] == 'fonts.css') $preg_end = 'is';
	//else $preg_end = 'U';
	$preg_end = 'is';
	preg_match_all('/url\((\"|\')(.*?)(\"|\')\)/is', $css_src, $matches, PREG_SET_ORDER);
	preg_match_all('/url\((.*?)\)/is', $css_src, $matches_no_quotes, PREG_SET_ORDER);
	$matches = array_merge($matches, $matches_no_quotes);
	
	if($matches)
	{
		foreach($matches as $match)
		{ 
			$file_url = str_replace(array('"', "'"), '', $match[1].$match[2]);
			
			if(!stristr($file_url, 'data:'))
			{
				//скачивем файл
				$new_name = file_get(array(showUrlCorrect($css_url, $file_url), $folder));

				// замена url
				$css_src = str_replace($file_url, ''.$new_name.'', $css_src); 
				
			}
		}
	}
	//echo $css_url.'<br>';
	file_save($css_file_path, $css_src);
	return $css_file;
}

function file_get($_P = array())
{
	list($url, /* ссылка по которой скачиваем */ 
	$folder /* папка в которую скачиваем */) = $_P;
	
	//$url = str_replace(" ", "%20", $url);
	list($url, $t) = explode('?', $url);
	$file = file_get_name($url);
	
	$parts = parse_url($url);
	//$file_name = str_replace("/", '-', trim($parts['path'], '/'));
	$file_name = $file['name'];
	
	$file_name = urldecode($file_name);
	$my_path = $folder.'/'.$file_name;
	if(!file_exists($my_path))
	{
		$f = fopen($my_path, 'w');
		fwrite($f, getPage($url));
		fclose($f);
	}
	return $file_name;
}