<?php

if($_GET['block_id']) $item = db()->where('id', $_GET['block_id'])->getOne('blocks');

if($_GET['col_int']) $col_int = $_GET['col_int'];
if($col_int == 0) $col_int = '0';


if($item['image']) $image = HTTP_PATH.$item['image'];
else $image = HTTP_PATH.'/files/images/block_default.png';

$block_id = $item['id'];

if($_GET['block_schema_id']) $block_num = $_GET['block_schema_id'];
else $block_num = $block['id'];

if($_GET['replace_id']) $replace_id = $_GET['replace_id'];
else $replace_id = $block_num;

if(!$block) $block = db()->where('id', $block_num)->getOne('blocks_schema');

$theme_id = $block['theme_id'];

?>

<div id="block_<?=$block['id']?>" class="card bottommargin-minier  block-item block_<?=$block['id']?> ">

<input type="hidden" name="areas[blocks][]" value="<?=$block_num?>" /> 

  <div class="card-header ">
  <div class="btn-toolbar pull-right">
  
  <?php if($choose_block == 1) { ?>
   <button class="btn btn-primary btn-xs " type="button" onclick="block_add_exists_to_area('<?=$block['id']?>','<?=$replace_id?>','<?=$_GET['no_replace']?>', '<?=$_GET['after_block_schema_id']?>')">
    Добавить
  </button>&nbsp;
  <?php } ?>
 
  <?php if($choose_block != 1) { ?>
	<button type="button" title="Переместить вверх" 
	onclick=" var wrapper = $(this).closest('.block-item'); wrapper.insertBefore(wrapper.prev()); "
	class="btn btn-light btn-xs before_btn_sttngs"><i class="fa fa-arrow-up"></i></button>

	<button type="button" title="Переместить вниз"
	onclick="var wrapper = $(this).closest('.block-item'); wrapper.insertAfter(wrapper.next());"
	class="btn btn-light btn-xs after_btn_sttngs"><i class="fa fa-arrow-down"></i></button>
	&nbsp;
  
  
  <button type="button" onclick="modal_dialog_open('block_edit_content', 'theme_id=<?=$theme_id?>&block_schema_id=<?=$block_num?>&block_id=<?=$block_id?>')"  title="Содержимое" class="btn btn-primary btn-xs "><i class="fa fa-images"></i></button>
  
  <button type="button" onclick="modal_dialog_open('block_edit', 'theme_id=<?=$theme_id?>&block_schema_id=<?=$block_num?>&block_id=<?=$block_id?>')"  title="Настройки" class="btn btn-primary btn-xs "><i class="fa fa-cog"></i></button>
  
  <button type="button" onclick="modal_dialog_open('choose_block', 'block_schema_id=<?=$block_num?>&category_id=<?=$item['category_id']?>&page_id=<?=$_GET['page_id']?>&replace_id=<?=$block_num?>')"   title="Заменить блок" class="btn btn-primary btn-xs "><i class="fa fa-exchange-alt"></i></button>
   <?php } ?>
  
<div class="dropdown ">
  <button class="btn btn-danger btn-xs dropdown-toggle" type="button" title="Удалить ряд"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fa fa-trash"></i>
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a onclick="block_delete('<?=$block['id']?>', '<?=$_GET['page_id']?>', '<?=$area?>'); return false;" class="dropdown-item" href="#">Удалить с этой страницы</a>
    <a onclick="block_delete_all('<?=$block['id']?>'); return false;" class="dropdown-item" href="#">Удалить <b>со всех страниц</b></a>
  </div>
</div>
 
  
  </div>
  
  
	<span class="pseudo-title "><b><?=api('blocks.get_cat_name', $item['category_id'])?></b></span> <span class="badge badge-pill badge-primary">#<?=$block_id?> (<?=$block['id']?>)</span>
	
  </div>
  
  <div class="card-body">
  
  <input name="rows[<?=$area?>][<?=$row_num?>][blocks][<?=$col_int?>][block_num]" value="<?=$block_num ?>" type="hidden" />
  <input name="rows[<?=$area?>][<?=$row_num?>][blocks][<?=$col_int?>][id]" value="<?=$block_id ?>" type="hidden" />
  
  <div class="img_block">
  <img src="<?=$image?>" />
  </div>
  

  </div>
</div>
