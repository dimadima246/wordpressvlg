<?php

//echo '<pre>'; print_r($_GET); echo '</pre>'; 
$block_schema = db()->where('id', $_GET['block_schema_id'])->getOne('blocks_schema');
$block_files_path = '/sources/themes/'.$block_schema['theme_id'].'/files';

$default_block_path = '/sources/blocks/'.$_GET['block_id'];
$default_settings_path = ROOT.$default_block_path.'/settings.json';




$data = array();
$data['content'] = json_decode($block_schema['content'], 1);
$data['content_structure'] = json_decode(db()->where('id', $block_schema['block_id'])->getValue('blocks', 'content_structure'), 1);
//$data['settings'] = json_decode($block_schema['settings'], 1);

//echo '<pre>'; print_r($data['content']); echo '</pre>'; 
?>

<div class="modal-header">
<h3 class="modal-title" id="exampleModalLabel">Содержимое блока</h3>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
<form id="<?=$param?>_form" method="POST" enctype="multipart/form-data">
<div class="modal-body" data-width="950px">



<input type="hidden" name="theme_id" value="<?=$_GET['theme_id']?>" />
<input type="hidden" name="block_schema_id" value="<?=$_GET['block_schema_id']?>" />
<input type="hidden" name="block_id" value="<?=$_GET['block_id']?>" />

<?php include(ROOT.'/apps/blocks/html/content.php'); ?>


</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
<button type="submit" class="btn btn-primary">Сохранить</button>
</div>
</form>  

<script>

$("form#<?=$param?>_form").submit(function(event){
 
  //disable the default form submission
  event.preventDefault();
 
  //grab all form data  
  var formData = new FormData($(this)[0]);
 
  $.ajax({
    url: 'index.php?app=ajax&method=api&param=blocks.edit_content',
    type: 'POST',
    data: formData,
    async: false,
    cache: false,
    contentType: false,
    processData: false,
    success: function (returndata) {
	
	var dialog = '<?=$param?>';	
	var params = 'theme_id=<?=$_GET['theme_id']?>&block=<?=$_GET['block_schema_id']?>&block_id=<?=$_GET['block_id']?>';
	
	$('#'+dialog+' .modal-content').html('<center><img style="margin:50px 0px" src="<?=HTTP_PATH?>/files/images/ajax-loader.gif" /></center>');
	
   $.ajax({
		url: 'index.php?app=ajax&method=dialog&param='+dialog,
		cache: false,
		data: params,
		type: "GET",
	   success: function(html) {
		   $('#'+dialog+'').modal('hide');
		   
		   // Если визуальный редактор
		   <?php if($_GET['ajax_load_block']) { ?>
		   params = 'theme_id=<?=$_GET['theme_id']?>&page_id=<?=$_GET['page_id']?>&block_schema_id=<?=$_GET['block_schema_id']?>';
		   $.ajax({
				url: 'index.php?app=block_view',
				cache: false,
				data: params,
				type: "GET",
			   success: function(html) {
				   
				   // Подставили данные
				   $('#block_<?=$_GET['block_schema_id']?>').after(html).remove();
					bind_settings();
					
			   }
		  });
		  <?php } ?>
	   }
  });
	  
	  
    }
  });
 
  return false;
});


function ajax_form(form, api_func,)
{
	//var data = $('#'+form).serialize();
	var data = new FormData($('#'+form)[0]);
	
	$.ajax({
		type: "POST",
		url: 'index.php?app=ajax&method=api&param='+api_func,
		data: data,
		//dataType: 'json'
	})
	.done(function( data ) {
		alert(data);
		//$('#<?=$param?>').modal('hide');
		//window.location.href='/themes?act=edit&id='+data.id;
	});	
}



</script>