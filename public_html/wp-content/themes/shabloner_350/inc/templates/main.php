<?php

if($_POST)
{
	//echo '<pre>'; print_r($_POST); echo '</pre>'; 
	
	if($_POST['options'])
	{
		foreach($_POST['options'] as $name => $value)
		{
			$id = db()->where('option_name', $name)->getValue('options', 'option_id');
			$data = array('option_name' => $name, 'option_value' => $value);
			if($id) db()->where('option_id', $id)->update('options', $data);
			else db()->insert('options', $data);
			
			// Если это почты
			if($name == 'emails')
			{
				write(get_template_directory().'/emails.txt', $value);
			}
			
			// Если это код
			if($name == 'shcode')
			{
				write(get_template_directory().'/shcode.txt', $value);
			}
			
			// Если это главный шрифт
			/*if($name == 'font_title' || $name == 'font_text')
			{
				$font = db()->where('name', $value)->getOne('fonts');
				if($font['id'])
				{
					$options[$name.'_path'] = 'http://shabloner.ru/fonts/'.$font['slug'].'/'.$font['slug'].'.css';
				}
			}*/
		}
		$saved = 1;
	}
	

		
	
}

//$res = db()->get('options', array(0, 99));
$options = array();
if($res) foreach($res as $item) $options[$item['name']] = $item['value'];


?>

<h1 class="display-4">Настройки темы</h1>


<hr>

<?php if($saved == 1) { ?>
<div class="alert alert-success"><i class="fas fa-check-circle"></i> Изменения сохранены!</div>
<?php } ?>

<!--<a class="btn btn-success btn-lg " style="color:#fff"><i class="fas fa-cubes"></i> Визуальный редактор</a>

<hr>-->

	 
<form action="" method="POST" enctype="multipart/form-data">
<div class="row">
    <div class="col-sm">

		<div class="form-group">
			<label for="">Адрес компании</label>
			
				<div class="input-group ">
				  <div class="input-group-prepend">
					<span class="input-group-text" id=""><i class="fas fa-map-marker-alt"></i></span>
				  </div>
				<input name="options[address]" type="text" class="form-control " id="name" placeholder="Например: Москва, ул. Тверская 17, стр. 1" value="<?php if($saved == 1) echo $_POST['options']['address']; else echo get_option('address')?>" >
				</div>		
				
			<small class="form-text text-muted"></small>
				
		 </div>
	
				
	
		<div class="form-group">
			<label for="">Контактный телефон</label>
				
				<div class="input-group ">
				  <div class="input-group-prepend">
					<span class="input-group-text" id=""><i class="fas fa-phone"></i></span>
				  </div>
				<input name="options[phone]" type="text" class=" form-control fonts" id="name" placeholder="Например: +7 (495) 775-25-25" value="<?php if($saved == 1) echo $_POST['options']['phone']; else echo get_option('phone')?>" >
				</div>		
				
		 </div>
	
	
	
	
		<div class="form-group">
			<label for="">Контактный E-mail</label>
				
				<div class="input-group ">
				  <div class="input-group-prepend">
					<span class="input-group-text" id=""><i class="far fa-envelope"></i></span>
				  </div>
				<input name="options[prdvg_email]" type="text" class=" form-control fonts" id="name" placeholder="Например: user@mail.ru" value="<?php if($saved == 1) echo $_POST['options']['prdvg_email']; else echo get_option('prdvg_email')?>" >
				</div>		
				
				
		 </div>
	
	
		<div class="form-group">
			<label for="">Дни и часы работы</label>
			
				
				<div class="input-group ">
				  <div class="input-group-prepend">
					<span class="input-group-text" id=""><i class="far fa-clock"></i></span>
				  </div>
				<input name="options[schedule]" type="text" class=" form-control fonts" id="name" placeholder="Например: Ежедневно: с 09-00 до 20-00" value="<?php if($saved == 1) echo $_POST['options']['schedule']; else echo get_option('schedule')?>" >
				</div>		
				
		 </div>
	
	
	</div>
    <div class="col-sm">
		<div class="form-group">
			<label for="">Почтовые адреса для заявок с форм</label>
			
			<textarea style="height:200px" name="options[emails]" class="form-control"><?=file_get_contents(get_template_directory().'/emails.txt')?></textarea>
			<small class="text-muted">Почтовые адреса, на которые вы хотите принимать заявки с форм. Каждый адрес с новой строки. Следите за тем, чтобы не было лишних пробелов и других символов, не относящихся к почтовым ящикам.</small>
			
		 </div>
		 		 
    </div>
	    <div class="col-sm">
		<div class="form-group">
			<label for="">HTML-код для счетчиков, виджетов, чатов и т.д.</label>
			
			<textarea style="height:200px" name="options[shcode]" class="form-control"><?=stripslashes(file_get_contents(get_template_directory().'/shcode.txt'))?></textarea>
			<small class="text-muted">Код из этого поля будет отображаться на каждой странице шаблона перед закрывающим тегом &lt;/body&gt;</small>
			
		 </div>
		 		 
    </div>
	
</div>


<hr>



<button class="btn btn-primary" type="submit">Сохранить</button>

</form>  

