

$('#panelka').on('mouseover', function() {
	window.panelka_focus = true;
});

$('#panelka').on('mouseout', function() {
	window.panelka_focus = false;
});


$('body').on('click', function() {
	// Убрать панельку
	if(window.panelka_focus == false) $('#panelka').slideUp();
});

//document.execCommand("defaultParagraphSeparator", false, "p");

$('#btn_bold').on('click', function() { 
	document.execCommand('bold', false, null);
});

$('#btn_italic').on('click', function() { 
	document.execCommand('italic', false, null);
});

$('#btn_underline').on('click', function() { 
	document.execCommand('underline', false, null);
});

$('#btn_strikethrough').on('click', function() { 
	document.execCommand('strikeThrough', false, null);
});

$('#btn_color').on('click', function() { 
	modal_dialog_open_constructor('color_picker');
});

$('#btn_link').on('click', function() { 

	/*var selObj = window.getSelection();
	
	var selRange = selObj.getRangeAt(0);
	console.log(selRange);*/
	
	//$('#link_selection').val(selObj.toString());
	modal_dialog_open_constructor('link_add');
	
	//selectAndHighlightRange('current_editor', '2', '8')
	
	window.savedSel = saveSelection();
	
});


$('#btn_unlink').on('click', function() { 
	document.execCommand('unlink', false, false);
});


$('#clear_html').on('click', function() { 
	document.execCommand('removeFormat', false, null);
	
	var replacement = window.getSelection();
	console.log(replacement);
	//alert(replacement);
	
	replaceSelectedText((replacement.toString()));
	
});



var getComputedDisplay = (typeof window.getComputedStyle != "undefined") ?
    function(el) {
        return window.getComputedStyle(el, null).display;
    } :
    function(el) {
        return el.currentStyle.display;
    };

function replaceWithOwnChildren(el) {
    var parent = el.parentNode;
    while (el.hasChildNodes()) {
        parent.insertBefore(el.firstChild, el);
    }
    parent.removeChild(el);
}


function removeSelectionFormatting() {
    var sel = rangy.getSelection();

    if (!sel.isCollapsed) {
        for (var i = 0, range; i < sel.rangeCount; ++i) {
            range = sel.getRangeAt(i);

            // Split partially selected nodes 
            range.splitBoundaries();

            // Get formatting elements. For this example, we'll count any
            // element with display: inline, except <br>s.
            var formattingEls = range.getNodes([1], function(el) {
                return el.tagName != "BR" && getComputedDisplay(el) == "inline";
            });

            // Remove the formatting elements
            for (var i = 0, el; el = formattingEls[i++]; ) {
                replaceWithOwnChildren(el);
            }
        }
    }
}


window.savedSel = 0;

function saveSelection() {
    if (window.getSelection) {
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            var ranges = [];
            for (var i = 0, len = sel.rangeCount; i < len; ++i) {
                ranges.push(sel.getRangeAt(i));
            }
            return ranges;
        }
    } else if (document.selection && document.selection.createRange) {
        return document.selection.createRange();
    }
    return null;
}

function restoreSelection(savedSel) {
    if (savedSel) {
        if (window.getSelection) {
            sel = window.getSelection();
            sel.removeAllRanges();
            for (var i = 0, len = savedSel.length; i < len; ++i) {
                sel.addRange(savedSel[i]);
            }
        } else if (document.selection && savedSel.select) {
            savedSel.select();
        }
    }
}


function clearSelection() {
	if (window.getSelection) {
	  window.getSelection().removeAllRanges();
	} else { // старый IE
	  document.selection.empty();
	}
}
  
function setLink(href, target)
{
	document.execCommand('unlink', false, false);
	
	var replacement = window.getSelection();
	
	var code = '<a href="'+href+'"'
	
	if(target == 1) code += ' target="_blank"';
	
	code += '>'+replacement+'</a>';
	
	replaceSelectionWithHtml(code);
	//saveContent();
	
	clearSelection();
	return false;
}

function setFont(font)
{
	//document.execCommand('removeFormat', false, null);
	var replacement = window.getSelection();
	if(!font) font = 'Arial';
	var code = '<span style="font-family:'+font+'">'+replacement.toString()+'</span>';
	replaceSelectionWithHtml(code);
	saveContent();
	clearSelection();
	return false;
}

function setFontColor(color)
{
	//document.execCommand('removeFormat', false, null);
	var replacement = window.getSelection();
	if(!color) color = '#333';
	var code = '<span style="color:'+color+'">'+replacement.toString()+'</span>';
	replaceSelectionWithHtml(code);
	saveContent();
	clearSelection();
	return false;
}

