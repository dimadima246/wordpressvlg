<div class="modal-header">
<h3 class="modal-title" id="exampleModalLabel">Макросы конструктора</h3>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body" data-width="1150px">
<form id="<?=$param?>_form" method="POST">
<?php $macroses = db()->get('macroses'); ?>

<table class="table">
  <thead>
    <tr>
      <th width="25%" scope="col">Макрос</th>
      <th scope="col">Описание</th>
      <th scope="col">В Wordpress</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($macroses as $macros) { ?> 
    <tr>
		<td><input value="[<?=$macros['name']?>]" class="form-control" type='text' /></td>
		<td><?=htmlspecialchars($macros['description'])?></td>
		<td><?=htmlspecialchars($macros['wordpress'])?></td>
	</tr>
	<?php } ?>
  </tbody>
</table>
  
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
</div>
