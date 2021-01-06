<div class="form-row settings_line">
    <div class="col">
      <input name="settings[name][<?=$_GET['id']?>]" type="text" class="form-control" placeholder="[macros_name]" value="<?=$_GET['name']?>">
    </div>
    <div class="col">
      <input name="settings[title][<?=$_GET['id']?>]" type="text" class="form-control" placeholder="Название" value="<?=$_GET['title']?>">
    </div>
    <div class="col">
      <select onchange="line_change_value($(this))" name="settings[type][<?=$_GET['id']?>]" name="type" class="form-control" >
		<option <?php if($_GET['type'] == 'text') echo 'selected="selected"'; ?> value="text">Текст</option>
		<option <?php if($_GET['type'] == 'select') echo 'selected="selected"'; ?> value="text">Выбор</option>
		<option <?php if($_GET['type'] == 'image') echo 'selected="selected"'; ?> value="image">Изображение</option>
	  </select>
    </div>
    <div class="col-md-6 value">
	<?php if($_GET['type'] == 'image') { ?>
	<?php if($_GET['value_val']) echo '<div class="img_block bottommargin-minier"><img src="'.$_GET['value_val'].'" /></div>';?>
		<input  name="settings[value][<?=$_GET['id']?>]" type="file" class="form-control " placeholder="По умолчанию">
	<?php } else { ?>
		<input  name="settings[value][<?=$_GET['id']?>]" type="text" class="form-control " placeholder="По умолчанию" value="<?=$_GET['value_val']?>">
	<?php } ?>
    </div>
    <div class="col-md-1">
      <button onclick="line_delete($(this))" type="button" class="btn btn-danger">X</button>
    </div>
	
</div>
