<?php

namespace themes;

function get_fonts()
{
	return db()->get('fonts');
}


function edit($_P)
{
	foreach(array('id') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	$id = $_P['id'];
	$theme = db()->where('id', $_P['id'])->getOne('themes');
	
	$theme_folder = ROOT.'/sources/themes/'.$id;
	
	$data = array(
						 'demo_updated' => '0',
						 'wp_updated' => '0',
						 'category_id' => $_P['category_id'],
						 //'name' => $_P['name'],
						 'description' => $_P['description'],
						 'colors' => $_P['colors'],
						 'css' => $_P['css'],
						 'html' => $_P['html'],
						 'api_path' => $_P['api_path'],
						 );
	
	if(!$_P['wp_folder_name']) $data['wp_folder_name'] = 'shabloner_'.$id;
	else $data['wp_folder_name'] = preg_replace('/[^0-9A-Za-z_]/i', '', $_P['wp_folder_name']);
	
	if($_P['category_id']) $data['category_id'] = $_P['category_id'];
	if($_P['default_button_class']) $data['default_button_class'] = $_P['default_button_class'];
	else $data['default_button_class'] = '';
	
	if($_P['category']) 
	{
		$category = db()->where('name', $_P['category'])->getOne('themes_cats');
		if($category['id']) $data['category_id'] = $category['id'];
	}
	
	// Изображение
	if($_FILES['image']['size'] > 0)
	{
		if($theme['image']) @unlink(ROOT.$theme['image']);
		$file = api('files.upload', array($_FILES['image']['name'], $_FILES['image']['tmp_name']));
		$data['image'] = $file['file_path'];
	}
		

	// Фон
	if($_P['settings']['bg_delete']) 
	{
		@unlink(ROOT.$theme['bg_image']);
		$data['bg_image'] = '';
	}
	
	if($_FILES['bg_image']['size'] > 0)
	{
		if($theme['bg_image']) @unlink(ROOT.$theme['bg_image']);
		$file = api('files.upload', array($_FILES['bg_image']['name'], $_FILES['bg_image']['tmp_name'], '/sources/themes/'.$_P['id'].'/files'));
		$data['bg_image'] = $file['file_path'];
	}
	
	// Сохранили настройки
	$data['settings'] = json_encode($_P['settings']);
	
	// Сохранили структуру контента и меню
	$data['content'] = $_P['content'];
	$data['menu'] = $_P['menu'];

	db()->where('id', $_P['id'])->update('themes', $data);					 
	
	
	return error(0);
}


function pages_get($_P=array())
{
	if($_P['id']) db()->where('id', $_P['id']);
	if($_P['theme_id']) db()->where('theme_id', $_P['theme_id']);
	
	// Сортировка
	if($_P['order']) $order = '`'.$_P['order'].'`';
	else $order = "name";
	
	if($_P['order_by']) $order_by = $_P['order_by'];
	else $order_by = "asc";
	
	// Вывод
	if($_P['offset']) $offset = $_P['offset'];
	else $offset = "0";
	
	if($_P['count']) $count = $_P['count'];
	else $count = "30";

	$res = array();
	
	db()->withTotalCount();
	db()->orderBy($order, $order_by);
	
	$res['data'] = db()->get("pages_schema", array ($offset, $count), $fields);
	//echo db()->getLastQuery()." | ".db()->getLastError().'<br>';
	$res['total'] = db()->totalCount;
	return $res;
}


function page_save($_P)
{
	foreach(array('id') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	$data = array();
	
	if($_P['areas'])
	{
		foreach($_P['areas'] as $area => $rows)
		{
			if(in_array($area, array('blocks'))) // 'header', 'slider', 'content', 'footer', 'rows', 
			{
				$data[$area] = json_encode($rows);
			}
		}
	}
	
	db()->where('id', $_P['id'])->update('pages_schema', $data);
	
	return error('0');
}



function block_delete($_P=array())
{
	foreach(array('theme_id', 'block') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	$theme_id = $_P['theme_id'];
	$folder = ROOT.'/sources/themes/'.$theme_id.'/blocks/'.$_P['block'];
	
	api('files.delete_directory', $folder);
	
	//@unlink($file_path);
	
	return error('0');
}

function page_new($_P=array())
{
	foreach(array('theme_id', 'role') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	$id = db()->where('theme_id', $_P['theme_id'])->where('role', $_P['role'])->where('role', 'other', '!=')->getValue('pages_schema', 'id');
	if($id) return array('id' => $id);
	
	if($_P['role'] == 'other' && !$_P['name']) return error('no name');	
	
	$theme_id = $_P['theme_id'];
	
	$data = array(
						'theme_id' => $_P['theme_id'],
						'role' => $_P['role'],
						);
	$fields = array(
	'blocks', 'rows', 'header', 'slider', 'content', 'footer', 'slug'
	);
	foreach($fields as $field) $data[$field] = '';	
	
	if($_P['slug']) $data['slug'] = api('sys.slug', $_P['slug']);		
	
	if($_P['name']) $data['name'] = $_P['name'];		
	else $data['name'] = role_name($_P['role']);		
	
	if($_P['from_page_id']) 
	{
		$from_page = db()->where('id', $_P['from_page_id'])->getOne('pages_schema');
		foreach(array('header', 'slider', 'content', 'footer', 'blocks') as $field) $data[$field] = $from_page[$field];
	}
	
	$id = db()->insert('pages_schema', $data);
	
	return array('id' => $id);
}

function page_edit($_P=array())
{
	foreach(array('id', 'theme_id') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	$data = array(
						'role' => $_P['role'],
						);
	if($_P['name']) $data['name'] = $_P['name'];					
	if($_P['slug']) $data['slug'] = $_P['slug'];					
	
	db()->where('id', $_P['id'])->where('theme_id', $_P['theme_id'])->update('pages_schema', $data);
	
	return error('0');
}


function page_delete($_P=array())
{
	foreach(array('id') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	db()->where('id', $_P['id'])->delete('pages_schema');
	
	return error('0');
}



function main_page_id($theme_id)
{
	$page_id = db()->where('theme_id', $theme_id)->where('role', 'index')->getValue('pages_schema', 'id');
	if(!$page_id) $page_id = db()->where('theme_id', $theme_id)->orderBy('id', 'asc')->getValue('pages_schema', 'id');
		
	return $page_id;
}

function replace_url($_P = array())
{
	list($url, $schema) = $_P;
	$items = explode("\n", $schema);
	foreach($items as $item)
	{
		$item = clean($item);
		list($find, $replace) = explode('|', $item);
		$url = str_replace($find, $replace, $url);
	}
	return $url;
}
