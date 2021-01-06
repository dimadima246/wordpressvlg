<?php

header ("Content-Type:text/css");


/** ===============================================================
 *
 *      Primary Color Scheme
 *
 ================================================================== */

if( isset( $_GET[ 'colors' ] ) AND $_GET[ 'colors' ] != '' )
{
	
	foreach(explode(',', $_GET['colors']) as $color ) $colors[] = "#" . $color;

}
else
{
	$colors = array(
							 '#17a2b8',
							 );
						 
}

$count = count($colors);

$color = $colors[0]; // Первый цвет - основной


?>


/* ----------------------------------------------------------------
	Colors

	Replace the HEX Code with your Desired Color HEX
-----------------------------------------------------------------*/

body { 
	color: #222;

}

::selection { background: <?php echo $color; ?>; }

::-moz-selection { background: <?php echo $color; ?>; }

::-webkit-selection { background: <?php echo $color; ?>; }

#posts h3 a:hover {
	color: <?php echo $color; ?>;
}



/*
h1 > span:not(.nocolor):not(.badge),
h2 > span:not(.nocolor):not(.badge),
h3 > span:not(.nocolor):not(.badge),
h4 > span:not(.nocolor):not(.badge),
h5 > span:not(.nocolor):not(.badge),
h6 > span:not(.nocolor):not(.badge),
*/

a,
.header-extras li .he-text span,
#primary-menu ul li:hover > a,
#primary-menu ul li.current > a,
#primary-menu div ul li:hover > a,
#primary-menu div ul li.current > a,
#primary-menu ul ul li:hover > a,
#primary-menu ul li .mega-menu-content.style-2 ul.mega-menu-column > li.mega-menu-title > a:hover,
#top-cart > a:hover,
.top-cart-action span.top-checkout-price,
.breadcrumb a:hover,
.portfolio-filter li a:hover,
.portfolio-desc h3 a:hover,
.portfolio-overlay a:hover,
#portfolio-navigation a:hover,
.entry-title h2 a:hover,
.entry-meta li a:hover,
.post-timeline .entry:hover .entry-timeline,
.post-timeline .entry:hover .timeline-divider,
.ipost .entry-title h3 a:hover,
.ipost .entry-title h4 a:hover,
.spost .entry-title h4 a:hover,
.mpost .entry-title h4 a:hover,
.comment-content .comment-author a:hover,
.product-title h3 a:hover,
.single-product .product-title h2 a:hover,
.product-price ins,
.single-product .product-price,
.feature-box.fbox-border .fbox-icon i,
.feature-box.fbox-border .fbox-icon img,
.feature-box.fbox-plain .fbox-icon i,
.feature-box.fbox-plain .fbox-icon img,
.process-steps li.active h5,
.process-steps li.ui-tabs-active h5,
.team-title span,
.pricing-box.best-price .pricing-price,
.btn-link,
.page-link,
.page-link:hover, 
.page-link:focus,
.dark .post-timeline .entry:hover .entry-timeline,
.dark .post-timeline .entry:hover .timeline-divider,
.clear-rating-active:hover { color: <?php echo $color; ?>; }

.color,
.bgmenu  div#top-cart a span,
.top-cart-item-desc a:hover,
.portfolio-filter.style-3 li.activeFilter a,
.faqlist li a:hover,
.tagcloud a:hover,
.dark .top-cart-item-desc a:hover,
.iconlist-color li i,
.dark.overlay-menu #header-wrap:not(.not-dark) #primary-menu > ul > li:hover > a,
.dark.overlay-menu #header-wrap:not(.not-dark) #primary-menu > ul > li.current > a,
.overlay-menu #primary-menu.dark > ul > li:hover > a,
.overlay-menu #primary-menu.dark > ul > li.current > a,
.nav-tree li:hover > a,
.nav-tree li.current > a,
.nav-tree li.active > a,
.woocommerce .woocommerce-breadcrumb a { color: <?php echo $color; ?> !important; }

