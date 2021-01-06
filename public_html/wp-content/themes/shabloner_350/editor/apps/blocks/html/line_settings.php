<?php //if(!$int) $int = $_GET['id'];
if($int == 0) $int =mt_rand(111111,999999); ?>
<div class="form-row-block">
<div class="form-row  ">
    <div class="col">
      <input name="settings[<?=$int?>][name]" type="text" class="form-control" placeholder="[macros_name]" value="<?=$_GET['name'].$item['name']?>">
    </div>
    <div class="col">
      <input name="settings[<?=$int?>][title]" type="text" class="form-control" placeholder="Название" value="<?=$_GET['title'].$item['title']?>">
    </div>
    <div class="col">
      <select data-int="<?=$int?>" onchange="line_change_value($(this))" name="settings[<?=$int?>][type]" name="type" class="form-control" >
		<option <?php if($_GET['type'].$item['type'] == 'text') echo 'selected="selected"'; ?> value="text">Текст</option>
		<option <?php if($_GET['type'].$item['type'] == 'textarea') echo 'selected="selected"'; ?> value="textarea">Текст (поле)</option>
		<option <?php if($_GET['type'].$item['type'] == 'select') echo 'selected="selected"'; ?> value="select">Выбор</option>
		<option <?php if($_GET['type'].$item['type'] == 'image') echo 'selected="selected"'; ?> value="image">Изображение</option>
	  </select>
    </div>
    <div class="col-md-6 value">
	<?php if($item['type'] == 'image') { ?>
	<?php if($item['file_path']) echo '<div class="img_block bottommargin-minier"><img src="'.HTTP_PATH.'/sources/themes/'.$_GET['theme_id'].'/files'$item['file_path'].'?'.time().'" /></div>';?>
		<input  name="settings[<?=$int?>][value]" type="file" class="form-control " placeholder="По умолчанию">
	<?php } elseif($item['type'] == 'select') { ?>
	<div class="form-row">
		<div class="col">
		<input  name="settings[<?=$int?>][options]" type="text" class="form-control col" placeholder="Варианты выбора" value="<?=$item['options']?>">
		</div>
		<div class="col">
		<input  name="settings[<?=$int?>][value]" type="text" class="form-control col" placeholder="По умолчанию" value="<?=$item['value']?>">
		</div>	
	</div>	
	<?php } else { ?>
		<input  name="settings[<?=$int?>][value]" type="text" class="form-control " placeholder="По умолчанию" value="<?=$item['value']?>">
	<?php } ?>
    </div>
    <div class="col" style="max-width:110px">
<div class="pull-right btn-toolbar">

<button type="button" title="Переместить вверх" 
onclick=" var wrapper = $(this).closest('.form-row-block'); wrapper.insertBefore(wrapper.prev()); "
class="btn btn-light btn-sm before_btn_sttngs"><i class="fa fa-arrow-up"></i></button>

<button type="button" title="Переместить вниз"
onclick="var wrapper = $(this).closest('.form-row-block'); wrapper.insertAfter(wrapper.next());"
class="btn btn-light btn-sm after_btn_sttngs"><i class="fa fa-arrow-down"></i></button>
&nbsp;

      <button onclick="line_delete($(this))" type="button" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
	  
	  
    </div>
	  
    </div>
	
</div>
<div class="form-row settings_line topmargin-minier">
    <div class="col">
      <input name="settings[<?=$int?>][description]" type="text" class="form-control form-control-sm" placeholder="Описание" value="<?=htmlspecialchars($_GET['description'].$item['description'])?>">
    </div>
</div>


</div>
