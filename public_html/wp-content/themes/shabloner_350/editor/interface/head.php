<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Shabloner" />

	<!-- Stylesheets
	============================================= -->
<!--<link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet"> -->
	<link rel="stylesheet" href="<?=HTTP_PATH?>/interface/proximanova/stylesheet.css" type="text/css" />

	<link rel="stylesheet" href="<?=HTTP_PATH?>/interface/css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?=HTTP_PATH?>/interface/css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?=HTTP_PATH?>/interface/style.css" type="text/css" />
	<link rel="stylesheet" href="<?=HTTP_PATH?>/interface/css/dark.css" type="text/css" />
	<link rel="stylesheet" href="<?=HTTP_PATH?>/interface/css/font-icons.css" type="text/css" />
	<link rel="stylesheet" href="<?=HTTP_PATH?>/interface/css/animate.css" type="text/css" />
	<link rel="stylesheet" href="<?=HTTP_PATH?>/interface/css/magnific-popup.css" type="text/css" />
	<link rel="stylesheet" href="<?=HTTP_PATH?>/interface/css/fonts.css" type="text/css" />
	<link rel="stylesheet" href="<?=HTTP_PATH?>/interface/css/colors.php" type="text/css" />

	
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous"><link rel="stylesheet" href="<?=HTTP_PATH?>/interface/css/responsive.css" type="text/css" />

	

	<meta name="viewport" content="width=device-width, initial-scale=1" />

	
	<!-- External JavaScripts
	============================================= -->
	<script src="<?=HTTP_PATH?>/interface/js/jquery.js"></script>
	
	<script src="<?=HTTP_PATH?>/interface/js/plugins.js"></script>

	<script src="<?=HTTP_PATH?>/files/materialcolorpicker.js"></script>

<!--Popper-->
<script src="<?=HTTP_PATH?>/files/popper.min.js"></script>

<!--<script src="<?=HTTP_PATH?>/files/html5sortable-master/dist/html5sortable.js"></script>-->


<link rel="stylesheet" href="<?=HTTP_PATH?>/interface/chosen/chosen.min.css" />
<script src="<?=HTTP_PATH?>/interface/chosen/chosen.jquery.min.js"></script>

	
	<script src="<?=HTTP_PATH?>/files/functions.js"></script>
	
<link rel="stylesheet" href="<?=HTTP_PATH?>/files/styles.css" />

<script src="<?=HTTP_PATH?>/files/ace-builds-master/src-min-noconflict/ace.js"></script>
	
	
	<!-- Document Title
	============================================= -->
	<title><?php if($title) echo $title; else echo 'Шаблонер - Конструктор тем'; ?></title>

</head>

<body class="stretched no-transition">

			<?php //include('menu.php'); ?>


	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix" >

	
<?php //include('header.php'); ?>
	
	
	<section id="page-title" style=" padding-bottom: 23px;">

			<div class="container clearfix">
				<?php include('breadcrumbs.php'); ?>
				<h1><?=$title?> <small class="" id="total_items"></small></h1>
			</div>

		</section>	
		
<?php //include('submenu.php'); ?>
		
		
		<!-- Content
		============================================= -->
		<section id="content" class="bottommargin">

			<div class="">



<div class="container clearfix topmargin-sm" >

<?php if($_POST && $_RETURN['error'] == '0') { ?>
<div class="alert alert-success" role="alert">
  Операция прошла успешно!
</div>
<?php } ?>

<?php if($_POST && $_RETURN['error'] != '0') { ?>
<div class="alert alert-danger" role="alert">
  <b>Ошибка</b>: <?=$_RETURN['error']?>
</div>
<?php } ?>

<?php if(LOCAL_SERVER == 1 || !stristr($_SERVER['HTTP_HOST'], '.')) { ?>
<div class="alert alert-warning" role="alert">
  <b>Внимание</b>: Сайт работает на локальном сервере!</a>
</div>
<?php } ?>