#primary-menu.style-3 > ul > li.current > a,
.bgmenu,
#primary-menu.style-10 > ul > li:hover > a,
#primary-menu.style-10 > ul > li.current > a,
#primary-menu.style-10 > div > ul > li:hover > a,
#primary-menu.style-10 > div > ul > li.current > a,
#top-cart > a > span,
#page-menu-wrap,
#page-menu ul ul,
#page-menu.dots-menu nav li.current a,
#page-menu.dots-menu nav li div,
.portfolio-filter li.activeFilter a,
.portfolio-filter.style-4 li.activeFilter a:after,
.portfolio-shuffle:hover,
.entry-link:hover,
.sale-flash,
.button:not(.button-white):not(.button-dark):not(.button-border):not(.button-black):not(.button-red):not(.button-teal):not(.button-yellow):not(.button-green):not(.button-brown):not(.button-aqua):not(.button-purple):not(.button-leaf):not(.button-pink):not(.button-blue):not(.button-dirtygreen):not(.button-amber):not(.button-lime),
.button.button-dark:hover,
.promo.promo-flat,
.feature-box .fbox-icon i,
.feature-box .fbox-icon img,
.fbox-effect.fbox-dark .fbox-icon i:hover,
.fbox-effect.fbox-dark:hover .fbox-icon i,
.fbox-border.fbox-effect.fbox-dark .fbox-icon i:after,
.i-rounded:hover,
.i-circled:hover,
ul.tab-nav.tab-nav2 li.ui-state-active a,
.testimonial .flex-control-nav li a,
.skills li .progress,
.owl-carousel .owl-dots .owl-dot,
#gotoTop:hover,
.dark .button-dark:hover,
.dark .fbox-effect.fbox-dark .fbox-icon i:hover,
.dark .fbox-effect.fbox-dark:hover .fbox-icon i,
.dark .fbox-border.fbox-effect.fbox-dark .fbox-icon i:after,
.dark .i-rounded:hover,
.dark .i-circled:hover,
.dark ul.tab-nav.tab-nav2 li.ui-state-active a,
.dark .tagcloud a:hover,
.ei-slider-thumbs li.ei-slider-element,
.nav-pills .nav-link.active,
.nav-pills .nav-link.active:hover,
.nav-pills .nav-link.active:focus,
.nav-pills .show > .nav-link,
.checkbox-style:checked + .checkbox-style-1-label:before,
.checkbox-style:checked + .checkbox-style-2-label:before,
.checkbox-style:checked + .checkbox-style-3-label:before,
.radio-style:checked + .radio-style-3-label:before,
.irs-bar,
.irs-from,
.irs-to,
.irs-single,
input.switch-toggle-flat:checked + label,
input.switch-toggle-flat:checked + label:after,
input.switch-toggle-round:checked + label:before,
.bootstrap-switch .bootstrap-switch-handle-on.bootstrap-switch-themecolor,
.bootstrap-switch .bootstrap-switch-handle-off.bootstrap-switch-themecolor{ background-color: <?php echo $color; ?>; }

.bgcolor,
.bgmenu,
.bgcolor #header-wrap,
.button.button-3d:not(.button-white):not(.button-dark):not(.button-border):not(.button-black):not(.button-red):not(.button-teal):not(.button-yellow):not(.button-green):not(.button-brown):not(.button-aqua):not(.button-purple):not(.button-leaf):not(.button-pink):not(.button-blue):not(.button-dirtygreen):not(.button-amber):not(.button-lime):not(.button-2),
.process-steps li.active a,
.process-steps li.ui-tabs-active a,
.sidenav > .ui-tabs-active > a,
.sidenav > .ui-tabs-active > a:hover,
.owl-carousel .owl-nav [class*=owl-]:hover,
.page-link,
.page-link:hover,
.page-link:focus { background-color: <?php echo $color; ?> !important; }

