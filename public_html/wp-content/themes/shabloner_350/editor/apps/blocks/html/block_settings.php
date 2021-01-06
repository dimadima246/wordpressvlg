<?php

foreach($default_settings as $int => $item) {
$type = $item['type'];	
if($type == 'image') $field_type = 'file';
else if($type == 'select') $field_type = 'select';
else if($type == 'textarea') $field_type = 'textarea';
else $field_type = 'text';

$value = $data['settings'][$int]['value'];
$image = $block_files_path.str_replace($default_block_path.'/files', '', $data['settings'][$int]['file_path']).'?'.time();

?>

<div class="form-group">
<input name="settings[<?=$int?>][type]" type="hidden" value="<?=$default_settings[$int]['type']?>" />
<input name="settings[<?=$int?>][name]" type="hidden" value="<?=$default_settings[$int]['name']?>" />

	<label for="value"><?php if($default_settings[$int]['title']) echo $default_settings[$int]['title']; else echo $default_settings[$int]['name'];?></label>
	
	<?php if($data['settings'][$int]['file_path']) echo '<div class="img_block bottommargin-minier"><img src="'.$image.'" /></div>';?>
	
	<?php if($field_type == 'select') { ?>
	<select name="settings[<?=$int?>][value]" value="<?=$value?>" class="form-control" id="value" >
	<?php $options = explode(',', $default_settings[$int]['options']); foreach($options as $option) { list($val,$title) = explode('|', $option); ?>
	<option <?php if($value == trim($val)) echo 'selected="selected"'; ?> value="<?=trim($val)?>"><?=trim($title)?></option>
	<?php } ?>
	
	</select>
	<?php } else if($field_type == 'textarea') { ?>
	<textarea rows=5 name="settings[<?=$int?>][value]" class="form-control" id="value" ><?=$value?></textarea>
	<?php } else if($field_type == 'file') { ?>
	<div class="row">
		<div class="col-sm-9">
			<input name="settings[<?=$int?>][value]" type="<?=$field_type?>" value="<?=$value?>" class="form-control" id="value" >
		</div>
		<div class="col-sm-3">
			<div class="form-check ">
				<input name="settings[<?=$int?>][delete]" id="delete_<?=$int?>" type="checkbox" class="form-check-input" value="1">
				<label class="form-check-label" for="delete_<?=$int?>">Удалить</label>
			</div>
		</div>
	</div>
	<?php } else { ?>
	
	<input name="settings[<?=$int?>][value]" type="text" value="<?=str_replace('"', '&quot;', $value)?>" class="form-control" id="value" >
	
	<?php }  ?>

	<?php if($item['description']) { ?>
	<div class="help-box" ><?=$item['description']?></div>
	<?php }  ?>
	
	</div>
<?php } ?>