function setFontWeight(weight)
{
	//document.execCommand('removeFormat', false, null);
	var replacement = window.getSelection();
	if(!weight) weight = '400';
	var code = '<span style="font-weight:'+weight+'">'+replacement.toString()+'</span>';
	replaceSelectionWithHtml(code);
	saveContent();
	clearSelection();
	return false;
}

function setFontSize(size)
{
	//document.execCommand('removeFormat', false, null);
	var replacement = window.getSelection();
	if(!size) size = 'normal';
	var code = '<span style="font-size:'+size+'px">'+replacement.toString()+'</span>';
	replaceSelectionWithHtml(code);
	saveContent();
	clearSelection();
	return false;
}



function strip(html)
{
   var tmp = document.createElement("DIV");
   tmp.outerHTML = html;
   return tmp.textContent || tmp.innerText || "";
}

$('#btn_align').on('click', function() { 
	//$('.tooltip').hide();
});

$('#btn_align_left').on('click', function() { 
	document.execCommand('justifyLeft', false, null);
	return false;
});

$('#btn_align_center').on('click', function() { 
	document.execCommand('justifyCenter', false, null);
	return false;
});

$('#btn_align_right').on('click', function() { 
	document.execCommand('justifyRight', false, null);
	return false;
});



function getTextNodesIn(node) {
    var textNodes = [];
    if (node.nodeType == 3) {
        textNodes.push(node);
    } else {
        var children = node.childNodes;
        for (var i = 0, len = children.length; i < len; ++i) {
            textNodes.push.apply(textNodes, getTextNodesIn(children[i]));
        }
    }
    return textNodes;
}

function setSelectionRange(el, start, end) {
    if (document.createRange && window.getSelection) {
        var range = document.createRange();
        range.selectNodeContents(el);
        var textNodes = getTextNodesIn(el);
        var foundStart = false;
        var charCount = 0, endCharCount;

        for (var i = 0, textNode; textNode = textNodes[i++]; ) {
            endCharCount = charCount + textNode.length;
            if (!foundStart && start >= charCount && (start < endCharCount || (start == endCharCount && i <= textNodes.length))) {
                range.setStart(textNode, start - charCount);
                foundStart = true;
            }
            if (foundStart && end <= endCharCount) {
                range.setEnd(textNode, end - charCount);
                break;
            }
            charCount = endCharCount;
        }

        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    } else if (document.selection && document.body.createTextRange) {
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(el);
        textRange.collapse(true);
        textRange.moveEnd("character", end);
        textRange.moveStart("character", start);
        textRange.select();
    }
}

function makeEditableAndHighlight(colour) {
    sel = window.getSelection();
    if (sel.rangeCount && sel.getRangeAt) {
        range = sel.getRangeAt(0);
    }
    document.designMode = "on";
    if (range) {
        sel.removeAllRanges();
        sel.addRange(range);
    }
    // Use HiliteColor since some browsers apply BackColor to the whole block
    if (!document.execCommand("HiliteColor", false, colour)) {
        document.execCommand("BackColor", false, colour);
    }
    document.designMode = "off";
}

function highlight(colour) {
    var range, sel;
    if (window.getSelection) {
        // IE9 and non-IE
        try {
            if (!document.execCommand("BackColor", false, colour)) {
                makeEditableAndHighlight(colour);
            }
        } catch (ex) {
            makeEditableAndHighlight(colour)
        }
    } else if (document.selection && document.selection.createRange) {
        // IE <= 8 case
        range = document.selection.createRange();
        range.execCommand("BackColor", false, colour);
    }
}

function selectAndHighlightRange(id, start, end) {
    setSelectionRange(document.getElementById(id), start, end);
    //highlight("yellow");
}


