<?php

// Берется структура контента и по ней отображается контент
$structure = 'element';

if($_GET['structure']) $data['content_structure'][$structure] = json_decode(base64_decode($_GET['structure']), 1);
if(!$data['content_structure'][$structure]) $data['content_structure'][$structure] = api('blocks.default_blocks_data', 'content_structure_element');

$default_content = $data['content_structure'][$structure];

$default_block_path = '/sources/blocks/'.$_GET['id'];

//echo '<pre>'; print_r($item_arr); echo '</pre>'; 

if($item_int == 0) $item_int = mt_rand(11111,99999);
?>
<div class="content_item " data-int="<?=$item_int?>">

<div class="pull-right btn-toolbar">

<button type="button" title="Переместить вперед" onclick="" class="btn btn-light btn-xs before_btn"><i class="fa fa-arrow-left"></i></button>
<button type="button" title="Переместить назад" onclick="" class="btn btn-light btn-xs after_btn"><i class="fa fa-arrow-right"></i></button>
&nbsp;

<button type="button" title="Удалить" onclick="item_delete($(this))" class="btn btn-danger btn-xs "><i class="fa fa-times"></i></button>
</div>



<?php


foreach($default_content as $int => $item) {
	
if($int == 0) $int = '0';
$type = $item['type'];	
if($type == 'image') $field_type = 'file';
else if($type == 'select') $field_type = 'select';
else if($type == 'textarea') $field_type = 'textarea';
else $field_type = 'text';

$value = $item_arr[$int]['value'];

if($item_arr[$int]['file_path']) 
{
	//$image = $block_files_path.str_replace($default_block_path.'/files', '', $item_arr[$int]['file_path']).'?'.time();
	
if($item_arr[$int]['file_path']  && $urlParts[0] == 'ajax') {
	$item_arr[$int]['file_path'] = $block_files_path.str_replace($default_block_path.'/files', '', $item_arr[$int]['file_path']);
}
	
	$image = HTTP_PATH.'/sources/themes/'.$_GET['theme_id'].'/files'.$item_arr[$int]['file_path'].'?'.time();
}
else $image = '';


?>

<div class="form-group">
<input name="content[items][<?=$item_int?>][<?=$int?>][type]" type="hidden" value="<?=$default_content[$int]['type']?>" />
<input name="content[items][<?=$item_int?>][<?=$int?>][name]" type="hidden" value="<?=$default_content[$int]['name']?>" />

	<label for="value"><?php if($default_content[$int]['title']) echo $default_content[$int]['title']; else echo $default_content[$int]['name'];?></label>
	
	<?php if($image) echo '<div class="img_block bottommargin-minier"><img src="'.$image.'" /></div>';?>
	
	<?php if($field_type == 'select') { ?>
	<select name="content[items][<?=$item_int?>][<?=$int?>][value]" value="<?=$value?>" class="form-control" id="value" >
	<?php $options = explode(',', $default_content[$int]['value']); foreach($options as $option) { list($val,$title) = explode('|', $option); ?>
	<option <?php if($value == $val) echo 'selected="selected"'; ?> value="<?=trim($val)?>"><?=trim($title)?></option>
	<?php } ?>
	
	</select>
	<?php } else if($field_type == 'textarea') { ?>
	<textarea rows=5 name="content[items][<?=$item_int?>][<?=$int?>][value]" class="form-control" id="value" ><?=$value?></textarea>
	<?php } else if($field_type == 'file') { ?>
	<div class="">
		<div class="bottommargin-minier">
			<input name="content[items][<?=$item_int?>][<?=$int?>][value]" type="<?=$field_type?>" value="<?=$value?>" class="form-control" id="value" >
		</div>
		<div class="">
			<div class="form-check ">
				<input name="content[items][<?=$item_int?>][<?=$int?>][delete]" id="delete_<?=$item_int?>_<?=$int?>" type="checkbox" class="form-check-input" value="1">
				<label class="form-check-label" for="delete_<?=$item_int?>_<?=$int?>">Удалить</label>
			</div>
		</div>
	</div>
	<?php } else { ?>
	
	<input name="content[items][<?=$item_int?>][<?=$int?>][value]" type="text" value="<?=htmlspecialchars($value)?>" class="form-control" id="value" >
	
	<?php }  ?>

	</div>
<?php } ?>
		  
		  
</div>
