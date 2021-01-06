<?php

function api($method, $_P=array())
{
	
	list($app, $function) = explode('.', $method);
	
	$path = get_template_directory().'/inc/'.$app.'.php';
	
	if(file_exists($path)) require_once($path);
	else return false;
	
	$namespace = $app.'\\'.$function;
	
	return $namespace($_P);
	
}
