<?php

if(!$_GET['id']) redirect('/blocks?act=show');

$data = db()->where('id', $_GET['id'])->getOne('blocks');
if(!$data['id']) redirect('/blocks?act=show');

$title = 'Редактирование блока № '.$_GET['id'];

$_BREAD[] = array('', 'Редактирование блока');


if($_POST)
{
	$_RETURN = api('blocks.edit_source', $_POST);
	$data = db()->where('id', $_GET['id'])->getOne('blocks');
}
	
/*$data['code'] = file_get_contents(ROOT.'/sources/blocks/'.$_GET['id'].'/code.html');

$data['settings'] = json_decode(@file_get_contents(ROOT.'/sources/blocks/'.$_GET['id'].'/settings.json'), 1);
$data['content'] = json_decode(@file_get_contents(ROOT.'/sources/blocks/'.$_GET['id'].'/content.json'), 1);
$data['content_structure'] = json_decode(@file_get_contents(ROOT.'/sources/blocks/'.$_GET['id'].'/content_structure.json'), 1);*/

$data['settings'] = json_decode($data['settings'], 1);
$data['content'] = json_decode($data['content'], 1);
$data['content_structure'] = json_decode($data['content_structure'], 1);


//if(!$data['settings']['increment']) $data['settings']['increment'] = 1;
	
?>