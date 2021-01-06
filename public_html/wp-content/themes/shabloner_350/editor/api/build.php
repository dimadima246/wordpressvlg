<?php

namespace build;



function macroses($_P)
{
	foreach(array('str') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	if(!$_P['type']) $_P['type'] = 'test';
	
	global $macroses;
	if(!$macroses) $macroses = db()->orderBy('weight', 'desc')->get('macroses');
	
	foreach($macroses as $macros)
	{
		$_P['str'] = str_replace('['.$macros['name'].']', $macros[$_P['type']], $_P['str']);
	}
	
	foreach($_P as $key => $val) $_P['str'] = str_replace('['.$key.']', $val, $_P['str']);
	
	// Разделитель строки
	preg_match_all('/\{link\:(.*?)\}/is', $_P['str'], $matches, PREG_SET_ORDER);
	if($matches)
	{
		foreach($matches as $match)
		{
			$replacement = '/'.api('sys.slug', $match[1]);
			$_P['str'] = str_replace($match[0], $replacement, $_P['str']);
		}
	}
	
	return $_P['str'];
}

function no_div_block($area)
{
	if(in_array($block, array('header','slider','footer'))) return true;
	else return false;
}

function page($_P=array())
{
	foreach(array('page', 'data', 'theme_folder') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	$page = $_P['page'];
	$theme_folder = $_P['theme_folder'];
	$folder = $_P['folder'];
	$data = $_P['data'];
	$settings = $_P['settings'];
	
	$theme_id = $page['theme_id'];
	
	if(!$default_row) $default_row = db()->where('id', ROW_BLOCK)->getOne('blocks');
	if($page['role']) $page_name = $page['role'];
	else $page_name = $page['id'];
	
	if(!$_P['block_schema_id']) $blocks = json_decode($page['blocks'], 1);
	else $blocks = array($_GET['block_schema_id']);
	
	$page = array();
	
	// Раскидали ряды по областям
	$areas = array();
	if($blocks)
	{
		foreach($blocks as $block_schema_id)
		{
			
			// Первый блок ряда
			$block_schema = db()->where('id', $block_schema_id)->getOne('blocks_schema');
			$block = db()->where('id', $block_schema['block_id'])->getOne('blocks');
			
			if($block['category_id'] == 1) $areas['header'][] = $block_schema;
			else if($block['category_id'] == 2) $areas['slider'][] = $block_schema;
			else if($block['category_id'] == 19) $areas['footer'][] = $block_schema;
			else $areas['content'][] = $block_schema;
		}
	}
	
	//echo '<pre>'; print_r($areas); echo '</pre>'; 
	
	// Пошли по блокам
	foreach($areas as $area => $blocks)
	{
		$page[$area] .= "<!-- $area -->\n";
		if($area == 'content' && !$_P['block_schema_id']) $page[$area] .= '<section id="content" class="clearfix">'."\n";
		
		foreach($blocks as $block_schema)
		{
			// Начинаем формирование блоков
			$block_num = $block_schema['id'];
			$block_id = $block_schema['block_id'];
			
			if(!$_BLOCKS[$block_id]) $_BLOCKS[$block_id] = db()->where('id', $block_id)->getOne('blocks');
			$block = $_BLOCKS[$block_id]; 
			$block_name = api('blocks.get_cat_slug', $block['category_id']).'_'.$block_id.'_'.$block_num;
			
			$page[$area] .= "\n<!-- ".$block['name']." #".$block_id." (".$block_num.") -->\n";
			if($data['type'] == 'test') $page[$area] .= '<div data-id="'.$block_schema['id'].'" id="block_'.$block_schema['id'].'" class="block_schema block_'.$block_schema['id'].' area_'.$area.'">'."\n";
			
			// Настройки ряда
			$row_settings = json_decode($block_schema['row_settings'], 1);
			
			// Код ряда
			$row_html = $default_row['code'];
			
			// Настройки и файлы ряда
			if($row_settings)
			{
				foreach($row_settings as $int => $option) 
				{
					if($option['type'] == 'image' && $option['file_path'])
					{
						// Префикс имен файлов для подстановки в макросы
						//$file_prefix = 'row_'.$row['id'].'_';
						$file_prefix = '';
						$file_name = $file_prefix.api('files.getFileName', $option['file_path']);
						if($option['file_path'] && file_exists($theme_folder.'/files/'.$option['file_path'])) @copy($theme_folder.'/files'.$option['file_path'], $folder.'/files/'.$file_name);
						$value = '[template_directory]files/'.$file_prefix.trim($option['file_path'], '/');
					}
					else $value = $option['value'];
					
					preg_match('/\[if_exists\:'.$option['name'].'\](.*?)\[\/if_exists\:'.$option['name'].'\]/is', $row_html, $match_exists);
					if($match_exists[0])
					{
						if($value) $row_html = str_replace($match_exists[0], $match_exists[1], $row_html); 
						else $row_html = str_replace($match_exists[0], '', $row_html); 
					}
					
					$row_html = str_replace('['.$option['name'].']', $value, $row_html);
				}
				
				
			}
			
			$row_content = '';
			//if($area == 'content') $row_content .= "<div class='clearfix'>\n";
			
			
			/* Для замены на остальных страницах */
			// Вывод записей
			if(in_array($page_name, array('archive', 'search')) && 
			!$data['pages'][$page_name] &&
			$block['category_id'] == 25) 
			{
				$block_id = 27;
				if(!$_BLOCKS[$block_id]) $_BLOCKS[$block_id] = db()->where('id', $block_id)->getOne('blocks');
				$block = $_BLOCKS[$block_id]; 
				$block_name = api('blocks.get_cat_slug', $block['category_id']).'_archive_'.$block_num;
			}
			
			// Страница 404
			if(in_array($page_name, array('404')) && 
			!$data['pages'][$page_name] &&
			$block['category_id'] == 25) 
			{
				$block_id = 30;
				if(!$_BLOCKS[$block_id]) $_BLOCKS[$block_id] = db()->where('id', $block_id)->getOne('blocks');
				$block = $_BLOCKS[$block_id]; 
				$block_name = api('blocks.get_cat_slug', $block['category_id']).'_404_'.$block_num;
			}
			
			$block_folder = ROOT.'/sources/blocks/'.$block_id;
			$block_folder_theme = $folder_src.'/blocks/'.$block_num;
			$block_settings = json_decode($block_schema['settings'], 1);
			$block_html = $block['code'];
			
			// Файлы и настройки блока
			if($block_settings)
			{
				foreach($block_settings as $int => $option) 
				{
					if($option['type'] == 'image')
					{
						$value = '[template_directory]files/'.$file_block_prefix.trim($option['file_path'], '/');
						
						// Префикс имен файлов для подстановки в макросы
						$file_block_prefix = '';
						$file_name = $file_block_prefix.api('files.getFileName', $option['file_path']);
						if($option['file_path'] && file_exists($theme_folder.'/files'.$option['file_path'])) copy($theme_folder.'/files'.$option['file_path'], $folder.'/files/'.$file_name);
						
					}
					else $value = $option['value'];
					
					// Наличие элемента с условием
					preg_match_all('/\{if\:'.$option['name'].'\}(.*?)\{\/if\:'.$option['name'].'\}/is', $block_html, $matches, PREG_SET_ORDER);
					foreach($matches as $match_exists)
					{
						if($match_exists[0])
						{
							$parts = explode('{else}', $match_exists[1]);
							
							if($option['value'] || $option['file_path']) $if_part = $parts[0]; 
							else $if_part = $parts[1]; 
							
							$block_html = str_replace($match_exists[0], $if_part, $block_html);
						}
					}
					
					preg_match('/\[if_exists\:'.$option['name'].'\](.*?)\[\/if_exists\:'.$option['name'].'\]/is', $block_html, $match_exists);
					if($match_exists[0])
					{
						if($value) $block_html = str_replace($match_exists[0], $match_exists[1], $block_html); 
						else $block_html = str_replace($match_exists[0], '', $block_html); 
					}
					
					preg_match('/\[percent\:'.$option['name'].'\:(.*?)\]/is', $block_html, $match_exists);
					if($match_exists[0])
					{
						if($value) $block_html = str_replace($match_exists[0], ceil($option['value'] * ($match_exists[1]/100)), $block_html); 
						else $block_html = str_replace($match_exists[0], '', $block_html); 
					}
					
					$block_html = str_replace('['.$option['name'].']', $value, $block_html);
				}
				
			}
			
			// Обработка контента блока
			$block_content = json_decode($block_schema['content'], 1);
			
			// Обрабатываем items контента
			preg_match_all('/\{items\}(.*?)\{\/items\}/is', $block_html, $matches, PREG_SET_ORDER);
			foreach($matches as $match)
			{
				$item_template = $match[1];
				$items_html = '';
				
				if($block_content['items'])
				{
					unset($block_content['items']['file_path']);
					//$items_cnt = count($block_content['items']);
					$items_cnt = 0;
					foreach($block_content['items'] as $int => $item)
					{
						$items_cnt++;
						$item_html = $item_template;
						if(is_numeric($int))
						{
							foreach($item as $option_int => $option)
							{
								$value = '';
								if($option['type'] == 'image')
								{
									if($option['file_path']) $value = '[template_directory]files/'.$file_block_prefix.trim($option['file_path'], '/');
									
									// Префикс имен файлов для подстановки в макросы
									$file_block_prefix = '';
									$file_name = $file_block_prefix.api('files.getFileName', $option['file_path']);
									if($option['file_path'] && file_exists($theme_folder.'/files'.$option['file_path'])) @copy($theme_folder.'/files'.$option['file_path'], $folder.'/files/'.$file_name);
									
								}
								else $value = $option['value'];
								
								preg_match('/\{if_exists\:'.$option['name'].'\}(.*?)\{\/if_exists\:'.$option['name'].'\}/is', $item_html, $match_exists);
								if($match_exists[0])
								{
									if($value || $option['file_path']) $item_html = str_replace($match_exists[0], $match_exists[1], $item_html); 
									else $item_html = str_replace($match_exists[0], '', $item_html); 
								}
								
								// Вставляем класс визуального редактирования
								preg_match('/\{editable\:'.$option['name'].'\}/is', $item_html, $match_editable);
								if($match_editable[0])
								{
									//$replace = 'editable block_item_field_'.$option['name'].'_'.$int;
									$replace = 'editable block_'.$block_schema['id'].' item item-field_'.$option['name'].' item-option_'.$option_int.' item-int_'.$int;
									$item_html = str_replace($match_editable[0], $replace, $item_html);
								}
								
								$item_html = str_replace('{'.$option['name'].'}', $value, $item_html);
								
							}
						}
						
						
						// Вставляем класс при кратности
						preg_match_all('/\{alternate:(.*?)\:(.*?)\}/is', $item_html, $matches_cl, PREG_SET_ORDER);
						
						foreach($matches_cl as $match_cl)
						{
							if($match_cl[0])
							{
								if(is_int($items_cnt / $match_cl[2])) $item_html = str_replace($match_cl[0], $match_cl[1], $item_html);
								else $item_html = str_replace($match_cl[0], '', $item_html);
							}
						}
						
						// Разделитель строки
						preg_match('/\{clear\:(.*?)\}/is', $item_html, $match_cl);
						if($match_cl[0])
						{
							if($items_cnt % $match_cl[1] == 0 && $items_cnt != count($block_content['items'])) $item_html = str_replace($match_cl[0], '<div class="clear bottommargin"></div>', $item_html);
							else $item_html = str_replace($match_cl[0], '', $item_html);
						}
						
						// Подставили в основной контент
						$item_html = str_replace('[item_int]', $int, $item_html);
						if(is_numeric($int)) $items_html .= $item_html;
					}
				}
				$block_html = str_replace($match[0], $items_html, $block_html);
			}
			
			// Файлы и контент блока
			unset($block_content['items']);
			if($block_content)
			{
				foreach($block_content as $int => $option) 
				{
					if($option['type'] == 'image')
					{
						$value = $option['file_path'];
						if($option['file_path'])  $value = '[template_directory]files/'.$file_block_prefix.trim($value, '/');
						
						// Префикс имен файлов для подстановки в макросы
						$file_block_prefix = '';
						$file_name = $file_block_prefix.api('files.getFileName', $option['file_path']);
						if($option['file_path'] && file_exists($theme_folder.'/files'.$option['file_path'])) @copy($theme_folder.'/files'.$option['file_path'], $folder.'/files/'.$file_name);
						
					}
					else $value = $option['value'];
					
					// Наличие элемента
					preg_match('/\{if_exists\:'.$option['name'].'\}(.*?)\{\/if_exists\:'.$option['name'].'\}/is', $block_html, $match_exists);
					if($match_exists[0])
					{
						if($value || $option['file_path']) $block_html = str_replace($match_exists[0], $match_exists[1], $block_html); 
						else $block_html = str_replace($match_exists[0], '', $block_html); 
					}
					
					// Наличие элемента с условием
					preg_match_all('/\{if\:'.$option['name'].'\}(.*?)\{\/if\:'.$option['name'].'\}/is', $block_html, $matches, PREG_SET_ORDER);
					foreach($matches as $match_exists)
					{
						if($match_exists[0])
						{
							$parts = explode('{else}', $match_exists[1]);
							
							if($option['value'] || $option['file_path']) $if_part = $parts[0]; 
							else $if_part = $parts[1]; 
							
							$block_html = str_replace($match_exists[0], $if_part, $block_html);
						}
					}
					
					// Вставляем класс визуального редактирования
					preg_match('/\{editable\:'.$option['name'].'\}/is', $block_html, $match_editable);
					if($match_editable[0])
					{
						$replace = 'editable block_'.$block_schema['id'].' item-option_'.$int.' field_'.$option['name'];
						$block_html = str_replace($match_editable[0], $replace, $block_html);
					}
					
					$block_html = str_replace('{'.$option['name'].'}', $value, $block_html);
				}
			}
			
			$block_html = str_replace('[block_prefix]', trim($file_block_prefix,'_'), $block_html);
			
			//echo '<pre>'; print_r($block_content); echo '</pre>'; 
			
			// Упаковывем блоки в blocks
			//$builded_html = api('build.macroses', array('str' => $block_html, 'type' => $data['type'], 'theme_id' => $theme['id']));
			//api('files.write', array($folder.'/blocks/'.$block_name.'.php', $builded_html));
			
			$row_content .= $block_html;
			/*$row_content .= '<?php include(get_template_directory()."/blocks/'.$block_name.'.php") ?>';*/
			
			//if($area == 'content') $row_content .= "</div>\n";
			
			
			if($area == 'content')
			{
				$row_content = str_replace('[content]', $row_content, $row_html);
			}
			//else $page[$area] .= $row_content;
			
			$row_content = str_replace(array('[default_button_class]', '[button_class]'), $settings['default_button_class'], $row_content);
			$row_content = str_replace('[block_id]', 'block_'.$block_schema['id'], $row_content);
			
			
			// Сборка блока
			$builded_html = api('build.macroses', array('str' => $row_content, 'type' => $data['type'], 'theme_id' => $theme_id));

			if($data['type'] == 'test')
			{
				$builded_html = str_replace('.jpg', '.jpg?_'.time(), $builded_html);
				$builded_html = str_replace('.png', '.png?_'.time(), $builded_html);
				$builded_html = str_replace('.gif', '.gif?_'.time(), $builded_html);
				$builded_html = str_replace('.jpeg', '.jpeg?_'.time(), $builded_html);
			}
			
			if(!is_array($builded_html)) api('files.write', array($folder.'/blocks/'.$block_name.'.php', $builded_html));
			else echo $block_name.' '.implode(' ', $builded_html).'<br>';
			
			if($block_schema['id'])
			{
				if($data['type'] == 'test') $page[$area] .= "<?php ".'$block_schema_id = '.$block_schema['id'].'; $block_id = '.$block_schema['block_id'].'; $block_cat_id = '.$block['category_id'].';'."  include('".ROOT."/sources/preview_edit.php'); ?>";

				$row_new_content = '<?php include(get_template_directory()."/blocks/'.$block_name.'.php") ?>';
				$page[$area] .= $row_new_content;
				
				if($data['type'] == 'test') $page[$area] .= "<?php include('".ROOT."/sources/preview_edit_bottom.php'); ?>";
			}
			else $page[$area] .= "\n<!-- / block error -->\n";
			
			if($data['type'] == 'test') $page[$area] .= "\n\n</div>\n";
			$page[$area] .= "\n<!-- / block_".$block_schema['id']." -->\n";
			
		}
		
		if($area == 'content' && !$_P['block_schema_id']) $page[$area] .= "\n".'</section>'."\n\n";
		
	}
	
	// Дополнительные CSS и JS блоков
	$blocks_js = '// Индивидуальные функции блоков';
	$blocks_css = "/* CSS темы */\n".$_P['theme']['css']."\n\n";
	$blocks_css .= '/* Индивидуальные стили блоков */';
	
	$blocks = db()->where('(id in (select block_id from shabloner_blocks_schema where theme_id=?))', array($theme_id))->get('blocks', array(0, 9999));
	
	foreach($blocks as $block)
	{
		if($block['css']) $blocks_css .= "\n\n".$block['css'];
		if($block['js']) $blocks_js .= "\n\n".$block['js'];
	}
	
	// Фон сайта
	if(!$settings['stretched'])
	{
		$blocks_css .= "/* Фон сайта */\n";
		$blocks_css .= "body {
		
 padding-top: ".$settings['padding_top']."px ; 
padding-bottom: ".$settings['padding_bottom']."px !important; 
background-color: ".$settings['bg_color']." !important;\n";
		if($_P['theme']['bg_image'])
		{
			// Копируем
			$new_name = 'bg.'.api('files.getFileExtention', $_P['theme']['bg_image']);
			$new_file_name = $folder.'/files/'.$new_name;
			
			@copy(ROOT.'/'.$_P['theme']['bg_image'], $new_file_name);
			
			$blocks_css .= "background: url('../files/".$new_name."') left top no-repeat !important;
			background-position: 50% 50% !important;
			background-size: cover !important;
			background-attachment: fixed !important;";
		}
		$blocks_css .= "}\n";
	}
	
	api('files.write', array($folder.'/css/blocks.css', $blocks_css));
	api('files.write', array($folder.'/js/blocks.js', $blocks_js));
	
	/*if($page_name == 'index')
	{
		// Создали шапку и подвал 
		api('files.write', array($folder.'/index_header.php', api('build.macroses', array('str' => $page['header'], 'type' => $data['type'], 'theme_id' => $theme['id']))));
		api('files.write', array($folder.'/index_footer.php', api('build.macroses', array('str' => $page['footer'], 'type' => $data['type'], 'theme_id' => $theme['id']))));
		$content = '[header]'."\n".'[index_header]'."\n".$page['title']."\n".$page['content']."\n".'[index_footer]'."\n".'[footer]';
	}
	else */
	if(!$_P['block_schema_id']) $content = '[header]'."\n".implode('', $page)."\n".'[footer]'; 
	else $content = implode('', $page); 
	
	return $content;
}

function columns($column)
{
	$types = array(
						 '4_4' => array('', 'fullwidth'),
						 '1_2' => array('col_half', '1_2'),
						 '1_4' => array('col_one_fourth', '1_4'),
						 '1_3' => array('col_one_third', '1_3'),
						 '2_3' => array('col_two_third', '2_3'),
						 '3_4' => array('col_three_fourth', '3_4'),
						 );
	foreach($types as $type => $arr) if($type == $column) return $arr[0];	
	return '';	
}


function wp_page($page_id)
{
	$page = db()->where('id', $page_id)->getOne('pages_schema');
	if(!$page['id']) return error('wrong page');
	
	$folder = ROOT.'/../';

	$theme = db()->where('id', THEME_ID)->getOne('themes');
	$settings = json_decode($theme['settings'], 1);

	// Копируем файлы
	api('files.recurse_copy', array(ROOT.'/sources/themes/'.$theme['id'].'/files', $folder.'/files'));

	// Настройки
	$data = array(
						'folder' => $folder,
						'type' => 'wordpress',
						'theme_id' => THEME_ID,
						);

	// Подставили данные страницы
	$pData = array(
						  'page' => $page,
						  'theme_folder' => $folder,
						  'theme' => $theme,
						  'folder' => $folder,
						  'data' => $data,
						  'settings' => $settings,
						  );
	$content = api('build.page', $pData);

	if($page['role'] == 'other' && $page['slug']) $page_name = 'page-'.$page['slug'];
	else if($page['role'] == 'other') $page_name = 'page-'.api('sys.slug', $page['name']);
	else if($page['role']) $page_name = $page['role'];
	else $page_name = $page['id'];

	api('files.write', array($folder.'/'.$page_name.'.php', api('build.macroses', array('str' => $content, 'type' => $data['type'], 'theme_id' => $theme['id']))));
	return error('0');
}



