<?php


//echo '<pre>'; print_r($data); echo '</pre>'; 

foreach($default_settings['type'] as $int => $type) {
	
if($type == 'image') $field_type = 'file';
else $field_type = 'text';

$value = $data['settings']['value'][$int];
$image = $block_files_path.str_replace($default_block_path.'/files', '', $data['settings']['file_path'][$int]).'?'.mt_rand(11111,99999);

?>

<div class="form-group">
<input name="settings[type][<?=$int?>]" type="hidden" value="<?=$default_settings['type'][$int]?>" />
<input name="settings[name][<?=$int?>]" type="hidden" value="<?=$default_settings['name'][$int]?>" />

	<label for="value"><?php if($default_settings['title'][$int]) echo $default_settings['title'][$int]; else echo $default_settings['name'][$int];?></label>
	
	<?php if($data['settings']['file_path'][$int]) echo '<div class="img_block bottommargin-minier"><img src="'.$image.'" /></div>';?>
	
	<input name="settings[value][<?=$int?>]" type="<?=$field_type?>" value="<?=$value?>" class="form-control" id="value" >
	
</div>
<?php if($default_settings['name'][$int] == 'bg') { ?>
<div class="form-check ">
	<input name="settings[delete_bg]" id="delete_bg" type="checkbox" class="form-check-input" value="1">
	<label class="form-check-label" for="delete_bg">Удалить фон</label>
</div>
<?php } ?>
<?php } ?>