<?php
if(!api('sys.access', array('user_id' => $_SESSION['user_id'], 'id' => $_REQUEST['id'], 'object' => 'theme'))) die('access denied');

$page = db()->where('id', $_REQUEST['id'])->getOne('pages_schema');

?>
<div class="modal-header">
<h3 class="modal-title" id="exampleModalLabel">Редактирование страницы</h3>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body" data-width="450px">
<form id="<?=$param?>_form" method="POST">
<input type="hidden" name="theme_id" value="<?=$_GET['theme_id']?>">
<input type="hidden" name="id" value="<?=$_GET['id']?>">

  <div class="form-group">
	<label for="recipient-name" class="">Тип страницы:</label>
	<select  id="role" onchange="check_role();" class="form-control" name="role">
	<?php foreach(roles() as $role => $title) { ?>
	<option <?php if($role == $page['role']) echo 'selected="selected"'; ?> value="<?=$role?>"><?=$title?></option>
	<?php } ?>
	</select>
	
  </div>

  <div class="form-group">
	<label for="recipient-name" class="">Название страницы:</label>
	<input type="text" class="form-control" id="recipient-name" name="name" value="<?=$page['name']?>">
  </div>
  
  
  <div id="page_name">
	  
	  <div class="form-group">
		<label for="recipient-name" class="">ID страницы или постоянная ссылка:</label>
		<input type="text" class="form-control" id="" name="slug" value="<?=$page['slug']?>">
		<div class="text-muted">Должна совпадать с созданной страницей на WordPress. См. инструкцию <a href="http://shabloner.ru/support/sozdanie-unikalnoi-stranicy-v-redaktore" target="_blank">как создать уникальную страницу</a>.</div>
	  </div>
  </div>
  
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
<button onclick="ajax_form('<?=$param?>_form', 'themes.page_edit')" type="button" class="btn btn-primary">Сохранить</button>
</div>

<script>

function check_role()
{
	if($('#role option:selected').val() == 'other') $('#page_name').show();
	else $('#page_name').hide();
}

check_role();

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
		if(data.error != 0) alert(data.error);
		else
		{
			$('#<?=$param?>').modal('hide');
			window.location.href='';
			//window.location.href='/themes/?act=edit&id=<?=$_GET['theme_id']?>';
			//window.location.href='/page_view/?theme_id=<?=$_GET['theme_id']?>&page_id='+data.id;
		}
	});	
}



</script>