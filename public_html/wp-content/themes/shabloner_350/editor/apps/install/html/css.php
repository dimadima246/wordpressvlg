<p>Здесь вы можете указать дополнительные стили CSS для вашей темы</p>


<div class="form-group">
	<input name="css" id="css_input" type="hidden" />
	<div id="css_editor" class="editor"></div>
</div>

<textarea style="display:none" id="css_src"><?=htmlspecialchars($data['css'])?></textarea>

<script>

	// CSS редактор
    var css_editor = ace.edit("css_editor");
    css_editor.session.setMode("ace/mode/css");
	document.getElementById('css_editor').style.fontSize='16px';
	css_editor.setValue($('#css_src').val());
	$('#css_input').val(css_editor.getValue());
	
	
	css_editor.getSession().on('change', function(e) {
		$('#css_input').val(css_editor.getValue());
	});	
	
</script>

