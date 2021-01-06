<?php


$block_files_path = '/sources/themes/'.$_GET['theme_id'].'/files';

$default_block_path = '/sources/blocks/'.$_GET['block_id'];
//$default_settings_path = ROOT.$default_block_path.'/settings.json';


//$default_settings = json_decode(file_get_contents($default_settings_path), 1);
$block_schema = db()->where('id', $_GET['block_schema_id'])->getOne('blocks_schema');
$block = db()->where('id', $block_schema['block_id'])->getOne('blocks');
$default_settings = json_decode($block['settings'], 1);

$row_block = db()->where('id', ROW_BLOCK)->getOne('blocks');
$default_row_settings = json_decode($row_block['settings'], 1);

$data = array();
$data['settings'] = json_decode($block_schema['settings'], 1);
$data['row_settings'] = json_decode($block_schema['row_settings'], 1);

?>

<div class="modal-header">
<h3 class="modal-title" id="exampleModalLabel">Настройки блока</h3>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
<form id="<?=$param?>_form" method="POST" enctype="multipart/form-data">
<div class="modal-body" data-width="950px">





<input type="hidden" name="theme_id" value="<?=$_GET['theme_id']?>" />
<input type="hidden" name="block_schema_id" value="<?=$_GET['block_schema_id']?>" />
<input type="hidden" name="block_id" value="<?=$_GET['block_id']?>" />

<?php 
if(in_array($block['category_id'], array(1,2,19))) include(ROOT.'/apps/blocks/html/block_settings.php');
elseif(!$data['settings']) include(ROOT.'/apps/rows/html/row_settings.php');
else { ?>
<div class="tabs clearfix tabs-alt tabs-tb" id="tabs-block" >
<ul class="tab-nav clearfix" id="" >
  <li class="">
    <a  href="#row_settings_block" role="tab" >Основные</a>
  </li>

  <li class="">
    <a  href="#settings_block" role="tab"  >Дополнительные</a>
  </li>
</ul>

<div class="tab-container " id="">
  <div class="tab-content " id="row_settings_block" ><?php include(ROOT.'/apps/rows/html/row_settings.php'); ?></div>
  <div class="tab-content " id="settings_block" ><?php include(ROOT.'/apps/blocks/html/block_settings.php'); ?></div>
</div>

</div>
<?php }?>






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
    url: 'index.php?app=ajax&method=api&param=blocks.edit',
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
	
	//else $('.modal-dialog').css('width', '550px'); 
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