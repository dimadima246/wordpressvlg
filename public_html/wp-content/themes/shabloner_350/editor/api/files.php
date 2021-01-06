<?php

namespace files;


$_IMAGES = array(
				 "gif",
				 "jpg",
				 "jpeg",
				 "png"
				 );

  function recurse_copy($_P=array()) { 
  list($src,$dst) = $_P;
  
	  $dir = opendir($src); 
	  @mkdir($dst); 
	  while(false !== ( $file = readdir($dir)) ) { 
		  if (( $file != '.' ) && ( $file != '..' )) { 
			  if ( is_dir($src . '/' . $file) ) { 
				  recurse_copy(array($src . '/' . $file,$dst . '/' . $file)); 
			  } 
			  else { 
				  copy($src . '/' . $file,$dst . '/' . $file); 
			  } 
		  } 
	  } 
	  closedir($dir); 
  }
  
  function delete_directory($dirname) {
		   if (is_dir($dirname))
			 $dir_handle = opendir($dirname);
	   if (!$dir_handle)
			return false;
	   while($file = readdir($dir_handle)) {
			 if ($file != "." && $file != "..") {
				  if (!is_dir($dirname."/".$file))
					   unlink($dirname."/".$file);
				  else
					   delete_directory($dirname.'/'.$file);
			 }
	   }
	   closedir($dir_handle);
	   rmdir($dirname);
	   return true;
  }  

function write($_P=array())
{
	list($path, $str) = $_P;
	//echo $path.' | '.__LINE__.' | '.__FILE__.'<br>';
	
	$f = fopen($path, 'w') ;
	fwrite($f, $str);
	fclose($f); 
}

function upload($_P)
{
	list($name,$tmp_name,$path,$string_name) = $_P;
	
	$fileExt = strtolower(getFileExtention($name));
	if(!fileIsGoodExtention($fileExt)) return false;
	
	if($path) $fileFolder = $path;
	else $fileFolder = '/files/uploads/';
	
	list($fileExt, $q) = explode('?', $fileExt);
	
	if($string_name == "") $filePath = $fileFolder.'/'.randomWord(16).".".$fileExt;
	else $filePath = $fileFolder.'/'.$string_name.".".$fileExt;
	
	copy($tmp_name,ROOT.$filePath);
	
	
	return array("ext"=>$fileExt,"file_path"=>$filePath);
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
  list($ext, $q) = explode('?', $ext);
  return strtolower($ext);
}

function getFileName($filePath) 
{
  $parts = explode("/",$filePath);
  $name = $parts[count($parts)-1];
  return $name;
}

function toDownloadTemplate($_P=array())
{
	list($filePath,$fileName) = $_P;
	$endFileName = $fileName;

	// Если запрашивающий агент поддерживает докачку 
	$content = file_get_contents($filePath); 
	
	$tmp_file = ROOT.'/temp/'.randomWord(32);
	
	$f = fopen($tmp_file,"w");
	fwrite($f,$content);
	fclose($f);
	
	$fileName = $tmp_file;

	if (!file_exists($fileName)) 
	 { 
	  header ("HTTP/1.0 404 Not Found"); 
	  exit; 
	 } 
	$fsize = filesize($fileName); 
	$ftime = date("D, d M Y H:i:s T", filemtime($fileName)); 
	$fd = @fopen($fileName, "rb"); 
	if (!$fd){ 
	header ("HTTP/1.0 403 Forbidden"); 
	exit; 
	} 
	// Если запрашивающий агент поддерживает докачку 
	if ($HTTP_SERVER_VARS["HTTP_RANGE"]) { 
	$range = $HTTP_SERVER_VARS["HTTP_RANGE"]; 
	$range = str_replace("bytes=", "", $range); 
	$range = str_replace("-", "", $range); 
	if ($range) {fseek($fd, $range);} 
	} 
	$content = fread($fd, filesize($fileName)); 
	fclose($fd); 
	if ($range) { 
	header("HTTP/1.1 206 Partial Content"); 
	} 
	else { 
	header("HTTP/1.1 200 OK"); 
	} 
	//header('Content-Type: text/html; charset=utf-8');
	header("Content-Disposition: attachment; filename=\"".$endFileName/*.".".$_FILE['extension']*/."\""); 
	header("Last-Modified: $ftime"); 
	header("Accept-Ranges: bytes"); 
	header("Content-Length: ".($fsize-$range)); 
	header("Content-Range: bytes $range-".($fsize -1)."/".$fsize); 
	header("Content-type: application/octet-stream; text/html; charset=utf-8"); 
	unlink($tmp_file);
	print $content; 
  
}

function file_upload_by_ftp($_P=array())
{
	$ftp_server=$_P['ftp_server']; 
	$ftp_user_name=$_P['ftp_user_name']; 
	$ftp_user_pass=$_P['ftp_user_pass']; 
	$file = $_P['file'];//tobe uploaded 
	$remote_file = $_P['remote_file']; 
	
	// set up basic connection 
	$conn_id = ftp_connect($ftp_server); 
	
	// login with username and password 
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 
	
	// upload a file 
	if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)) { 
	$res = true;
		//echo "<Br><span style='color:green'>successfully uploaded $file</span><Br>\n"; 
	} else { 
	$res = false;
		//echo "<Br><span style='color:red'>There was a problem while uploading $file</span><Br>\n"; 
		} 
	// close the connection 
	ftp_close($conn_id); 
	return $res;
}

function ftp_check($_P=array())
{
	$ftp_server=$_P['ftp_host']; 
	$ftp_user_name=$_P['ftp_login']; 
	$ftp_user_pass=$_P['ftp_pass']; 
	
	// установка соединения
	$conn_id = @ftp_connect($ftp_server); 

	// вход с именем пользователя и паролем
	$login_result = @ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 

	// проверка соединения
	if ((!$conn_id) || (!$login_result)) return false; 
	else return true;
}

function find_new($_P=array())
{
	//global $files_data;
	if(!$files_data) $files_data = array();
	foreach(array('folder', 'time') as $key) if(!$_P[$key]) return error('empty '.$key);
	$src = $_P['folder'];
	
	$dir = opendir($src); 
	$f = fopen($src.'/synch_log.txt', 'a');
	
	while(false !== ( $file = readdir($dir)) ) { 
		if (( $file != '.' ) && ( $file != '..' )) { 
			if ( is_dir($src . '/' . $file) ) { 
				recurse_find_new($src . '/' . $file); 
			} 
			else { 
				if(filemtime($src . '/' . $file) > $_P['time'] || filectime($src . '/' . $file) > $_P['time']) 
				{
					if($file != $src.'/synch_log.txt') fwrite($f, $src . '/' . $file."\n");
					//$files_data[] = $src . '/' . $file;
				}
			} 
		} 
	} 
	closedir($dir); 
}

