<?php

$data = array();


$cats = api('blocks.get_cats', $data ) ;

$rows = api('rows.get', array('theme_id' => $_GET['theme_id']));

?>
<div class="modal-header">
<h3 class="modal-title" id="exampleModalLabel">Выбор ряда</h3>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>

<div class="modal-body" data-width="950px">

<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item ">
    <a class="nav-link active" id="settings-tab" data-toggle="tab" href="#new" role="tab" aria-controls="settings" aria-selected="true">Новый</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="content-tab" data-toggle="tab" href="#exists" role="tab" aria-controls="content" aria-selected="false">Существующий (<?=$rows['total']?>)</a>
  </li>
</ul>

<div class="tab-content toppadding-xs" id="myTabContent">
  <div class="tab-pane fade show active" id="new" role="tabpanel" aria-labelledby="new-tab">
  
<div class="clearfix " style="display:table; width:100%">

	<ul class="et-pb-column-layouts">
		<?php foreach(api('rows.types_get', array()) as $int => $type) { ?>
		<li data-layout="<?=$type?>" class="row_id">
		<?php foreach(explode(",", $type) as $column) { ?> 
			<div class="et_pb_layout_column et_pb_column_layout_<?php if($int == 0) echo 'fullwidth'; else echo $column; ?>"><?=str_replace('_', ' / ', $column)?></div>
		<?php } ?>
		</li>
		<?php } ?>
	</ul>
	
</div>  
  
  </div>
  <div class="tab-pane fade" id="exists" role="tabpanel" aria-labelledby="exists-tab">
  
	<?php 
	
	if($rows['data']) {
	foreach($rows['data'] as $row) { 
	$choose_row = 1; 
	include(ROOT.'/apps/rows/html/row_item.php'); 
	}
	} else echo 'Рядов нет';	?>
  
  </div>
</div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
<!--<button onclick="ajax_form('<?=$param?>_form', 'themes.add')" type="button" class="btn btn-primary">Создать</button>
-->
</div>

<script>

$('.row_id').bind('click', function() {
	
	// Функция создания блока на странице
	var layout = $(this).data('layout');
	row_add_to_area(layout);
	return false;
});

function row_add_to_area(layout, row_id)
{
	$.ajax({
		type: "GET",
		url: 'index.php?app=ajax&method=api&param=rows.add',
		data: {
				  'area': '<?=$_GET['area']?>',
				  'theme_id': '<?=$_GET['theme_id']?>',
				  'page_id': '<?=$_GET['page_id']?>',
				  'layout': layout,
				  'row_id': row_id,
		},
		dataType: 'json'
	})
	.done(function( data ) {
		
		if(data.id)
		{
			$.ajax({
				type: "GET",
				url: '/ajax/app',
				data: {
						  'app': 'rows',
						  'html': 'row_item',
						  'area': '<?=$_GET['area']?>',
						  'theme_id': '<?=$_GET['theme_id']?>',
						  'page_id': '<?=$_GET['page_id']?>',
						  'layout': layout,
						  'row_id': data.id,
				},
				//dataType: 'json'
			})
			.done(function( data ) {
				$('#area_<?=$_GET['area']?>').append(data);
				sortableInit();
				$('#<?=$param?>').modal('hide');
				
			});	
		}
		
		
	});	
}



</script>