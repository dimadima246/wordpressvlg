<link rel="stylesheet" href="<?=HTTP_PATH?>/interface/proximanova/stylesheet.css" type="text/css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="<?=HTTP_PATH?>/files/colpick-master/css/colpick.css">
<link rel="stylesheet" type="text/css" href="<?=HTTP_PATH?>/sources/woocommerce.css">
<link rel="stylesheet" type="text/css" href="<?=HTTP_PATH?>/sources/woocommerce-layout.css">


<?php $color = '#307ECC'; ?>
<style>
body {
padding-top:57px;
}	

#dialogs .btn, .preview_edit .btn, #dialogs .modal, #dialogs .modal label, .dropdown-menu { 
	font-family: 'Proxima Nova Rg', sans-serif !important; 
	font-size: 15px !important;
}

#dialogs h1, #dialogs h2, #dialogs h3, #dialogs h4, #dialogs h5, #dialogs small, .page_preview .badge, .navbar-preview, #element_info {
	font-family: 'Proxima Nova Rg', sans-serif !important; 
}

.navbar-preview, .navbar-preview .dropdown-menu {
	font-size: 16px !important;
}

#dialogs .nav-pills .nav-link.active, #dialogs .nav-pills .nav-link.active:hover, .page_preview .badge-primary {
	background-color: <?=$color?> !important;
}

#dialogs .nav-pills .nav-link:not(.active) {
	color: <?=$color?>;
}

#dialogs .nav-pills .nav-link:hover {
	color:#333;
}

#dialogs .nav-pills .nav-link.active:hover {
	color:#fff;
}

.preview_edit .btn-primary, #dialogs .btn-primary { background-color: <?=$color?>; border-color: <?=$color?> }

.tabs.tabs-tb ul.tab-nav li.ui-tabs-active a {
	border-top-color: <?=$color?>;
}

#dialogs .modal-content form, .card h1, .card h2, .card h3, .card h4, .card h5 {
	margin-bottom:0px !important;
}

#dialogs .btn-primary:hover,
.preview_edit .btn-primary:hover {
    color: #fff;
    background-color: #2a65a0;
    border-color: #2a65a0;
}

.preview_edit .btn-toolbar .btn {
	margin-left:3px;
}

.content_item {
	width:100%;
	float: left;
	border:1px solid #f5f5f5;
	border-radius:4px;
	padding:10px;
	margin-right:2%;
	margin-bottom:2%;
	background-color:#f8f9fa;
	
}

.content_item:nth-child(3n) {
	margin-right:0px;
}

.block_schema {
	/*border-top: 1px #fff solid;
	border-bottom: 1px #fff solid;*/
}

.block_schema:hover {
	outline: #6c757d dotted 1px !important;
	
	/*border-top: <?=$color?> 1px dotted;
	border-bottom: <?=$color?> 1px dotted;*/
}

.preview_edit_bottom {
	position: absolute; margin-top:-18px; z-index:998; width:100%;  
}

.pull-left {
	float: left;
}

.preview_edit .btn:first-child {
	margin-left:0px;
}

#dialogs .content_item .btn-toolbar .btn {
	font-size:10px !important;
}

#wrapper {
	margin-top:30px;
	margin-bottom:30px;
}


.cv-head-1 {
    height: 199px !important;
    border-bottom: 0px !important;
}

.btn-outline-dark {
	background-color:#fff;
}

.top_block {
	padding:0px 14px;
}

#panelka {
	height:58px;
	width:100%;
	/*background-color: #343a40;*/
	background-color: #fff;
    z-index: 1031;
    position: fixed;
	top:0px;
	color:#222;
	padding:10px;
}

#panelka button {
	margin-right:10px;
}

#panelka button:last-child {
	margin-right:0px;
}

.editable {
	cursor:text !important;
}

</style>


<div id="panelka" class=" " style="display: none">

<div id="element_info" class="pull-right" style=" line-height: 2; font-size:18px">

<!--<span class="text-muted" id="panel-test"></span>-->
<span id="font_family_show"></span>, 
<b><span id="font_size_show"></span></b>
</div>

