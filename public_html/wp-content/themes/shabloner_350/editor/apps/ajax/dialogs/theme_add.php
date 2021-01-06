<div class="modal-header">
<h3 class="modal-title" id="exampleModalLabel">Новая тема</h3>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body" data-width="450px">
<form id="<?=$param?>_form" method="POST">
  <div class="form-group">
	<label for="recipient-name" class="col-form-label">Название темы:</label>
	<input type="text" class="form-control" id="recipient-name" name="name">
  </div>
  <div class="form-group">
	<label for="message-text" class="col-form-label">Описание:</label>
	<textarea rows=3 class="form-control" name="description" id="message-text"></textarea>
  </div>  
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
<button onclick="ajax_form('<?=$param?>_form', 'themes.add')" type="button" class="btn btn-primary">Создать</button>
</div>

<script>

function ajax_form(form, api_func,)
{
	var data = $('#'+form).serialize();
	
	$.ajax({
		type: "POST",
		url: 'index.php?app=ajax&method=api&param='+api_func,
		data: data,
		dataType: 'json'
	})
	.done(function( data ) {
		if(data.error) alert(data.error);
		else
		{
			$('#<?=$param?>').modal('hide');
			window.location.href='/themes?act=edit&id='+data.id;
		}
	});	
}



</script>