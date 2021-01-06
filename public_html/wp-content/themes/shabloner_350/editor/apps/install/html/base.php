
<div class="row">
    <div class="col-sm">
		<div class="row">
		<div class="form-group col">
			<label for="">Адрес компании</label>
			
				<div class="input-group ">
				  <div class="input-group-prepend">
					<span class="input-group-text" id=""><i class="fas fa-map-marker-alt"></i></span>
				  </div>
				<input name="options[address]" type="text" class="form-control " id="name" placeholder="Например: Москва, ул. Тверская 17, стр. 1" value="<?php if($saved == 1) echo $_POST['options']['address'];  else echo get_option_wp('address')?>" >
				</div>		
				
			<small class="form-text text-muted"></small>
				
		 </div>
		 </div>
	
				
		<div class="row">
		<div class="form-group col">
			<label for="">Контактный телефон</label>
				
				<div class="input-group ">
				  <div class="input-group-prepend">
					<span class="input-group-text" id=""><i class="fas fa-phone"></i></span>
				  </div>
				<input name="options[phone]" type="text" class=" form-control fonts" id="name" placeholder="Например: +7 (495) 775-25-25" value="<?php if($saved == 1) echo $_POST['options']['phone'];  else echo get_option_wp('phone')?>" >
				</div>		
				
		 </div>
		 </div>
	
	
		<div class="row">
		<div class="form-group col">
			<label for="">Контактный E-mail</label>
				
				<div class="input-group ">
				  <div class="input-group-prepend">
					<span class="input-group-text" id=""><i class="far fa-envelope"></i></span>
				  </div>
				<input name="options[prdvg_email]" type="text" class=" form-control fonts" id="name" placeholder="Например: user@mail.ru" value="<?php if($saved == 1) echo $_POST['options']['prdvg_email'];  else echo get_option_wp('prdvg_email')?>" >
				</div>		
				
				
		 </div>
		 </div>
		<div class="row">
		<div class="form-group col">
			<label for="">Дни и часы работы</label>
			
				
				<div class="input-group ">
				  <div class="input-group-prepend">
					<span class="input-group-text" id=""><i class="far fa-clock"></i></span>
				  </div>
				<input name="options[schedule]" type="text" class=" form-control fonts" id="name" placeholder="Например: Ежедневно: с 09-00 до 20-00" value="<?php if($saved == 1) echo $_POST['options']['schedule'];  else echo get_option_wp('schedule')?>" >
				</div>		
				
		 </div>
		 </div>
<hr>		 

	<div class="row">
	

	
		<div class="form-group col">
			<label for="color1">Основной цвет</label>
			<input name="settings[color]" type="text" class="colors form-control" id="color1" placeholder="Цвет" value="<?=$settings['color']?>" >		
		</div>
		
		
		<div class="form-group col hidden_stretched hidden">
			<label for="color1">Цвет фона</label>
			<input name="settings[bg_color]" type="text" class="colors form-control" id="bg_color" placeholder="Цвет" value="<?php if(!$settings['bg_color']) echo '#F5F5F5';  else echo $settings['bg_color'];?>" >	
			<span class="form-text text-muted">Указывается, если убрана галочка "Ширина на весь экран".</span>
			
		</div>
		
	</div>
		
			
		<hr>
	
		<p class="bottommargin-minier">Если хотите, чтобы ширина сайта была на весь экран, а не по размеру контейнера - отметьте эту галочку.</p>
		
		<div class="form-check " onclick="stretched_check()">
			<input value="1" name="settings[stretched]" <?php if($settings['stretched'] == 1) echo 'checked="checked"';?> type="checkbox" class="form-check-input" id="stretched">
			<label class="form-check-label" for="stretched">Ширина на весь экран</label>
		  </div>
	

	<div id="" class="hidden_stretched hidden">
		<hr>
	
	<?php $padding = array(0,15,30,45,60,75,90); ?>
	
	<div class="row">
		<div class="form-group col">
			<label for="font_size">Отступ сверху</label>
			<select class="form-control" name="settings[padding_top]">
			<?php foreach($padding as $val) { ?>
			<option <?php if($settings['padding_top'] == $val) echo 'selected="selected"'; ?> value="<?=$val?>"><?=$val?>px</option>
			<?php } ?>
			</select>
		</div>
		
	
		<div class="form-group col">
			<label for="font_size">Отступ снизу</label>
			<select class="form-control" name="settings[padding_bottom]">
			<?php foreach($padding as $val) { ?>
			<option <?php if($settings['padding_bottom'] == $val) echo 'selected="selected"'; ?> value="<?=$val?>"><?=$val?>px</option>
			<?php } ?>
			</select>
		</div>
		</div>
		
		<hr>
	<div class="form-group">
			<label for="image">Изображение фона</label>
			<?php if($data['bg_image']) { ?><div class="img_block bottommargin-minier"><img class="" src="<?=HTTP_PATH.$data['bg_image']?>" /></div>
		 
		 <div class="form-check bottommargin-minier" >
			<input value="1" name="settings[bg_delete]" type="checkbox" class="form-check-input" id="bg_delete">
			<label class="form-check-label text-danger" for="bg_delete">Удалить</label>
		  </div>

			
			<?php } ?>
			<input name="bg_image" type="file" class="form-control" id="bg_image" >
			<span class="form-text text-muted">Это изображение будет отображаться на фоне, позади основного содержимого сайта.</span>
		</div>

		
		
	</div>	
		<hr>
	

		<div class="form-group ">
			<label for="font_size">Стиль кнопок по умолчанию</label>
			<select class="form-control" name="settings[default_button_class]">
			<?php
			$buttons = array(
									 '' => 'Обычный',
									 'button-3d' => '3d-кнопки',
									 'button-border' => 'Кнопки с контуром',
									 'button-border-thin' => 'Кнопки с тонким контуром',
									 'button-circle' => 'Округлые кнопки',
									 'button-circle' => 'Округлые кнопки',
									 'button-circle button-3d' => 'Округлые 3d-кнопки',
									 'button-circle button-3d button-border' => 'Округлые 3d-кнопки с контуром',
									 'button-circle button-border' => 'Округлые кнопки с контуром',
									 'button-fill' => 'Кнопки с эффектом заполнения',
									 );

			foreach($buttons as $val => $title) { ?>
			<option <?php if($settings['default_button_class'] == $val) echo 'selected="selected"'; ?> value="<?=$val?>"><?=$title?></option>
			<?php } ?>
			</select>
		</div>
		

	
	
	

    </div>
	
	
	<?php $fonts = db()->groupBy('name', 'asc')->get('fonts', array(0,999)); ?>

    <div class="col-sm">
			<label for="">Шрифты</label>
	
		<?php include($_APP['folder'].'/html/fonts_block.php'); ?>
		<hr>
		 
		<div class="form-group ">
			<label for="font_size">Размер шрифта основного текста</label>
			<select name="settings[font_size]" id="font_size" class="form-control">
			<?php for($i=9;$i<31;$i++) { ?>
			<option <?php if($settings['font_size'] == $i) echo 'selected="selected"'; ?> value="<?=$i?>"><?=$i?>px</option>
			<?php } ?>
			</select>
		</div>
		<hr>
		<div class="form-group">
			<label for="">Почтовые адреса для заявок с форм</label>
			
			<textarea style="height:200px" name="options[emails]" class="form-control"><?=file_get_contents(ROOT.'/../emails.txt')?></textarea>
			<small class="text-muted">Почтовые адреса, на которые вы хотите принимать заявки с форм. Каждый адрес с новой строки. Следите за тем, чтобы не было лишних пробелов и других символов, не относящихся к почтовым ящикам.</small>
			
		 </div>
		 		 
	 
		 
		 
		 
    </div>
	
	
	
