<?php

namespace blocks;


function default_blocks_data($what)
{
	if($what == 'settings') return array
	(
		 array(
		 'name' => 'class',
		 'title' => 'Классы CSS',
		 ),
		 array(
		 'name' => 'style',
		 'title' => 'Стили CSS',
		 ),
		 array(
		 'name' => 'bg',
		 'title' => 'Фон',
		 'type' => 'image',
		 ),
	);
	
	if($what == 'content_structure_main') return array
	(
		 array(
		 'name' => 'title',
		 'title' => 'Заголовок',
		 'type' => 'text',
		 ),
		 array(
		 'name' => 'text',
		 'title' => 'Текст',
		 'type' => 'textarea',
		 ),
		 array(
		 'name' => 'button_text',
		 'title' => 'Текст кнопки',
		 'type' => 'text',
		 ),
		 array(
		 'name' => 'url',
		 'title' => 'Ссылка',
		 'type' => 'text',
		 ),
		 array(
		 'name' => 'image',
		 'title' => 'Изображение',
		 'type' => 'image',
		 ),
	 );
	 
	if($what == 'content_structure_element') return array
	(
		 array(
		 'name' => 'title',
		 'title' => 'Заголовок',
		 'type' => 'text',
		 ),
		 array(
		 'name' => 'text',
		 'title' => 'Текст',
		 'type' => 'textarea',
		 ),
		 array(
		 'name' => 'button_text',
		 'title' => 'Текст кнопки',
		 'type' => 'text',
		 ),
		 array(
		 'name' => 'url',
		 'title' => 'Ссылка',
		 'type' => 'text',
		 ),
		 array(
		 'name' => 'image',
		 'title' => 'Изображение',
		 'type' => 'image',
		 ),
		 array(
		 'name' => 'field_1',
		 'title' => 'Доп. поле 1',
		 'type' => 'text',
		 ),
		 array(
		 'name' => 'field_2',
		 'title' => 'Доп. поле 2',
		 'type' => 'text',
		 ),
	 );
}


function get_cats($_P=array())
{
	if($_P['id']) db()->where('id', $_P['id']);
	if($_P['content'] == 1) db()->where('id', array(1,2,19), 'not in');
	if($_P['not_in']) db()->where('id', $_P['not_in'], 'not in');
	db()->where('count', 0, '>');
	return db()->orderBy('name', 'asc')->get('blocks_cats');
}


function get_cat_name($id)
{
	global $_CATS;
	if(!$_CATS[$id]) 
	{
		$_CATS[$id] = db()->where('id', $id)->getValue('blocks_cats', 'name');
	}
	return $_CATS[$id];
}

function get_cat_slug($id)
{
	global $_CATS_SLUG;
	if(!$_CATS_SLUG[$id]) 
	{
		$_CATS_SLUG[$id] = db()->where('id', $id)->getValue('blocks_cats', 'slug');
	}
	return $_CATS_SLUG[$id];
}



