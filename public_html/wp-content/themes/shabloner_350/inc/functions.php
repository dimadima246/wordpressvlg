<?php


function db()
{
	global $db;
	return $db;
}

function clean($str)
{
	$str = str_replace(array("\n","\r","\t"),"",$str);
	return trim($str);
}


function redirect($url)
{
	$urlParts = parse_url($url);
	if(!$urlParts['host']) $url = HTTP_PATH.str_replace("&amp;", "&", $url);
	header("Location: $url");
	die("<script type=\"text/javascript\">window.location = '$url';</script>");
}

function error($str)
{
	return array("error"=>$str);
}

function randomWord($number) {

$letters = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
for($i=0;$i<$number;$i++) {
$word .= $letters[mt_rand(0,count($letters)-1)];
}
return $word;
}

function xml2array ( $xmlObject, $out = array () )
{
    foreach ( (array) $xmlObject as $index => $node )
        $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

    return $out;
}

function postPage($url, $post=array(), $cookie='') 
{
  //$url = "http://".str_replace("http://","",$url);
  $ch = curl_init(); 
  curl_setopt($ch, CURLOPT_URL, $url);
  //curl_setopt($ch, CURLOPT_HEADER, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
  //curl_setopt($ch, CURLOPT_USERAGENT,USER_AGENT);
  if(count($post))
  {
	  curl_setopt($ch, CURLOPT_POST, 1);
	  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  }
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,30);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  
  if($cookie)
  {
	  curl_setopt( $ch, CURLOPT_COOKIEJAR,  $cookie );
	  curl_setopt( $ch, CURLOPT_COOKIEFILE, $cookie );
  }
  
  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
}


function getPage($url) 
{
  //$url = "http://".str_replace("http://","",$url);
  $ch = curl_init(); 
  curl_setopt($ch, CURLOPT_URL, $url);
  //curl_setopt($ch, CURLOPT_HEADER, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch, CURLOPT_USERAGENT,USER_AGENT);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,30);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  $result = curl_exec($ch);
  
  curl_close($ch);
  return $result;
}

function get_encoding($str){
    $cp_list = array('utf-8', 'windows-1251');
    foreach ($cp_list as $k=>$codepage){
        if (md5($str) === md5(iconv($codepage, $codepage, $str))){
            return $codepage;
        }
    }
    return null;
}

function showUrlCorrect($current_url, $url)
{
	list($link_href, $trash) = explode("#", $url);
	$current_url_data = parse_url($current_url);
	$link_data = parse_url($link_href);
	//echo '<pre>'; print_r($current_url_data); echo '</pre>'; 
	
	
	$link_domain = show_website_clear($link_data['host']);
	
	if(substr($link_data['path'], 0, 2) == './') 
	{
		$link_href = ltrim($link_href, '.');
	}
	
	if(strstr($link_href, '../'))
	{
		$orig_parts = explode('/', $current_url_data['path']);
		unset($orig_parts[count($orig_parts)-1]);
		unset($orig_parts[count($orig_parts)-1]);
		
		$link_href = implode('/', $orig_parts).str_replace('..','',$link_href);
	}
	elseif(substr($link_data['path'], 0, 1) != '/' && !$link_data['host'])
	{
		$parts = explode('/', $current_url_data['path']);
		unset($parts[count($parts)-1]);
		
		$parts[] = $link_data['path'];
		$current_url_data['path'] = implode('/', $parts);
		return $current_url_data['scheme'].'://'.$current_url_data['host'].'/'.ltrim($current_url_data['path'],'/');
	}
	
	if(!$link_data['host']) $link_href = $current_url_data['scheme'].'://'.$current_url_data['host'].'/'.ltrim($link_href,'/');
	return $link_href;
}




function file_get_name($url)
{
	$data = array();
	list($url, $q) = explode('?', $url);
	$parts = explode('/', $url);
	$data['name'] = $parts[count($parts)-1];
	
	$ext_parts = explode('.', $data['name']);
	$data['ext'] = $ext_parts[count($ext_parts)-1];
	return $data;
}

function file_save($path, $content)
{
	$f = fopen($path, 'w');
	fwrite($f, $content);
	fclose($f);
}

function write($path, $str)
{
	$f = fopen($path, 'w') ;
	fwrite($f, $str);
	fclose($f); 
}

function upload($name,$tmp_name,$path,$string_name='')
{
	
	$fileExt = strtolower(getFileExtention($name));
	if(!fileIsGoodExtention($fileExt)) return false;
	
	if($path) $fileFolder = $path;
	else
	{
		$fileFolder = '/files/upload/'.date("Y")."/".date("m")."/".date("d");
		$yearFolder = '/files/upload/'.date("Y");
		$monthFolder = '/files/upload/'.date("Y")."/".date("m");
		$dayFolder = '/files/upload/'.date("Y")."/".date("m")."/".date("d");
		
		if(!file_exists(ROOT.$yearFolder)) mkdir(ROOT.$yearFolder);
		if(!file_exists(ROOT.$monthFolder)) mkdir(ROOT.$monthFolder);
		if(!file_exists(ROOT.$dayFolder)) mkdir(ROOT.$dayFolder);
	}
	
	if($string_name == "") $filePath = $fileFolder.'/'.$name;
	else $filePath = $fileFolder.'/'.$string_name.".".$fileExt;

	copy($tmp_name, $filePath);
	
	return array("ext"=>$fileExt, "file_path"=>str_replace(get_template_directory(), '', $filePath));
}

function fileIsGoodExtention($fileExt)
{
	$_ALLOWED_EXTENSIONS = array(
													 "gif",
													"jpg",
													"jpeg",
													"png",
													"txt",
													"xml",
													"xlsx",
													"xls",
													"doc",
													"docx",
													"rtf",
													"zip",
													"rar",
													"xml",
													"pdf",
													"mp3",
													"html",
													"htm"
													 );
	if(in_array($fileExt, $_ALLOWED_EXTENSIONS)) return true;
	else return false;
}

function getFileExtention($filePath) 
{
  $parts = explode(".",$filePath);
  $ext = $parts[count($parts)-1];
  return strtolower($ext);
}

function getFileName($filePath) 
{
  $parts = explode("/",$filePath);
  $name = $parts[count($parts)-1];
  return $name;
}
