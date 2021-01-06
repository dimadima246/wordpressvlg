<div class="modal-header">
<h3 class="modal-title" id="exampleModalLabel">Экспорт</h3>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body" data-width="450px">
<form id="<?=$param?>_form" method="POST">
<input name="theme_id" type="hidden" class="form-control" id="theme_id" value="<?=$_GET['theme_id']?>" >

 <!--<div class="form-group">
	<label for="name">ID темы (услуги на сайте)</label>
	<input name="theme_id" type="text" class="form-control" id="theme_id" value="<?=$_GET['theme_id']?>" >
  </div>-->

  <div class="form-group">
	<label for="folder">Тип экспорта</label>
	<select class="form-control" name="type">
	<option value="wordpress">Тема для WordPress</option>
	<option value="shabloner">Статичный сайт</option>
	</select>
  </div>

  
 <!--<div class="form-group">
	<label for="folder">Название папки с темой</label>
	<input name="folder" type="text" class="form-control" id="folder" placeholder="По умолчанию: shabloner_<?=$_GET['theme_id']?>" value="" >
	<div class="help-box">Только латинские символы, цифры и символ подчеркивания</div>
  </div>

  <div class="form-group">
	<div class="form-check ">
		<input checked="checked" value="1" name="no_files"  type="checkbox" class="form-check-input" id="no_files">
		<label class="form-check-label" for="no_files">Не копировать корневые файлы темы</label>
	  </div>
  </div>

  <div class="form-group">
	<div class="form-check ">
		<input value="1" name="settings[demo_cms]"  type="checkbox" class="form-check-input" id="demo_cms">
		<label class="form-check-label" for="demo_cms">Создать тему для ДЕМО-движка</label>
	  </div>
  </div>

  <div class="form-group">
	<div class="form-check ">
		<input value="1" name="settings[demo_site]"  type="checkbox" class="form-check-input" id="demo_site">
		<label class="form-check-label" for="demo_site">Создать демо сайт</label>
	  </div>
  </div>
  
  <div class="form-group">
	<div class="form-check ">
		<input checked="checked" value="1" name="settings[wordpress]"  type="checkbox" class="form-check-input" id="wordpress">
		<label class="form-check-label" for="wordpress">Создать тему для WordPress</label>
	  </div>
  </div>-->

  
  </form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
<button onclick="ajax_form('<?=$param?>_form', 'build_template')" type="button" class="btn btn-primary">Начать</button>
</div>

<script>

function ajax_form(form, api_func,)
{
	var data = $('#'+form).serialize();
	$('#<?=$param?> .modal-body').html('<center class="topmargin-lg bottommargin-lg "><img src="<?=HTTP_PATH?>/files/images/ajax-loader.gif" /></center>');
	
	$.ajax({
		type: "POST",
		url: '/ajax/'+api_func,
		data: data,
		//dataType: 'json'
	})
	.done(function( data ) {
		$('#<?=$param?> .modal-body').html(data);
		$('#<?=$param?> .modal-footer').hide();
		//window.location.href='/themes?act=edit&id='+data.id;
	});	
}



</script>