function init_caret()
{
	if (document.selection) {
		
		var tagName = document.selection.createRange().parentElement().tagName;
		//console.log(document.selection.createRange().parentElement().outerHTML); // IE
		var html_of_element = document.selection.createRange().parentElement().outerHTML;
		
		//console.log('1: '+html_of_element); 
	} else {
		// everyone else
			
		var tagName = window.getSelection().anchorNode.parentNode.tagName;
		//console.log(tagName); // IE
		var html_of_element = window.getSelection().anchorNode.parentNode;
		
		//console.log('2: '+html_of_element); 
	}
	
	if(tagName == 'SPAN') 
	{
		// Узнаем цвет
		var font_family = jQuery(html_of_element).css('font-family');
		var font_size = jQuery(html_of_element).css('font-size');
		
		$('#font_family_show').text(font_family);
		$('#font_size_show').text(font_size);
		
		
	}
	else var color = jQuery(html_of_element).closest('.editable').css('color');
	if(color) $('#main_color').val(rgb2hex(color));	

	if(tagName == 'A') 
	{
		// Можем выделять кнопку ссылки на панельке, когда курсор находится внутри ссылки
		var href = jQuery(html_of_element).attr('href');
		var target = jQuery(html_of_element).attr('target');
		$('#btn_link').addClass('active');
		
		if(target == "_blank") $('#link_target').val('1');
		else $('#link_target').val('');
		
		$('#exist_link').attr('id', '');
		jQuery(html_of_element).attr('id', 'exist_link');
	}
	else
	{
		var href = '';
		$('#btn_link').removeClass('active');
	}
	$('#link_input').val(href);
	//console.log(href); 
	
	// Элемент на странице, хранящий ссылку
	
	
	// Простые теги
	if(tagName == 'B') $('#btn_bold').addClass('active');
	else $('#btn_bold').removeClass('active');
	
	if(tagName == 'I') $('#btn_italic').addClass('active');
	else $('#btn_italic').removeClass('active');
	
	if(tagName == 'U') $('#btn_underline').addClass('active');
	else $('#btn_underline').removeClass('active');
	
	if(tagName == 'STRIKE') $('#btn_strikethrough').addClass('active');
	else $('#btn_strikethrough').removeClass('active');
	
	//console.log(tagName+' '+$('#btn_bold').attr('class')); 
}

function componentToHex(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
}

var hexDigits = new Array
        ("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f"); 