#primary-menu.style-4 > ul > li:hover > a,
#primary-menu.style-4 > ul > li.current > a,
.top-cart-item-image:hover,
.portfolio-filter.style-3 li.activeFilter a,
.post-timeline .entry:hover .entry-timeline,
.post-timeline .entry:hover .timeline-divider,
.cart-product-thumbnail img:hover,
.feature-box.fbox-outline .fbox-icon,
.feature-box.fbox-border .fbox-icon,
.dark .top-cart-item-image:hover,
.dark .post-timeline .entry:hover .entry-timeline,
.dark .post-timeline .entry:hover .timeline-divider,
.dark .cart-product-thumbnail img:hover,
.heading-block.border-color:after { border-color: <?php echo $color; ?>; }

.top-links ul ul,
.top-links ul div.top-link-section,
#primary-menu ul ul:not(.mega-menu-column),
#primary-menu ul li .mega-menu-content,
#primary-menu.style-6 > ul > li > a:after,
#primary-menu.style-6 > ul > li.current > a:after,
#top-cart .top-cart-content,
.fancy-title.title-border-color:before,
.dark #primary-menu:not(.not-dark) ul ul,
.dark #primary-menu:not(.not-dark) ul li .mega-menu-content,
#primary-menu.dark ul ul,
#primary-menu.dark ul li .mega-menu-content,
.dark #primary-menu:not(.not-dark) ul li .mega-menu-content.style-2,
#primary-menu.dark ul li .mega-menu-content.style-2,
.dark #top-cart .top-cart-content,
.tabs.tabs-tb ul.tab-nav li.ui-tabs-active a,
.irs-from:after,
.irs-single:after,
.irs-to:after { border-top-color: <?php echo $color; ?>; }

#page-menu.dots-menu nav li div:after,
.title-block { border-left-color: <?php echo $color; ?>; }

.title-block-right { border-right-color: <?php echo $color; ?>; }

.fancy-title.title-bottom-border h1,
.fancy-title.title-bottom-border h2,
.fancy-title.title-bottom-border h3,
.fancy-title.title-bottom-border h4,
.fancy-title.title-bottom-border h5,
.fancy-title.title-bottom-border h6,
.more-link,
.tabs.tabs-bb ul.tab-nav li.ui-tabs-active a { border-bottom-color: <?php echo $color; ?>; }

.border-color,
.process-steps li.active a,
.process-steps li.ui-tabs-active a,
.tagcloud a:hover,
.page-link,
.page-link:hover,
.page-link:focus { border-color: <?php echo $color; ?> !important; }

.fbox-effect.fbox-dark .fbox-icon i:after,
.dark .fbox-effect.fbox-dark .fbox-icon i:after { box-shadow: 0 0 0 2px <?php echo $color; ?>; }

.fbox-border.fbox-effect.fbox-dark .fbox-icon i:hover,
.fbox-border.fbox-effect.fbox-dark:hover .fbox-icon i,
.dark .fbox-border.fbox-effect.fbox-dark .fbox-icon i:hover,
.dark .fbox-border.fbox-effect.fbox-dark:hover .fbox-icon i { box-shadow: 0 0 0 1px <?php echo $color; ?>; }


.button:hover {
    background-color: #444 !important;
    color: #FFF !important;
    text-shadow: 1px 1px 1px rgba(0,0,0,0.2) !important;
}
.button:hover.button-border {
    background-color: <?php echo $color; ?> !important;
    color: #fff !important;
}

