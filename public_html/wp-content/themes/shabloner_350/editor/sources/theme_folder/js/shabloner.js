
function menu_extra_elements()
{
	var $menu_main = $('.extra_menu_container ul:first-child');
	
	var container_width = $('.container').width();
	var menu_width = $menu_main.width();
	$($menu_main.children('li:not(#extra_elements)')).each(function (index, value) {
		var menu_width = $menu_main.width();
			
		console.log(container_width+' | '+menu_width);	
			
		if((container_width == 1140 && menu_width > 700) ||
		(container_width == 940 && menu_width > 500))
		{
			if($('#extra_elements').length == '0') $menu_main.append('<li id="extra_elements" class="menu-item submenu"><a href="#"><div>...</div></a><ul class="submenu"></ul></li>');
			$('#extra_elements .submenu').prepend($menu_main.children('li:not(#extra_elements)').last());
		}
	});
	
}


// margintop_auto
function margintop_auto() {
	var parent_height = $('.vertical-middle,.vertical-middle-auto').height();
	var margintop_height = $('.margintop-auto').height();
	var margin_top = ((parent_height - margintop_height) / 2) - 10;
	$('.margintop-auto').css('margin-top', margin_top+'px')
}


function vertical_middle()
{
	var height = $('.vertical-middle-auto').height();
	var margin_top = height/2;
	console.log(height+' / '+margin_top);
	$('.vertical-middle-auto').css('width', '100%').css('margin-top', '-'+margin_top+'px').css('position', 'absolute').css('top', '50%');
}

vertical_middle();
vertical_middle();

margintop_auto();

$(function() {
	//margintop_auto();
	//vertical_middle();
	menu_extra_elements();
});

$(window).resize(function() {
	menu_extra_elements();
});

$('.has-children, .menu-item-has-children').click(function() {
	if($(this).data('opened') != true) 
	{
		$(this).data('opened', true);
		return false;
	}
	else return true;

});

$('ul:not(.sub-menu):not(.demo-site) > li.menu-item-has-children > a').append('&nbsp;<i class="icon-angle-down"></i>'); 

$('.sub-menu li:not(.has-children) > a').click(function() {
window.location.href=$(this).attr('href');
});

$('.current-page-parent, .current-menu-item').addClass('current');

function modal_dialog_open(url)
{
	
	var dialog = 'dialog';
	var loading_html = '<center style="margin:50px 0px" class="text-muted">Загрузка...</center>';
	
	$('#'+dialog).modal();
	$('#'+dialog+' .modal-content').html(loading_html);
	
	//else $('.modal-dialog').css('width', '550px'); 
   $.ajax({
		url: url,
		cache: false,
		//data: params,
		type: "GET",
	    success: function(html) {
		   $('#'+dialog+' .modal-content').html(html);
		   
		   var width = $('#'+dialog+' .modal-body').data('width');
		   if(width) $('#'+dialog+' .modal-dialog').css('width', width).css('max-width', width);
		   
		   var $form = $('#'+dialog+' form');
		   
		   $form.submit(function(e) {
			   e.preventDefault;
			   var data = $form.serialize();
			   $('#'+dialog+' .modal-content').html('<center style="margin:50px 0px" class="text-muted">Отправка...</center>');
			   
			   // Отправка формы
			   $.ajax({
					url: $form.data('url'),
					cache: false,
					data: data,
					type: "POST",
					success: function(html) {
						$('#'+dialog+' .modal-content').html('<center style="margin:50px 0px" class="text-success">Ваша заявка принята!</center>');
					}
			   });
			   
			   
			   return false;
		   });
		   
	   }
  });
}

$('.dialog_open').bind('click', function() {
	modal_dialog_open($(this).data('url'));
});

$('.ajax_form').submit(function(e) {
	e.preventDefault;
	$form = $(this);
	
   var data = $form.serialize();
   
   // Отправка формы
   $.ajax({
		url: $form.data('url'),
		cache: false,
		data: data,
		type: "POST",
		success: function(html) {
			alert('Ваша заявка принята!');
			window.location.href='';
		}
   });
	
	return false;
});




