<?php

namespace cats;

function get($_P=array())
{
	if($_P['id']) db()->where('id', $_P['id']);
	if($_P['slug']) db()->where('slug', $_P['slug']);
	
	return db()->orderBy('name', 'asc')->get('demo_categories');
}

function get_schema($_P=array())
{
	
	return db()->orderBy('name', 'asc')->get('demo_categories_schema');
}


function add($_P)
{
	foreach(array('name') as $key) if(!$_P[$key]) return error('empty '.$key);
	
	$data = array(
						 'name' => $_P['name'],
						);
	$slug = api('sys.slug', $_P['name']);
	if(db()->where('slug', $slug)->getValue('demo_categories', 'slug')) $slug = $slug.'-1';
	
	$data['slug'] = $slug;
	
	if($_P['parent_id']) $data['parent_id'] = $_P['parent_id'];
	
	$id = db()->insert('demo_categories', $data);
	
	return array('id' => $id);
}

