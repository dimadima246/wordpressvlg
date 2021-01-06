<?php $fonts = db()->groupBy('name', 'asc')->get('fonts', array(0,999)); ?>

<div class="row">
    <div class="col-sm">
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
		
		 
    </div>
	
    <div class="col-sm">
			
		<link id="title_font_inc" href="" rel="stylesheet">
		<link id="text_font_inc" href="" rel="stylesheet">
		<link id="text_add_inc" href="" rel="stylesheet">

		
		<label class="bottommargin-minier">Просмотр шрифта заголовков</label>
		<div class="font_preview bottommargin-xs">

		<h4 title="Шрифт заголовка" id="font_title_preview" class="nobottommargin">Съешь ещё этих мягких французских булок, да выпей же чаю.</h4>

		</div>	
	<hr>
		<label class="bottommargin-minier">Просмотр основного шрифта</label>
		<div class="font_preview bottommargin-xs">

		<p title="Шрифт текста" id="font_text_preview" class="nobottommargin">Съешь ещё этих мягких французских булок, да выпей же чаю.</p>

		</div>	
	<hr>
		<label class="bottommargin-minier">Просмотр дополнительного шрифта</label>
		<div class="font_preview bottommargin-xs">

		<p title="Шрифт текста" id="font_add_preview" class="nobottommargin">Съешь ещё этих мягких французских булок, да выпей же чаю.</p>

		</div>	

		
    </div>
	
	
</div>

<script>

function colors_init()
{
	$.each( $('.colors'), function( key, value ) {
		var val = $(this).val();
		$(this).css('background-color', val);
	});
	
}

colors_init();


$(".colors").each(function(i,e){
	new MaterialColorPickerJS($(e)[0]);
});

$('.colors').bind('change', colors_init);


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

</script>