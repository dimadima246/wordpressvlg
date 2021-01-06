<div class="modal-header">
<h3 class="modal-title" id="exampleModalLabel">Ссылка</h3>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body" data-width="450px">
<form id="<?=$param?>_form" method="POST">
  <div class="form-group">
	<label for="link_dialog" class="col-form-label">Ссылка:</label>
	<input type="text" class="form-control" id="link_dialog" name="link_dialog">
  </div>
  
	<div class="form-check ">
		<input id="target_blank" type="checkbox" class="form-check-input" value="1">
		<label class="form-check-label" for="target_blank">Открывать ссылку в новом окне</label>
	</div>
  
	<div class="form-check " id="delete_block">
		<input id="delete_link" type="checkbox" class="form-check-input" value="1">
		<label style="color:red" class="form-check-label " for="delete_link">Удалить ссылку</label>
	</div>
  
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
<button onclick="create_link()" type="button" class="btn btn-primary">Сохранить</button>
</div>

<script>

if($('#exist_link').length) $('#delete_block').show();
else $('#delete_block').hide(); 

$('#link_dialog').val($('#link_input').val());

if($('#link_target').val() == 1) $('#target_blank').prop('checked', true);
else $('#target_blank').prop('checked', false);

function create_link(form, api_func)
{
	if($('#target_blank').is(':checked')) target = 1;
	else target = 0;
	
	if($('#delete_link').is(':checked')) 
	{
		$('#exist_link').after($('#exist_link').text()).remove();
	}
	else if($('#exist_link').length)
	{
		if(target == 1) htmlTarget = '_blank';
		else htmlTarget = '';
			
		$('#exist_link').attr('href', $('#link_dialog').val()).attr('target', htmlTarget).attr('id', '');
	}
	else
	{
		restoreSelection(window.savedSel);
		setLink($('#link_dialog').val(), target);
	}
	
	saveContent();
	
	$('#link_add').modal('hide');
	
	
}



</script>