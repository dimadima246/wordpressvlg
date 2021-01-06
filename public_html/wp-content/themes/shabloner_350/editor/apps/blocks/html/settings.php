<?php

//echo '<pre>'; print_r($data['settings']); echo '</pre>'; 

?>

<div class="alert alert-info">Для настроек типа "выбор" в качестве значения по умолчанию указываются значения для выбора через запятую. Их русскоязычные названия пишутся в настройке через прямой слэш "|". Например: "dark|Темный,light|Светлый"</div>


<div id="settings">
<div id="settings_ghost_block">

<?php
//if(!$data['settings']) $data['settings'] = api('blocks.default_blocks_data', 'settings');
if($data['settings']) foreach($data['settings'] as $int => $item) if(is_int($int)) include(ROOT.'/apps/blocks/html/line_settings.php'); 

?>

<input type="hidden" id="increment"  value="<?=($int+1)?>"  />

</div>  
  
</div>  

<button type="button" onclick="line_add()" class="btn btn-block btn-light">Добавить</button>

<script>
function line_add(name, title, type, value_val, id)
{
	if(!id)
	{
		id = parseInt($("#increment").val());
		$("#increment").val((id + 1))
	}
	
	$.ajax({
		type: "GET",
		url: "/ajax/app",
		data: { 
				 html : 'line_settings.php',
				 app : 'blocks',
				 id : id,
				 name : name,
				 title : title,
				 type : type,
				 value_val : value_val,
			     },
		//dataType: 'json'
	})
	.done(function( data ) {
		$("#settings_ghost_block").append(data);
		//move_blocks_init();
	});	
}

<?php 
if(!$data['settings']) { ?>
/*line_add('class');
line_add('style');
line_add('bg', 'Фон', 'image');*/
<?php } ?>

</script>