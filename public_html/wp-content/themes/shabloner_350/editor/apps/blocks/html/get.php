<?php if($res['data']) { foreach($res['data'] as $item) {

if($item['image']) $image = $item['image'];
else $image = '/files/images/block_default.png';

$link = '/blocks/?act=edit&id='.$item['id'];

?>
<div class="ajax_items block_item bottommargin-minier" id="block_<?=$item['id']?>">
	<div class="row">
		<div class="col-md-6"><a href="<?=$link ?>"><img src="<?=$image?>"/></a></div>
		<div class="col">
		
		<div class="">
		<span class="pull-right"><?=$item['id']?></span>
			<h4 class="card-title"><a href="<?=$link ?>"><?=$item['name']?></a></h4>
			<div class="card-text"><?=$item['description']?></div>
			<div class="card-text">
			Категория: <b><?=api('blocks.get_cat_name', $item['category_id'])?></b>
			</div>
			<div class="topmargin-xs">
			<a href="<?=$link ?>" class="btn btn-primary ">Редактировать</a>
	<button onclick="modal_dialog_open('block_copy', 'id=<?=$item['id']?>')" class="btn btn-success" type="button">Копировать</button>
			<button onclick="block_delete(<?=$item['id']?>)" type="button" class="btn btn-light">Удалить</button>
		</div>
		</div>

  </div>
	</div>

</div>
<?php }} ?>
