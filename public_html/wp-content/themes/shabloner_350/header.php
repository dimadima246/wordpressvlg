<!DOCTYPE html>
<html dir="ltr" lang="ru-RU">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

	<!-- Stylesheets
	============================================= -->
	<link rel="stylesheet" href="<?=get_template_directory_uri()?>/css/bootstrap.css?_1606137543" type="text/css" />
	<link rel="stylesheet" href="<?=get_template_directory_uri()?>/base.css?_1606137543" type="text/css" />
	<link rel="stylesheet" href="<?=get_template_directory_uri()?>/css/swiper.css?_1606137543" type="text/css" />

	<link rel="stylesheet" href="<?=get_template_directory_uri()?>/css/dark.css?_1606137543" type="text/css" />
	<link rel="stylesheet" href="<?=get_template_directory_uri()?>/css/font-icons.css?_1606137543" type="text/css" />
	<link rel="stylesheet" href="<?=get_template_directory_uri()?>/css/et-line.css?_1606137543" type="text/css" />
	<link rel="stylesheet" href="<?=get_template_directory_uri()?>/css/animate.css?_1606137543" type="text/css" />
	<link rel="stylesheet" href="<?=get_template_directory_uri()?>/css/magnific-popup.css?_1606137543" type="text/css" />
	
	<!--Цветовая схема-->
	<link rel="stylesheet" href="<?=get_template_directory_uri()?>/css/palette.css?_1606137543" type="text/css" />
	
	<link rel="stylesheet" href="<?=get_template_directory_uri()?>/css/fonts.css?_1606137543" type="text/css" />
	<link rel="stylesheet" href="<?=get_template_directory_uri()?>/css/blocks.css?_1606137543" type="text/css" />
	
	<link rel="stylesheet" href="<?=get_template_directory_uri()?>/custom.css?_1606137543" type="text/css" />
	<link rel="stylesheet" href="<?=get_template_directory_uri()?>/css/responsive.css?_1606137543" type="text/css" />
	<link rel="stylesheet" href="<?=get_template_directory_uri()?>/style.css?_1606137543" type="text/css" />
	
	<!--Шрифты-->
	<link rel="stylesheet" href="<?=get_template_directory_uri()?>/fonts/firasans.css?_1606137543" type="text/css" />
<link rel="stylesheet" href="<?=get_template_directory_uri()?>/fonts/roboto.css?_1606137543" type="text/css" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<!-- Document Title
	============================================= -->
	<title><?php if(is_home()) { bloginfo('name'); echo ' | '; bloginfo('description'); } else wp_title(''); ?></title>
	<?php wp_head() ?>
</head>

<body class="stretched no-transition <?php if(is_home()) echo 'main_page'; ?> [page_preview]">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix ">