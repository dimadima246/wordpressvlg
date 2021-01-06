<?php

$blocks_path = ROOT.'/blocks';

$cats = glob($blocks_path.'/*');

echo '<pre>'; print_r($cats); echo '</pre>'; 

foreach($cats as $cat)
{
	$slug = str_replace($blocks_path.'/', '' ,$cat);
	echo $slug.'<br>';
	$category_id = db()->where('slug', $slug)->getValue('blocks_cats', 'id');
	if(!$category_id) $category_id = db()->insert('blocks_cats', array('slug' => $slug));
	
	
	$blocks = glob($cat.'/*');
	
	foreach($blocks as $block)
	{
		$res = parse_ini_file($block.'/settings.ini', TRUE);
		
		$block = str_replace(ROOT, '', $block);
		$path = $block.'/index.html';
		$data = array(
							   'path' => $path,
							   'image' =>  $block.'/image.jpg',
							   'category_id' => $category_id
							  );
		
		if($res['main']['name']) $data['name'] = $res['main']['name'];
		if($res['main']['description']) $data['description'] = $res['main']['description'];
		
		if(!db()->where('path', $path)->getValue('blocks', 'id')) db()->insert('blocks', $data);
		
		echo '<pre>'; print_r($data); echo '</pre>'; 
	}
	
	db()->where('id', $category_id)->update('blocks_cats', array('count' => count($blocks)));
	
}

echo 'done.';