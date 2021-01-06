<?php

//echo '<pre>'; print_r($data['content_structure']['element']); echo '</pre>'; 


// Берется структура контента и по ней отображается контент
$structure = 'main';
//if(!$data['content_structure'][$structure]) $data['content_structure'][$structure] = api('blocks.default_blocks_data', 'content_structure_element');

$default_content = $data['content_structure'][$structure];
$default_block_path = '/sources/blocks/'.$_GET['id'];

if($default_content) {
foreach($default_content as $int => $item) {
if($int == 0) $int = '0';
$type = $item['type'];	
if($type == 'image') $field_type = 'file';
else if($type == 'select') $field_type = 'select';
else if($type == 'textarea') $field_type = 'textarea';
else $field_type = 'text';

$value = $data['content'][$int]['value'];
//$image = $block_files_path.str_replace($default_block_path.'/files', '', $data['content'][$int]['file_path']).'?'.time();

if($data['content'][$int]['file_path'] && $urlParts[0] == 'ajax') $data['content'][$int]['file_path'] = $block_files_path.str_replace($default_block_path.'/files', '', $data['content'][$int]['file_path']);

$image = HTTP_PATH.'/sources/themes/'.$_GET['theme_id'].'/files'.$data['content'][$int]['file_path'].'?'.time();
?>

<div class="form-group">
<input name="content[<?=$int?>][type]" type="hidden" value="<?=$default_content[$int]['type']?>" />
<input name="content[<?=$int?>][name]" type="hidden" value="<?=$default_content[$int]['name']?>" />

	<label for="value"><?php if($default_content[$int]['title']) echo $default_content[$int]['title']; else echo $default_content[$int]['name'];?></label>
	
	<?php if($data['content'][$int]['file_path']) echo '<div class="img_block bottommargin-minier"><img src="'.$image.'" /></div>';?>
	
	<?php if($field_type == 'select') { ?>
	<select name="content[<?=$int?>][value]"  class="form-control" id="value" >
	<?php $options = explode(',', $default_content[$int]['value']); foreach($options as $option) { list($val,$title) = explode('|', $option); ?>
	<option <?php if($value == trim($val)) echo 'selected="selected"'; ?> value="<?=trim($val)?>"><?=trim($title)?></option>
	<?php } ?>
	
	</select>
	<?php } else if($field_type == 'textarea') { ?>
	<textarea rows=5 name="content[<?=$int?>][value]" class="form-control" id="value" ><?=$value?></textarea>
	<?php } else if($field_type == 'file') { ?>
	<div class="">
		<div class="bottommargin-minier">
			<input name="content[<?=$int?>][value]" type="<?=$field_type?>" value="<?=$value?>" class="form-control" id="value" >
		</div>
		<?php if($data['content'][$int]['file_path']) { ?>
		<div class="">
			<div class="form-check ">
				<input name="content[<?=$int?>][delete]" id="delete_<?=$int?>" type="checkbox" class="form-check-input" value="1">
				<label class="form-check-label" for="delete_<?=$int?>">Удалить</label>
			</div>
		</div>
		<?php }  ?>
	</div>
	<?php } else { ?>
	
	<input name="content[<?=$int?>][value]" type="text" value="<?=htmlspecialchars($value)?>" class="form-control" id="value" >
	
	<?php }  ?>
	<?php if($default_content[$int]['description']) { ?>
	<div class="help-box" ><?=$default_content[$int]['description']?></div>
	<?php }  ?>
	</div>
<?php } 
}

 if($data['content_structure']['element']) { ?>
<hr>
<label >Элементы</label>

<div id="content_items" class="clearfix">

<div class="" id="content_ghost_block">

<?php 

//echo '<pre>'; print_r($data['content']['items']); echo '</pre>'; 

if($data['content']['items']) 
{
	foreach($data['content']['items'] as $item_int => $item_arr) 
	{
		if(is_numeric($item_int)) include(ROOT.'/apps/blocks/html/content_item.php');
	}
}
?>


</div>  


</div>

<button type="button" onclick="content_item_add()" class="btn btn-block btn-light">Добавить</button>
<?php } ?>

<script>
function move_blocks_init() {

$('.before_btn').on('click', function(e) {
    var wrapper = $(this).closest('.content_item')
    wrapper.insertBefore(wrapper.prev())
})
$('.after_btn').on('click', function(e) {
    var wrapper = $(this).closest('.content_item')
    wrapper.insertAfter(wrapper.next())
})
}

move_blocks_init();

//sortableInit();

function item_delete(var_this)
{
	var_this.closest('.content_item').remove();
}

function content_item_add()
{
	$.ajax({
		type: "GET",
		url: "index.php?app=ajax&method=app",
		data: { 
				 html : 'content_item.php',
				 appl : 'blocks',
				 structure : '<?=base64_encode(json_encode($data['content_structure']['element']))?>',
				 
			     },
		//dataType: 'json'
	})
	.done(function( data ) {
		$("#content_ghost_block").append(data);
		move_blocks_init();
	});	
}

<?php 
if(!$data['content']['items']) {
for($i=0; $i<3; $i++) { ?> 
//content_item_add('<?=$i?>'); 
<?php }} ?>


</script>


