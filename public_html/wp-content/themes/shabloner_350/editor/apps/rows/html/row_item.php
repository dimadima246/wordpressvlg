<?php

if($_GET['area']) $area = $_GET['area'];

if($_GET['theme_id']) $theme_id = $_GET['theme_id'];


if($_GET['row_id']) $row_id = $_GET['row_id'];

if($choose_row != 1) 
{
	$row = db()->where('id', $row_id)->getOne('rows_schema');
}
else $row_id = $row['id'];


$layout = $row['layout'];


?>

<div id="row_<?=$row_id?>" class="card bottommargin-minier   ">
  <div class="card-header <?php if($choose_row != 1) echo 'cursor_move'; ?> sortable-handle">
  

<div class="pull-right btn-toolbar">
   <?php if($choose_row == 1) { ?>
  <button class="btn btn-success btn-sm " type="button" onclick="row_add_to_area('', '<?=$row['id']?>')">
    Добавить
  </button>
   <?php } ?>
  &nbsp;
  <button type="button" onclick="modal_dialog_open('row_edit', 'theme_id=<?=$theme_id?>&row_id=<?=$row_id?>')" data-toggle="tooltip" title="Настройки" class="btn btn-primary btn btn-sm"><i class="fa fa-cog"></i></button>
  &nbsp;
<div class="dropdown ">
  <button class="btn btn-danger btn-sm dropdown-toggle" type="button" title="Удалить ряд"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fa fa-trash"></i>
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a onclick="row_delete('<?=$row_id?>', '<?=$_GET['page_id']?>', '<?=$area?>'); return false;" class="dropdown-item" href="#">Удалить с этой страницы</a>
    <a onclick="row_delete_all('<?=$row_id?>'); return false;" class="dropdown-item" href="#">Удалить <b>со всех страниц</b></a>
  </div>
</div>

  </div>
  
   
   
  
<input type="hidden" name="areas[<?=$area?>][]" value="<?=$row_id?>" /> 
  
    <h4>
	Ряд <span class="badge badge-pill badge-primary">#<?=$row['id']?></span>
	<!--<b><?=str_replace(array(',', '_'), array(' + ', ' / '), $layout)?></b>-->
	</h4>
  </div>
  
  <div class="card-body">
  <input name="rows[<?=$area?>][<?=$row_id?>][layout]" value="<?=$layout ?>" type="hidden" />
  <div class="row ">
  
		<?php 
		$blocks = json_decode($row['blocks'], 1);
		
		foreach(explode(',', $layout) as $col_int => $column) { ?>
		<div class="col-md-<?=api('rows.type', $column)?>">
		
		<?php 
		$block = db()->where('id', $blocks[$col_int])->getOne('blocks_schema');
		$item = db()->where('id', $block['block_id'])->getOne('blocks');
		include(ROOT.'/apps/rows/html/block_item.php');
		?>
		
		</div>
		<?php } ?>
	  
  </div>
  
  </div>
</div>
