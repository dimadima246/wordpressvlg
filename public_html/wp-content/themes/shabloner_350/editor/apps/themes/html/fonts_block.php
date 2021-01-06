<div class="tabs tabs-alt tabs-tb clearfix ui-tabs ui-corner-all ui-widget ui-widget-content" id="">

	<ul class="tab-nav clearfix">
		<li><a href="#choose">Выбрать</a></li>
		<li><a href="#manual">Указать вручную</a></li>
	</ul>

	<div class="tab-container">

		<div class="tab-content clearfix" id="choose">
		<p>Выбрать шрифт по нужным параметрам можно на сайте <a target="_blank" href="https://fontstorage.com/ru/">https://fontstorage.com/ru/</a>. После этого укажите названия нужных шрифтов в полях ниже.</p>
		
			<div class="form-group">
				<label for="">Шрифт заголовков</label>
					<select name="settings[font_title_id]" id="font_title_id" type="text" class=" form-control fonts_id chosen-select"  >
					<!--
					<optgroup label="Популярные">
						<option value="">Fira Sans</option>
						<option value="">Roboto</option>
					</optgroup>
						<option disabled value="">-----</option>
						-->
						
					<?php foreach($fonts as $font) { ?>
						<option <?php if($font['id'] == $settings['font_title_id']) echo 'selected="selected"'; ?> value="<?=$font['id']?>" data-font-family="<?=$font['name']?>" data-slug="<?=$font['slug']?>"><?=$font['name']?></option>
					<?php } ?>
					</select>
			</div>
			
			<div class="form-group">
				<label for="">Шрифт текста</label>
					<select name="settings[font_text_id]" id="font_text_id" type="text" class=" form-control fonts_id chosen-select"  >
					<?php foreach($fonts as $font) { ?>
						<option <?php if($font['id'] == $settings['font_text_id']) echo 'selected="selected"'; ?> value="<?=$font['id']?>" data-font-family="<?=$font['name']?>" data-slug="<?=$font['slug']?>"><?=$font['name']?></option>
					<?php } ?>
					</select>
			</div>
			
			
			
		</div>
		
		<div class="tab-content clearfix" id="manual">
	<p>Вы можете подключить шрифты из библиотеки <a target="_blank" href="https://fonts.google.com">Google Fonts</a> или загрузить собственный шрифт. Для этого нужно указать ссылку на css-файл шрифтов и название шрифта (font-family). Смотрите подробную инструкцию <a target="_blank" href="http://shabloner.ru/page/manual_new#fonts">в справочном центре</a>.</p>

	<div class="form-group">
			<label for="">Шрифт заголовков</label>

			<div class="row" id="font_title_own">
			<div class="col-sm-4">
				<input name="settings[font_title]" type="text" class=" form-control fonts " id="font_title" placeholder="Название шрифта" value="<?=$settings['font_title']?>" >
			</div>	
			<div class="col-sm">
				<input name="settings[font_title_path]" type="text" class=" form-control fonts col" id="font_title_path" placeholder="Ссылка на CSS файл шрифта заголовков" value="<?=$settings['font_title_path']?>" >
			</div>	
			</div>
			
			
			
		</div>
		
		<div class="form-group">
			<label for="">Шрифт текста</label>
			
			<div class="row" id="font_text_own">
			<div class="col-sm-4">
			
				<input name="settings[font_text]" type="text" class="bottommargin-minier form-control fonts" id="font_text" placeholder="Название шрифта" value="<?=$settings['font_text']?>" >
			</div>	
			<div class="col-sm">
				
				<input name="settings[font_text_path]" type="text" class="form-control fonts" id="font_text_path" placeholder="Ссылка на CSS файл основного шрифта" value="<?=$settings['font_text_path']?>" >
			</div>	
			</div>
				
		 </div>
		

		
		
		</div>

	</div>

</div>