<button id="btn_bold" class="btn btn-outline-dark" title="Жирный"  data-toggle="tooltip">
<i class="fa fa-bold"></i>
</button>


<button id="btn_italic" class="btn btn-outline-dark" title="Курсив"  data-toggle="tooltip">
<i class="fa fa-italic"></i>
</button>


<button id="btn_underline" class="btn btn-outline-dark" title="Подчеркнутый"  data-toggle="tooltip">
<i class="fa fa-underline"></i>
</button>


<button id="btn_strikethrough" class="btn btn-outline-dark" title="Зачеркнутый"  data-toggle="tooltip">
<i class="fa fa-strikethrough"></i>
</button>


<div class="it_is_btn btn-group"  title="Шрифт"  data-toggle="tooltip" data-placement="left" >
	<button id="btn_weight" type="button" class="btn btn-outline-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<i class="fa fa-font"></i>
	</button>
	<div class="dropdown-menu">
		<?php 
		$fonts = array();
		if($settings['font_title']) $fonts[] = $settings['font_title'];
		if($settings['font_text']) $fonts[] = $settings['font_text'];
		if($settings['font_add']) $fonts[] = $settings['font_add'];
		
		foreach($fonts as $font) { ?>
		<a class="dropdown-item" onclick="setFont('<?=$font?>'); return false;" style="font-family:<?=$font?>" href="#"><?=$font?></a>
		<?php } ?>
	</div>
</div>


<div class="it_is_btn btn-group"  title="Размер текста"  data-toggle="tooltip" data-placement="left" >
	<button id="btn_weight" type="button" class="btn btn-outline-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<i class="fa fa-text-height"></i>
	</button>
	<div class="dropdown-menu">
		<?php foreach(array(12, 14, 16, 18, 20, 22, 24, 26, 28, 30, 32, 34, 36, 38, 40, 42, 46, 52, 62, 72, 82, 92, 102) as $size) { ?>
		<a class="dropdown-item" onclick="setFontSize(<?=$size?>); return false;" href="#"><?=$size?>px</a>
		<?php } ?>
	</div>
</div>


<div class="it_is_btn btn-group"  title="Жирность текста"  data-toggle="tooltip" data-placement="left" >
	<button id="btn_weight" type="button" class="btn btn-outline-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<i class="fa fa-text-width"></i>
	</button>
	<div class="dropdown-menu">
		<a class="dropdown-item" onclick="setFontWeight(100); return false;" href="#">100, Thin</a>
		<a class="dropdown-item" onclick="setFontWeight(300); return false;" href="#">300, Light</a>
		<a class="dropdown-item" onclick="setFontWeight(400); return false;" href="#">400, Normal</a>
		<a class="dropdown-item" onclick="setFontWeight(500); return false;" href="#">500, Medium</a>
		<a class="dropdown-item" onclick="setFontWeight(600); return false;" href="#">600, Semi Bold</a>
		<a class="dropdown-item" onclick="setFontWeight(700); return false;" href="#">700, Bold</a>
		<a class="dropdown-item" onclick="setFontWeight(800); return false;" href="#">800, Bolder</a>
		<a class="dropdown-item" onclick="setFontWeight(900); return false;" href="#">900, Extra Bold</a>
		<a class="dropdown-item" onclick="setFontWeight(0); return false;" href="#">Убрать жирность</a>
	</div>
</div>


<button id="btn_color" class="btn btn-outline-dark" title="Цвет шрифта"  data-toggle="tooltip">
<i class="fa fa-palette"></i>
</button>


<button id="btn_link" class="btn btn-outline-dark" title="Ссылка"  data-toggle="tooltip">
<i class="fa fa-link"></i>
</button>

