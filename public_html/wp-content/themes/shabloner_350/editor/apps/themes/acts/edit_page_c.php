<?php

if(!$_GET['id'] || !$_GET['page_id']) redirect('/themes?act=show');
$theme_path = ROOT.'/sources/themes/'.$_GET['id'];
$file_path = $theme_path.'/files';

if(!file_exists($file_path)) redirect('/themes?act=show');

$data = db()->where('id', $_GET['id'])->getOne('themes');
$page = db()->where('id', $_GET['page_id'])->getOne('pages_schema');
if(!$data['id']) redirect('/themes?act=show');

$title = $page['name'];

$_BREAD[] = array('/themes?act=edit&id='.$_GET['id'], $data['name']);
$_BREAD[] = array('', 'Редактирование страницы');


if($_POST)
{
	$data = $_POST;
	
	$data['id'] = $_GET['page_id'];
	
	
	$_RETURN = api('themes.page_save', $data);
	
	//$data = db()->where('id', $_GET['id'])->getOne('themes');
}
	

$category = db()->where('id', $data['category_id'])->getOne('themes_cats');

$_PAGE = db()->where('id', $_GET['page_id'])->getOne('pages_schema');
	
?>