@media only screen and (max-width: 991px) {

	body:not(.dark) #header:not(.dark) #header-wrap:not(.dark):not(.bgmenu) #primary-menu > ul > li:hover a,
	body:not(.dark) #header:not(.dark) #header-wrap:not(.dark):not(.bgmenu) #primary-menu > ul > li.current a,
	body:not(.dark) #header:not(.dark) #header-wrap:not(.dark):not(.bgmenu) #primary-menu > div > ul > li:hover a,
	body:not(.dark) #header:not(.dark) #header-wrap:not(.dark):not(.bgmenu) #primary-menu > div > ul > li.current a,
	#primary-menu ul ul li:hover > a,
	#primary-menu ul li .mega-menu-content.style-2 > ul > li.mega-menu-title:hover > a,
	#primary-menu ul li .mega-menu-content.style-2 > ul > li.mega-menu-title > a:hover { color: <?php echo $color; ?> !important; }

	#page-menu nav { background-color: <?php echo $color; ?> !important; }

}


@media only screen and (max-width: 767px) {

	.portfolio-filter li a:hover { color: <?php echo $color; ?>; }
}


<?php 

if($count > 1) {
	
for($i=1; $i<$count; $i++) {

$num = '-'.($i+1);

$color = $colors[$i];

?>


.btn-link<?=$num?>,
.page-link<?=$num?>,
.page-link<?=$num?>:hover,
.page-link<?=$num?>:focus,
.dark<?=$num?> .post-timeline .entry:hover .entry-timeline,
.dark<?=$num?> .post-timeline .entry:hover .timeline-divider,
.color<?=$num?>,
.dark<?=$num?> .top-cart-item-desc a:hover,
.iconlist-color<?=$num?> li i,
.dark<?=$num?>.overlay-menu #header-wrap:not(.not-dark) #primary-menu > ul > li:hover > a,
.dark<?=$num?>.overlay-menu #header-wrap:not(.not-dark) #primary-menu > ul > li.current > a,
.overlay-menu<?=$num?> #primary-menu.dark > ul > li:hover > a,
.overlay-menu<?=$num?> #primary-menu.dark > ul > li.current > a,
.nav-tree<?=$num?> li:hover > a,
.nav-tree<?=$num?> li.current > a,
.nav-tree<?=$num?> li.active > a 
{color: <?php echo $color; ?> !important}

#primary-menu<?=$num?>.style-3 > ul > li.current > a,
#primary-menu<?=$num?>.style-10 > ul > li:hover > a,
#primary-menu<?=$num?>.style-10 > ul > li.current > a,
#primary-menu<?=$num?>.style-10 > div > ul > li:hover > a,
#primary-menu<?=$num?>.style-10 > div > ul > li.current > a,
#top-cart<?=$num?> > a > span,
.bgmenu<?=$num?>,
#page-menu-wrap<?=$num?>,
#page-menu<?=$num?> ul ul,
#page-menu<?=$num?>.dots-menu nav li.current a,
#page-menu<?=$num?>.dots-menu nav li div,
.entry-link<?=$num?>:hover,
.sale-flash<?=$num?>,
.button<?=$num?>:not(.button-white):not(.button-dark):not(.button-border):not(.button-black):not(.button-red):not(.button-teal):not(.button-yellow):not(.button-green):not(.button-brown):not(.button-aqua):not(.button-purple):not(.button-leaf):not(.button-pink):not(.button-blue):not(.button-dirtygreen):not(.button-amber):not(.button-lime),
.button<?=$num?>.button-dark:hover,
.promo<?=$num?>.promo-flat,
.feature-box<?=$num?> .fbox-icon i,
.feature-box<?=$num?> .fbox-icon img,
.fbox-effect<?=$num?>.fbox-dark .fbox-icon i:hover,
.fbox-effect<?=$num?>.fbox-dark:hover .fbox-icon i,
.fbox-border<?=$num?>.fbox-effect.fbox-dark .fbox-icon i:after,
.i-rounded<?=$num?>:hover,
.i-circled<?=$num?>:hover,
.testimonial<?=$num?> .flex-control-nav li a,
.skills<?=$num?> li .progress,
.owl-carousel<?=$num?> .owl-dots .owl-dot,
#gotoTop<?=$num?>:hover,
.dark<?=$num?> .button-dark:hover,
.dark<?=$num?> .fbox-effect.fbox-dark .fbox-icon i:hover,
.dark<?=$num?> .fbox-effect.fbox-dark:hover .fbox-icon i,
.dark<?=$num?> .fbox-border.fbox-effect.fbox-dark .fbox-icon i:after,
.dark<?=$num?> .i-rounded:hover,
.dark<?=$num?> .i-circled:hover,
.dark<?=$num?> ul.tab-nav.tab-nav2 li.ui-state-active a,
.dark<?=$num?> .tagcloud a:hover,
.ei-slider-thumbs<?=$num?> li.ei-slider-element,
.nav-pills<?=$num?> .nav-link.active,
.nav-pills<?=$num?> .nav-link.active:hover,
.nav-pills<?=$num?> .nav-link.active:focus,
.nav-pills<?=$num?> .show > .nav-link,
.checkbox-style<?=$num?>:checked + .checkbox-style-1-label:before,
.checkbox-style<?=$num?>:checked + .checkbox-style-2-label:before,
.checkbox-style<?=$num?>:checked + .checkbox-style-3-label:before,
.radio-style<?=$num?>:checked + .radio-style-3-label:before,
.irs-bar<?=$num?>,
.irs-from<?=$num?>,
.irs-to<?=$num?>,
.irs-single<?=$num?>,
input.switch-toggle-flat<?=$num?>:checked + label,
input.switch-toggle-flat<?=$num?>:checked + label:after,
input.switch-toggle-round<?=$num?>:checked + label:before,
.bootstrap-switch<?=$num?> .bootstrap-switch-handle-on.bootstrap-switch-themecolor,
.bootstrap-switch<?=$num?> .bootstrap-switch-handle-off.bootstrap-switch-themecolor { background-color: <?php echo $color; ?> !important; }

.bgcolor<?=$num?>,
.bgmenu<?=$num?>,
.bgcolor<?=$num?> #header-wrap,
.button<?=$num?>.button-3d:not(.button-white):not(.button-dark):not(.button-border):not(.button-black):not(.button-red):not(.button-teal):not(.button-yellow):not(.button-green):not(.button-brown):not(.button-aqua):not(.button-purple):not(.button-leaf):not(.button-pink):not(.button-blue):not(.button-dirtygreen):not(.button-amber):not(.button-lime):hover,
.process-steps<?=$num?> li.active a,
.process-steps<?=$num?> li.ui-tabs-active a,
.sidenav<?=$num?> > .ui-tabs-active > a,
.sidenav<?=$num?> > .ui-tabs-active > a:hover,
.owl-carousel<?=$num?> .owl-nav [class*=owl-]:hover,
.page-link<?=$num?>,
.page-link<?=$num?>:hover,
.page-link<?=$num?>:focus { background-color: <?php echo $color; ?> !important; }

#primary-menu<?=$num?>.style-4 > ul > li:hover > a,
#primary-menu<?=$num?>.style-4 > ul > li.current > a,
.top-cart-item-image<?=$num?>:hover,
.portfolio-filter<?=$num?>.style-3 li.activeFilter a,
.post-timeline<?=$num?> .entry:hover .entry-timeline,
.post-timeline<?=$num?> .entry:hover .timeline-divider,
.cart-product-thumbnail<?=$num?> img:hover,
.feature-box<?=$num?>.fbox-outline .fbox-icon,
.feature-box<?=$num?>.fbox-border .fbox-icon,
.dark<?=$num?> .top-cart-item-image:hover,
.dark<?=$num?> .post-timeline .entry:hover .entry-timeline,
.dark<?=$num?> .post-timeline .entry:hover .timeline-divider,
.dark<?=$num?> .cart-product-thumbnail img:hover,
.heading-block<?=$num?>.border-color:after { border-color: <?php echo $color; ?> !important; }

.top-links<?=$num?> ul ul,
.top-links<?=$num?> ul div.top-link-section,
#primary-menu<?=$num?> ul ul:not(.mega-menu-column),
#primary-menu<?=$num?> ul li .mega-menu-content,
#primary-menu<?=$num?>.style-6 > ul > li > a:after,
#primary-menu<?=$num?>.style-6 > ul > li.current > a:after,
#top-cart<?=$num?> .top-cart-content,
.fancy-title<?=$num?>.title-border-color:before,
.dark<?=$num?> #primary-menu:not(.not-dark) ul ul,
.dark<?=$num?> #primary-menu:not(.not-dark) ul li .mega-menu-content,
#primary-menu<?=$num?>.dark ul ul,
#primary-menu<?=$num?>.dark ul li .mega-menu-content,
.dark<?=$num?> #primary-menu:not(.not-dark) ul li .mega-menu-content.style-2,
#primary-menu<?=$num?>.dark ul li .mega-menu-content.style-2,
.dark<?=$num?> #top-cart .top-cart-content,
.tabs<?=$num?>.tabs-tb ul.tab-nav li.ui-tabs-active a,
.irs-from<?=$num?>:after,
.irs-single<?=$num?>:after,
.irs-to<?=$num?>:after { border-top-color: <?php echo $color; ?> !important; }

#page-menu<?=$num?>.dots-menu nav li div:after,
.title-block<?=$num?> { border-left-color: <?php echo $color; ?> !important; }

.title-block-right<?=$num?> { border-right-color: <?php echo $color; ?> !important; }

.fancy-title<?=$num?>.title-bottom-border h1,
.fancy-title<?=$num?>.title-bottom-border h2,
.fancy-title<?=$num?>.title-bottom-border h3,
.fancy-title<?=$num?>.title-bottom-border h4,
.fancy-title<?=$num?>.title-bottom-border h5,
.fancy-title<?=$num?>.title-bottom-border h6,
.more-link<?=$num?>,
.tabs<?=$num?>.tabs-bb ul.tab-nav li.ui-tabs-active a { border-bottom-color: <?php echo $color; ?> !important; }

.border-color<?=$num?>,
.process-steps<?=$num?> li.active a,
.process-steps<?=$num?> li.ui-tabs-active a,
.tagcloud<?=$num?> a:hover,
.page-link<?=$num?>,
.page-link<?=$num?>:hover,
.page-link<?=$num?>:focus { border-color: <?php echo $color; ?> !important; }

.fbox-effect<?=$num?>.fbox-dark .fbox-icon i:after,
.dark<?=$num?> .fbox-effect.fbox-dark .fbox-icon i:after { box-shadow: 0 0 0 2px <?php echo $color; ?> !important; }

.fbox-border<?=$num?>.fbox-effect.fbox-dark .fbox-icon i:hover,
.fbox-border<?=$num?>.fbox-effect.fbox-dark:hover .fbox-icon i,
.dark<?=$num?> .fbox-border.fbox-effect.fbox-dark .fbox-icon i:hover,
.dark<?=$num?> .fbox-border.fbox-effect.fbox-dark:hover .fbox-icon i { box-shadow: 0 0 0 1px <?php echo $color; ?> !important; }

.button<?=$num?>:hover.button-border {
    background-color: <?php echo $color; ?> !important;
    color: #fff !important;
}


.button<?=$num?>.button-border {
    color: <?php echo $color; ?> !important;
    border-color: <?php echo $color; ?> !important;
}


@media only screen and (max-width: 991px) {

	#page-menu<?=$num?> nav { background-color: <?php echo $color; ?> !important; }

}


@media only screen and (max-width: 767px) {

	.portfolio-filter<?=$num?> li a:hover { color: <?php echo $color; ?> !important; }
}

<?php }} ?>

#primary-menu.style-10.style-2 > div #top-search, #primary-menu.style-10.style-2 > div #top-cart, #primary-menu.style-10.style-2 > div #side-panel-trigger {
	margin-top:20px !important;
	margin-bottom:20px !important;
	
}