<div class="it_is_btn btn-group"  title="Выравнивание"  data-toggle="tooltip" data-placement="left" >
	<button id="btn_align" type="button" class="btn btn-outline-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<i class="fa fa-align-left"></i>
	</button>
	<div class="dropdown-menu">
		<a class="dropdown-item" href="#" id="btn_align_left"><i class="fa fa-align-left"></i>&nbsp;&nbsp;По левому краю</a>
		<a class="dropdown-item" href="#" id="btn_align_center"><i class="fa fa-align-center"></i>&nbsp;&nbsp;По центру</a>
		<a class="dropdown-item" href="#" id="btn_align_right"><i class="fa fa-align-right"></i>&nbsp;&nbsp;По правому краю</a>
	</div>
</div>

<!--<button id="btn_align" class=" dropdown dropdown-toggle"   aria-haspopup="true" aria-expanded="false">
<i class="fa fa-align-left"></i>

<div class="dropdown-menu" aria-labelledby="btn_align">
<?php foreach($pages as $page) { $name = $page['name']; ?>
	<?php if($page['id'] == $_GET['page_id']) { ?>	
	
		<a class="dropdown-item " href="<?=HTTP_PATH?>/page_view/?theme_id=<?=$_GET['theme_id']?>&page_id=<?=$page['id']?>"><b><?=$name?></b></a>
	
	<?php } else { ?>	
		<a class="dropdown-item" href="<?=HTTP_PATH?>/page_view/?theme_id=<?=$_GET['theme_id']?>&page_id=<?=$page['id']?>"><?=$name?></a>
	<?php } ?>	
<?php } ?>	
</div>

</button>-->

<button class="btn btn-outline-dark" title="Очистить форматирование" id="clear_html"  data-toggle="tooltip">
<i class="fa fa-eraser"></i>
</button>



</div>


<?php
$data = db()->where('id', $_GET['theme_id'])->getOne('themes');

$theme_link = HTTP_PATH.'/index.php?app=themes&act=edit&id='.$_GET['theme_id'];

$pages = db()->where('theme_id', $_GET['theme_id'])->orderBy('name', 'asc')->get('pages_schema', array(0, 999));
$page = db()->where('id', $_GET['page_id'])->getOne('pages_schema');
$name = $page['name'];
?>

<nav class="navbar-preview navbar navbar-expand-lg navbar-dark bg-dark fixed-top">

	<a target="_blank" title="Шаблонер" class="navbar-brand" href="<?=SHTTP_PATH?>?utm_source=editor">
	<img src="<?=HTTP_PATH?>/files/images/navbar-logo.png" width="30" height="30" alt="">
	</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item ">
				<a title="Настройки темы" class="nav-link" href="<?=$theme_link?>"><?=$data['name']?></a>
			</li>
			<li title="Выбор страницы" class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?=$name?>
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				<?php foreach($pages as $page) { $name = $page['name']; ?>
					<?php if($page['id'] == $_GET['page_id']) { ?>	
					
						<a class="dropdown-item " href="index.php?app=page_view&theme_id=<?=$_GET['theme_id']?>&page_id=<?=$page['id']?>"><b><?=$name?></b></a>
					
					<?php } else { ?>	
						<a class="dropdown-item" href="index.php?app=page_view&theme_id=<?=$_GET['theme_id']?>&page_id=<?=$page['id']?>"><?=$name?></a>
					<?php } ?>	
				<?php } ?>	
				</div>
			</li>
		</ul>
		
		<form class="form-inline nomargin">
			<button onclick="modal_dialog_open_constructor('page_new', 'theme_id=<?=$_GET['theme_id']?>')" class="btn btn-outline-light my-2 my-sm-0" type="button">Новая страница</button>&nbsp;
		
<button onclick="modal_dialog_open_constructor('page_build_dialog', 'theme_id=<?=$_GET['theme_id']?>&page_id=<?=$_GET['page_id']?>')" class="btn btn-outline-light my-2 my-sm-0" type="button"><i class="fas fa-save"></i> Сохранить</button>&nbsp;
			
<a target="_blank" href="<?=str_replace('wp-admin', '', WP_ADMIN_URL)?>" class="btn btn-outline-light my-2 my-sm-0" ><i class="fas fa-eye"></i> Просмотр сайта</a>
			
		</form>		
		
		
	</div>
	
</nav>