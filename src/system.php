<?php

/*
	Get human-readable file size
	
	Parameters
		string $path
	
	Return
		string
*/
function human_filesize($path){
	$bytes=filesize($path);
	$units=array('b','Kb','Mb','Gb','Tb','Eb');
	for($i=count($units)-1;$i>=0;--$i){
		if($bytes>=pow(1024,$i)){
			return str_replace('.',',',(string)round($bytes/pow(1024,$i),2).' '.$units[$i]);
		}
	}
	return false;
}

/*
	Scan a directory without '.' and '..'

	Parameters
		string $dir

	Return
		array
*/
function lessdir($dir){
	return array_slice(scandir($dir),2);
}

/*
	Get a file's mime type

	Parameters
		string $path

	Return
		string
*/
function mimetype($path){
	if(!is_file($path)){
		throw new Exception("'$path' is not a file");
	}
	if(!is_readable($path)){
		throw new Exception("'$path' is not readable");
	}
	// METHOD 1: FileInfo extension
	if(extension_loaded('fileinfo')){
		$finfo=finfo_open(FILEINFO_MIME);
		$type=finfo_file($finfo,$path);
		finfo_close($finfo);
		if(empty($type)){
			throw new Exception("Cannot retrieve mime type with fileinfo extension");
		}
	}
	// METHOD 2: mime_content_type() function
	elseif(function_exists('mime_content_type')){
		$type=mime_content_type($path);
		if(empty($type)){
			throw new Exception("Cannot retrieve mime type with mime_content_type() function");
		}
	}
	// METHOD 3: file command
	elseif(function_exists('exec')){
		$out=`file -bi $path`;
		if(empty($out)){
			throw new Exception("It seems that the 'file' command does not exist on this operating system");
		}
		$type=substr($out,0,strpos($out,';'));
	}
	if(!$type){
		return 'application/octet-stream';
	}
	else{
		$type=explode(';',$type);
		return $type[0];
	}
}

/*
	Get human-readable permissions

	Parameters
		string $path

	Return
		string
*/
function human_fileperms($path){
	$perms=fileperms($path);
	// Socket
	if(($perms & 0xC000)==0xC000){
		$info='s';
	}
	// Symbolic Link
	elseif(($perms & 0xA000)==0xA000){
		$info='l';
	}
	// Regular
	elseif(($perms & 0x8000)==0x8000){
		$info='-';
	}
	// Block special
	elseif(($perms & 0x6000)==0x6000){
		$info='b';
	}
	// Directory
	elseif(($perms & 0x4000)==0x4000){
		$info='d';
	}
	// Character special
	elseif(($perms & 0x2000)==0x2000){
		$info='c';
	}
	// FIFO pipe
	elseif(($perms & 0x1000)==0x1000){
		$info='p';
	}
	// Unknown
	else{
		$info='u';
	}
	// Owner
	$info.=(($perms & 0x0100)?'r':'-');
	$info.=(($perms & 0x0080)?'w':'-');
	$info.=(($perms & 0x0040)?
				(($perms & 0x0800)?'s':'x'):
				(($perms & 0x0800)?'S':'-'));
	// Group
	$info.=(($perms & 0x0020)?'r':'-');
	$info.=(($perms & 0x0010)?'w':'-');
	$info.=(($perms & 0x0008)?
				(($perms & 0x0400)?'s':'x'):
				(($perms & 0x0400)?'S':'-'));
	// World
	$info.=(($perms & 0x0004)?'r':'-');
	$info.=(($perms & 0x0002)?'w':'-');
	$info.=(($perms & 0x0001)?
				(($perms & 0x0200)?'t':'x'):
				(($perms & 0x0200)?'T':'-'));
	return $info;
}

/*
	Remove a directory recursively

	Parameters
		string $path
*/
function rrmdir($path) {
	if(is_dir($path)) {
		foreach(lessdir($path) as $file) {
			if(is_dir("$path/$file")) {
				rrmdir("$path/$file");
			}
			else {
				unlink("$path/$file");
			}
		}
		rmdir($path);
	}
}
