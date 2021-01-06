<?php
//echo '<pre>'; print_r($data['content']); echo '</pre>'; 
?>
<div class="row">
    <div class="col-sm">
		 <div class="form-group">
			<label for="title">Заголовок</label>
			<input name="content[title]" type="text" class="form-control" id="title" value="<?=$data['content']['title']?>" >
		  </div>
		  
		 <!--<div class="form-group">
			<label for="text">Description</label>
			<input type="text" class="form-control" id="text" >
		  </div>-->
		<div class="form-group">
			<label for="text">Текст</label>
			<textarea name="content[text]" class="form-control" id="text" rows="6"><?=$data['content']['text']?></textarea>
		 </div>
		 
		 <div class="form-group">
			<label for="title">Текст кнопки</label>
			<input name="content[button_text]" type="text" class="form-control" id="button_text" value="<?=$data['content']['button_text']?>" >
		  </div>
		  
		 <div class="form-group">
			<label for="title">Ссылка</label>
			<input name="content[url]" type="text" class="form-control" id="url" value='<?=$data['content']['url']?>' >
			<!--<small class="form-text text-muted">modal_dialog_open("[template_directory]/forms/basic.php");</small>
			<small class="form-text text-muted">window.location.href="http://google.com"</small>-->
		  </div>
		  
    </div>
    <div class="col-sm">
		 <div class="form-group">
			<label for="image">Изображение</label>
	<?php if($data['content']['file_path']) { ?><div class="img_block bottommargin-minier"><img class="" src="<?=$data['content']['file_path'].'?'.mt_rand(11111,99999)?>" /></div><?php } ?>
			<input name="content[image]" type="file" class="form-control" id="image" >
		  </div>
	
		<div class="form-check ">
			<input name="content[delete_bg]" id="delete_bg" type="checkbox" class="form-check-input" value="1">
			<label class="form-check-label" for="delete_bg">Удалить фон</label>
		</div>
	
    </div>

</div>


<h4 >Элементы</h4>

<div id="content_items" class="clearfix">

<div class="" id="content_ghost_block">

<?php if($data['content']['items']) foreach($data['content']['items']['title'] as $int => $title) include(ROOT.'/apps/blocks/html/content_item.php'); ?>


</div>  


</div>

<button type="button" onclick="content_item_add()" class="btn btn-block btn-light">Добавить</button>

<script>
function move_blocks_init() {

$('.before_btn').on('click', function(e) {
    var wrapper = $(this).closest('.content_item')
    wrapper.insertBefore(wrapper.prev())
})
$('.after_btn').on('click', function(e) {
    var wrapper = $(this).closest('.content_item')
    wrapper.insertAfter(wrapper.next())
})
}

move_blocks_init();

//sortableInit();

function item_delete(var_this)
{
	var_this.closest('.content_item').remove();
}

function content_item_add(id, title, text, url, image, button_text, field_1, field_2)
{
	$.ajax({
		type: "GET",
		url: "/ajax/app",
		data: { 
				 html : 'content_item.php',
				 app : 'blocks',
				 id : id,
				 title : title,
				 text : text,
				 url : url,
				 image : image,
				 
				 button_text : button_text,
				 field_1 : field_1,
				 field_2 : field_2,
			     },
		//dataType: 'json'
	})
	.done(function( data ) {
		$("#content_ghost_block").append(data);
		move_blocks_init();
	});	
}

<?php for($i=0; $i<(3 - count($data['content']['items'])); $i++) { ?> 
content_item_add('<?=$i?>'); 
<?php } ?>


</script>


