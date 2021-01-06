<div class="modal-header">
<h3 class="modal-title" id="exampleModalLabel">Скачать изображения</h3>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body" data-width="450px">

<div id="loader" class="center allpadding hidden">
<img src="/interface/images/ajax-loader.gif" />
</div>

<form id="<?=$param?>_form" method="POST">

<div class="alert alert-info">Перед скачиванием убедись, что запущен <b>iimrunner.exe</b></div>

  <div class="form-group">
	<label for="recipient-name" class="col-form-label">Ключевое слово:</label>
	<input type="text" class="form-control" id="recipient-name" name="keyword">
  </div>
  
  <div class="form-group">
	<label for="recipient-name" class="col-form-label">Папка:</label>
	<input type="text" class="form-control" id="recipient-name" name="folder">
	<div class="help-box">Будет создана здесь /SHABLONER/themes_data/downloaded_images/</div>
  </div>
  
</form>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
<button onclick="ajax_form('<?=$param?>_form', 'parse.imacros')" type="button" class="btn btn-primary">Скачать</button>
</div>

<script>

function ajax_form(form, api_func,)
{
	$('#loader').removeClass('hidden');
	$('#<?=$param?>_form').hide();
	
	var data = $('#'+form).serialize();
	
	$.ajax({
		type: "POST",
		url: 'index.php?app=ajax&method=api&param='+api_func,
		data: data,
		//dataType: 'json'
	})
	.done(function( data ) {
		$('#<?=$param?>').modal('hide');
		/*if(data.error) alert(data.error);
		else
		{
			$('#<?=$param?>').modal('hide');
			//window.location.href='/themes?act=edit&id='+data.id;
		}*/
	});	
}



</script>