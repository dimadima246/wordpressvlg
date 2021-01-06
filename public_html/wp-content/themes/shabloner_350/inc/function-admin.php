<?php

/*
	
@package shablonertheme
	
	========================
		ADMIN PAGE
	========================
*/


function admin_menu_add_external_link_top_level() {
    global $menu;

    $menu_slug = "external_slug"; // just a placeholder for when we call add_menu_page
    $menu_pos = 111; // whatever position you want your menu to appear

    // create the top level menu, using $menu_slug as a placeholder for the link
    add_menu_page( 'admin_menu_add_external_link_top_level', 'Шаблонер', 'read', $menu_slug, '', get_template_directory_uri() . '/inc/shabloner-icon.png', $menu_pos );

    $hash = md5(DB_HOST.DB_USER.DB_PASSWORD.DB_NAME.AUTH_KEY);
    $menu[$menu_pos][2] = get_template_directory_uri().'/editor/index.php?app=auth&hash='.$hash;
}

add_action( 'admin_menu', 'admin_menu_add_external_link_top_level' );

