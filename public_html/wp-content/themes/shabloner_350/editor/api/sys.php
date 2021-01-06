<?php

namespace sys;

function preg_simple($_P = array())
{
	list($pattern, $str, $num) = $_P;
	preg_match($pattern, $str, $match);
	return $match[$num];
}

function rus2eng($text)
{
    // Русский алфавит
    $rus_alphabet = array(
        'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й',
        'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф',
        'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
        'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й',
        'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф',
        'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'
    );
    
    // Английская транслитерация
    $rus_alphabet_translit = array(
        'A', 'B', 'V', 'G', 'D', 'E', 'IO', 'ZH', 'Z', 'I', 'I',
        'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F',
        'H', 'C', 'CH', 'SH', 'SH', '', 'Y', '', 'E', 'IU', 'IA',
        'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'i',
        'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f',
        'h', 'c', 'ch', 'sh', 'sh', '', 'y', '', 'e', 'iu', 'ia'
    );
    
    return str_replace($rus_alphabet, $rus_alphabet_translit, $text);
}

function slug($txt)
{
	$txt = mb_strtolower($txt, 'utf8');
	$txt = rus2eng($txt);
	$txt = str_replace(' ', '-', $txt);
	$txt = str_replace(array('!','#',',','.','(',')','/','\\','"',"'", "~", ":"), '', $txt);
	
	return $txt;
}

function access($_P=array())
{
	if(isAuth()) return true; // проверка вторизации
	
	foreach(array('object', 'id', 'user_id') as $key) if(!$_P[$key]) return false;
	
	
	// Тема
	if($_P['object'] == 'theme')
	{
		$id = db()->where('id', $_P['id'])->where('user_id', $_P['user_id'])->getValue('themes', 'id');
	}
	
	// Страницы
	else if($_P['object'] == 'page')
	{
		$page = db()->where('id', $_P['id'])->getOne('pages_schema');
		$id = db()->where('id', $page['theme_id'])->where('user_id', $_P['user_id'])->getValue('themes', 'id');
	}
	
	// Блок
	else if($_P['object'] == 'block_schema')
	{
		
	}
	
	if($id) return true;
	else return false;
}

