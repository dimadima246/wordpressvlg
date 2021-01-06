<div class="row">
    <div class="col-sm">
		  <div class="form-row ">
			  <div class="col">
				 <div class="form-group">
					<label for="name">Название</label>
					<input name="name" type="text" class="form-control" id="name" value="<?=$data['name']?>" >
				  </div>
			  </div>	  
			  <div class="col-sm-2">
				 <div class="form-group">
					<label for="name">Столбцов</label>
					<input class="form-control" name="colors" type="text" value="<?=$data['colors']?>">
				  </div>
			  </div>	  
		  </div>	  
		  <div class="form-group">
			<label for="category_id">Категория</label>
			<select name="category_id" class="form-control" id="category_id">
			  <option value='0'>-Выберите-</option>
			  <?php foreach(api('blocks.get_cats') as $cat) { ?>
			  <option <?php if($data['category_id'] == $cat['id']) echo 'selected="selected"'; ?> value='<?=$cat['id']?>'><?=$cat['name']?></option>
			  <?php }  ?>
			</select>
		  </div>
		  
		  
    </div>
    <div class="col-sm">
		<div class="form-group">
			<label for="description">Описание</label>
			<textarea name="description" class="form-control" id="description" rows="5"><?=$data['description']?></textarea>
		 </div>
    </div>

</div>

<div class="form-group">
	<label for="image">Изображение</label>
	<?php if($data['image']) { ?><div class="img_block bottommargin-minier"><img class="" src="<?=$data['image']?>?_<?=time()?>" /></div><?php } ?>
	<input name="image" type="file" class="form-control" id="image" >
	<small class="form-text text-muted">Соотношение ~4:1, например: 850x200 пикселей</small>
</div>



<div class="tabs tabs-alt tabs-tb clearfix ui-tabs ui-corner-all ui-widget ui-widget-content topmargin-sm" id="tabs">

<ul class="tab-nav clearfix ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header" id="" >
  <li class="">
    <a  href="#html_editor" role="tab" >HTML-код</a>
  </li>
  <li class="">
    <a  href="#css_edit" role="tab"  >CSS-стили</a>
  </li>
  <li class="">
    <a href="#js_edit" role="tab"  >JS-код</a>
  </li>
</ul>

<input type="hidden" name="id" value="<?=$_GET['id']?>" />

<div class="tab-container " id="myTabContent">

  <div class="tab-content " id="html_editor" >
	<div class="form-group">
		<input name="code" id="code" type="hidden" />
		<div id="editor" class="editor"></div>
	 </div>
  </div>
  
  <div class="tab-content " id="css_edit" >
	<div class="form-group">
		<input name="css" id="css_input" type="hidden" />
		<div id="css_editor" class="editor"></div>
	 </div>
  </div>
  
  <div class="tab-content " id="js_edit" >
	<div class="form-group">
		<input name="js" id="js_input" type="hidden" />
		<div id="js_editor" class="editor"></div>
	 </div>
  </div>
  
</div>


</div>



<textarea style="display:none" id="code_src"><?=htmlspecialchars($data['code'])?></textarea>
<textarea style="display:none" id="css_src"><?=htmlspecialchars($data['css'])?></textarea>
<textarea style="display:none" id="js_src"><?=htmlspecialchars($data['js'])?></textarea>

<script src="/files/ace-builds-master/src-min-noconflict/ace.js"></script>
<script>

	// HTML редактор
    var editor = ace.edit("editor");
    editor.session.setMode("ace/mode/html");
	document.getElementById('editor').style.fontSize='16px';
	editor.setValue($('#code_src').val());
	$('#code').val(editor.getValue());
	
	// CSS редактор
    var css_editor = ace.edit("css_editor");
    css_editor.session.setMode("ace/mode/css");
	document.getElementById('css_editor').style.fontSize='16px';
	css_editor.setValue($('#css_src').val());
	$('#css_input').val(css_editor.getValue());
	
	// JS редактор
    var js_editor = ace.edit("js_editor");
    js_editor.session.setMode("ace/mode/javascript");
	document.getElementById('js_editor').style.fontSize='16px';
	js_editor.setValue($('#js_src').val());
	$('#js_input').val(js_editor.getValue());
	
	
	editor.getSession().on('change', function(e) {
		$('#code').val(editor.getValue());
	});	
	
	css_editor.getSession().on('change', function(e) {
		$('#css_input').val(css_editor.getValue());
	});	
	
	js_editor.getSession().on('change', function(e) {
		$('#js_input').val(js_editor.getValue());
	});	

</script>