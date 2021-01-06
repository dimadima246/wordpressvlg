<?php

function showSocials($template='')
{
	if(!$template) $template = '<a href="[link]" class="social-icon si-small si-borderless si-[social]"><i class="icon-[social]"></i><i class="icon-[social]"></i></a>';
	
	$socials = array();
	
	$socials['vk'] = get_option_wp('prdvg_vk');
	//$socials['ok'] = get_option_wp('prdvg_ok');
	$socials['instagram'] = get_option_wp('prdvg_instagram');
	$socials['facebook'] = get_option_wp('prdvg_facebook');
	$socials['youtube'] = get_option_wp('prdvg_youtube');
	$socials['twitter'] = get_option_wp('prdvg_twitter');
	
	$res = '';
	
	foreach($socials as $social => $link)
	{
		if($social == 'ok') $social = 'odnoklassniki';
		
		$title = str_replace(
		array('vk', 'instagram', 'facebook', 'youtube', 'twitter'),
		array('Вконтакте', 'Instagram', 'Facebook', 'YouTube', 'Twitter'), $social);
		
		$html = $template;
		$html = str_replace('[title]', $title, $html);
		$html = str_replace('[link]', $link, $html);
		$html = str_replace('[social]', $social, $html);
		$res .= $html."\n";
	}
	
	return $res;
	
}

function get_template_directory_uri()
{
	global $theme_path;
	return $theme_path;
}

function get_template_directory()
{
	global $folder;
	return $folder;
}

