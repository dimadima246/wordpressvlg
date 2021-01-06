<div class="content_item">

<button onclick="item_delete($(this))" class="btn btn-danger btn-xs pull-right">X</button>
		 <div class="form-group">
			<label for="title">Title</label>
			<input type="text" name="content[items][title][<?=$_GET['id']?>]" class="form-control" id="title" value="<?=$_GET['title']?>" >
		  </div>
		<div class="form-group">
			<label for="description">Text</label>
			<textarea name="content[items][description][<?=$_GET['id']?>]" class="form-control" id="text" rows="6"><?=$_GET['description']?></textarea>
		 </div>
		 <div class="form-group">
			<label for="image">Изображение</label>
			<?php if($_GET['image']) echo '<div class="img_block bottommargin-minier"><img src="'.$_GET['image'].'" /></div>';?>
			<input name="content[items][image][<?=$_GET['id']?>]" type="file" class="form-control" id="image" >
		  </div>
</div>