function add($_P=array())
{
	foreach(array('page_id') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	$page = db()->where('id', $_P['page_id'])->getOne('pages_schema');
	
	// Настройки блока ряда
	$block_row = db()->where('id', ROW_BLOCK)->getOne('blocks');
	
	// Создали блок
	$data = array(
						'block_id' => BLOCK_EMPTY,
						'theme_id' => $page['theme_id'],
						'row_settings' => $block_row['settings'],
						'row_id' => '0',
						);
	$fields = array(
	'content', 'content_structure', 'settings'
	);
	foreach($fields as $field) $data[$field] = '';
	
	$id = db()->insert('blocks_schema', $data);
	if(!$id) return error('block_schema_id error');
	
	// Обозначили её на странице
	$blocks = json_decode($page['blocks'], 1);
	
	// Указан ли блок после которого вставить этот
	$add_arr = array($id);
	if($_P['after_block_schema_id'])
	{
		if($blocks)
		{
			foreach($blocks as $block_num => $block_schema_id)
			{
				if($block_schema_id == $_P['after_block_schema_id'])
				{
					array_splice($blocks, ($block_num+1), 0, $add_arr);
					break 1;
				}
			}
		}
		else $blocks[] = $id;
	}
	else $blocks[] = $id;
	
	db()->where('id', $page['id'])->update('pages_schema', array('blocks' => json_encode($blocks)));
	
	return array('id' => $id);
}

function add_exists($_P)
{
	foreach(array('id', 'page_id') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	$page = db()->where('id', $_P['page_id'])->getOne('pages_schema');
	$block_schema = db()->where('id', $_P['id'])->getOne('blocks_schema');
	if(!$block_schema['id']) return error('wrong id');
	
	$blocks = json_decode($page['blocks'], 1);	
	
	// Проверили есть ли такой блок на странице
	foreach($blocks as $int => $block_schema_id) if($block_schema_id == $_P['id']) return error('block already exists on this page');
	
	// Разместили блок на странице
	if($_P['replace_id'] && !$_P['no_replace'])
	{
		foreach($blocks as $int => $block_id) if($_P['replace_id'] == $block_id) $blocks[$int] = $_P['id'];
	}
	else $blocks[] = $_P['id'];
	
	db()->where('id', $page['id'])->update('pages_schema', array('blocks' => json_encode($blocks)));

	return array('block_id' => $block_schema['block_id']);
}

function move($_P)
{
	foreach(array('block_schema_id', 'page_id', 'direction') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	$page = db()->where('id', $_P['page_id'])->getOne('pages_schema');
	$block_schema = db()->where('id', $_P['block_schema_id'])->getOne('blocks_schema');
	if(!$block_schema['id']) return error('wrong id');
	
	$blocks = array_values(json_decode($page['blocks'], 1));	
	
	// Меняем местами блоки	
	foreach($blocks as $block_num => $block_schema_id)
	{
		if($block_schema_id == $_P['block_schema_id'])
		{
			if($_P['direction'] == 'up' && $blocks[$block_num - 1]) 
			{
				$blocks[$block_num] = $blocks[$block_num - 1]; // Предыдущий на текущее место
				$blocks[$block_num - 1] = $_P['block_schema_id']; // Текущий назад
			}
			if($_P['direction'] == 'down' && $blocks[$block_num + 1]) 
			{
				$blocks[$block_num] = $blocks[$block_num + 1]; // Следующий на текущее место
				$blocks[$block_num + 1] = $_P['block_schema_id']; // Следующий назад
			}
			break 1;
		}
	}
	
	db()->where('id', $page['id'])->update('pages_schema', array('blocks' => json_encode($blocks)));

	return error('0');
}


function get($_P=array())
{
	
	if($_P['id']) db()->where('id', $_P['id']);
	if($_P['category_id']) db()->where('category_id', $_P['category_id']);
	
	// Поиск
	if($_P['search']) 
	{
		$firstSearch = $_P['search'];
		$words = explode(' ', $_P['search']);
		foreach($words as $int => $word) $words[$int] = $word; // sys_semantic_word
		$_P['search'] = '%'.implode('%', $words).'%';
		
		$_P['search'] = trim($_P['search']);
		$data = array();
		for($i=0;$i<1;$i++) $data[] = $_P['search'];
		$data[] = $firstSearch;
		db()->where("(name LIKE ? or description LIKE ?)", $data); //  or `title` LIKE ? or `description` LIKE ?
		
	}
	
	// Сортировка
	if($_P['order']) $order = '`'.$_P['order'].'`';
	else $order = "id";
	
	if($_P['order_by']) $order_by = $_P['order_by'];
	else $order_by = "desc";
	
	// Вывод
	if($_P['offset']) $offset = $_P['offset'];
	else $offset = "0";
	
	if($_P['count']) $count = $_P['count'];
	else $count = "30";

	$res = array();
	
	db()->withTotalCount();
	if($_P['order_rand'] == 1) db()->orderBy('rand()');
	else db()->orderBy($order, $order_by)->orderBy('id', 'desc');
	
	$res['data'] = db()->get("blocks", array ($offset, $count), $fields);
	//echo db()->getLastQuery()." | ".db()->getLastError().'<br>';
	$res['total'] = db()->totalCount;
	return $res;
}

function get_schema($_P=array())
{
	if($_P['id']) db()->where('id', $_P['id']);
	if($_P['theme_id']) db()->where('theme_id', $_P['theme_id']);
	
	// Сортировка
	if($_P['order']) $order = '`'.$_P['order'].'`';
	else $order = "id";
	
	if($_P['order_by']) $order_by = $_P['order_by'];
	else $order_by = "desc";
	
	// Вывод
	if($_P['offset']) $offset = $_P['offset'];
	else $offset = "0";
	
	if($_P['count']) $count = $_P['count'];
	else $count = "30";

	$res = array();
	
	db()->withTotalCount();
	if($_P['order_rand'] == 1) db()->orderBy('rand()');
	else db()->orderBy($order, $order_by)->orderBy('id', 'desc');
	
	$res['data'] = db()->get("blocks_schema", array ($offset, $count), $fields);
	//echo db()->getLastQuery()." | ".db()->getLastError().'<br>';
	$res['total'] = db()->totalCount;
	return $res;
}


function delete($_P=array())
{
	foreach(array('id', 'page_id') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	$block_schema = db()->where('id', $_P['id'])->getOne('blocks_schema');
	if(!$block_schema['id']) return error('wrong block');
	
	// Изменения в страницах
	$page = db()->where('id', $_P['page_id'])->getOne('pages_schema');
	if(!$page['id']) return error('wrong page');
	
	$blocks = json_decode($page['blocks'], 1);
	
	foreach($blocks as $int => $block) 
	{
		if($block == $_P['id']) unset($blocks[$int]);
	}
	
	$data = array('blocks' => json_encode($blocks));
		
	db()->where('id', $page['id'])->update('pages_schema', $data);
	
	return error('0');
}

function delete_all($_P=array())
{
	foreach(array('id') as $key) if(!$_P[$key]) return error('empty '.$key);

	// Удалять файлы блока
	$block_schema = db()->where('id', $_P['id'])->getOne('blocks_schema');
	
	$files_path = ROOT.'/sources/themes/'.$block_schema['theme_id'].'/files';
	
	// Файлы настроек
	$settings = json_decode($block_schema['settings'], 1);
	if($settings) foreach($settings as $item) if($item['file_path']) @unlink($files_path.'/'.$item['file_path']);
	 
	// Файлы настроек ряда
	$settings = json_decode($block_schema['row_settings'], 1);
	if($settings) foreach($settings as $item) if($item['file_path']) @unlink($files_path.'/'.$item['file_path']);
	 
	// Файлы контента
	$old_block = json_decode($block_schema['content'], 1);
	if($old_block)
	{
		foreach($old_block as $int => $item)
		{
			if($item['file_path'])
			{
				@unlink($files_path.'/'.$item['file_path']);
			}
		}
	}
	
	if($old_block['items'])
	{
		foreach($old_block['items'] as $item_int => $item_arr)
		{
			foreach($item_arr as $int => $item)
			{
				if($item['file_path'])
				{
					@unlink($files_path.'/'.$item['file_path']);
				}
			}
			
		}
	}			
	
	// Убрали со страниц
	$pages = db()->where('theme_id', $block_schema['theme_id'])->get('pages_schema');
	foreach($pages as $page)
	{
		$blocks = json_decode($page['blocks'], 1);
		
		foreach($blocks as $int => $block) 
		{
			if($block == $_P['id']) unset($blocks[$int]);
		}
		
		$data = array('blocks' => json_encode($blocks));
			
		db()->where('id', $page['id'])->update('pages_schema', $data);
	}
	
	db()->where('id', $_P['id'])->delete('blocks_schema');
	
	return error('0');
}
function cats_cache_count()
{
	$cats = get_cats();
	foreach($cats as $cat)
	{
		$category_id = $cat['id'];
		$count = db()->where('category_id', $category_id)->getValue('blocks', 'count(*)');
		if($count <= 0) $count = '0';
		
		
		db()->where('id', $category_id)->update('blocks_cats', array('count' => $count));
	}
}




function edit($_P)
{
	foreach(array('block_schema_id') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	$blocks_schema = db()->where('id', $_P['block_schema_id'])->getOne('blocks_schema');
	if(!$blocks_schema['id']) return error('wrong block_schema_id');
	
	$block = db()->where('id', $blocks_schema['block_id'])->getOne('blocks');
	
	$files_path = '/sources/themes/'.$blocks_schema['theme_id'].'/files';
	
	$old = array();
	$old['settings'] = json_decode($blocks_schema['settings'], 1);
	$old['row_settings'] = json_decode($blocks_schema['row_settings'], 1);
			
	// Изображения настроек
	foreach(array('settings', 'row_settings') as $set_type)
	{
		foreach($_P[$set_type] as $int => $item)
		{
			$type = $item['type'];
			if($type == 'image' && $_FILES[$set_type]['size'][$int]['value'] > 0)
			{
				// Удалили старый
				@unlink(ROOT.$files_path.$old[$set_type][$int]['file_path']);
				
				// Сохраняем
				$file_name = 'st_block_'.$set_type.'_'.$blocks_schema['id'].'_'.$_P[$set_type][$int]['name'].'_'.randomWord(8);
				
				$fData = array(
									  $_FILES[$set_type]['name'][$int]['value'],
									  $_FILES[$set_type]['tmp_name'][$int]['value'],
									  $files_path,
									  $file_name
									  );
				
				$file = api('files.upload', $fData);
				$_P[$set_type][$int]['file_path'] = str_replace($files_path, '', $file['file_path']);
			}
			elseif($item['delete'] == 1) 
			{
				$_P[$set_type][$int]['file_path'] = '';
				@unlink(ROOT.$files_path.$old[$set_type][$int]['file_path']);
			}
			else $_P[$set_type][$int]['file_path'] = $old[$set_type][$int]['file_path'];
		}
	}
	

	
	// Сохранили настройки
	//$_P['settings'] = array_merge($old_settings, $_P['settings']);
	$settings = json_encode($_P['settings']);
	$row_settings = json_encode($_P['row_settings']);
	
	
	// Обновили в БД
	db()->where('id', $blocks_schema['id'])->update('blocks_schema', array('settings' => $settings, 'row_settings' => $row_settings));
	
	return error(0);
}

function edit_content($_P)
{
	foreach(array('block_schema_id') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	$blocks_schema = db()->where('id', $_P['block_schema_id'])->getOne('blocks_schema');
	if(!$blocks_schema['id']) return error('wrong block_schema_id');
	
	$block = db()->where('id', $blocks_schema['block_id'])->getOne('blocks');
	
	$files_path = '/sources/themes/'.$blocks_schema['theme_id'].'/files';
			
	$old_content = json_decode($blocks_schema['content'], 1);
			
	// Основное изображение контента
	foreach($_P['content'] as $int => $item)
	{
		$type = $item['type'];
		if($type == 'image' && $_FILES['content']['size'][$int]['value'] > 0)
		{
			// Удалили старый
			@unlink(ROOT.$files_path.$old_content[$int]['file_path']);
			
			// Сохраняем
			$file_name = 'ct_block_'.$blocks_schema['id'].'_'.$_P['content'][$int]['name'].'_'.randomWord(8);
			
			$fData = array(
								  $_FILES['content']['name'][$int]['value'],
								  $_FILES['content']['tmp_name'][$int]['value'],
								  $files_path,
								  $file_name
								  );
			
			$file = api('files.upload', $fData);
			$_P['content'][$int]['file_path'] = str_replace($files_path, '', $file['file_path']);
		}
		elseif($item['delete'] == 1) 
		{
			$_P['content'][$int]['file_path'] = '';
			@unlink(ROOT.$files_path.$old_content[$int]['file_path']);
		}
		elseif($type == 'image') $_P['content'][$int]['file_path'] = $old_content[$int]['file_path'];
	}
	
	// Изображения контента
	if($_P['content']['items'])
	{
		foreach($_P['content']['items'] as $item_int => $item_arr)
		{
			if($item_arr)
			{
				foreach($item_arr as $int => $item)
				{
					$type = $item['type'];
					
					
					if($type == 'image' && $_FILES['content']['size']['items'][$item_int][$int]['value'] > 0)
					{
						// Удалили старый
						@unlink(ROOT.$files_path.$old_content['items'][$item_int][$int]['file_path']);
						
						// Сохраняем
						$file_name = 'ct_block_item_'.$blocks_schema['id'].'_'.$item_int.'_'.$int .'_'.$_P['content']['items'][$item_int][$int]['name'].'_'.randomWord(8);
						
						$fData = array(
											  $_FILES['content']['name']['items'][$item_int][$int]['value'],
											  $_FILES['content']['tmp_name']['items'][$item_int][$int]['value'],
											  $files_path,
											  $file_name
											  );
						
						$file = api('files.upload', $fData);
						$_P['content']['items'][$item_int][$int]['file_path'] = str_replace($files_path, '', $file['file_path']);
					}
					elseif($item['delete'] == 1)
					{
						$_P['content']['items'][$item_int][$int]['file_path'] = '';
						@unlink(ROOT.$files_path.$old_content['items'][$item_int][$int]['file_path']);
					}
					elseif($type == 'image') $_P['content']['items'][$item_int][$int]['file_path'] = $old_content['items'][$item_int][$int]['file_path'];
				}
			}
		}
	}
	
	// Удалили файлы старого элемента
	if($old_content['items'])
	{
		foreach($old_content['items'] as $item_int => $item_arr)
		{
			if($item_arr)
			{
				foreach($item_arr as $int => $item)
				{
					if(file_exists(ROOT.$files_path.$old_content['items'][$item_int][$int]['file_path']) && 
					!$_P['content']['items'][$item_int])
					{
						@unlink(ROOT.$files_path.$old_content['items'][$item_int][$int]['file_path']);
					}
				}
			}
		}
	}
	
	
	// Сохранили контент
	//if($old_content) $_P['content'] = @array_merge($old_content, $_P['content']);
	$content = json_encode($_P['content']);
	//api('files.write', array($block_path.'/content.json', $content));
	//cats_cache_count();
	
	// Обновили в БД
	db()->where('id', $blocks_schema['id'])->update('blocks_schema', array('content' => $content));
	
	return error(0);
}

function edit_content_manual($_P)
{
	foreach(array('block_schema_id') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	//echo 'edit_content_manual<pre>'; print_r($_P); echo '</pre>'; 
	
	$blocks_schema = db()->where('id', $_P['block_schema_id'])->getOne('blocks_schema');
	if(!$blocks_schema['id']) return error('wrong block_schema_id');
	
	$block = db()->where('id', $blocks_schema['block_id'])->getOne('blocks');
	
	$files_path = '/sources/themes/'.$blocks_schema['theme_id'].'/files';
			
	$old_content = json_decode($blocks_schema['content'], 1);
			
	// Основное изображение контента
	foreach($_P['content'] as $int => $item)
	{
		$type = $item['type'];
		if($type == 'image' && $_P['content'][$int]['file_path'])
		{
			// Удалили старый
			//@unlink(ROOT.$files_path.$old_content[$int]['file_path']);
			
			// Сохраняем
			$file_name = 'ct_block_'.$blocks_schema['id'].'_'.$_P['content'][$int]['name'].'.'.api('files.getFileExtention', $_P['content'][$int]['file_path']);
			
			$new_file_name = $files_path.'/'.$file_name;
			copy(from_utf_8($_P['content'][$int]['file_path']), ROOT.$new_file_name);
			//echo 'COPYCOPY: '.$_P['content'][$int]['file_path'].' | '.$new_file_name.'<br>';
			
			$_P['content'][$int]['file_path'] = str_replace($files_path, '', $new_file_name);
		}
		elseif($item['delete'] == 1) 
		{
			$_P['content'][$int]['file_path'] = '';
			//@unlink(ROOT.$files_path.$old_content[$int]['file_path']);
		}
		else $_P['content'][$int]['file_path'] = $old_content[$int]['file_path'];
	}
	
	// Изображения контента
	if($_P['content']['items'])
	{
		foreach($_P['content']['items'] as $item_int => $item_arr)
		{
			if($item_arr)
			{
				foreach($item_arr as $int => $item)
				{
					$type = $item['type'];
					
					
					if($type == 'image' && $_P['content']['items'][$item_int][$int]['file_path'])
					{
						// Удалили старый
						//@unlink(ROOT.$files_path.$old_content['items'][$item_int][$int]['file_path']);
						
						// Сохраняем
						$file_name = 'ct_block_item_'.$blocks_schema['id'].'_'.$item_int.'_'.$int .'_'.$_P['content']['items'][$item_int][$int]['name'].'.'.api('files.getFileExtention', $_P['content']['items'][$item_int][$int]['file_path']);
						
						$new_file_name = $files_path.'/'.$file_name;
						if(stristr($_P['content']['items'][$item_int][$int]['file_path'], 'E:'))
							$_P['content']['items'][$item_int][$int]['file_path'] = ltrim($_P['content']['items'][$item_int][$int]['file_path'], '/');
						copy(from_utf_8($_P['content']['items'][$item_int][$int]['file_path']), ROOT.$new_file_name);
						//echo 'COPYCOPY: '.$_P['content']['items'][$item_int][$int]['file_path'].' | '.ROOT.$new_file_name.'<br>';
						
						$_P['content']['items'][$item_int][$int]['file_path'] = str_replace($files_path, '', $new_file_name);
					}
					elseif($item['delete'] == 1)
					{
						$_P['content']['items'][$item_int][$int]['file_path'] = '';
						//@unlink(ROOT.$files_path.$old_content['items'][$item_int][$int]['file_path']);
					}
					else $_P['content']['items'][$item_int][$int]['file_path'] = $old_content['items'][$item_int][$int]['file_path'];
				}
			}
		}
	}
	
	// Удалили файлы старого элемента
	if($old_content['items'])
	{
		foreach($old_content['items'] as $item_int => $item_arr)
		{
			if($item_arr)
			{
				foreach($item_arr as $int => $item)
				{
					if(file_exists(ROOT.$files_path.$old_content['items'][$item_int][$int]['file_path']) && 
					!$_P['content']['items'][$item_int])
					{
						//@unlink(ROOT.$files_path.$old_content['items'][$item_int][$int]['file_path']);
					}
				}
			}
		}
	}
	
	
	// Сохранили контент
	//if($old_content) $_P['content'] = @array_merge($old_content, $_P['content']);
	$content = json_encode($_P['content']);
	//api('files.write', array($block_path.'/content.json', $content));
	//cats_cache_count();
	
	// Обновили в БД
	db()->where('id', $blocks_schema['id'])->update('blocks_schema', array('content' => $content));
	
	return error(0);
}

function set($_P=array())
{
	foreach(array('block_schema_id', 'block_id') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	$block = db()->where('id', $_P['block_schema_id'])->getOne('blocks_schema');
	$block_main = db()->where('id', $_P['block_id'])->getOne('blocks');
	
	if(!$block['id']) return error('wrong block_schema_id');
	
	$files_path = '/sources/themes/'.$block['theme_id'].'/files';
	$remote_files_path = ROOT;
	//$remote_files_path = REMOTE_FILES_PATH;
	
	// Файлы из настроек
	$settings = json_decode($block_main['settings'], 1);
	if($settings)
	{
		foreach($settings as $int => $item)
		{
			if($item['type'] == 'image' && $item['file_path'])
			{
				@unlink(ROOT.$files_path.'/'.$item['file_path']);
				$new_file_name = 'st_block_'.$block['id'].'_'.$int.'.'.api('files.getFileExtention', $item['file_path']);
				@copy(from_utf_8($remote_files_path.$item['file_path']), ROOT.$files_path.'/'.$new_file_name);
				$settings[$int]['file_path'] = '/'.$new_file_name;
			}
		}
	}
	
	// Данные контента
	$data = array(
						 'block_id' => $_P['block_id'],
						 );
	
	// Сохранение контента предыдущего блока
	if($_P['save_content'] != 1)
	{
		$old_block = json_decode($block['content'], 1);
		if($old_block)
		{
			foreach($old_block as $int => $item)
			{
				if($item['file_path'])
				{
					@unlink(ROOT.$files_path.'/'.$item['file_path']);
				}
			}
		}
		
		if($old_block['items'])
		{
			foreach($old_block['items'] as $item_int => $item_arr)
			{
				foreach($item_arr as $int => $item)
				{
					if($item['file_path'])
					{
						@unlink(ROOT.$files_path.'/'.$item['file_path']);
					}
				}
				
			}
		}			
		
		// Подставляем контент по умолчанию
		$content = json_decode($block_main['content'], 1);
		if($content)
		{
			foreach($content as $int => $item)
			{
				if($item['type'] == 'image'  && $item['file_path'])
				{
					@unlink(ROOT.$files_path.'/'.$item['file_path']);
					$new_file_name = 'ct_block_'.$block['id'].'_'.$int.'.'.api('files.getFileExtention', $item['file_path']);
					@copy(from_utf_8($remote_files_path.$item['file_path']), ROOT.$files_path.'/'.$new_file_name);
					$content[$int]['file_path'] = '/'.$new_file_name;
				}
			}
		}
		
		if($content['items'])
		{
			foreach($content['items'] as $item_int => $item_arr)
			{
				if($item_arr)
				{
					foreach($item_arr as $int => $item)
					{
						if($item['file_path'])
						{
							$file_path = $item['file_path'];
							$new_file_name = 'ct_block_'.$block['id'].'_item_'.$item_int.'_'.$int.'.'.api('files.getFileExtention', $file_path);
							@copy(from_utf_8($remote_files_path.$file_path), ROOT.$files_path.'/'.$new_file_name);
							$content['items'][$item_int][$int]['file_path'] = '/'.$new_file_name;
						}
					}
				}
			}
		}
		$data['content'] = json_encode($content);
		$data['settings'] = json_encode($settings);
		
		db()->where('id', $block['id'])->update('blocks_schema', $data);
		
	}
	else 
	{
		// Преобразовываем контент в простой массив
		$exists_content = json_decode($block['content'], 1);
		
		$old_content = array();
		
		// items отдельно
		$items = $exists_content['items'];
		unset($exists_content['items']);
		$int = 0;
		foreach($items as $item)
		{
			foreach($item as $field)
			{
				$old_content['items'][$int][$field['name']] = $field['value'];
			    if($field['type'] == 'image') $old_content['items'][$int]['file_path'] = $field['file_path'];
			}
			$int++;
		}
		
		// Основной контент
		foreach($exists_content as $field)
		{
			$old_content[$field['name']] = $field['value'];
			if($field['type'] == 'image') $old_content['file_path'] = $field['file_path'];
		}
		
		//$data['content'] = json_encode($content);
		$data['settings'] = json_encode($settings);
		
		db()->where('id', $block['id'])->update('blocks_schema', $data);
		
		// Устанавливаем
		edit_content_by_bsid(array('block_schema_id' => $block['id'], 'content' => $old_content));
	}
	
	
	return error('0');
}

function delete_source($_P=array())
{
	if(!isAdmin()) return error('access denied');
	foreach(array('id') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	// Удалили запись из БД
	db()->where('id', $_P['id'])->delete('blocks');
	
	// Удалили файлы
	$directory_path = ROOT.'/sources/blocks/'.$_P['id'];
	api('files.delete_directory', $directory_path);
	
	return error('0');
}

function visual_edit($_P=array())
{
	foreach(array('theme_id', 'block_schema_id') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	if(!$_P['option_int']) $_P['option_int'] = '0';
	
	$block_schema = db()->where('id', $_P['block_schema_id'])->getOne('blocks_schema');
	
	$content = json_decode($block_schema['content'], 1);
	
	// Если это вложенный item
	if($_P['it_is_item'])
	{
		if(!$_P['item_int']) return error('empty item_int');
		$old_value = $content['items'][$_P['item_int']][$_P['option_int']]['value'];
		if($old_value == $_P['value']) return error('old value: '.$old_value);
		$content['items'][$_P['item_int']][$_P['option_int']]['value'] = $_P['value'];
	}
	else 
	{
		$old_value = $content[$_P['option_int']]['value'];
		if($old_value == $_P['value']) return error('old value: '.$old_value);
		$content[$_P['option_int']]['value'] = $_P['value'];
	}
	
	// Пакуем контент
	$content = json_encode($content);
	
	db()->where('id', $_P['block_schema_id'])->update('blocks_schema', array('content' => $content));
	return error('0');
}

function add_and_set($_P=array())
{
	foreach(array('page_id', 'block_id') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	$res = api('blocks.add', array('page_id' => $_P['page_id']));
	$bsid = $res['id'];
	api('blocks.set', array('block_schema_id' => $bsid, 'block_id' => $_P['block_id']));
	$bs = db()->where('id', $bsid)->getOne('blocks_schema');
	
	// Блоки с предустановленными настройками
	if($_P['block_id'] == 90) $_P['row_settings'] = array('container' => 'nocontainer', 'padding_bottom' => 'unset');
	
	// Карты
	if(in_array($_P['block_id'], array(91, 89))) 
	{
		$_P['row_settings'] = array('container' => 'nocontainer', 'padding_bottom' => 'unset', 'padding_top' => 'unset');
	}
	
	// Инфо блок 
	if(in_array($_P['block_id'], array(93))) 
	{
		if(coin(50)) $_P['row_settings'] = array('container' => 'nocontainer', 'padding_bottom' => 'unset', 'padding_top' => 'unset');
	}
	
	// Плитка витрина
	if(in_array($_P['block_id'], array(95))) 
	{
		//if(coin(50)) $_P['row_settings'] = array('container' => 'nocontainer', 'padding_bottom' => 'unset');
	}
	
	// Простая обложка
	if(in_array($_P['block_id'], array(49))) 
	{
		if(coin(50)) $_P['settings']['center'] = 'center';
	}
	
	// Галлереи
	if(in_array($_P['block_id'], array(78, 77))) 
	{
		$_P['row_settings'] = array('container' => 'nocontainer', 'padding_bottom' => 'unset');
	}
	
	foreach(array('settings', 'row_settings') as $type)
	{
		if($_P[$type])
		{
			// Настраиваем
			$bs_settings = json_decode($bs[$type], 1);
			foreach($bs_settings as $bs_int => $bs_setting)
			{
				foreach($_P[$type] as $name => $value) if($name == $bs_setting['name']) $bs_settings[$bs_int]['value'] = $value;
			}
			db()->where('id', $bsid)->update('blocks_schema', array($type => json_encode($bs_settings)));
			
		}
	}
	return array('block_schema_id' => $bsid);
}

function block_files_path($val, $folder)
{
	if(stristr($val, 'sources/blocks')) $val = str_replace('/sources/blocks', ROOT.'/sources/blocks', $val);
	else $val = str_replace('files/', $folder.'/files/', $val);
	return $val;
}

function edit_content_by_bsid($_P=array())
{
	foreach(array('block_schema_id', 'content') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	$block_schema = db()->where('id', $_P['block_schema_id'])->getOne('blocks_schema');
	//$content = json_decode($block_schema['content'], 1);
	$content = array();
	
	$folder = api('parse.get_folder', $block_schema['theme_id']);
	
	// Берем структуру контента
	$block = db()->where('id', $block_schema['block_id'])->getOne('blocks');
	$content_structure = json_decode($block['content_structure'], 1);
	$content_default = json_decode($block['content'], 1);
	
	
	// Значения по умолчанию
	if($content_default['items']) 
	{
		foreach($content_default['items'] as $item)
		{
			$content_default_item = $item;
			break 1;
		}
	}
	unset($content_default['items']);
	
	//echo 'content_default_item before<pre>'; print_r($content_default_item); echo '</pre>'; 
	//echo '/*********************edit_content_by_bsid***********************/';
	
	
	// Основной контент
	if($content_structure['main'])
	{
		$content = $content_default;
		unset($content['items']);
		foreach($content_structure['main'] as $int => $item)
		{
			foreach($_P['content'] as $name => $val)
			{
				if($item['name'] == $name) $content[$int]['value'] = str_replace('[empty]', '', $val);
				if($item['type'] == 'image'  && ($name == 'file_path' || $name == 'image')) 
				{
					//$content[$int]['file_path'] = $val;
					$val = block_files_path($val, $folder);
					$content[$int]['file_path'] = $val;
					//echo $name.'<br>';
				}
			}
		}
	}
	
	// Элементы
	if($content_structure['element'] && $_P['content']['items'])
	{
		$items_cnt = 0;
		$items_total = count($_P['content']['items']);
		foreach($_P['content']['items'] as $item_int => $content_item)
		{
			$items_cnt++;
			if($item_int == 0) $item_int = mt_rand(111111, 999999);
			
			if($items_cnt <= $items_total) $content['items'][$item_int] = $content_default_item;
			
			foreach($content_structure['element'] as $int => $item)
			{
				foreach($content_item as $name => $val)
				{
					
					if($item['name'] == $name) $content['items'][$item_int][$int]['value'] = str_replace('[empty]', '', $val);
					if($item['type'] == 'image' && $name == 'image') 
					{
						//echo 'image '.$val.' <pre>'; print_r($item); echo '</pre>'; 
						$val = block_files_path($val, $folder);
						$content['items'][$item_int][$int]['file_path'] = $val;
					}
				}
			}
		}
	}
	
	//echo 'edit_content_manual<pre>'; print_r($content); echo '</pre>'; 
	$res = edit_content_manual(array('block_schema_id' => $_P['block_schema_id'], 'content' => $content));
	
	return $res;
}

function edit_settings_by_bsid($_P=array())
{
	foreach(array('block_schema_id') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	$block_schema = db()->where('id', $_P['block_schema_id'])->getOne('blocks_schema');
	
	$content = array();
	
	$folder = api('parse.get_folder', $block_schema['theme_id']);
	
	$bs = db()->where('id', $_P['block_schema_id'])->getOne('blocks_schema');
	
	$files_path = '/sources/themes/'.$block_schema['theme_id'].'/files';
	
	foreach(array('settings', 'row_settings') as $type)
	{
		if($_P[$type])
		{
			// Настраиваем
			$bs_settings = json_decode($bs[$type], 1);
			foreach($bs_settings as $bs_int => $bs_setting)
			{
				foreach($_P[$type] as $name => $value) 
				{
					if($name == $bs_setting['name']) 
					{
						if($bs_setting['type'] == 'image')
						{
							$value = block_files_path($value, $folder);
							
							$file_name = 'st_block_'.$block_schema['id'].'_'.$bs_int.'_'.$name.'.'.api('files.getFileExtention', $value);
							
							$new_file_name = $files_path.'/'.$file_name;
							copy(from_utf_8($value), ROOT.$new_file_name);
							
							$bs_settings[$bs_int]['file_path'] = str_replace($files_path, '', $new_file_name);
							
							//echo $value.' imageimage<br>';
						}
						else $bs_settings[$bs_int]['value'] = $value;
						
						//echo $name.'<pre>'; print_r($bs_settings); echo '</pre>'; 
					}
				}
			}
			db()->where('id', $_P['block_schema_id'])->update('blocks_schema', array($type => json_encode($bs_settings)));
			//echo db()->getLastQuery()." | ".db()->getLastError();
		}
	}
	
	return $res;
}
