<div class="modal-header">
<h3 class="modal-title" id="exampleModalLabel">Выбор цвета</h3>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body" data-width="450px">


<div id="color_picker_block"></div>

</div>
<!--
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
<button onclick="ajax_form('<?=$param?>_form', 'themes.add')" type="button" class="btn btn-primary">Выбрать</button>
</div>
-->
<script>

console.log($('#main_color').val());

$('#color_picker_block').colpick({
    color: $('#main_color').val(),
    flat:true,
	submitText: 'Выбрать',
	onSubmit: function(hsb,hex,rgb,el,bySetColor) {
		//console.log('#'+hex);
		setFontColor('#'+hex)
		$('#<?=$param?>').modal('hide');
	},
	
    //layout:'hex'
});


</script>