<div class="modal-header">
<h3 class="modal-title" id="exampleModalLabel">Синхронизация</h3>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>

<div class="modal-body" data-width="500px">
<form id="<?=$param?>_form" method="POST">
 <input type="hidden" name="theme_id" value="<?=$_GET['theme_id']?>" />
 <div id="synch_result">
<b>Внимание</b>! При синхронизации все изменения в теме, сделанные вручную через файлы темы будут потеряны. Продолжить?
</div>

</form>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
<button onclick="ajax_form('<?=$param?>_form', 'themes.add')" type="button" class="btn btn-primary">Продолжить</button>
</div>

<script>

function ajax_form(form, api_func,)
{
	var data = $('#'+form).serialize();
	
	$('#synch_result').html('<center><img src="<?=HTTP_PATH?>/files/images/ajax-loader.gif" /></center>');
	
	$.ajax({
		type: "POST",
		url: '/ajax/synch',
		data: data,
		//dataType: 'json'
	})
	.done(function( data ) {
		$('#synch_result').html(data);
	});	
}



</script>