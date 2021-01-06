<?php 

$blocks = api('blocks.get', array('category_id' => $_GET['cat_id']));


?>

<div class="list-group">

<?php foreach($blocks['data'] as $block) {
if($block['image']) $image = HTTP_PATH.$block['image'];
else $image = '/files/images/block_default.png';
	?>
  <a data-block_id="<?=$block['id']?>" href="#" class="list-group-item list-group-item-action flex-column align-items-start block_id">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1"><?=$block['name']?></h5>
      <small>ID: <?=$block['id']?></small>
    </div>
    <p class="img_block">
	<img src="<?=$image?>" />
	</p>
    <!--<small>Donec id elit non mi porta.</small>-->
  </a>
<?php } ?>
  
</div>