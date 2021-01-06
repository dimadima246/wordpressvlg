<?php

$default_cat = 1;

$data = array('not_in' => array('24'));

/*if($_GET['type'] == 'header') $data['id'] = 1;
elseif($_GET['type'] == 'slider') $data['id'] = 2;
elseif($_GET['type'] == 'footer') $data['id'] = 19;
else $data['content'] = 1;*/

$cats = api('blocks.get_cats', $data ) ;

$blocks = api('blocks.get_schema', array('theme_id' => $_GET['theme_id']));

?>
<div class="modal-header">
<h3 class="modal-title" id="exampleModalLabel">Выбор блока</h3>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body" data-width="850px">

<form id="<?=$param?>_form" method="POST">

<div class="tabs clearfix tabs-alt tabs-tb" id="tabs-block" >


<ul class="tab-nav clearfix" id="" >
  <li class="">
    <a  href="#block_new" role="tab" >Новый</a>
  </li>

  <li class="">
    <a  href="#block_exists" role="tab"  >Существующий</a>
  </li>
</ul>

<div class="tab-container " id="">
  <div class="tab-content " id="block_new" >
  
<?php if($_GET['block_schema_id']) { ?>
<div class="form-check ">
	<input id="save_content" type="checkbox" class="form-check-input" value="1">
	<label class="form-check-label" for="save_content">Сохранить прежнее содержимое блока</label>
</div>
<hr>
<?php } ?>

		  <input type="hidden" id="area" value="<?=$_GET['area']?>" /> 
<input type="hidden" id="replace" value="<?=$_GET['replace']?>" /> 
<input type="hidden" id="row_num" value="<?=$_GET['row_num']?>" /> 
<input type="hidden" id="block_num" value="<?=$_GET['block_num']?>" /> 
<input type="hidden" id="col_int" value="<?=$_GET['col_int']?>" /> 

<div class="row">
<div class="leftpadding-minier nav col-md-4 flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

<?php foreach($cats as $int => $cat) { ?>
  <a data-cat_id="<?=$cat['id']?>" class="nav-link <?php if($cat['id']==$default_cat) echo 'active';?>" id="v-pills-<?=$cat['id']?>-tab" data-toggle="pill" href="#v-pills-<?=$cat['id']?>" role="tab" aria-controls="v-pills-<?=$cat['id']?>" aria-selected="<?php if($int==0) echo 'true';?>">
  <span class="pull-right"><?=$cat['count']?></span>
  <?=$cat['name']?></a>
<?php } ?>
</div>
<div class="col tab-content" id="v-pills-tabContent">
<?php foreach($cats as $int => $cat) { ?>
  <div class="tab-pane fade show <?php if($cat['id']==$default_cat) echo 'active';?>" id="v-pills-<?=$cat['id']?>" role="tabpanel" aria-labelledby="v-pills-<?=$cat['id']?>-tab">
  
  <div class="card allpadding-minier" id="cat_block_<?=$cat['id']?>">
	<?=$cat['name']?>
  </div>
  
  
  
  </div>
<?php } ?>
</div>
</div>  
  
  </div>
  <div class="tab-content " id="block_exists" >
  
	<?php 
	
	if($blocks['data']) {
	foreach($blocks['data'] as $block) { 
	$choose_block = 1; 
	
	$item = db()->where('id', $block['block_id'])->getOne('blocks');
	
	include(ROOT.'/apps/rows/html/block_item.php'); 
	}
	} else echo 'Блоков нет';	?>
  
  </div>
</div>

</div>






</form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
<!--<button onclick="ajax_form('<?=$param?>_form', 'themes.add')" type="button" class="btn btn-primary">Создать</button>
-->
</div>

<script>

function block_add_to_area(block_id, block_schema_id)
{
	if($('#save_content').is(':checked')) var save_content = 1;
	else var save_content = 0;
	
	$.ajax({
		type: "GET",
		url: 'index.php?app=ajax&method=api&param=blocks.set',
		data: {
				  'block_id': block_id,
				  'block_schema_id': block_schema_id,
				  'save_content': save_content,
		},
		//dataType: 'json'
	})
	.done(function( data ) {
		
	   // Визуальный редактор
	   params = 'theme_id=<?=$_GET['theme_id']?>&page_id=<?=$_GET['page_id']?>&block_schema_id='+block_schema_id;
	   $.ajax({
			url: 'index.php?app=block_view',
			cache: false,
			data: params,
			type: "GET",
		   success: function(html) {
			   
			   // Подставили данные
			   $('#block_'+block_schema_id).after(html).remove();
			   bind_settings();
		   }
	  });
		
	});	
	
}

