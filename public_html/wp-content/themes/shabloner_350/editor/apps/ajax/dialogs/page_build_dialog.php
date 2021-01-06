<div class="modal-header">
<h3 class="modal-title" id="exampleModalLabel">Сохранение изменений</h3>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>

<div class="modal-body" data-width="500px">
<form id="<?=$param?>_form" method="POST">
 <input type="hidden" name="theme_id" value="<?=$_GET['theme_id']?>" />
 <input type="hidden" name="page_id" value="<?=$_GET['page_id']?>" />
 <div id="synch_result" style="font-size: 120%;">

</div>

</form>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
<a target="_blank" href="<?=str_replace('wp-admin', '', WP_ADMIN_URL)?>" class="btn btn-primary"><i class="fas fa-eye"></i> Просмотр сайта</a>
</div>

<script>

function ajax_form(form)
{
	var data = $('#'+form).serialize();
	
	$('#synch_result').html('<center><img src="<?=HTTP_PATH?>/files/images/ajax-loader.gif" /></center>');
	
	$.ajax({
		type: "POST",
		url: 'index.php?app=ajax&method=build.wp_page',
		data: data,
		//dataType: 'json'
	})
	.done(function( data ) {
		$('#synch_result').html(data);
	});	
}

ajax_form('<?=$param?>_form');

</script>