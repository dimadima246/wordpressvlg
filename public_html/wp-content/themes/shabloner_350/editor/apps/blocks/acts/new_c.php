<?php

$title = 'Новый блок';

$_BREAD[] = array('', $title );

if($_POST)
{
	$res = api('blocks.add_source', $_POST);
	$data = $_POST;
	if($res['id']) redirect('/blocks?act=show');
}
	
?>