function block_add_exists_to_area(block_schema_id, block_schema_replace_id, no_replace, after_block_schema_id)
{
	
	$.ajax({
		type: "GET",
		url: 'index.php?app=ajax&method=api&param=blocks.add_exists',
		data: {
				  'page_id': '<?=$_GET['page_id']?>',
				  'id': block_schema_id,
				  'replace_id': block_schema_replace_id,
				  'no_replace': no_replace,
		},
		dataType: 'json'
	})
	.done(function( data ) {
		if(data.block_id)
		{
			//if(no_replace == 1) $('#wrapper').append('<div id="block_'+block_schema_id+'"></div>');
			
		   // Визуальный редактор
		   params = 'theme_id=<?=$_GET['theme_id']?>&page_id=<?=$_GET['page_id']?>&block_schema_id='+block_schema_id;
		   $.ajax({
				url: 'index.php?app=block_view',
				cache: false,
				data: params,
				type: "GET",
			   success: function(html) {
				   
				   if(!after_block_schema_id) 
				   {
					   $('#wrapper').append('<div id="block_'+block_schema_id+'"></div>');
					   $('#block_'+block_schema_id).after(html).remove();
				   }
				   else
				   {
					   // Подставили данные
					   if(no_replace != 1) $('#block_'+block_schema_replace_id).after(html).remove();
					   else $('div#block_'+after_block_schema_id+'.block_schema').after(html);
				   }
					
				   $('#<?=$param?>').modal('hide');
					   
				   bind_settings();
			   }
		  });
			
		}
		else alert(data.error);
	});	
	
}


function show_blocks_by_cat_id(cat_id)
{
	
	$.ajax({
		type: "GET",
		url: 'index.php?app=ajax&method=app',
		data: {
				  'appl': 'themes',
				  'html': 'cats',
				  'cat_id': cat_id,
		},
		//dataType: 'json'
	})
	.done(function( data ) {
		$('#cat_block_'+cat_id).html(data);
		
			$('.block_id').bind('click', function() {
				
				console.log('block clicked');
				
				// Функция создания блока на странице
				var block_id = $(this).data('block_id');
				
				<?php if($_GET['block_schema_id']) { ?>
				block_add_to_area(block_id, <?=$_GET['block_schema_id']?>);
				<?php } else { ?>
				
				var after_block_schema_id = '<?=$_GET['after_block_schema_id']?>';
				
				$.ajax({
					type: "POST",
					url: 'index.php?app=ajax&method=api&param=blocks.add',
					data: {
							  'page_id': '<?=$_GET['page_id']?>',
							  'after_block_schema_id': after_block_schema_id,
					},
					dataType: 'json'
				})
				.done(function( data ) {
					
					if(data.id) 
					{
						<?php if($_GET['after_block_schema_id']) { ?>
						$('#block_<?=$_GET['after_block_schema_id']?>').after('<div id="block_'+data.id+'"></div>');
						<?php } else { ?>
						$('#wrapper').append('<div id="block_'+data.id+'"></div>');
						<?php } ?>
						
						block_add_to_area(block_id, data.id);
					}
					else alert(data.error);
					
				});	
				
				<?php } ?>
				
				$('#<?=$param?>').modal('hide');
				return false;
			});
		
		//window.location.href='/themes?act=edit&id='+data.id;
	});	
}

<?php 

if($_GET['category_id']) 
{echo  "$('#v-pills-".$_GET['category_id']."-tab').tab('show'); // Открыть нужный таб
show_blocks_by_cat_id(".$_GET['category_id']."); "; }
else echo "show_blocks_by_cat_id('".$default_cat."');"; ?>  

 
$('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
	//alert($(this).data('cat_id')); // получить ID для подгрузки блоков
	var cat_id = $(this).data('cat_id');
	show_blocks_by_cat_id(cat_id);
	  
});


function ajax_form(form, api_func)
{
	var data = $('#'+form).serialize();
	
	$.ajax({
		type: "POST",
		url: 'index.php?app=ajax&method=api&param='+api_func,
		data: data,
		dataType: 'json'
	})
	.done(function( data ) {
		$('#<?=$param?>').modal('hide');
		window.location.href='/themes?act=edit&id='+data.id;
	});	
} 



</script>