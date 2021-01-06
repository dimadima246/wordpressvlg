<?php

header ("Content-Type:text/css");

if( isset( $_GET[ 'fonts' ] ) AND $_GET[ 'fonts' ] != ',,' ) foreach(explode(',', $_GET['fonts']) as $font ) $fonts[] = $font;
else
{
	$fonts = array(
						 'Lora',
						 'Open Sans',
						 'Crete Round',
						 );
}

if($_GET['font_size']) $font_size = $_GET['font_size'].'px';
else $font_size = '15px';

$font_size_menu = rtrim(ceil($font_size*0.8), 'px').'px';

/*$font_size_h2 = rtrim(ceil($font_size*2), 'px').'px';
$font_size_h3 = rtrim(ceil($font_size*1.5), 'px').'px';
$feature_box_h3 = rtrim(ceil($font_size*1.1), 'px').'px';*/

$font_size_h2 = '200%';
$font_size_h3 = '150%';
$feature_box_h3 = '130%';

$font_size = str_replace('pxpx', 'px', $font_size);

?>/* ----------------------------------------------------------------
	Fonts

	Replace your Fonts as necessary
-----------------------------------------------------------------*/



body,
small,
#primary-menu ul ul li > a,
.wp-caption,
.feature-box.fbox-center.fbox-italic p,
.skills li .progress-percent .counter,
#top-search form input,
#primary-menu ul li > a,
#logo #site_description,
#primary-menu ul li .mega-menu-content.style-2 ul.mega-menu-column > li.mega-menu-title > a,
.nav-tree ul ul a { font-family: '<?=$fonts[1]?>', sans-serif ; }

h1,
h2,
h3,
h4,
h5,
h6,
.entry-link,
.entry.entry-date-section span,
.button.button-desc,
.counter,
label,
#site_name,
.nav-tree li a,
.wedding-head .first-name,
.wedding-head .last-name { font-family: '<?=$fonts[0]?>', sans-serif !important; }


.entry-meta li,
.entry-link span,
.entry blockquote p,
.more-link,
.comment-content .comment-author span,
.button.button-desc span,
.testi-content p,
.team-title span,
.before-heading,
.wedding-head .first-name span,
.wedding-head .last-name span { font-family: '<?=$fonts[1]?>', serif; }

#site_name {
	    font-weight: 500;
}

.font-body { font-family: '<?=$fonts[1]?>', sans-serif !important; }

.font-primary { font-family: '<?=$fonts[1]?>', sans-serif !important; }

.font-secondary { font-family: '<?=$fonts[1]?>', serif !important; } 


/* ----------------------------------------------------------------
	You can change your Font Specific Settings here
-----------------------------------------------------------------*/


body { line-height: 1.5; }



body, .acctitle, .dropdown-menu, .widget p:not(.lead), #copyrights, .promo > span {
    font-size: <?=$font_size?> !important;
}


h1,
h2,
h3,
h4,
h5,
h6 {
	font-weight: 600;
	line-height: 1.5;
}


h1, h2, .heading-block h2 {
    font-size: <?=$font_size_h2?> ;
}

#slider h2, #slider:not(.cblock-56) h1 {
    font-size: 300% ;
}


h3 {
    font-size: <?=$font_size_h3?> !important;
}

.feature-box h3 {
    font-size: <?=$feature_box_h3?> !important;
}

#logo {
	font-size: 36px;
	line-height: 100%;
}

#primary-menu ul li > a {
	font-weight: bold;
	font-size: <?=$font_size_menu?>;
	letter-spacing: 1px;
	text-transform: uppercase;
}

#primary-menu ul ul li > a {
	font-size: <?=$font_size_menu?>;
	font-weight: 400;
	letter-spacing: 0;
}

#primary-menu ul li .mega-menu-content.style-2 ul.mega-menu-column > li.mega-menu-title > a {
	font-size: <?=$font_size_menu?>;
	font-weight: bold;
	letter-spacing: 1px;
	text-transform: uppercase !important;
	line-height: 1.3 !important;
}

#top-search form input {
	font-size: 32px;
	font-weight: 700;
	letter-spacing: 2px;
}

.entry-meta li {
	font-size: 13px;
	line-height: 14px;
	font-style: italic;
}

.entry-link {
	text-transform: uppercase;
	letter-spacing: 1px;
	font-size: 24px;
	font-weight: 700;
}

.entry-link span {
	font-style: italic;
	font-weight: normal;
	text-transform: none;
	letter-spacing: 0;
	font-size: 14px;
}

.entry blockquote p {
	font-weight: 400;
	font-style: italic;
}

.entry.entry-date-section span {
	font-size: 18px;
	font-weight: bold;
	letter-spacing: 1px;
	text-transform: uppercase;
}

.more-link { font-style: italic; }

.comment-content .comment-author span {
	font-size: 12px;
	font-weight: normal;
	font-style: italic;
}

.wp-caption { font-style: italic; }

.button.button-desc {
	font-size: 22px;
	line-height: 1;
}

.button.button-desc span {
	font-size: 14px;
	font-weight: 400;
	letter-spacing: 1px;
	font-style: italic;
	text-transform: none;
}

.feature-box.fbox-center.fbox-italic p { font-style: italic; }

.testi-content p { font-style: italic; }

.team-title span {
	font-weight: 400;
	font-style: italic;
	font-size: 15px;
}

.counter {
	font-size: 42px;
	font-weight: 600;
}

.skills li .progress-percent .counter { font-weight: 400; }

label {
	font-size: <?=$font_size?>;
	font-weight: 700;
	/*text-transform: uppercase;*/
	letter-spacing: 1px;
}

.before-heading {
	font-size: 16px;
	font-style: italic;
	font-weight: 400;
}

.wedding-head .first-name,
.wedding-head .last-name {
	font-weight: bold;
	text-transform: uppercase;
	letter-spacing: 2px;
}

.wedding-head .first-name span,
.wedding-head .last-name span {
	font-size: 56px;
	font-weight: 400;
	font-style: italic;
	text-transform: none;
}


@media (max-width: 991px)
{
	#primary-menu ul ul li > a {
		font-size: <?=$font_size?> !important;
	}
}

.button {
	font-size: <?=$font_size?> !important;
}

.white-font, .white-font .social-icon {
	color: #fff !important;
}