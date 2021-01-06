
<div class="alert alert-info">Для настроек типа "выбор" в качестве значения по умолчанию указываются значения для выбора через запятую. Их русскоязычные названия пишутся в настройке через прямой слэш "|". Например: "dark|Темный,light|Светлый"</div>

<h3>Основной конент</h3>

<div id="content_structure_block">

<?php 
$structure = 'main';
if(!$data['content_structure'][$structure] && $_GET['act'] == 'new') $data['content_structure'][$structure] = api('blocks.default_blocks_data', 'content_structure_main');

if($data['content_structure'][$structure]) foreach($data['content_structure'][$structure] as $int => $item) if(is_int($int)) include(ROOT.'/apps/blocks/html/line_content.php'); ?>

<input type="hidden" id="increment"  value="<?=($int+1)?>"  />

</div>  
  
<button type="button" onclick="line_content_add('', '', '', '#content_structure_block', 'main')" class="btn btn-block btn-light">Добавить</button>

<hr>

<h3>Элемент</h3>

<div id="content_element_structure_block">

<?php 
$structure = 'element';
if(!$data['content_structure'][$structure] && !$_GET['id']) $data['content_structure'][$structure] = api('blocks.default_blocks_data', 'content_structure_element');


if($data['content_structure'][$structure]) foreach($data['content_structure'][$structure] as $int => $item) if(is_int($int)) include(ROOT.'/apps/blocks/html/line_content.php'); ?>

<input type="hidden" id="increment"  value="<?=($int+1)?>"  />

</div>  
  
<button type="button" onclick="line_content_add('', '', '', '#content_element_structure_block', 'element')" class="btn btn-block btn-light">Добавить</button>


<script>

function line_content_add(name, title, type, selector, structure)
{
	$.ajax({
		type: "GET",
		url: "/ajax/app",
		data: { 
				 html : 'line_content.php',
				 app : 'blocks',
				 name : name,
				 title : title,
				 type : type,
				 structure : structure,
			     },
		//dataType: 'json'
	})
	.done(function( data ) {
		$(selector).append(data);
		//move_blocks_init();
	});	
}

</script>