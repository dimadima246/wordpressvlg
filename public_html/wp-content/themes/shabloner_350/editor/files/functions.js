function explode( delimiter, string ) {	// Split a string by string
	// 
	// +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// +   improved by: kenneth
	// +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)

	var emptyArray = { 0: '' };

	if ( arguments.length != 2
		|| typeof arguments[0] == 'undefined'
		|| typeof arguments[1] == 'undefined' )
	{
		return null;
	}

	if ( delimiter === ''
		|| delimiter === false
		|| delimiter === null )
	{
		return false;
	}

	if ( typeof delimiter == 'function'
		|| typeof delimiter == 'object'
		|| typeof string == 'function'
		|| typeof string == 'object' )
	{
		return emptyArray;
	}

	if ( delimiter === true ) {
		delimiter = '1';
	}

	return string.toString().split ( delimiter.toString() );
}


function infinite_scroll_init(selector)
{
	$('.ajax_items').remove();
	window.block = [];
	window.page = [];
	
	window.block[selector] = false;
	window.page[selector] = -1;
}

function infinite_scroll(form, container, ajax_path)
{
	$(".ajax-loader").show();
	
	if(window.block[form] == 2)
	{
		//alert('end');
		$(".ajax-loader").hide();
		return true;
	}
	
	if(window.block[form] == 0) 
	{
		window.block[form] = 1;
		window.page[form]++;
		$.ajax({
			type: "POST",
			url: ajax_path+'?page='+window.page[form],
			data: $('#'+form).serialize(),
			//dataType: 'json'
		})
		.done(function( data ) {
			$(".ajax-loader").hide();
			obj = explode('[delimiter]', data);
			var total = obj[0];
			var html = obj[1];
			
			$("#total_items").html(total);
			
			if(html) 
			{
				$("#"+container).append(html);
				window.block[form] = 0;
			}
			else window.block[form] = 2;
			
			//alert(window.page[form] );
		});
	}
	
}

function block_delete(id, redirect)
{
	
	if (confirm("Удалить блок № "+id+"?")) {
	$.ajax({
		type: "POST",
		url: "/ajax/api/blocks.delete_source",
		data: { 
				 id : id,
			     },
		dataType: 'json'
	})
	.done(function( data ) {
		if(redirect == 1) window.location.href='/blocks/?act=show';
		else $("#block_"+id).slideUp();
	});	
		
	} else {
	  //alert("Вы нажали кнопку отмена")
	}
}

function theme_delete(id, redirect)
{
	
	if (confirm("Удалить тему № "+id+"?")) {
	$.ajax({
		type: "POST",
		url: "/ajax/api/themes.delete",
		data: { 
				 id : id,
			     },
		dataType: 'json'
	})
	.done(function( data ) {
		if(redirect == 1) window.location.href='/themes/?act=show';
		else $("#theme_"+id).slideUp();
	});	
		
	} else {
	  //alert("Вы нажали кнопку отмена")
	}
}


function modal_dialog_open(dialog, params)
{
	
	if(!$('#'+dialog).length)
	{
		$('#dialogs').append('<div class="modal fade " id="'+dialog+'" tabindex="-1" role="dialog" aria-labelledby="dialog"><div class="modal-dialog" role="document"><div class="modal-content"></div></div></div>');
	}
	
	$('#'+dialog).modal();
	$('#'+dialog+' .modal-content').html('<center><img style="margin:50px 0px" src="files/images/ajax-loader.gif" /></center>');
	
	//else $('.modal-dialog').css('width', '550px'); 
   $.ajax({
		url: 'index.php?app=ajax&method=dialog&param='+dialog,
		cache: false,
		data: params,
		type: "GET",
	   success: function(html) {
		   $('#'+dialog+' .modal-content').html(html);
		   
		   var width = $('#'+dialog+' .modal-body').data('width');
		   if(width) $('#'+dialog+' .modal-dialog').css('width', width).css('max-width', width);
		   
	   }
  });
}


  
function page_delete(id)
{
	if (confirm("Вы уверены, что хотите удалить страницу? ")) {
		$.ajax({
			type: "POST",
			url: 'index.php?app=ajax&method=api&param=themes.page_delete',
			data: {
					  'id': id,
			},
			dataType: 'json'
		})
		.done(function( data ) {
			window.location.href='';
		});	
	}
}  

/*function sortableInit()
{
	sortable('.sortable', {
		forcePlaceholderSize: true,
		placeholderClass: 'ph-class bottommargin-minier', 
		handle: '.sortable-handle',
	});
}*/

function line_delete(var_this)
{
	var_this.closest('.form-row-block').remove();
}

function line_change_value(var_this)
{
	var val = var_this.val();
	var id = var_this.data('int');
	
	if(val == 'image') html = '<input  name="settings['+id+'][value]" type="file" class="form-control " placeholder="По умолчанию">';
	else if(val == 'select') html = '<div class="form-row"><div class="col"><input  name="settings['+id+'][options]" type="text" class="form-control " placeholder="Варианты выбора" /></div><div class="col"><input  name="settings['+id+'][value]" type="text" class="form-control " placeholder="По умолчанию" /></div></div>';
	else html = '<input  name="settings['+id+'][value]" type="text" class="form-control " placeholder="По умолчанию">';
	
	var_this.closest('.form-row-block').find('.value').html(html);
}

function move_before(selector) {
    var wrapper = $(this).closest(selector); wrapper.insertBefore(wrapper.prev());
   
}	

function move_after(selector) {
    var wrapper = $(this).closest(selector); wrapper.insertAfter(wrapper.next());
}	
