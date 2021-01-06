
<div id="settings">
<div id="settings_ghost_block"></div>  
  
</div>  

<button type="button" onclick="line_add()" class="btn btn-block btn-light">Добавить</button>

<script>


function line_delete(var_this)
{
	var_this.closest('.form-row').remove();
}

function line_change_default(var_this)
{
	var val = var_this.val();
	
	if(val == 'text') html = '<input  name="settings[default][]" type="text" class="form-control " placeholder="По умолчанию">';
	if(val == 'image') html = '<input  name="settings[default][]" type="file" class="form-control " placeholder="По умолчанию">';
	
	var_this.closest('.settings_line').find('.default').html(html);
}

function line_add(id, name, title, type, default_val)
{
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
				 default_val : default_val,
			     },
		//dataType: 'json'
	})
	.done(function( data ) {
		$("#settings_ghost_block").append(data);
	});	
}

<?php if($data['settings']) { foreach($data['settings']['name'] as $int => $name) {
	
$type = $data['settings']['type'][$int];
if($type == 'image') $default_val = $data['settings']['file_path'][$int];
else $default_val = $data['settings']['default'][$int];

?>

setTimeout(function() {
line_add('<?=$int?>', '<?=$name?>', '<?=$data['settings']['title'][$int]?>', '<?=$type?>', '<?=$default_val?>');
}, (500));



<?php }} else { ?>
line_add('0', 'class');
line_add('1', 'style');
<?php } ?>

</script>