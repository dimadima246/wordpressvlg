<?php if($res['data']) { foreach($res['data'] as $item) {

if($item['image']) $image = $item['image'];
else $image = '/files/images/theme_default.png';

$link = '/themes/?act=edit&id='.$item['id'];

?>
<div class="ajax_items block_item bottommargin-minier" id="theme_<?=$item['id']?>">
	<div class="row">
		<div class="col-md-4"><a href="<?=$link ?>"><img src="<?=$image?>"/></a></div>
		<div class="col">
		
		<div class="">
		<span class="pull-right"><?=$item['id']?></span>
			<h4 class="card-title"><a href="<?=$link ?>"><?=$item['name']?></a></h4>
			<div class="card-text bottommargin-xs"><?=$item['description']?></div>
			<a href="<?=$link ?>" class="btn btn-primary blue">Редактировать</a>
			<button onclick="theme_delete(<?=$item['id']?>)" type="button" class="btn btn-light">Удалить</button>
		</div>

  </div>
	</div>

</div>
<?php }} ?>
