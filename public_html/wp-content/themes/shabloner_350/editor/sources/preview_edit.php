<?php
$theme_id = $_GET['theme_id'];

if($_GET['replace_id']) $replace_id = $_GET['replace_id'];
else $replace_id = $block_schema_id;

?>

<div class="clearfix preview_edit hidden" style="position: absolute; z-index:998; width:100%; margin-top:15px ">
	<div class="top_block" style=""> <!-- container -->
	<div class=" pull-left btn-toolbar">
	<button title="Поменять блок" type="button" class="btn btn-outline-dark " onclick="modal_dialog_open_constructor('choose_block_visual', 'block_schema_id=<?=$block_schema_id?>&category_id=<?=$block_cat_id?>&page_id=<?=$_GET['page_id']?>&theme_id=<?=$theme_id?>&replace_id=<?=$replace_id?>')">#<?=$block_id?> (<?=$block_schema_id?>) <i class="fas fa-caret-down"></i></button>
	&nbsp;
	&nbsp;
	
	<a href="#block_<?=$block_schema_id?>" title="Переместить вверх" 
	onclick="block_move('<?=$block_schema_id?>', 'up'); var wrapper = $(this).closest('div.block_schema'); wrapper.insertBefore(wrapper.prev()); "
	class="btn btn-outline-dark before_btn_sttngs"><i class="fa fa-arrow-up"></i></a>

	<a href="#block_<?=$block_schema_id?>" title="Переместить вниз"
	onclick="block_move('<?=$block_schema_id?>', 'down'); var wrapper = $(this).closest('div.block_schema'); wrapper.insertAfter(wrapper.next());"
	class="btn btn-outline-dark after_btn_sttngs"><i class="fa fa-arrow-down"></i></a>
	&nbsp;
	&nbsp;
		
  <button type="button" onclick="modal_dialog_open_constructor('block_edit_content', 'theme_id=<?=$theme_id?>&block_schema_id=<?=$block_schema_id?>&block_id=&ajax_load_block=1&page_id=<?=$_GET['page_id']?>')"  title="Содержимое" class="btn btn-outline-dark "><i class="fa fa-images"></i> Содержимое</button>
  
  <button type="button" onclick="modal_dialog_open_constructor('block_edit', 'theme_id=<?=$theme_id?>&block_schema_id=<?=$block_schema_id?>&block_id=<?=$block_id?>&ajax_load_block=1&page_id=<?=$_GET['page_id']?>')"  title="Настройки" class="btn btn-outline-dark "><i class="fa fa-cog"></i> Настройки</button>
  	
	</div>
	
		<div class="pull-right btn-toolbar">
  
  
<div class="dropdown ">
  <button class="btn btn-outline-dark dropdown-toggle" type="button" title="Удалить ряд"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fa fa-trash"></i>
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a onclick="block_delete('<?=$block_schema_id?>', '<?=$_GET['page_id']?>', '<?=$area?>'); return false;" class="dropdown-item" href="#">Удалить с этой страницы</a>
    <a onclick="block_delete_all('<?=$block_schema_id?>'); return false;" class="dropdown-item" href="#">Удалить <b>со всех страниц</b></a>
  </div>
</div>
			
		</div>

	</div>
</div>