</div>


<script>



$(".chosen-select").chosen();


function fonts_preview()
{
	
	$('#title_font_inc').attr('href', $('#font_title_path').val());
	$('#font_title_preview').css('font-family', $('#font_title').val());
	
	$('#text_font_inc').attr('href', $('#font_text_path').val());
	$('#font_text_preview').css('font-family', $('#font_text').val());
	
	$('#text_add_inc').attr('href', $('#font_add_path').val());
	$('#font_add_preview').css('font-family', $('#font_add').val());
	
	$('#font_text_preview, #font_add_preview').css('font-size', $('#font_size').val()+'px');
	
	console.log($('#font_size').val());
	
}

fonts_preview();

function fonts_preview_init()
{
	$('#font_title_path').change(fonts_preview);
	$('#font_text_path').change(fonts_preview);
	$('#font_add_path').change(fonts_preview);
	
	$('#font_title').change(fonts_preview);
	$('#font_text').change(fonts_preview);
	$('#font_add').change(fonts_preview);
	
	$('#font_title_id').change(fonts_choose);
	$('#font_text_id').change(fonts_choose);
	$('#font_add_id').change(fonts_choose);
	
	$('#font_size').change(fonts_preview);
	
}




function fonts_choose()
{
	var font_title = $('#font_title_id option:selected').data('font-family');
	var title_slug = $('#font_title_id option:selected').data('slug');
	var font_title_link = '<?=HTTP_PATH?>/files/fonts/' + title_slug + '/' +title_slug+ '.css';
	
	var font_text = $('#font_text_id option:selected').data('font-family');
	var text_slug = $('#font_text_id option:selected').data('slug');
	var font_text_link = '<?=HTTP_PATH?>/files/fonts/' + text_slug + '/' +text_slug+ '.css';
	
	var font_add = $('#font_add_id option:selected').data('font-family');
	var add_slug = $('#font_add_id option:selected').data('slug');
	var font_add_link = '<?=HTTP_PATH?>/files/fonts/' + add_slug + '/' +add_slug+ '.css';
	
	$('#font_title').val(font_title);
	$('#font_title_path').val(font_title_link);
	
	$('#font_text').val(font_text);
	$('#font_text_path').val(font_text_link);
	
	$('#font_add').val(font_add);
	$('#font_add_path').val(font_add_link);
	
	fonts_preview();

}

fonts_preview_init();


function colors_init()
{
	$.each( $('.colors'), function( key, value ) {
		var id = $(this).data('id');
		var val = $(this).val();
		$('#color_'+id).css('color', val);
	});
	
}

$('.colors').bind('change', colors_init);

function stretched_check()
{
	if($("#stretched").is(':checked')) $('.hidden_stretched').addClass('hidden');
	else $('.hidden_stretched').removeClass('hidden');
}

$(".colors").each(function(i,e){
	new MaterialColorPickerJS($(e)[0]);
});

$('.colors').bind('change', colors_init);

stretched_check();
colors_init();

$( function() {
	
    /*$( "#category" ).autocomplete({
      source: availableTags
    });*/
	
    var fonts = [
<?php foreach(api('themes.get_fonts') as $item) { ?>
"<?=$item['name']?>", 
<?php }  ?>
    ];
    /*$( ".fonts" ).autocomplete({
      source: fonts
    });*/
	
  } );
</script>