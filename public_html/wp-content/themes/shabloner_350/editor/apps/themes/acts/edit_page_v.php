
<?php

//echo '<pre>'; print_r($_PAGE); echo '</pre>'; 
//echo '<pre>'; print_r($_POST); echo '</pre>'; 

?>



<form method="POST" id="edit_page">
<input type="hidden" name="id" id="theme_id" value="<?=$_GET['id']?>" /> 
<input type="hidden" name="page_id" id="page_id" value="<?=$_GET['page_id']?>" /> 

<div class="row">


<div class="col-md-9">

<?php

//echo '<pre>'; print_r($_PAGE); echo '</pre>'; 

$areas = array(
					  //'header' => 'Шапка (Меню)',
					  //'slider' => 'Заголовок, слайдер, обложка',
					  //'content' => 'Структура страницы',
					 // 'footer' => 'Подвал',
					 //'rows' => 'Структура страницы',
					 'blocks' => 'Полотно',
					  );

?>

<?php foreach($areas as $area => $area_title) { ?>

	<div class="section_block allpadding-minier  bottommargin-sm">
	<!--<h4 class="bottommargin-minier"><?=$area_title?></h4>-->
		<div id="area_<?=$area?>" class="sortable">
<?php
$theme_id = $_GET['id'];
$blocks = json_decode($_PAGE[$area], 1);

if($blocks) 
{
	foreach($blocks as $block_schema_id) 
	{
		$block = db()->where('id', $block_schema_id)->getOne('blocks_schema');
		$item = db()->where('id', $block['block_id'])->getOne('blocks');
		
		include(ROOT.'/apps/rows/html/block_item.php');
	}
}

?>
		
		</div>
		
	<button type="button" onclick="modal_dialog_open('choose_block', '&category_id=15&page_id=<?=$_GET['page_id']?>&no_replace=1');" class="btn btn-light btn-block "><i class="fa fa-plus"></i> Добавить блок</button>
	
	</div>

<?php } ?>

	

</div>

<div class="col-md-3">
<?php include($_APP['folder'].'/html/pages.php'); ?>


</div>

</div>


<hr>

<button class="btn btn-primary" type="submit">Сохранить</button>
<button onclick="modal_dialog_open('build_template', 'theme_id=<?=$_GET['id']?>')" class="btn btn-success" type="button">Компиляция</button>
<a target="_blank" class="btn btn-inverse" href="/page_view/?theme_id=<?=$_GET['id']?>&page_id=<?=$_GET['page_id']?>">Просмотр</a>

</form>  

<script>


function block_delete(id)
{
	if (confirm("Удалить ряд с этой страницы? ")) {
		$.ajax({
			type: "POST",
			url: 'index.php?app=ajax&method=api&param=blocks.delete',
			data: {
					  'id': id,
					  'page_id': <?=$_GET['page_id']?>,
					},
			dataType: 'json'
		})
		.done(function( data ) {
			$('#block_'+id).remove();
		});	
	}
}  
  
function block_delete_all (id)
{
	
	if (confirm("Блок удалится со всех страниц, со всеми настройками и файлами. Удалить блок? ")) {
		
		$.ajax({
			type: "POST",
			url: 'index.php?app=ajax&method=api&param=blocks.delete_all',
			data: {
					  'id': id,
					},
			dataType: 'json'
		})
		.done(function( data ) {
			$('#block_'+id+', .block_'+id).remove();
		});	
	}
}    
  
</script>