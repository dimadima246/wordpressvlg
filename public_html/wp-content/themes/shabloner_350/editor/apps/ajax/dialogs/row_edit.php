<?php

//echo '<pre>'; print_r($_GET); echo '</pre>'; 

$row_files_path = '/sources/themes/'.$_GET['theme_id'].'/files';

$row_block = db()->where('id', ROW_BLOCK)->getOne('blocks');
$default_settings = json_decode($row_block['settings'], 1);

$data = array();
$row_schema = db()->where('id', $_GET['row_id'])->getOne('rows_schema');
$data['settings'] = json_decode($row_schema['settings'], 1);

$block_files_path = '/sources/themes/'.$row_schema['theme_id'].'/files';
//$default_block_path = '/sources/blocks/'.$_GET['block_id'];

//echo '<pre>'; print_r($data['settings']); echo '</pre>'; 

?>

<div class="modal-header">
<h3 class="modal-title" id="exampleModalLabel">Настройки ряда</h3>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
<form id="<?=$param?>_form" method="POST" enctype="multipart/form-data">
<div class="modal-body" data-width="950px">
<input type="hidden" name="theme_id" value="<?=$_GET['theme_id']?>" />
<input type="hidden" name="id" value="<?=$_GET['row_id']?>" />


<?php include(ROOT.'/apps/rows/html/row_settings.php'); ?>


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
    url: 'index.php?app=ajax&method=api&param=rows.edit',
    type: 'POST',
    data: formData,
    async: false,
    cache: false,
    contentType: false,
    processData: false,
    success: function (returndata) {
	
	var dialog = '<?=$param?>';	
	$('#'+dialog).modal('hide');
	  
	  
    }
  });
 
  return false;
});

</script>