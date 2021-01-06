<p>Здесь вы можете указать коды счетчиков, дополнительных виджетов и т.д., они будут добавлены в конец кода темы перед закрывающим тегом &lt;/body&gt;</p>


<div class="form-group">
	<input name="html" id="html_input" type="hidden" />
	<div id="html_editor" class="editor"></div>
</div>

<textarea style="display:none" id="html_src"><?=htmlspecialchars($data['html'])?></textarea>

<script>

	// html редактор
    var html_editor = ace.edit("html_editor");
    html_editor.session.setMode("ace/mode/html");
	document.getElementById('html_editor').style.fontSize='16px';
	html_editor.setValue($('#html_src').val());
	$('#html_input').val(html_editor.getValue());
	
	
	html_editor.getSession().on('change', function(e) {
		$('#html_input').val(html_editor.getValue());
	});	
	
</script>