function rgb2hex(rgb) {
 rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
 return hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

function hex(x) {
  return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
 }
 
 
function initEditable()
{
 
$(".editable").each(function() {
	
	// Создаем интерфейс редактирования
	$(this).attr('contentEditable', true);
	
	
	// Определяет внутри какого тега находится каретка
	$(this).bind('keydown keyup' , function(e) {
		init_caret();
	});	
	
	// Фокус
	$(this).bind('click', function() {
		
		
		$(this).focus();
		
		// Открывается панелька
		$('#panelka').slideDown();
		$('#panelka button').removeClass('active')
		
		$(this).attr('id', 'current_editor');
		
		init_caret();
		
		var this_field = $(this);
				
		$('#panel-test').text($(this).attr('class'));
		
		
		var classes = explode(' ', $(this).attr('class'));
		data = new Object();
	
		var classes_list = '';
	
		//console.log('------------');
		$(classes).each(function(i, val) {
			//console.log(i+' = '+val);
			
			if(val) classes_list += '.'+val;
			
			// Разбираем, что нашли
			var res = explode('_', val);
			var prefix = res[0];
			var int_val = res[1];
			
			if(prefix == 'block') data.block = int_val;
			if(prefix == 'field') data.field = int_val;
			
			if(prefix == 'item') data.it_is_item = 1;
			
			if(prefix == 'item-field') data.item_field = int_val;
			if(prefix == 'item-int') data.item_int = int_val;
			if(prefix == 'item-option') data.option_int = int_val;
			
		});
		
		data.class = classes_list;
		
		//$('#element_input').val($(this).html());
		
		//
		
		// Общий элемент цвета
		$('#font_family_show').text($(this).css('font-family'));
		$('#font_size_show').text($(this).css('font-size'));
		
		
		
	});
	
	$(this).on('mouseover', function() {
		window.panelka_focus = true;
	});

	$(this).on('mouseout', function() {
		window.panelka_focus = false;
	});
	
	// Расфокус
	$(this).on('blur', function() {
		
		$(this).attr('id', '');
		
		//data.value = $(this).html();
		//$('#editor').html($(this).text());
		//console.log('blur text: '+$(this).text());
		//console.log('blur html: '+$(this).html());
		
		window.contetData = data;
		saveContent();
	});
	
	
	
	
});

console.log('editable initialized');
}

function saveContent()
{
	setTimeout(function(){
		console.log('------saveContent------');
		window.contetData.value = $(window.contetData.class).html();
		
		// Сохраняем...
	$.ajax({
		type: "GET",
		url: 'index.php?app=ajax&method=api&param=blocks.visual_edit',
		data: {
				  'theme_id': window.theme_id,
				  'block_schema_id': window.contetData.block,
				  'option_int': window.contetData.option_int,
				  'item_int': window.contetData.item_int,
				  'value': window.contetData.value,
				  'it_is_item': window.contetData.it_is_item,
		},
		dataType: 'json'
	})
	.done(function( data ) {
		console.log(data);
	});	
		
	console.log(window.contetData);
		
	}, 100);
}

function replaceSelectionWithHtml(html) {
var range, html;
if (window.getSelection && window.getSelection().getRangeAt) {
range = window.getSelection().getRangeAt(0);
range.deleteContents();
var div = document.createElement("div");
div.innerHTML = html;
var frag = document.createDocumentFragment(), child;
while ( (child = div.firstChild) ) {
frag.appendChild(child);
}
range.insertNode(frag);
} else if (document.selection && document.selection.createRange) {
range = document.selection.createRange();
range.pasteHTML(html);
}
}


function replaceSelectedText(replacementText) {
    var sel, range;
    if (window.getSelection) {
        sel = window.getSelection();
        if (sel.rangeCount) {
            range = sel.getRangeAt(0);
            range.deleteContents();
            range.insertNode(document.createTextNode(replacementText));
        }
    } else if (document.selection && document.selection.createRange) {
        range = document.selection.createRange();
        range.text = replacementText;
    }
}

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


function block_move(block_schema_id, direction)
{
	$.ajax({
		type: "POST",
		url: 'index.php?app=ajax&method=api&param=blocks.move',
		data: {
				  'block_schema_id': block_schema_id,
				  'page_id': window.page_id,
				  'direction': direction,
				},
		dataType: 'json'
	})
	.done(function( data ) {
		//alert(data);
	});	
}

function block_delete(id)
{
	if (confirm("Удалить ряд с этой страницы? ")) {
		$.ajax({
			type: "POST",
			url: 'index.php?app=ajax&method=api&param=blocks.delete',
			data: {
					  'id': id,
					  'page_id': window.page_id,
					},
			dataType: 'json'
		})
		.done(function( data ) {
			$('.block_'+id).remove();
			check_blocks_on_page();
		});	
	}
}  
  
function block_delete_all (id)
{
	
	if (confirm("Блок удалится со всех страниц, со всеми настройками и файлами. Удалить блок? ")) {
		
		$.ajax({
			type: "POST",
			url: 'index.php?app=ajax&method=api&param=blocks.delete_all',
			data: {
					  'id': id,
					},
			dataType: 'json'
		})
		.done(function( data ) {
			$('#block_'+id+', .block_'+id).remove();
			check_blocks_on_page();
		});	
	}
}    

function modal_dialog_open_constructor(dialog, params)
{
	
	if(!$('#'+dialog).length)
	{
		$('#dialogs').append('<div class="modal fade " id="'+dialog+'" tabindex="-1" role="dialog" aria-labelledby="dialog"><div class="modal-dialog" role="document"><div class="modal-content"></div></div></div>');
	}
	
	$('#'+dialog).modal();
	$('#'+dialog+' .modal-content').html('<center><img style="margin:50px 0px" src="/files/images/ajax-loader.gif" /></center>');
	
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

function check_blocks_on_page()
{
	if($('div').is('.block_schema')) $('.last_block button').addClass('hidden'); 
	else  $('.last_block button').removeClass('hidden'); 
}

function bind_settings()
{
	$('.block_schema').bind('mouseover', function() {
		//$(this).addClass('border_color_main') 
		$('#'+$(this).attr('id')+' .preview_edit').removeClass('hidden');
	});

	$('.block_schema').bind('mouseout', function() {
		//$(this).removeClass('border_color_main') 
		$('#'+$(this).attr('id')+' .preview_edit').addClass('hidden');
	});
	
	check_blocks_on_page();
	
	semicolon_init();
	
	$('div#wrapper a').bind('click', function(e) {
		e.preventDefault;
		return false;
	});


	$('.ajax_form').submit(function(e) {
		e.preventDefault;
		$form = $(this);
		
	   var data = $form.serialize();
	   
		return false;
	});

	
	
	
}

function getRandomArbitrary(min, max) {
  return Math.random() * (max - min) + min;
}


jQuery.loadScript = function (url, callback) {
    jQuery.ajax({
        url: url,
        dataType: 'script',
        success: callback,
        async: true
    });
}


function semicolon_init()
{
	$.loadScript('sources/theme_folder/js/functions.js?_'+getRandomArbitrary(111111111, 999999999));
	
	SEMICOLON.widget.loadFlexSlider();
	
	setTimeout(function() {
		vertical_middle();
		vertical_middle();
		$('div[class*=preloader2]').removeClass('preloader2');
		$(window).resize();
		
		$('.dialog_open').bind('click', function() {
			modal_dialog_open($(this).data('url'));
		});
		initEditable();
		margintop_auto();
		
		}, (1 * 1000));	
	
}